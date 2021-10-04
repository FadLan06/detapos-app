<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Data_model');
        $this->load->model('Barang_model');

        $this->load->library('form_validation');

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    function aksi()
    {
        if (isset($_POST['smpn_war'])) {
            $data = [
                'kode_warna' => htmlspecialchars($this->input->post('kode_warna')),
                'nama_warna' => htmlspecialchars($this->input->post('nama_warna')),
                'token' => htmlspecialchars($this->session->userdata('token')),
            ];

            $this->db->insert('tb_warna_barang', $data);
            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Warna Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Warna') . "';</script>";
        } elseif (isset($_POST['ubah_war'])) {
            $data = [
                'kode_warna' => htmlspecialchars($this->input->post('kode_warna')),
                'nama_warna' => htmlspecialchars($this->input->post('nama_warna'))
            ];

            $this->db->where('id_warna_barang', $this->input->post('id_warna'));
            $this->db->update('tb_warna_barang', $data);
            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Warna Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Warna') . "';</script>";
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Kategori Barang';

        $token = $data['user']['token'];
        $data['warna'] = $this->db->get_where('tb_warna_barang', ['token' => $token])->result();
        $data['ukuran'] = $this->db->get_where('tb_ukuran_barang', ['token' => $token])->result();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('barang/warna_barang', $data);
        $this->load->view('templates/footer');
    }

    function hapus($id)
    {
        $this->db->where('id_warna_barang', $id);
        $this->db->delete('tb_warna_barang');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Warna Barang Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Warna') . "';</script>";
    }
}
