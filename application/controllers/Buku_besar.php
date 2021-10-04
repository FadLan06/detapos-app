<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku_besar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $this->load->model('Akuntansi_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'BUKU BESAR';

        $token = $this->session->userdata('token');
        $data['akun'] = $this->db->query("SELECT *,count(tb_jurnal.id_akun) 'jumlah_akun', tb_akun.id_akun 'idakun' from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun");

        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/buku_besar', $data);
        $this->load->view('templates/footer');
    }

    function detail_akun()
    {
        $data['cek_akun'] = $this->db->get_where('tb_akun', ['id_akun' => $_GET['idakun']])->row_array();
        $this->load->view('akuntansi/detail_akun', $data);
    }
}
