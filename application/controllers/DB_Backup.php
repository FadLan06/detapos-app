<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DB_Backup extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
        if ($this->session->userdata('role_id') != '1') {
            redirect('Login');
        }
        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Backup Database';

        $this->load->view('templates/header', $data);
        $this->load->view('db_backup/index', $data);
        $this->load->view('templates/footer');
    }

    public function backup()
    {
        $this->load->dbutil();

        $tanggal = date('YmdS_His');

        $config = [
            'format'                => 'zip',
            'filename'              => 'DetaPOS_' . $tanggal . '_db.sql',
            'add_drop'              => TRUE,
            'add_insert'            => TRUE,
            'newline'               => "\n",
            'foreign_key_checks'    => FALSE,
        ];

        $backup = &$this->dbutil->backup($config);
        $nama_file = 'DetaPOS_' . $tanggal . '.zip';
        $this->load->helper('download');
        force_download($nama_file, $backup);
    }
}
