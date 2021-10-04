<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        is_logged_in();
        $this->load->model('Data_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Profil Perusahaan';

        $data['setting'] = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        $this->db->where('id_prov!=', 0);
        $this->db->order_by('nama', 'ASC');
        $data['provinsi'] = $this->db->get_where('tb_provinsi')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('setting/profil', $data);
        $this->load->view('templates/footer');
    }

    function aksi()
    {
        if (isset($_POST['ubh_toko'])) {
            if ($_FILES['gambar']['error'] <> 4) {

                $config['upload_path'] = 'assets/upload';
                $config['allowed_types'] = 'jpeg|jpg|png|gif|bmp|ico';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('gambar')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->index($error);
                } else {
                    $hasil  = $this->upload->data();

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = 'assets/upload/' . $hasil['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width']         = 150;
                    $config['height']       = 50;
                    $config['new_image'] = 'assets/upload/' . $hasil['file_name'];

                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $data = array(
                        'nama_toko' => htmlspecialchars($this->input->post('nama_toko')),
                        'alamat' => htmlspecialchars($this->input->post('alamat')),
                        'provinsi' => htmlspecialchars($this->input->post('provinsi')),
                        'kota' => htmlspecialchars($this->input->post('kota')),
                        'no_telpon' => htmlspecialchars($this->input->post('no_telpon')),
                        'email_toko' => htmlspecialchars($this->input->post('email')),
                        'logo'        => $hasil['file_name'],
                        'barcode' => htmlspecialchars($this->input->post('barcode')),
                        'struk' => htmlspecialchars($this->input->post('struk')),
                        'zona' => htmlspecialchars($this->input->post('zona')),
                        'kode_unik' => htmlspecialchars($this->input->post('kode_unik')),
                    );

                    $token  = $this->session->userdata('token');
                    $query  = $this->db->get_where('setting_app', array('token' => $token))->row_array();
                    unlink("assets/upload/" . $query['logo']);

                    $this->db->where('token', $token);
                    $this->db->update('setting_app', $data);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Profil Toko Berhasil Di Ubah!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Profil') . "';</script>";
                }
            } else {
                $data = [
                    'nama_toko' => htmlspecialchars($this->input->post('nama_toko')),
                    'alamat' => htmlspecialchars($this->input->post('alamat')),
                    'provinsi' => htmlspecialchars($this->input->post('provinsi')),
                    'kota' => htmlspecialchars($this->input->post('kota')),
                    'no_telpon' => htmlspecialchars($this->input->post('no_telpon')),
                    'email_toko' => htmlspecialchars($this->input->post('email')),
                    'barcode' => htmlspecialchars($this->input->post('barcode')),
                    'struk' => htmlspecialchars($this->input->post('struk')),
                    'zona' => htmlspecialchars($this->input->post('zona')),
                    'kode_unik' => htmlspecialchars($this->input->post('kode_unik')),
                ];

                $this->db->where('token', $this->session->userdata('token'));
                $this->db->update('setting_app', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Profil Toko Berhasil Di Ubah!'); </script>";
                }
                echo "<script>window.location='" . site_url('Profil') . "';</script>";
            }
        }
    }

    function ambil_data()
    {
        $modul = $this->input->post('modul');
        $id = $this->input->post('id');

        if ($modul == "kabupaten") {
            echo $this->Data_model->kabupaten($id);
        }
    }
}
