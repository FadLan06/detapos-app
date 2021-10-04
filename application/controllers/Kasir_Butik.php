<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir_Butik extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Data_model');
        $this->load->model('Akuntansi_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Transaksi Kasir';

        $token = $data['user']['token'];
        $data['detail'] = $this->db->query("SELECT *, (harga * qty) as sub_total FROM tb_detail_penjualan_tmp WHERE token='$token' ORDER by kode_barang")->row();
        $data['no_kwitansi'] = $this->Data_model->no_kwitansi();
        $data['no_jurnal'] = $this->Akuntansi_model->no_jurnal();
        $data['rekening'] = $this->db->get_where('tb_rekening', ['token' => $token])->result();

        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/kasir_butik', $data);
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
        $potongan = htmlspecialchars($this->input->post('potongan'));
        $ukuran = htmlspecialchars($this->input->post('ukuran'));
        $varian = htmlspecialchars($this->input->post('varian'));
        $petugas = htmlspecialchars($this->session->userdata('username'));
        $qty = htmlspecialchars($this->input->post('qty'));
        $timee = date('Y-m-d H:i:s');
        $token = htmlspecialchars($this->session->userdata('token'));
        $data = $this->Data_model->simpan_barang_butik($kobar, $nabar, $harga, $harga_beli, $potongan, $ukuran, $varian, $petugas, $qty, $timee, $token);
        echo json_encode($data);
    }

    function cek_barang()
    {
        if ($_POST) {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $token = $this->session->userdata('token');

            $kode   = $_POST['kode'];
            $qty    = $_POST['qty'];

            $query = $this->db->query("SELECT b.kode_barang, b.token, b.jml_stok, p.kode_barang as kode, sum(p.qty) as qty, p.token as tok FROM tb_barang b LEFT JOIN tb_detail_penjualan_tmp p ON p.kode_barang = b.kode_barang WHERE b.kode_barang='$kode' AND b.token='$token'")->row_array();

            if (!empty($kode)) {
                $stok = $query['jml_stok'] - $query['qty'];
                if ($qty > $stok) {
                    echo '<script>
                        alert("Stok tidak cukup, stok barang tersisa ' . $stok . ' !");
                            $("#qty2").val("");
                            $("#qty2").focus();
                    </script>';
                }
            }
        }
    }

    function delete()
    {
        $this->Data_model->delete_bt($_POST["id"], $_POST["hg"], $_POST["vr"], $_POST["uk"]);
        // echo 'Data Deleted';
    }

    function data_kasir()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $data['user']['token'];
        $petugas = $this->session->userdata('username');
        $data = $this->db->query("SELECT *, sum(harga * qty - potongan) as sub_total, sum(modal * qty) as hg_pokok, sum(qty) as kty, sum(potongan) as potongan FROM tb_detail_penjualan_tmp WHERE token='$token' AND petugas='$petugas' GROUP BY harga, kode_barang, varian, ukuran ORDER BY kode_barang")->result();
        echo json_encode($data);
    }

    function ambil_data()
    {
        $kode = $this->input->post('kode');
        $barang = $this->db->get_where('tb_barang', ['kode_barang' => $kode, 'token' => $this->session->userdata('token')])->row();
        $query = $this->db->get_where('tb_barang_harga', ['id_barang' => $barang->kode_barang, 'token' => $barang->token]);
        if ($query->num_rows() != 0) {
            foreach ($query->result_array() as $data) {
                echo "<option value='$data[harga_jual]' >$data[harga_jual] / $data[satuan]</option>";
            }
        }
    }

    function ambil_data1()
    {
        $kode = $this->input->post('kode');
        $barang = $this->db->get_where('tb_barang', ['kode_barang' => $kode, 'token' => $this->session->userdata('token')])->row();
        $query = $this->db->get_where('tb_barang_warna', ['kode_barang' => $barang->kode_barang, 'token' => $barang->token]);
        if ($query->num_rows() != 0) {
            foreach ($query->result_array() as $data) {
                echo "<option value='$data[warna]' >$data[warna]</option>";
            }
        }
    }

    function ambil_data2()
    {
        $kode = $this->input->post('kode');
        $barang = $this->db->get_where('tb_barang', ['kode_barang' => $kode, 'token' => $this->session->userdata('token')])->row();
        $query = $this->db->get_where('tb_barang_ukuran', ['kode_barang' => $barang->kode_barang, 'token' => $barang->token]);
        if ($query->num_rows() != 0) {
            foreach ($query->result_array() as $data) {
                echo "<option value='$data[ukuran]' >$data[ukuran]</option>";
            }
        }
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
                'nama_barang'   =>  $barang['nama_barang'] . ' / ' . $barang['warna'] . ' / ' . $barang['ukuran'],
                'satuan'         =>  $barang['satuan'],
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
                        'label'  => $row->nama_pel,
                        'value'  => $row->nama_pel,
                        'diskon'  => $row->diskon,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    public function smpn_pen()
    {
        if (isset($_POST['enter'])) {
            $user = $this->db->get_where('user', ['token' => $this->session->userdata('token')])->row_array();
            $dt = $this->db->query("SELECT * FROM tb_detail_penjualan_tmp WHERE token='" . $this->session->userdata('token') . "' AND petugas='" . $this->session->userdata('username') . "' ");
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);
            if ($dt->num_rows() > 0) {

                //PENJUALAN
                $no_transaksi = $this->input->post('no_kwitansi');
                $jmlh_bayar = $this->input->post('jmlbayar2');
                $total = $this->input->post('total');
                $totval = $this->input->post('totval');
                $totpok = $this->input->post('totpok');
                $status = $this->input->post('status');
                $metodePem = $this->input->post('metodePem');
                $bank = $this->input->post('bank');
                $pelanggan = $this->input->post('pelanggan');
                $tgl = date('Y-m-d');
                $petugas = $this->input->post('username');
                $bayar = $this->input->post('bayar');
                $diskon = $this->input->post('diskon');
                $tempo = $this->input->post('tempo');
                $pot = $this->input->post('pot2');
                $token = $this->input->post('token');

                $data = [
                    'no_transaksi' => $no_transaksi,
                    'kode_pelanggan' => $pelanggan,
                    'tgl_transaksi' => $tgl,
                    'petugas' => $petugas,
                    'status' => $status,
                    'metodePem' => $metodePem,
                    'bank' => $bank,
                    'timestmp' => date('Y-m-d H:i:s'),
                    'bayar' => str_replace(',', '', $bayar),
                    'total' => $total,
                    'diskon' => $diskon,
                    'pot' => $pot,
                    'tempo' => $tempo,
                    'token' => $this->session->userdata('token')
                ];
                $this->db->insert('tb_penjualan', $data);

                // $pel = $this->db->get_where('tb_pelanggan', ['token' => $this->session->userdata('token'), 'nama_pel' => $pelanggan])->row();
                // if ($pel->nama_pel != $pelanggan) {
                //     $kode_pel = rand();
                //     $dat = [
                //         'kode_pel' => $kode_pel,
                //         'nama_pel' => $pelanggan,
                //         'no_hp' => '',
                //         'email' => '',
                //         'alamat' => '',
                //         'diskon' => 0,
                //         'token' => $this->session->userdata('token')
                //     ];
                //     $this->db->insert('tb_pelanggan', $dat);
                // }

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
                        'potongan' => $row['potongan'],
                        'ukuran' => $row['ukuran'],
                        'varian' => $row['varian'],
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

                //AKUNTANSI
                if ($status == 'Lunas') {
                    if ($user['coupon'] == 'new') {
                        $datta = [
                            'no_jurnal' => $this->input->post('no_jurnal'),
                            'tgl_jurnal' => date('Y-m-d'),
                            'keterangan' => 'Pendapatan Penjualan dengan Nomor Transaksi ' . $no_transaksi,
                            'token' => $this->session->userdata('token'),
                            'no_transaksi' => $no_transaksi
                        ];

                        $this->db->insert('tb_jurnal_tmp', $datta);

                        $tok = $this->session->userdata('token');
                        if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) {
                            if ($metodePem == 'Transfer') {
                                $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (113,411,112,511) ORDER BY kode_akun='113', kategori='HL' DESC")->result_array();
                            } else {
                                $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (111,112,411,511) ORDER BY kategori='HL' DESC")->result_array();
                            }
                        } else {
                            $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (111,112,411,511) ORDER BY kategori='HL' DESC")->result_array();
                        }
                        // foreach ($ak as $aku) {
                        //     $ch[] = $aku;
                        // }

                        foreach ($ak as $ro) {
                            if ($metodePem == 'Transfer') {
                                if ($ro['kode_akun'] == '113') {
                                    // $ka = 'D';
                                    $dt1 = [
                                        'no_jurnal' => $this->input->post('no_jurnal'),
                                        'id_akun' => $ro['id_akun'],
                                        'nominal' => $totval,
                                        'tipe' => 'D',
                                        'token' => $this->session->userdata('token'),
                                        'no_transaksi' => $no_transaksi
                                    ];

                                    $this->db->insert('tb_jurnal', $dt1);
                                } else if ($ro['kode_akun'] == '411') {
                                    // $ka = 'K';
                                    $dt1 = [
                                        'no_jurnal' => $this->input->post('no_jurnal'),
                                        'id_akun' => $ro['id_akun'],
                                        'nominal' => $totval,
                                        'tipe' => 'K',
                                        'token' => $this->session->userdata('token'),
                                        'no_transaksi' => $no_transaksi
                                    ];

                                    $this->db->insert('tb_jurnal', $dt1);
                                }
                            } else {
                                if ($ro['kode_akun'] == '111') {
                                    // $ka = 'D';
                                    $dt1 = [
                                        'no_jurnal' => $this->input->post('no_jurnal'),
                                        'id_akun' => $ro['id_akun'],
                                        'nominal' => $totval,
                                        'tipe' => 'D',
                                        'token' => $this->session->userdata('token'),
                                        'no_transaksi' => $no_transaksi
                                    ];

                                    $this->db->insert('tb_jurnal', $dt1);
                                } else if ($ro['kode_akun'] == '411') {
                                    // $ka = 'K';
                                    $dt1 = [
                                        'no_jurnal' => $this->input->post('no_jurnal'),
                                        'id_akun' => $ro['id_akun'],
                                        'nominal' => $totval,
                                        'tipe' => 'K',
                                        'token' => $this->session->userdata('token'),
                                        'no_transaksi' => $no_transaksi
                                    ];

                                    $this->db->insert('tb_jurnal', $dt1);
                                }
                            }

                            if ($ro['kode_akun'] == '112') {
                                // $ka = 'K';
                                $dt1 = [
                                    'no_jurnal' => $this->input->post('no_jurnal'),
                                    'id_akun' => $ro['id_akun'],
                                    'nominal' => $totpok,
                                    'tipe' => 'K',
                                    'token' => $this->session->userdata('token'),
                                    'no_transaksi' => $no_transaksi
                                ];

                                $this->db->insert('tb_jurnal', $dt1);
                            } else if ($ro['kode_akun'] == '511') {
                                // $ka = 'K';
                                $dt1 = [
                                    'no_jurnal' => $this->input->post('no_jurnal'),
                                    'id_akun' => $ro['id_akun'],
                                    'nominal' => $totpok,
                                    'tipe' => 'D',
                                    'token' => $this->session->userdata('token'),
                                    'no_transaksi' => $no_transaksi
                                ];

                                $this->db->insert('tb_jurnal', $dt1);
                            }
                        }
                    }
                }

                if ($status == 'Lunas') {
                    redirect('Kasir_Butik/Cetak_Struk/' . $no_transaksi);
                } elseif ($status == 'Hutang') {
                    redirect('Kasir_Butik');
                }
            }
        }
    }

    public function cetak_struk($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['tra'] = $this->db->query("SELECT p.*, p.diskon as disc FROM tb_penjualan p WHERE p.no_transaksi='$id' AND p.token='$token'")->row_array();
        $data['nm_toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 27])->row_array();
        $data['akses1'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
        $data['akses2'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 39])->row_array();
        $data['akses3'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();
        $data['akses4'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();

        if (($akses3['menu_id'] = 40) && ($akses2['menu_id'] = 39) && ($akses4['menu_id'] = 29)) {
            $data['penjualan'] = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$id' AND token='$token' GROUP BY harga, kode_barang ORDER BY kode_barang")->result_array();
        } else {
            $data['penjualan'] = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$id' AND token='$token' GROUP BY kode_barang")->result_array();
        }

        if ($data['nm_toko']['struk'] == 'thermal') {
            $this->load->view('transaksi/cetak_struk', $data);
        } elseif ($data['nm_toko']['struk'] == 'matrix') {
            $this->load->view('transaksi/cetak_struk1', $data);
        } elseif ($data['nm_toko']['struk'] == 'biasa') {
            if ($token == 'DPE8DR8MRWKYNHJPV') {
                $this->load->view('transaksi/cetak_struk_vamos', $data);
            } else {
                $this->load->view('transaksi/cetak_struk2', $data);
            }
        }
    }
}
