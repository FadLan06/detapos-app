<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Data_model');
        $this->load->model('Barang_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'HOME';

        $token = $this->session->userdata('token');
        $data['penjualan'] = $this->Data_model->penjualan($token);
        $data['barang'] = $this->Data_model->barang($token);
        $data['supplier'] = $this->Data_model->supplier($token);
        $data['pelanggan'] = $this->Data_model->pelanggan($token);
        $data['modal'] = $this->Data_model->modal($token);
        $data['pendapatan'] = $this->Data_model->pendapatan($token);
        $data['pengeluaran'] = $this->Data_model->pengeluaran($token);
        $data['laba'] = $data['pendapatan'] - $data['pengeluaran'];

        $this->db->group_by('tgl_jurnal');
        $data['tanggal'] = $this->db->get_where('tb_jurnal_tmp', ['token' => $token, 'MONTH(tgl_jurnal)' => date('m')])->result_array();

        $data['log'] = $this->db->query("SELECT * FROM tb_log WHERE token='$token' ORDER BY id_log DESC LIMIT 10")->result_array();

        $data['alert'] = $this->db->get_where('tb_alert', ['kd_alert' => 1])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }

    function ambil_stok()
    {
        $token = $this->session->userdata('token');
        $hasil = $this->db->get_where('tb_barang', ['token' => $token])->result_array();
        foreach ($hasil as $dat) {
            if ($dat['jml_stok'] <= $dat['minimal_stok']) {
                echo '<div class="alert text-dark alert-dismissible fade show" style="background-color: #00FF00;" role="alert">Stok barang <b>' . $dat['kode_barang'] . ' - ' . $dat['nama_barang'] . '</b> kurang ' . $dat['jml_stok'] . ', Segera lakukan pemesanan!</div>';
            }
        }
    }

    function ambil_tempo()
    {
        $token = $this->session->userdata('token');
        $tgl_skrng = date('Y-m-d');
        $hasil = $this->db->query("SELECT * FROM tb_barang WHERE token = '$token' AND tgl_tempo = '$tgl_skrng'")->result();
        foreach ($hasil as $key) {
            echo '<div class="alert text-dark alert-dismissible fade show" style="background-color: yellow;" role="alert">Data barang <b>' . $key->kode_barang . ' - ' . $key->nama_barang . '</b> sudah memasuki jatuh tempo, segera lakukan pemeriksaan barang anda!</div>';
        }
    }

    function ambil_terlaris()
    {
        $token = $this->session->userdata('token');

        $no = 1;
        $barang = $this->db->query("SELECT a.*, sum(a.qty) as total FROM tb_detail_penjualan a WHERE a.token='$token' GROUP BY a.kode_barang ORDER BY total DESC LIMIT 10");
        if ($barang->num_rows() > 0) {
            foreach ($barang->result() as $data) {
                $bar = $this->db->get_where('tb_barang', ['token' => $data->token, 'kode_barang' => $data->kode_barang])->row();
                echo '<tr>
                    <td align="center">' . $no++ . '</td>
                    <td>' . $bar->kode_barang . '</td>
                    <td>' . $bar->nama_barang . '</td>
                    <td align="center">' . $data->total . '</td>
                </tr>';
            }
        } else {
            echo "<tr><td colspan='4' align='center'><i>Tidak ada data ...</i></td></tr>";
        }
    }

    function ambil_pesan()
    {
        $tanggal = $this->db->get_where('user', ['role_id' => 2, 'token' => $this->session->userdata('token')])->result_array();
        foreach ($tanggal as $tgl) {

            $produk = $this->session->userdata('produk');
            if ($produk == '3m') {
                $tanggalakhir = date('Y-m-d', strtotime('+90 day', $tgl['date_created']));
                $tanggalsekarang    = date('Y-m-d');
            } else if ($produk == '1m') {
                $tanggalakhir = date('Y-m-d', strtotime('+30 day', $tgl['date_created']));
                $tanggalsekarang    = date('Y-m-d');
            } else if ($produk == '6m') {
                $tanggalakhir = date('Y-m-d', strtotime('+180 day', $tgl['date_created']));
                $tanggalsekarang    = date('Y-m-d');
            } else {
                $tanggalakhir = date('Y-m-d', strtotime('+365 day', $tgl['date_created']));
                $tanggalsekarang    = date('Y-m-d');
            }

            $hari = IntervalDays($tanggalsekarang, $tanggalakhir);
            $har = round($hari);
        }

        if (($hari <= '10') && ($hari != '0') && ($hari >= '0')) {
            $pesan = '<div class="alert alert-danger hm" role="alert" align="center">
                <h6>Masa aktif sisa ' . $hari . ' Hari. Segera hubungi CS Detapos +62 811-4324-445 untuk perpajangan masa aktif user anda!</h6>
            </div>';

            echo json_encode($pesan);
        } else if (($hari <= '0') && ($hari == '0')) {

            $this->db->set('is_active', 0);
            $this->db->where('token', $this->session->userdata('token'));
            $this->db->update('user');

            $date = array('last_login' => date('Y-m-d H:i:s'));
            $id = $this->session->userdata('role_id');
            $this->db->where('role_id', $id);
            $this->db->update('user', $date);

            $this->session->unset_userdata('email');
            $this->session->unset_userdata('role_id');

            $this->session->set_flashdata('message', '<div class="alert alert-success text-dark alert-dismissible fade show" role="alert">Akses anda berkahir hari ini, Hubungi CS (0811-4324-442)!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Login');
        }
    }
}
