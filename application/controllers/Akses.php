<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akses extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Menu_model');
        // if ($this->session->userdata('role_id') != '1') {
        //     redirect('Login');
        // }
        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['title'] = 'DASHBOARD';
        $data['judul'] = 'USER AKSES';

        $this->db->where('role_id !=', 1);
        $this->db->where('role_id !=', 3);
        $data['kuser'] = $this->db->get('user')->result_array();

        $this->db->where('id_menu !=', 1);
        $this->db->where('id_menu !=', 4);
        $this->db->where('id_menu !=', 5);
        $this->db->where('id_menu !=', 18);
        $this->db->where('is_active', 1);
        $this->db->order_by('menu', 'asc');
        $this->db->join('user_menu', 'user_menu.id = user_sub_menu.id_menu');
        $data['menu'] = $this->db->get('user_sub_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('akses/index', $data);
        $this->load->view('templates/footer');
    }

    public function change_member($id)
    {
        $data['judul'] = 'USER AKSES';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['use'] = $this->db->get_where('user', ['token' => $id, 'role_id' => 2])->row_array();

        $this->db->where('id_menu !=', 1);
        $this->db->where('id_menu !=', 4);
        $this->db->where('id_menu !=', 5);
        $this->db->where('id_menu !=', 18);
        $this->db->where('is_active', 1);
        $this->db->order_by('menu', 'asc');
        $this->db->join('user_menu', 'user_menu.id = user_sub_menu.id_menu');
        $data['menu'] = $this->db->get('user_sub_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('akses/change', $data);
        $this->load->view('templates/footer');
    }

    public function change()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
        $role = $this->input->post('roleI');
        $user_id = $this->input->post('userId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id,
            'role' => $role,
            'user_id' => $user_id,
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function change1()
    {
        $menu_id1 = $this->input->post('menuId1');
        $role_id1 = $this->input->post('roleId1');
        $role1 = $this->input->post('roleI1');
        $user_id1 = $this->input->post('userId1');

        $data = [
            'role_id' => $role_id1,
            'menu_id' => $menu_id1,
            'role' => $role1,
            'user_id' => $user_id1,
        ];

        $result = $this->db->get_where('user_access_menu', $data)->row();

        if ($result->tambah != 1) {
            $this->db->set('tambah', 1);
            $this->db->where('role_id', $role_id1);
            $this->db->where('menu_id', $menu_id1);
            $this->db->where('role', $role1);
            $this->db->where('user_id', $user_id1);
            $this->db->update('user_access_menu');
        } else {
            $this->db->set('tambah', 0);
            $this->db->where('role_id', $role_id1);
            $this->db->where('menu_id', $menu_id1);
            $this->db->where('role', $role1);
            $this->db->where('user_id', $user_id1);
            $this->db->update('user_access_menu');
        }

        // $this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">Tambah Changed!</div>');
    }

    public function change2()
    {
        $menu_id2 = $this->input->post('menuId2');
        $role_id2 = $this->input->post('roleId2');
        $role2 = $this->input->post('roleI2');
        $user_id2 = $this->input->post('userId2');

        $data = [
            'role_id' => $role_id2,
            'menu_id' => $menu_id2,
            'role' => $role2,
            'user_id' => $user_id2,
        ];

        $result = $this->db->get_where('user_access_menu', $data)->row();

        if ($result->ubah != 1) {
            $this->db->set('ubah', 1);
            $this->db->where('role_id', $role_id2);
            $this->db->where('menu_id', $menu_id2);
            $this->db->where('role', $role2);
            $this->db->where('user_id', $user_id2);
            $this->db->update('user_access_menu');
        } else {
            $this->db->set('ubah', 0);
            $this->db->where('role_id', $role_id2);
            $this->db->where('menu_id', $menu_id2);
            $this->db->where('role', $role2);
            $this->db->where('user_id', $user_id2);
            $this->db->update('user_access_menu');
        }

        // $this->session->set_flashdata('message2', '<div class="alert alert-success" role="alert">Ubah Changed!</div>');
    }

    public function change3()
    {
        $menu_id3 = $this->input->post('menuId3');
        $role_id3 = $this->input->post('roleId3');
        $role3 = $this->input->post('roleI3');
        $user_id3 = $this->input->post('userId3');

        $data = [
            'role_id' => $role_id3,
            'menu_id' => $menu_id3,
            'role' => $role3,
            'user_id' => $user_id3,
        ];

        $result = $this->db->get_where('user_access_menu', $data)->row();

        if ($result->hapus != 1) {
            $this->db->set('hapus', 1);
            $this->db->where('role_id', $role_id3);
            $this->db->where('menu_id', $menu_id3);
            $this->db->where('role', $role3);
            $this->db->where('user_id', $user_id3);
            $this->db->update('user_access_menu');
        } else {
            $this->db->set('hapus', 0);
            $this->db->where('role_id', $role_id3);
            $this->db->where('menu_id', $menu_id3);
            $this->db->where('role', $role3);
            $this->db->where('user_id', $user_id3);
            $this->db->update('user_access_menu');
        }

        // $this->session->set_flashdata('message3', '<div class="alert alert-success" role="alert">Hapus Changed!</div>');
    }

    public function reset($id)
    {
        $passnew = rand();
        $username = $this->uri->segment('4');
        $data = ['password' => password_hash($passnew, PASSWORD_DEFAULT)];

        $this->db->where('id', $id);
        $this->db->update('user', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data Member <b>' . $username . '</b>, berhasil reset password menjadi <b>' . $passnew . '</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Akses');
    }

    public function perpanjang($id)
    {
        $wktu = time();
        $username = $this->uri->segment('4');
        $data = ['date_created' => $wktu, 'produk' => '1y'];

        $this->db->where('id', $id);
        $this->db->update('user', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data Member <b>' . $username . '</b>, berhasil Perpanjang Masa Aktif <b>' . longdate_indo(date('Y-m-d', $wktu)) . '</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

        redirect('Akses');
    }

    public function view()
    {
        if ($_POST['id']) {
            $kd = $_POST['id'];
            $data['data'] = $this->db->get_where('user', ['id' => $kd])->row_array();

            $this->load->view('akses/_view', $data);
        }
    }

    public function status($par)
    {
        $this->Menu_model->user_status($par);
    }

    function hapus_akses($id)
    {
        $this->db->where('token', $id);
        $this->db->delete('user');

        $this->db->where('token', $id);
        $this->db->delete('setting_app');

        $this->db->where('token', $id);
        $this->db->delete('tb_akun');

        $this->db->where('token', $id);
        $this->db->delete('tb_barang');

        $this->db->where('token', $id);
        $this->db->delete('tb_detail_penjualan');

        $this->db->where('token', $id);
        $this->db->delete('tb_detail_penjualan_tmp');

        $this->db->where('token', $id);
        $this->db->delete('tb_jurnal');

        $this->db->where('token', $id);
        $this->db->delete('tb_jurnal_tmp');

        $this->db->where('token', $id);
        $this->db->delete('tb_kategori_barang');

        $this->db->where('token', $id);
        $this->db->delete('tb_log');

        $this->db->where('token', $id);
        $this->db->delete('tb_pelanggan');

        $this->db->where('token', $id);
        $this->db->delete('tb_penjualan');

        $this->db->where('token', $id);
        $this->db->delete('tb_supplier');

        $this->db->where('role_id', $id);
        $this->db->delete('user_access_menu');

        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Data User Akses Berhasil di Hapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Akses');
    }
}
