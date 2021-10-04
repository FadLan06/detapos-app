<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $this->load->model('Akuntansi_model');
    }

    function aksi()
    {
        if (isset($_POST['tmbh_akun'])) {
            $kode_akun = htmlspecialchars($this->input->post('kode_akun'));
            $aksi = $this->db->get_where('tb_akun', ['kode_akun' => $kode_akun, 'token' => $this->session->userdata('token')]);
            $dat = $aksi->num_rows();
            if ($dat > 0) {
                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Proses gagal!, Tidak boleh kode akun yang sama.'); </script>";
                }
            } else {
                $data = [
                    'kode_akun' => htmlspecialchars($this->input->post('kode_akun')),
                    'nama_akun' => htmlspecialchars($this->input->post('nama_akun')),
                    'kategori' => htmlspecialchars($this->input->post('kategori')),
                    'token' => htmlspecialchars($this->session->userdata('token'))
                ];

                $this->db->insert('tb_akun', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Akun Berhasil di Tambahkan!'); </script>";
                }
            }
            echo "<script>window.location='" . site_url('Akun') . "';</script>";
        } elseif (isset($_POST['ubah_akun'])) {
            $data = [
                'kode_akun' => htmlspecialchars($this->input->post('kode_akun')),
                'nama_akun' => htmlspecialchars($this->input->post('nama_akun')),
                'kategori' => htmlspecialchars($this->input->post('kategori'))
            ];

            $this->db->where('id_akun', $this->input->post('id_akun'));
            $this->db->update('tb_akun', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Akun Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Akun') . "';</script>";
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'AKUN';

        $token = $this->session->userdata('token');
        $this->db->order_by('kode_akun', 'ASC');
        $data['akun'] = $this->db->get_where('tb_akun', ['token' => $token]);

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/akun', $data);
        $this->load->view('templates/footer');
    }

    public function dt_akun()
    {
        if ($_POST['id_akun']) {
            $kd = $_POST['id_akun'];
            $token = $this->session->userdata('token');

            $data['data'] = $this->db->get_where('tb_akun', ['id_akun' => $kd, 'token' => $token])->row_array();

            $this->load->view('akuntansi/_akun', $data);
        }
    }

    function hps_akun($id)
    {
        $query1 = $this->db->get_where('tb_jurnal', ['id_akun' => $id]);
        $kd1 = $query1->num_rows();
        if ($kd1 > 0) {

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Akun ini tidak bisa di Hapus, Karena akun ini sudah ada di Jurnal Umum! '); </script>";
            }
        } else {
            $this->db->where('id_akun', $id);
            $this->db->delete('tb_akun');

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Akun Berhasil di Hapus!'); </script>";
            }
        }
        echo "<script>window.location='" . site_url('Akun') . "';</script>";
    }
}
