<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notif extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Notif Stok';

        $this->load->view('templates/header', $data);
        $this->load->view('alert/notif', $data);
        $this->load->view('templates/footer');
    }
}
