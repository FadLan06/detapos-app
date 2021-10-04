<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ket_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();


        $this->load->model('m_kategori');
        $this->load->model('Data_model');
        $this->load->model('Barang_model');

        $this->load->library('form_validation');

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    function aksi()
    {
        if (isset($_POST['smpn_ket'])) {
            $kode_kategori = htmlspecialchars($this->input->post('kd_kat'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_kategori_barang', ['token' => $token, 'kode_kategori' => $kode_kategori])->num_rows();
            $query1 = $this->db->get_where('tb_kategori_barang', ['token' => $token, 'kode_kategori' => $kode_kategori])->row();

            if (($query > 0) and ($kode_kategori == $query1->kode_kategori)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data kategori barang, Kode Kategori sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
            } else {
                if ($_FILES['icon']['error'] <> 4) {

                    $config['upload_path'] = './assets/upload/kategori/';
                    $config['allowed_types'] = 'jpeg|jpg|png|gif|bmp|ico';
                    $config['encrypt_name'] = true;
                    $config['max_size']     = '100';
                    $config['max_width']    = '217';
                    $config['max_height']   = '217';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('icon')) {
                        echo "<script>alert('Data Kategori Barang Gagal Upload!'); </script>";
                        echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
                    } else {
                        $hasil  = $this->upload->data();

                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './assets/upload/kategori/' . $hasil['file_name'];
                        $config['create_thumb'] = FALSE;
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 100;
                        $config['height'] = 100;
                        $config['new_image'] = './assets/upload/kategori/' . $hasil['file_name'];
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();

                        $data = [
                            'kode_kategori' => htmlspecialchars($this->input->post('kd_kat')),
                            'nama_kategori' => htmlspecialchars($this->input->post('nama_kategori')),
                            'icon' => $hasil['file_name'],
                            'token' => htmlspecialchars($this->session->userdata('token')),
                        ];

                        $this->db->insert('tb_kategori_barang', $data);

                        if ($this->db->affected_rows() > 0) {
                            echo "<script>alert('Data Kategori Barang Berhasil di Tambahkan!'); </script>";
                        }
                        echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
                    }
                } else {
                    $data = [
                        'kode_kategori' => htmlspecialchars($this->input->post('kd_kat')),
                        'nama_kategori' => htmlspecialchars($this->input->post('nama_kategori')),
                        'token' => htmlspecialchars($this->session->userdata('token')),
                    ];

                    $this->db->insert('tb_kategori_barang', $data);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Kategori Barang Berhasil di Tambahkan!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
                }
            }
        } elseif (isset($_POST['ubah_ket'])) {
            if ($_FILES['icon']['error'] <> 4) {

                $config['upload_path'] = './assets/upload/kategori/';
                $config['allowed_types'] = 'jpeg|jpg|png|gif|bmp|ico';
                $config['encrypt_name'] = true;
                $config['max_size']     = '100';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('icon')) {
                    echo "<script>alert('Data Kategori Barang Gagal Upload!'); </script>";
                    echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
                } else {
                    $hasil  = $this->upload->data();
                    $data = [
                        'kode_kategori' => htmlspecialchars($this->input->post('kd_kat')),
                        'nama_kategori' => htmlspecialchars($this->input->post('nama_kategori')),
                        'icon' => $hasil['file_name'],
                    ];

                    $token  = $this->session->userdata('token');
                    $id_kategori = htmlspecialchars($this->input->post('id_kat'));
                    $query  = $this->db->get_where('tb_kategori_barang', array('token' => $token, 'id_kategori' => $id_kategori))->row_array();
                    unlink("assets/upload/kategori/" . $query['icon']);

                    $this->db->where('id_kategori', htmlspecialchars($this->input->post('id_kat')));
                    $this->db->update('tb_kategori_barang', $data);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Kategori Barang Berhasil di Ubah!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
                }
            } else {
                $data = [
                    'kode_kategori' => htmlspecialchars($this->input->post('kd_kat')),
                    'nama_kategori' => htmlspecialchars($this->input->post('nama_kategori')),
                ];

                $this->db->where('id_kategori', htmlspecialchars($this->input->post('id_kat')));
                $this->db->update('tb_kategori_barang', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Kategori Barang Berhasil di Ubah!'); </script>";
                }
                echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
            }
        } elseif (isset($_POST['smpn_sub_ket'])) {
            $kode_sub = htmlspecialchars($this->input->post('kode_sub_kategori'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_sub_kategori_barang', ['token' => $token, 'kode_sub_kategori' => $kode_sub])->num_rows();
            $query1 = $this->db->get_where('tb_sub_kategori_barang', ['token' => $token, 'kode_sub_kategori' => $kode_sub])->row();

            if (($query > 0) and ($kode_sub == $query1->kode_kategori)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data sub kategori barang, Kode Sub Kategori sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
            } else {
                $data = [
                    'kode_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                    'kode_sub_kategori' => htmlspecialchars($this->input->post('kode_sub_kategori')),
                    'nama_sub_kategori' => htmlspecialchars($this->input->post('nama_sub_kategori')),
                    'token' => htmlspecialchars($this->session->userdata('token')),
                ];

                $this->db->insert('tb_sub_kategori_barang', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Sub Kategori Barang Berhasil di Tambahkan!'); </script>";
                }
                echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
            }
        } elseif (isset($_POST['ubah_sub_ket'])) {
            $data = [
                'kode_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                'nama_sub_kategori' => htmlspecialchars($this->input->post('nama_sub_kategori')),
            ];

            $this->db->where('id_sub_kategori', htmlspecialchars($this->input->post('id_sub_kategori')));
            $this->db->update('tb_sub_kategori_barang', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Kategori Barang Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Kategori Barang';

        $token = $data['user']['token'];
        $data['kat'] = $this->db->get_where('tb_kategori_barang', ['token' => $token])->result();
        $data['set'] = $this->db->get_where('setting_app', ['token' => $token])->row();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('barang/ket_barang', $data);
        $this->load->view('templates/footer');
    }

    public function ubah_kategori($kd)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Ubah Data Kategori Barang';

        $token = $this->session->userdata('token');
        $data['data'] = $this->db->get_where('tb_kategori_barang', ['id_kategori' => $kd, 'token' => $token])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('barang/ubah_ket_barang', $data);
        $this->load->view('templates/footer');
    }

    function hapus_ket($id)
    {
        $token  = $this->session->userdata('token');
        $query  = $this->db->get_where('tb_kategori_barang', array('token' => $token, 'id_kategori' => $id))->row_array();
        unlink("assets/upload/kategori/" . $query['icon']);

        $this->db->where('id_kategori', $id);
        $this->db->delete('tb_kategori_barang');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Kategori Barang Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Ket_barang') . "';</script>";
    }
}
