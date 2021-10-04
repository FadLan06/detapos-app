<?php
defined('BASEPATH') or exit('No direct script access allowed');

class No_rekening extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'No. Rekening Perusahaan';

        $token = $this->session->userdata('token');
        $data['rekening'] = $this->db->get_where('tb_rekening', ['token' => $token])->result_array();
        $data['rek'] = $this->db->get_where('tb_rekening', ['token' => $token])->row();
        $data['moota'] = $this->db->get_where('tb_moota', ['token' => $token])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('setting/no_rekening', $data);
        $this->load->view('templates/footer');
    }

    function proses_rek()
    {
        if (isset($_POST['tambah_rek'])) {
            $data = [
                'atas_nama'     =>  htmlspecialchars($this->input->post('atas_nama')),
                'no_rekening'   =>  htmlspecialchars($this->input->post('no_rekening')),
                'jenis'         =>  htmlspecialchars($this->input->post('jenis')),
                'aktif'         =>  1,
                'token'     =>  htmlspecialchars($this->session->userdata('token'))
            ];

            $this->db->insert('tb_rekening', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('No_rekening') . "';</script>";
        } else if (isset($_POST['ubah_rek'])) {
            $data = [
                'atas_nama'     =>  htmlspecialchars($this->input->post('atas_nama')),
                'no_rekening'   =>  htmlspecialchars($this->input->post('no_rekening')),
                'jenis'         =>  htmlspecialchars($this->input->post('jenis'))
            ];

            $this->db->where('kd_rekening', $this->input->post('kd_rekening'));
            $this->db->update('tb_rekening', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('No_rekening') . "';</script>";
        } elseif (isset($_POST['tambah_moota'])) {
            $data = [
                'apikey'     =>  htmlspecialchars($this->input->post('apikey')),
                'is_active'  =>  1,
                'token'     =>  htmlspecialchars($this->session->userdata('token'))
            ];

            $this->db->insert('tb_moota', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('No_rekening') . "';</script>";
        } elseif (isset($_POST['ubah_moota'])) {
            $data = [
                'apikey'     =>  htmlspecialchars($this->input->post('apikey'))
            ];

            $this->db->where('token', $this->session->userdata('token'));
            $this->db->update('tb_moota', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('No_rekening') . "';</script>";
        }
    }

    function simpan()
    {
        $data = [
            'apikey'     =>  htmlspecialchars($this->input->post('apikey')),
            'is_active'  =>  1,
            'token'     =>  htmlspecialchars($this->session->userdata('token'))
        ];

        $result = $this->db->insert('tb_moota', $data);
        echo json_encode($result);
    }

    function simpan1()
    {
        $data = [
            'apikey'     =>  htmlspecialchars($this->input->post('apikey'))
        ];

        $this->db->where('token', $this->session->userdata('token'));
        $result = $this->db->update('tb_moota', $data);
        echo json_encode($result);
    }

    function hapus($id)
    {
        $this->db->where('kd_rekening', $id);
        $this->db->delete('tb_rekening');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('No_rekening') . "';</script>";
    }

    public function ubah_rek()
    {
        if ($_POST['kd_rekening']) {
            $kd = $_POST['kd_rekening'];
            $token = $this->session->userdata('token');
            $data['data'] = $this->db->get_where('tb_rekening', ['kd_rekening' => $kd, 'token' => $token])->row_array();

            $this->load->view('setting/_ubah_rek', $data);
        }
    }

    public function aktif()
    {
        $token = $this->input->post('token');

        $data = [
            'token' => $token,
        ];

        $result = $this->db->get_where('tb_rekening', $data)->row();

        if ($result->aktif != 1) {
            $this->db->set('aktif', 1);
            $this->db->where('token', $token);
            $this->db->update('tb_rekening');
            $this->session->set_flashdata('message1', '<div class="alert alert-success alert-dismissible fade show" role="alert">Changed<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $this->db->set('aktif', 0);
            $this->db->where('token', $token);
            $this->db->update('tb_rekening');
            $this->session->set_flashdata('message1', '<div class="alert alert-success alert-dismissible fade show" role="alert">Uncheck<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    public function aktif1()
    {
        $token = $this->input->post('token');

        $data = [
            'token' => $token,
        ];

        $result = $this->db->get_where('tb_moota', $data)->row();

        if ($result->is_active != 1) {
            $this->db->set('is_active', 1);
            $this->db->where('token', $token);
            $this->db->update('tb_moota');
            $this->session->set_flashdata('message1', '<div class="alert alert-success alert-dismissible fade show" role="alert">Changed<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $this->db->set('is_active', 0);
            $this->db->where('token', $token);
            $this->db->update('tb_moota');
            $this->session->set_flashdata('message1', '<div class="alert alert-success alert-dismissible fade show" role="alert">Uncheck<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
}
