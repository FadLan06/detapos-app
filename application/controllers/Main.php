<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function index()
    {
        $data['judul'] = 'MAINTENANCE';

        // $this->load->view('templates/header', $data);
        $this->load->view('login/main', $data);
        // $this->load->view('templates/footer');
    }

}