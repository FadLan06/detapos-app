<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Menu_model', 'menu');
        // if ($this->session->userdata('role_id') != '1') {
        //     redirect('Login');
        // }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['title'] = 'DATA MENU';
        $data['judul'] = 'DATA MENU';
        $data['menu1'] = $this->db->get('user_menu')->result();

        $data['submenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['sub_menu'] = $this->db->query("SELECT * FROM user_sub_menu WHERE sub_menu = 0 GROUP BY title")->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('templates/footer');
    }

    function aksi()
    {
        if (isset($_POST['smpn_menu'])) {
            $this->db->set('menu', $this->input->post('menu'));
            $this->db->insert('user_menu');

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Menu') . "';</script>";
        } elseif (isset($_POST['ubah_menu'])) {
            $this->db->set('menu', $this->input->post('menu'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('user_menu');

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Menu') . "';</script>";
        } elseif (isset($_POST['smpn_sub'])) {
            $data = [
                'title' => $this->input->post('title'),
                'id_menu' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'sub_menu' => $this->input->post('sub_menu'),
                'is_active' => 1
            ];
            $this->db->insert('user_sub_menu', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Submenu Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Menu') . "';</script>";
        } elseif (isset($_POST['ubah_sub'])) {
            $data = [
                'title' => $this->input->post('title'),
                'id_menu' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'sub_menu' => $this->input->post('sub_menu'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('user_sub_menu', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Submenu Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Menu') . "';</script>";
        }
    }

    function hapus_menu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_menu');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Menu') . "';</script>";
    }

    public function hapus_sub($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Submenu Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Menu') . "';</script>";
    }

    public function detail_menu()
    {
        if ($_POST['id']) {
            $kd = $_POST['id'];
            $data['data'] = $this->db->get_where('user_menu', ['id' => $kd])->row();

            $this->load->view('menu/_ubah_menu', $data);
        }
    }

    public function detail_sub()
    {
        if ($_POST['id']) {
            $kd = $_POST['id'];
            $data['data'] = $this->db->get_where('user_sub_menu', ['id' => $kd])->row();
            $data['menu'] = $this->db->get('user_menu')->result_array();
            $data['sub_menu'] = $this->db->get_where('user_sub_menu', ['sub_menu' => 0])->result_array();

            $this->load->view('menu/_ubah_sub', $data);
        }
    }
}
