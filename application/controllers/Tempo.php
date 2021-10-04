<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tempo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Hong_Kong');
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Jatuh Tempo';

        $this->load->view('templates/header', $data);
        $this->load->view('alert/tempo', $data);
        $this->load->view('templates/footer');
    }
}
