<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data User';

        $this->db->where('role_id !=', 1);
        $data['userr'] = $this->db->get_where('user', ['token' => $this->session->userdata('token')])->result();

        $this->load->view('templates/header', $data);
        $this->load->view('setting/user', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_user()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'Username sudah tersedia!'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email sudah tersedia!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[password-confirm]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password-confirm', 'Password Confirm', 'required|trim|matches[password]');


        if ($this->form_validation->run() == false) {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $data['judul'] = 'Tambah Data User';

            $this->load->view('templates/header', $data);
            $this->load->view('setting/tambah_user', $data);
            $this->load->view('templates/footer');
        } else {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $email = $this->input->post('email', true);
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.png',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'posisi' => htmlspecialchars($this->input->post('posisi', true)),
                'role_id' => '3',
                'is_active' => 1,
                'date_created' => time(),
                'coupon' => htmlspecialchars($this->session->userdata('coupon')),
                'token' => htmlspecialchars($this->session->userdata('token'))
            ];

            $token = $this->session->userdata('token');
            $role = $this->session->userdata('role_id');
            $user_id = $this->session->userdata('id');

            $akses = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
            $akses1 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();
            $akses2 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 39])->row_array();
            $akses3 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();

            if (isset($akses['menu_id'])) {
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->db->query("INSERT INTO user_access_menu (id, role_id, menu_id, role, user_id, tambah, ubah, hapus) VALUES ('','$token','18','3','$user_id','1','1','1'), ('','$token','19','3','$user_id','1','1','1'), ('','$token','20','3','$user_id','1','1','1'), ('','$token','22','3','$user_id','1','1','1'), ('','$token','38','3','$user_id','1','1','1'), ('','$token','28','3','$user_id','1','1','0'), ('','$token','36','3','$user_id','1','1','1') ");
            } elseif (isset($akses1['menu_id'])) {
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->db->query("INSERT INTO user_access_menu (id, role_id, menu_id, role, user_id, tambah, ubah, hapus) VALUES ('','$token','18','3','$user_id','1','1','1'), ('','$token','19','3','$user_id','1','1','1'), ('','$token','20','3','$user_id','1','1','1'), ('','$token','22','3','$user_id','1','1','1'), ('','$token','40','3','$user_id','1','1','1'), ('','$token','28','3','$user_id','1','1','0'), ('','$token','36','3','$user_id','1','1','1') ");
            } elseif (isset($akses2['menu_id'])) {
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->db->query("INSERT INTO user_access_menu (id, role_id, menu_id, role, user_id, tambah, ubah, hapus) VALUES ('','$token','18','3','$user_id','1','1','1'), ('','$token','19','3','$user_id','1','1','1'), ('','$token','20','3','$user_id','1','1','1'), ('','$token','22','3','$user_id','1','1','1'), ('','$token','39','3','$user_id','1','1','1'), ('','$token','28','3','$user_id','1','1','0'), ('','$token','36','3','$user_id','1','1','1') ");
            } elseif (isset($akses3['menu_id'])) {
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->db->query("INSERT INTO user_access_menu (id, role_id, menu_id, role, user_id, tambah, ubah, hapus) VALUES ('','$token','18','3','$user_id','1','1','1'), ('','$token','19','3','$user_id','1','1','1'), ('','$token','20','3','$user_id','1','1','1'), ('','$token','22','3','$user_id','1','1','1'), ('','$token','29','3','$user_id','1','1','1'), ('','$token','28','3','$user_id','1','1','0'), ('','$token','36','3','$user_id','1','1','1') ");
            } else {
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->db->query("INSERT INTO user_access_menu (id, role_id, menu_id, role, user_id, tambah, ubah, hapus) VALUES ('','$token','18','3','$user_id','1','1','1'), ('','$token','19','3','$user_id','1','1','1'), ('','$token','20','3','$user_id','1','1','1'), ('','$token','22','3','$user_id','1','1','1'), ('','$token','27','3','$user_id','1','1','1'), ('','$token','28','3','$user_id','1','1','0'), ('','$token','36','3','$user_id','1','1','1') ");
            }

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data user berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('User') . "';</script>";
        }
    }

    public function change_user($id)
    {
        $data['judul'] = 'USER AKSES';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $data['user']['id'];
        $data['use'] = $this->db->get_where('user', ['token' => $id, 'id' => $this->uri->segment(4)])->row_array();
        $set = $this->db->get_where('setting_app', ['token' => $id])->row_array();

        $this->db->where('id_menu !=', 1);
        $this->db->where('id_menu !=', 2);
        $this->db->where('id_menu !=', 4);
        $this->db->where('id_menu !=', 5);
        $this->db->where('id_menu !=', 18);
        $this->db->where('id_menu !=', 19);
        $this->db->where('id_menu !=', 20);
        $this->db->where('id_menu !=', 21);
        $this->db->where('id_menu !=', 22);
        $this->db->where('user_sub_menu.id !=', 29);
        $this->db->where('id_menu !=', 43);
        $this->db->where('id_menu !=', 44);
        $this->db->where('id_menu !=', 53);
        $this->db->where('id_menu !=', 54);
        $this->db->where('id_menu !=', 55);
        $this->db->where('id_menu !=', 29);
        if ($set['usaha'] != 'Butik') {
            $this->db->where('id_menu !=', 57);
            $this->db->where('id_menu !=', 58);
            $this->db->where('id_menu !=', 59);
            $this->db->where('id_menu !=', 61);
            $this->db->where('id_menu !=', 62);
        }
        $this->db->where('id_menu !=', 27);
        $this->db->where('id_menu !=', 38);
        $this->db->where('id_menu !=', 39);
        $this->db->where('id_menu !=', 40);
        $this->db->where('id_menu !=', 56);
        $this->db->where('id_menu !=', 30);
        $this->db->where('is_active', 1);
        if ($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR') {
            $this->db->where('id_menu !=', 36);
        }
        $this->db->order_by('menu', 'asc');
        $this->db->join('user_menu', 'user_menu.id = user_sub_menu.id_menu');
        $data['menu'] = $this->db->get('user_sub_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('setting/chang', $data);
        $this->load->view('templates/footer');
    }

    public function chang()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
        $role = $this->input->post('roleII');
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
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
        } else {
            $this->db->delete('user_access_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Uncheck!</div>');
        }
    }

    public function chang1()
    {
        $menu_id4 = $this->input->post('menuId4');
        $role_id4 = $this->input->post('roleId4');
        $role4 = $this->input->post('roleI4');
        $user_id4 = $this->input->post('userId4');

        $data = [
            'role_id' => $role_id4,
            'menu_id' => $menu_id4,
            'role' => $role4,
            'user_id' => $user_id4,
        ];

        $result = $this->db->get_where('user_access_menu', $data)->row();

        if ($result->tambah != 1) {
            $this->db->set('tambah', 1);
            $this->db->where('role_id', $role_id4);
            $this->db->where('menu_id', $menu_id4);
            $this->db->where('role', $role4);
            $this->db->where('user_id', $user_id4);
            $this->db->update('user_access_menu');
            $this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">Tambah Changed!</div>');
        } else {
            $this->db->set('tambah', 0);
            $this->db->where('role_id', $role_id4);
            $this->db->where('menu_id', $menu_id4);
            $this->db->where('role', $role4);
            $this->db->where('user_id', $user_id4);
            $this->db->update('user_access_menu');
            $this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">Tambah Uncheck!</div>');
        }
    }

    public function chang2()
    {
        $menu_id5 = $this->input->post('menuId5');
        $role_id5 = $this->input->post('roleId5');
        $role5 = $this->input->post('roleI5');
        $user_id5 = $this->input->post('userId5');

        $data = [
            'role_id' => $role_id5,
            'menu_id' => $menu_id5,
            'role' => $role5,
            'user_id' => $user_id5,
        ];

        $result = $this->db->get_where('user_access_menu', $data)->row();

        if ($result->ubah != 1) {
            $this->db->set('ubah', 1);
            $this->db->where('role_id', $role_id5);
            $this->db->where('menu_id', $menu_id5);
            $this->db->where('role', $role5);
            $this->db->where('user_id', $user_id5);
            $this->db->update('user_access_menu');
            $this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">Ubah Changed!</div>');
        } else {
            $this->db->set('ubah', 0);
            $this->db->where('role_id', $role_id5);
            $this->db->where('menu_id', $menu_id5);
            $this->db->where('role', $role5);
            $this->db->where('user_id', $user_id5);
            $this->db->update('user_access_menu');
            $this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">Ubah Uncheck!</div>');
        }
    }

    public function chang3()
    {
        $menu_id6 = $this->input->post('menuId6');
        $role_id6 = $this->input->post('roleId6');
        $role6 = $this->input->post('roleI6');
        $user_id6 = $this->input->post('userId6');

        $data = [
            'role_id' => $role_id6,
            'menu_id' => $menu_id6,
            'role' => $role6,
            'user_id' => $user_id6,
        ];

        $result = $this->db->get_where('user_access_menu', $data)->row();

        if ($result->hapus != 1) {
            $this->db->set('hapus', 1);
            $this->db->where('role_id', $role_id6);
            $this->db->where('menu_id', $menu_id6);
            $this->db->where('role', $role6);
            $this->db->where('user_id', $user_id6);
            $this->db->update('user_access_menu');
            $this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">Hapus Changed!</div>');
        } else {
            $this->db->set('hapus', 0);
            $this->db->where('role_id', $role_id6);
            $this->db->where('menu_id', $menu_id6);
            $this->db->where('role', $role6);
            $this->db->where('user_id', $user_id6);
            $this->db->update('user_access_menu');
            $this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">Hapus Uncheck!</div>');
        }
    }

    public function detail()
    {
        if ($_POST['id']) {
            $kd = $_POST['id'];
            $data['data'] = $this->db->get_where('user', ['id' => $kd])->row();

            $this->load->view('Setting/user_ubah', $data);
        }
    }

    public function ubah_user($kd)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data User';

        $data['data'] = $this->db->get_where('user', ['id' => $kd, 'token' => $this->session->userdata('token')])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('setting/user_ubah', $data);
        $this->load->view('templates/footer');
    }

    function hps_user($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
        $this->db->where('user_id', $id);
        $this->db->delete('user_access_menu');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data user berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('User') . "';</script>";
    }

    function ubah()
    {
        if (isset($_POST['ubh_user'])) {
            $username = $this->input->post('username_user');
            $id = $this->input->post('id');
            $query = $this->db->get_where('user', ['username' => $username]);
            $dt = $query->num_rows();
            $query1 = $this->db->get_where('user', ['id' => $id])->row();
            if (($dt > 0) and ($username != $query1->username)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal ubah data user, username yang anda ubah sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('User/Ubah_User/') . $id . "';</script>";
            } else {
                $baru = $this->input->post('password_user');
                $data = [
                    'nama' => htmlspecialchars($this->input->post('nama_user')),
                    'username' => htmlspecialchars($this->input->post('username_user')),
                    'email' => htmlspecialchars($this->input->post('email_user')),
                    'password' => password_hash($baru, PASSWORD_DEFAULT),
                    'posisi' => htmlspecialchars($this->input->post('posisi')),
                ];

                $this->db->where('id', $this->input->post('id'));
                $this->db->update('user', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data user berhasil di Ubah!'); </script>";
                }
                echo "<script>window.location='" . site_url('User') . "';</script>";
            }
        }
    }
}
