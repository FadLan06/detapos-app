<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Data_model');
        // if ($this->session->userdata('role_id') != '1') {
        //     redirect('Login');
        // }
        
        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['title'] = 'DASHBOARD';
        $data['judul'] = 'DASHBOARD';
        $data['tanggal'] = $this->db->get_where('user',['role_id' => 2])->result_array();
        
        $data['users'] = $this->Data_model->users();
        $data['users_aktif'] = $this->Data_model->users_aktif();
        $data['users_nonaktif'] = $this->Data_model->users_nonaktif();

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}