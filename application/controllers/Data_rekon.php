<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_rekon extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $this->load->model('Rekon_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'DATA REKON';

        $token = $this->session->userdata('token');
        $data['tahun'] = $this->db->query("SELECT tgl_rekon_tmp, token FROM tb_rekon_tmp WHERE token='$token' GROUP BY year(tgl_rekon_tmp)")->result_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['rekon'] = $this->Rekon_model->cari();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('data/rekon', $data);
        $this->load->view('templates/footer');
    }

    function aksi()
    {
        if (isset($_POST['simpan'])) {

            $no_rekon = $this->Rekon_model->no_rekon();

            $dataa = [
                'no_rekon' => $no_rekon,
                'uraian' => htmlspecialchars($this->input->post('uraian')),
                'nominal' => htmlspecialchars($this->input->post('nominal')),
                'tipe' => htmlspecialchars($this->input->post('tipe')),
                'keterangan' => htmlspecialchars($this->input->post('keterangan')),
                'tgl_rekon_tmp' => htmlspecialchars($this->input->post('tgl_rekon')),
                'token' => htmlspecialchars($this->session->userdata('token')),
            ];
            $this->db->insert('tb_rekon_tmp', $dataa);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Rekon Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Data_rekon') . "';</script>";
        } elseif (isset($_POST['ubah'])) {

            $dataa = [
                'uraian' => htmlspecialchars($this->input->post('uraian')),
                'nominal' => htmlspecialchars($this->input->post('nominal')),
                'tipe' => htmlspecialchars($this->input->post('tipe')),
                'saldo' => htmlspecialchars($this->input->post('saldo')),
                'keterangan' => htmlspecialchars($this->input->post('keterangan'))
            ];
            $this->db->where('id_rekon_tmp', $this->input->post('id_rekon'));
            $this->db->update('tb_rekon_tmp', $dataa);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Rekon Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Data_rekon') . "';</script>";
        } elseif (isset($_POST['simpan_final'])) {

            $dataa = [
                'uraian' => htmlspecialchars($this->input->post('uraian')),
                'nominal' => htmlspecialchars($this->input->post('nominal')),
                'tipe' => htmlspecialchars($this->input->post('tipe')),
                'tgl_final' => htmlspecialchars($this->input->post('tgl_rekon')),
                'token' => htmlspecialchars($this->session->userdata('token')),
            ];
            $this->db->insert('tb_rekon_final', $dataa);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Final Rekon Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Data_rekon/Final_rekon') . "';</script>";
        } elseif (isset($_POST['ubah_final'])) {

            $dataa = [
                'uraian' => htmlspecialchars($this->input->post('uraian')),
                'nominal' => htmlspecialchars($this->input->post('nominal')),
                'tipe' => htmlspecialchars($this->input->post('tipe')),
                'saldo' => htmlspecialchars($this->input->post('saldo')),
                'tgl_final' => htmlspecialchars($this->input->post('tgl_rekon'))
            ];

            $this->db->where('id_rekon_final', $this->input->post('id_rekon'));
            $this->db->update('tb_rekon_final', $dataa);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Final Rekon Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Data_rekon/Final_rekon') . "';</script>";
        }
    }

    public function ubah_rekon()
    {
        if ($_POST['id_rekon']) {
            $id = $_POST['id_rekon'];
            $token = $this->session->userdata('token');

            $data['data'] = $this->db->get_where('tb_rekon_tmp', ['id_rekon_tmp' => $id, 'token' => $token])->row();

            $this->load->view('data/_rekon', $data);
        }
    }

    function cetak()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'CETAK DATA REKON';

        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['rekon'] = $this->Rekon_model->cari();
        }
        $this->load->view('data/cetak_rekon', $data);
    }

    function export()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'EXPORT DATA REKON';

        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['rekon'] = $this->Rekon_model->cari();
        }
        $this->load->view('data/export_rekon', $data);
    }

    public function final_rekon()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'FINAL REKON';

        $token = $this->session->userdata('token');
        $data['tahun'] = $this->db->query("SELECT tgl_rekon_tmp, token FROM tb_rekon_tmp WHERE token='$token' GROUP BY year(tgl_rekon_tmp)")->result_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['final'] = $this->Rekon_model->cariFinal();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('data/final_rekon', $data);
        $this->load->view('templates/footer');
    }

    public function ubah_final_rekon()
    {
        if ($_POST['id_final']) {
            $id = $_POST['id_final'];
            $token = $this->session->userdata('token');

            $data['data'] = $this->db->get_where('tb_rekon_final', ['id_rekon_final' => $id, 'token' => $token])->row();

            $this->load->view('data/_final_rekon', $data);
        }
    }

    function cetak_final()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'CETAK DATA FINAL REKON';

        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['final'] = $this->Rekon_model->cariFinal();
        }
        $this->load->view('data/cetak_final_rekon', $data);
    }

    function export_final()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'EXPORT DATA FINAL REKON';

        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['final'] = $this->Rekon_model->cariFinal();
        }
        $this->load->view('data/export_final_rekon', $data);
    }

    function hapus_final($id)
    {
        $token = $this->session->userdata('token');

        $this->db->where('id_rekon_final', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_rekon_final');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Final Rekon Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Data_rekon/Final_rekon') . "';</script>";
    }

    function hapus_rekon($id)
    {
        $token = $this->session->userdata('token');

        $this->db->where('id_rekon_tmp', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_rekon_tmp');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Rekon Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Data_rekon') . "';</script>";
    }
}
