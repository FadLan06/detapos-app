<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coba extends CI_Controller
{
    public function index()
    {
        // $data['tampil_warna'] = $this->db->get('tb_coba')->result();
        // $this->load->view('coba', $data);
        $this->load->library('Mongo_db', ['activate' => 'default'], 'mongo_db');
        $data = $this->mongo_db->get('user');
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function kirim()
    {
        if ($_POST) {
            $resep = implode(", ", $this->input->post('check_list'));

            $data = [
                'nama' => 'fadlan',
                'resep' => $resep,
            ];

            $this->db->insert('tb_coba', $data);
            redirect('Coba');
        }
    }

    function convert()
    {
        // $this->load->view('coba_convert');
        $this->load->view('cobaa');
    }
}
