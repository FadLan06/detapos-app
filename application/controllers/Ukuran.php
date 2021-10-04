<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ukuran extends CI_Controller
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
        if (isset($_POST['smpn_kur'])) {
            $data = [
                'kode_ukuran' => htmlspecialchars($this->input->post('kode_ukuran')),
                'nama_ukuran' => htmlspecialchars($this->input->post('nama_ukuran')),
                'token' => htmlspecialchars($this->session->userdata('token')),
            ];

            $this->db->insert('tb_ukuran_barang', $data);
            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Ukuran Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Ukuran') . "';</script>";
        } elseif (isset($_POST['ubah_kur'])) {
            $data = [
                'kode_ukuran' => htmlspecialchars($this->input->post('kode_ukuran')),
                'nama_ukuran' => htmlspecialchars($this->input->post('nama_ukuran'))
            ];

            $this->db->where('id_ukuran_barang', $this->input->post('id_ukuran'));
            $this->db->update('tb_ukuran_barang', $data);
            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Ukuran Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Ukuran') . "';</script>";
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Kategori Barang';

        $token = $data['user']['token'];
        $data['ukuran'] = $this->db->get_where('tb_ukuran_barang', ['token' => $token])->result();
        $data['ukuran'] = $this->db->get_where('tb_ukuran_barang', ['token' => $token])->result();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('barang/ukuran_barang', $data);
        $this->load->view('templates/footer');
    }

    function hapus($id)
    {
        $this->db->where('id_ukuran_barang', $id);
        $this->db->delete('tb_ukuran_barang');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Ukuran Barang Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Ukuran') . "';</script>";
    }
}
