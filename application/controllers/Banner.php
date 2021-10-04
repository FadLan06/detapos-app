<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banner extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Upload Banner';

        $token = $this->session->userdata('token');
        $data['banner'] = $this->db->get_where('tb_shop_banner', ['token' => $token])->result_array();

        $this->db->where('token', $token);
        $data['rows'] = $this->db->count_all_results('tb_shop_banner');

        $this->load->view('templates/header', $data);
        $this->load->view('pesanan/banner', $data);
        $this->load->view('templates/footer');
    }

    function aksi()
    {
        if (isset($_POST['simpan'])) {
            if ($_FILES['gambar']['error'] <> 4) {

                $config['upload_path'] = './assets/upload/banner/';
                $config['allowed_types'] = '*';
                $config['encrypt_name'] = true;
                $config['max_size'] = '1024';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('gambar')) {
                    echo "<script>alert('Data File Gambar Gagal Upload!'); </script>";
                    echo "<script>window.location='" . site_url('Banner') . "';</script>";
                } else {
                    $hasil  = $this->upload->data();

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/upload/banner/' . $hasil['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 1200;
                    $config['height'] = 400;
                    $config['new_image'] = './assets/upload/banner/' . $hasil['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $data = [
                        'nama_produk' => htmlspecialchars($this->input->post('nama_produk')),
                        'produk' => htmlspecialchars($hasil['file_name']),
                        'token' => htmlspecialchars($this->session->userdata('token')),
                    ];

                    $this->db->insert('tb_shop_banner', $data);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data File Gambar Berhasil di Tambahkan!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Banner') . "';</script>";
                }
            }
        }
    }

    function hapus($id)
    {
        $token = $this->session->userdata('token');
        $data  = $this->db->get_where('tb_shop_banner', array('token' => $token, 'id_shop_banner' => $id))->result_array();
        foreach ($data as $dataa) {
            unlink("assets/upload/banner/" . $dataa['produk']);
        }

        $this->db->where("id_shop_banner", $id);
        $this->db->where("token", $token);
        $this->db->delete("tb_shop_banner");

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data File Gambar Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Banner') . "';</script>";
    }
}
