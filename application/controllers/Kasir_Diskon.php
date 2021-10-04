<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir_Diskon extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Data_model');
        // if ($this->session->userdata('role_id') != '2') {
        //     redirect('Login');
        // }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Transaksi Kasir';

        $token = $data['user']['token'];
        $data['detail'] = $this->db->query("SELECT *, (harga * qty) as sub_total FROM tb_detail_penjualan_tmp WHERE token='$token' ORDER by kode_barang")->row();
        $data['no_kwitansi'] = $this->Data_model->no_kwitansi();
        $data['pelanggan'] = $this->db->get_where('tb_pelanggan', ['token' => $token])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/kasir_diskon', $data);
        $this->load->view('templates/footer');
    }

    function simpan_barang()
    {
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $kobar = htmlspecialchars($this->input->post('kobar'));
        $nabar = htmlspecialchars($this->input->post('nabar'));
        $harga = htmlspecialchars($this->input->post('harga'));
        $harga_beli = htmlspecialchars($this->input->post('harga_beli'));
        $petugas = htmlspecialchars($this->session->userdata('username'));
        $qty = htmlspecialchars($this->input->post('qty'));
        $timee = date('Y-m-d H:i:s');
        $token = htmlspecialchars($this->session->userdata('token'));
        $data = $this->Data_model->simpan_barang($kobar, $nabar, $harga, $harga_beli, $petugas, $qty, $timee, $token);
        echo json_encode($data);
    }

    function cek_barang()
    {
        if ($_POST) {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $token = $this->session->userdata('token');

            $kode   = $_POST['kode'];
            $qty    = $_POST['qty'];

            $qry = $this->db->get_where('tb_detail_penjualan_tmp', ['kode_barang' => $kode, 'token' => $token])->row_array();
            $qqq = $this->db->get_where('tb_barang', ['kode_barang' => $kode, 'token' => $token])->row_array();

            if (!empty($kode)) {
                if (!empty($qry['qty'])) {
                    $stok = $qqq['jml_stok'] - $qry['qty'];

                    if ($qty > $stok) {
                        echo '<script>
                        alert("Stok tidak cukup, stok barang tersisa ' . $stok . ' !");
                            $("#qty1").val("");
                            $("#qty1").focus();
                    </script>';
                    }
                }
            }
        }
    }

    function delete()
    {
        $this->Data_model->delete($_POST["id"]);
        // echo 'Data Deleted';  
    }

    function data_kasir()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $data['user']['token'];
        $petugas = $this->session->userdata('username');
        $data = $this->db->query("SELECT *, sum(harga * qty) as sub_total, sum(qty) as kty FROM tb_detail_penjualan_tmp WHERE token='$token' AND petugas='$petugas' GROUP BY kode_barang ORDER BY kode_barang")->result();;
        echo json_encode($data);
    }

    function auto_kasir()
    {
        if (isset($_GET['term'])) {
            $result = $this->Data_model->getAuto($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'  => $row->kode_barang . ' / ' . $row->nama_barang,
                        'value'  => $row->kode_barang,
                        'nama'   => $row->nama_barang,
                        'harga'   => $row->harga_jual,
                        'harga_beli'   => $row->harga_beli,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    function proses()
    {
        if (isset($_GET['kode'])) {
            $kode = $_GET['kode'];
            $token = $this->session->userdata('token');
            $query = $this->db->get_where('tb_barang', ['kode_barang' => $kode, 'token' => $token]);
            $barang = $query->row_array();
            $data = array(
                'kode'          =>  $barang['kode_barang'],
                'nama_barang'   =>  $barang['nama_barang'],
                'harga'         =>  $barang['harga_jual'],
                'harga_beli'    =>  $barang['harga_beli'],
            );
            echo json_encode($data);
        }
    }

    function auto_pel()
    {
        if (isset($_GET['term'])) {
            $result = $this->Data_model->getAuto1($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'  => $row->kode_pel . ' / ' . $row->nama_pel,
                        'value'  => $row->kode_pel,
                        'diskon'  => $row->diskon,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    public function smpn_pen()
    {
        if (isset($_POST['enter'])) {
            $dt = $this->db->query("SELECT * FROM tb_detail_penjualan_tmp WHERE token='" . $this->session->userdata('token') . "' AND petugas='" . $this->session->userdata('username') . "' ");
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);
            if ($dt->num_rows() > 0) {

                $no_transaksi = $this->input->post('no_kwitansi');
                $jmlh_bayar = $this->input->post('jmlbayar2');
                $total = $this->input->post('total');
                $pot = $this->input->post('pot');
                $status = $this->input->post('status');
                $pelanggan = $this->input->post('pelanggan');
                $tgl = date('Y-m-d');
                $petugas = $this->input->post('username');
                $bayar = $this->input->post('bayar');
                $diskon = $this->input->post('diskon');
                $token = $this->input->post('token');


                $data = [
                    'no_transaksi' => $no_transaksi,
                    'kode_pelanggan' => $pelanggan,
                    'tgl_transaksi' => $tgl,
                    'petugas' => $petugas,
                    'status' => $status,
                    'timestmp' => date('Y-m-d H:i:s'),
                    'bayar' => str_replace(',', '', $bayar),
                    'total' => $total,
                    'diskon' => $diskon,
                    'token' => $this->session->userdata('token')
                ];
                $this->db->insert('tb_penjualan', $data);

                foreach ($dt->result_array() as $dtt) {
                    $char[] = $dtt;
                }

                foreach ($char as $row) {
                    $dataa = [
                        'no_transaksi' => $no_transaksi,
                        'kode_barang' => $row['kode_barang'],
                        'modal' => $row['modal'],
                        'tgl_penjualan' => date('Y-m-d'),
                        'qty' => $row['qty'],
                        'harga' => $row['harga'],
                        'total' => $pot,
                        'petugas' => $row['petugas'],
                        'timee' => $row['timee'],
                        'token' => $row['token']

                    ];

                    $this->db->insert('tb_detail_penjualan', $dataa);

                    $this->db->where('kode_barang', $row['kode_barang']);
                    $this->db->where('petugas', $row['petugas']);
                    $this->db->where('token', $row['token']);
                    $this->db->delete('tb_detail_penjualan_tmp');
                }

                redirect('Kasir_Diskon/Cetak_Struk/' . $no_transaksi);
            }
        }
    }

    public function cetak_struk($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['tra'] = $this->db->query("SELECT p.* FROM tb_penjualan p WHERE p.no_transaksi='$id' AND p.token='$token'")->row_array();
        $data['nm_toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $data['penjualan'] = $this->db->query("SELECT *, sum(harga*qty) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$id' AND token='$token' GROUP BY kode_barang")->result_array();
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 27])->row_array();
        $data['akses1'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
        $data['akses2'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 39])->row_array();
        $data['akses3'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();

        if ($data['nm_toko']['struk'] == 'thermal') {
            $this->load->view('transaksi/cetak_struk', $data);
        } elseif ($data['nm_toko']['struk'] == 'matrix') {
            $this->load->view('transaksi/cetak_struk1', $data);
        } elseif ($data['nm_toko']['struk'] == 'biasa') {
            $this->load->view('transaksi/cetak_struk2', $data);
        }
    }
}
