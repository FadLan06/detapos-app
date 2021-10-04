<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        is_logged_in();

        // if ($this->session->userdata('role_id') != '2') {
        //     redirect('Login');
        // }
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    public function index()
    {
        $this->form_validation->set_rules('lama', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password', 'Password Baru', 'required|trim|min_length[4]|matches[password1]', [
            'matches' => 'Kata sandi tidak cocok!',
            'min_length' => 'Kata sandi terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password1', 'Konfirmasi Password Baru', 'required|trim|matches[password]', [
            'matches' => 'Kata sandi tidak cocok!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $data['judul'] = 'Account';

            $data['setting'] = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('setting/account', $data);
            $this->load->view('templates/footer');
        } else {
            $lama = $this->input->post('lama');
            $baru = $this->input->post('password');
            if (password_verify($lama, $this->session->userdata('password'))) {
                if ($baru == $lama) {

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Password Baru Tidak Boleh Sama!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Account') . "';</script>";
                } else {
                    $hash = password_hash($baru, PASSWORD_DEFAULT);

                    $this->db->set('password', $hash);
                    $this->db->where('username', $this->session->userdata('username'));
                    $this->db->update('user');

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Password berhasil di Ubah!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Account') . "';</script>";

                    $date = array('last_login' => date('Y-m-d H:i:s'));
                    $id = $this->session->userdata('role_id');
                    $this->db->where('role_id', $id);
                    $this->db->update('user', $date);

                    $this->session->unset_userdata('username');
                    $this->session->unset_userdata('role_id');
                }
            } else {
                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Password Lama Salah!'); </script>";
                }
                echo "<script>window.location='" . site_url('Account') . "';</script>";
            }
        }
    }

    function aksi()
    {
        if (isset($_POST['ubh'])) {
            $username = $this->input->post('username');
            $id = $this->session->userdata('id');
            $query = $this->db->get_where('user', ['username' => $username]);
            $dt = $query->num_rows();
            $query1 = $this->db->get_where('user', ['id' => $id])->row();
            if (($dt > 0) and ($username != $query1->username)) {
                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal ubah data account, username yang anda ubah sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Account') . "';</script>";
            } else {
                $data = [
                    'nama' => htmlspecialchars($this->input->post('nama')),
                    'email' => htmlspecialchars($this->input->post('email')),
                    'username' => htmlspecialchars($this->input->post('username')),
                ];

                $this->db->where('id', $this->session->userdata('id'));
                $this->db->update('user', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Profil Toko Berhasil Di Ubah!'); </script>";
                }
                echo "<script>window.location='" . site_url('Account') . "';</script>";
            }
        }
    }
}
