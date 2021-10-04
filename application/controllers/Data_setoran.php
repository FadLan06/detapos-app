<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_setoran extends CI_Controller
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
        $data['judul'] = 'DATA SETORAN';

        $token = $this->session->userdata('token');
        $data['tahun'] = $this->db->query("SELECT tgl_rekon_tmp, token FROM tb_rekon_tmp WHERE token='$token' GROUP BY year(tgl_rekon_tmp)")->result_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        if ($this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['setoran'] = $this->Rekon_model->cariSet();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('data/setoran', $data);
        $this->load->view('templates/footer');
    }

    function aksi()
    {
        if (isset($_POST['simpan'])) {

            $no_setoran = $this->Rekon_model->no_setoran();

            $data = [
                'no_setoran' => $no_setoran,
                'tgl_setoran' => htmlspecialchars($this->input->post('tgl_setoran')),
                'uraian' => htmlspecialchars($this->input->post('uraian')),
                'token' => htmlspecialchars($this->session->userdata('token')),
            ];
            $this->db->insert('tb_setoran', $data);

            $bukti = $_FILES['bukti'];
            if ($bukti = '') {
            } else {
                $config['upload_path'] = './assets/upload/bukti/';
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('bukti')) {
                } else {
                    $bukti = $this->upload->data('file_name');
                }
            }
            $dataa = [
                'no_setoran' => $no_setoran,
                'tgl_tmp' => htmlspecialchars($this->input->post('tgl_setoran')),
                'nominal' => htmlspecialchars($this->input->post('nominal')),
                'expedisi' => htmlspecialchars($this->input->post('expedisi')),
                'rekening' => htmlspecialchars($this->input->post('rekening')),
                'bukti' => $bukti,
                'nm_pen' => htmlspecialchars($this->input->post('nm_pen')),
                'posisi' => htmlspecialchars($this->input->post('posisi')),
                'token' => htmlspecialchars($this->session->userdata('token')),
            ];
            $this->db->insert('tb_setoran_tmp', $dataa);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Setoran Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Data_setoran') . "';</script>";
        } elseif (isset($_POST['ubah'])) {

            $data = [
                'tgl_setoran' => htmlspecialchars($this->input->post('tgl_setoran')),
                'uraian' => htmlspecialchars($this->input->post('uraian')),
            ];

            $dataa = [
                'tgl_tmp' => htmlspecialchars($this->input->post('tgl_setoran')),
                'nominal' => htmlspecialchars($this->input->post('nominal')),
                'expedisi' => htmlspecialchars($this->input->post('expedisi')),
                'rekening' => htmlspecialchars($this->input->post('rekening')),
                'nm_pen' => htmlspecialchars($this->input->post('nm_pen')),
                'posisi' => htmlspecialchars($this->input->post('posisi')),
            ];

            $this->db->where('id_setoran', $this->input->post('id_setoran'));
            $this->db->update('tb_setoran', $data);
            $this->db->where('id_setoran_tmp', $this->input->post('id_setoran_tmp'));
            $this->db->update('tb_setoran_tmp', $dataa);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Setoran Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Data_setoran') . "';</script>";
        }
    }

    public function ubah_setoran()
    {
        if ($_POST['id']) {
            $id = $_POST['id'];
            $token = $this->session->userdata('token');

            $data['data'] = $this->db->get_where('tb_setoran', ['no_setoran' => $id, 'token' => $token])->row();

            $this->load->view('data/_setoran', $data);
        }
    }

    function hapus($id)
    {
        $token = $this->session->userdata('token');

        $data  = $this->db->get_where('tb_setoran_tmp', array('token' => $token, 'no_setoran' => $id))->result_array();
        foreach ($data as $dataa) {
            unlink("assets/upload/bukti/" . $dataa['bukti']);
        }

        $this->db->where('no_setoran', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_setoran');

        $this->db->where('no_setoran', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_setoran_tmp');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Setoran Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Data_setoran') . "';</script>";
    }

    function cetak()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'CETAK DATA SETORAN';

        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['setoran'] = $this->Rekon_model->cariSet();
        }
        $this->load->view('data/cetak_setoran', $data);
    }

    function export()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'EXPORT DATA SETORAN';

        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['setoran'] = $this->Rekon_model->cariSet();
        }
        $this->load->view('data/export_setoran', $data);
    }

    public function detail_bank()
    {
        if ($_POST['id']) {
            $id = $_POST['id'];
            $token = $this->session->userdata('token');

            $data['data'] = $this->db->get_where('tb_setoran_tmp', ['id_setoran_tmp' => $id, 'token' => $token, 'expedisi' => 'B'])->row();

            $this->load->view('data/_detail_bank', $data);
        }
    }

    public function detail_tunai()
    {
        if ($_POST['id']) {
            $id = $_POST['id'];
            $token = $this->session->userdata('token');

            $data['data'] = $this->db->get_where('tb_setoran_tmp', ['id_setoran_tmp' => $id, 'token' => $token, 'expedisi' => 'T'])->row();

            $this->load->view('data/_detail_tunai', $data);
        }
    }
}
