<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alert extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'ALERT INFORMASI';

        $data['alert'] = $this->db->get_where('tb_alert',['kd_alert' => 1])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('alert/index', $data);
        $this->load->view('templates/footer');
    }

    function aksi(){
        if(isset($_POST['simpan'])){
            $data = [
                'sapaan' => $this->input->post('sapaan'),
                'control' => $this->input->post('control'),
                'kalimat' => $this->input->post('kalimat')
            ];

            $this->db->where('kd_alert',1);
            $this->db->update('tb_alert',$data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil Diubah! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Alert');
        }
    }
}