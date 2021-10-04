<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
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
        if (isset($_POST['smpn_brng'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->row();

            if (($query > 0) and ($kode_barang == $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Tambah_Barang') . "';</script>";
            } else {
                $data = [
                    'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                    'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                    'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                    'tgl_input' => htmlspecialchars(date('y-m-d')),
                    'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                    'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                    'harga_jual' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual'))),
                    'persen' => htmlspecialchars($this->input->post('persen')),
                    'profit' => htmlspecialchars(str_replace(',', '', $this->input->post('profit'))),
                    'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                    'jml_stok' => htmlspecialchars($this->input->post('jml_stok')),
                    'minimal_stok' => htmlspecialchars($this->input->post('minimal_stok')),
                    'satuan' => htmlspecialchars($this->input->post('satuan')),
                    'token' => htmlspecialchars($this->session->userdata('token')),
                ];

                $this->db->insert('tb_barang', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Barang Berhasil di Tambahkan!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang') . "';</script>";
            }
        } elseif (isset($_POST['ubh_brng'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $id = htmlspecialchars($this->input->post('id'));
            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'id' => $id])->row();

            if (($query > 0) and ($kode_barang != $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Ubah_Barang/') . $id . "';</script>";
            } else {
                $tmbh = $this->input->post('jml_stok');
                $data = [
                    'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                    'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                    'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                    'tgl_input' => htmlspecialchars(date('y-m-d')),
                    'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                    'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                    'harga_jual' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual'))),
                    'persen' => htmlspecialchars($this->input->post('persen')),
                    'profit' => htmlspecialchars(str_replace(',', '', $this->input->post('profit'))),
                    'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                    'satuan' => htmlspecialchars($this->input->post('satuan')),
                    'minimal_stok' => htmlspecialchars($this->input->post('minimal_stok')),
                ];

                $this->db->set('jml_stok', $tmbh);
                $this->db->where('id', htmlspecialchars($this->input->post('id')));
                $this->db->update('tb_barang', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Barang Berhasil di Ubah!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang') . "';</script>";
            }
        } elseif (isset($_POST['smpn_brng_rt'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->row();

            if (($query > 0) and ($kode_barang == $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Tambah_Barang') . "';</script>";
            } else {
                $data = [
                    'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                    'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                    'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                    'tgl_input' => htmlspecialchars(date('y-m-d')),
                    'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                    'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                    'harga_jual' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual'))),
                    'persen' => htmlspecialchars($this->input->post('persen')),
                    'profit' => htmlspecialchars(str_replace(',', '', $this->input->post('profit'))),
                    'harga_jual1' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual1'))),
                    'persen1' => htmlspecialchars($this->input->post('persen1')),
                    'profit1' => htmlspecialchars(str_replace(',', '', $this->input->post('profit1'))),
                    'harga_jual2' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual2'))),
                    'persen2' => htmlspecialchars($this->input->post('persen2')),
                    'profit2' => htmlspecialchars(str_replace(',', '', $this->input->post('profit2'))),
                    'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                    'jml_stok' => htmlspecialchars($this->input->post('jml_stok')),
                    'minimal_stok' => htmlspecialchars($this->input->post('minimal_stok')),
                    'satuan' => htmlspecialchars($this->input->post('satuan')),
                    'isi' => htmlspecialchars($this->input->post('isi')),
                    'satuan1' => htmlspecialchars($this->input->post('satuan1')),
                    'isi1' => htmlspecialchars($this->input->post('isi1')),
                    'satuan2' => htmlspecialchars($this->input->post('satuan2')),
                    'isi2' => htmlspecialchars($this->input->post('isi2')),
                    'satuan3' => htmlspecialchars($this->input->post('satuan3')),
                    'isi3' => htmlspecialchars($this->input->post('isi3')),
                    'token' => htmlspecialchars($this->session->userdata('token')),
                ];

                $this->db->insert('tb_barang', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Barang Berhasil di Tambahkan!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang') . "';</script>";
            }
        } elseif (isset($_POST['ubh_brng_rt'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $id = htmlspecialchars($this->input->post('id'));
            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'id' => $id])->row();

            if (($query > 0) and ($kode_barang != $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Ubah_Barang/') . $id . "';</script>";
            } else {
                $tmbh = $this->input->post('jml_stok');
                $data = [
                    'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                    'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                    'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                    'tgl_input' => htmlspecialchars(date('y-m-d')),
                    'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                    'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                    'harga_jual' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual'))),
                    'persen' => htmlspecialchars($this->input->post('persen')),
                    'profit' => htmlspecialchars(str_replace(',', '', $this->input->post('profit'))),
                    'harga_jual1' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual1'))),
                    'persen1' => htmlspecialchars($this->input->post('persen1')),
                    'profit1' => htmlspecialchars(str_replace(',', '', $this->input->post('profit1'))),
                    'harga_jual2' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual2'))),
                    'persen2' => htmlspecialchars($this->input->post('persen2')),
                    'profit2' => htmlspecialchars(str_replace(',', '', $this->input->post('profit2'))),
                    'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                    'satuan' => htmlspecialchars($this->input->post('satuan')),
                    'isi' => htmlspecialchars($this->input->post('isi')),
                    'satuan1' => htmlspecialchars($this->input->post('satuan1')),
                    'isi1' => htmlspecialchars($this->input->post('isi1')),
                    'satuan2' => htmlspecialchars($this->input->post('satuan2')),
                    'isi2' => htmlspecialchars($this->input->post('isi2')),
                    'satuan3' => htmlspecialchars($this->input->post('satuan3')),
                    'isi3' => htmlspecialchars($this->input->post('isi3')),
                    'minimal_stok' => htmlspecialchars($this->input->post('minimal_stok')),
                ];

                $this->db->set('jml_stok', $tmbh);
                $this->db->where('id', htmlspecialchars($this->input->post('id')));
                $this->db->update('tb_barang', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Barang Berhasil di Ubah!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang') . "';</script>";
            }
        } elseif (isset($_POST['smpn_brng_ck'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->row();

            if (($query > 0) and ($kode_barang == $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Tambah_Barang') . "';</script>";
            } else {
                if ($this->input->post('smpn_brng_ck') && !empty($_FILES['file_upload']['name'])) {
                    $number = sizeof($_FILES['file_upload']['tmp_name']);
                    $files = $_FILES['file_upload'];

                    for ($i = 0; $i <= $number; $i++) {
                        if ($_FILES['file_upload']['error'][$i] != 0) {
                            $this->form_validation->set_message('file_upload', 'Couldn\'t upload the files');
                            return false;
                        }
                    }

                    $config['upload_path'] = './assets/upload/barang/';
                    $config['allowed_types'] = 'jpg|jpeg|jpe|png|gif|bmp';
                    $config['encrypt_name'] = true;

                    for ($i = 0; $i <= $number; $i++) {
                        $_FILES['file_upload']['name'] = $files['name'][$i];
                        $_FILES['file_upload']['type'] = $files['type'][$i];
                        $_FILES['file_upload']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['file_upload']['error'] = $files['error'][$i];
                        $_FILES['file_upload']['size'] = $files['size'][$i];

                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('file_upload')) {
                            $data = $this->upload->data();
                            chmod($data['full_path'], 0777);

                            $slug = url_title($this->input->post('nama_barang'), 'dash', TRUE);
                            $sl = $this->db->get_where('tb_barang', ['nama_barang' => $this->input->post('nama_barang')])->num_rows();
                            $sll = $sl + 1;

                            $config['image_library'] = 'gd2';
                            $config['source_image'] = './assets/upload/barang/' . $data['file_name'];
                            $config['create_thumb'] = FALSE;
                            $config['maintain_ratio'] = FALSE;
                            $config['quality'] = '50%';
                            $config['width'] = 400;
                            $config['height'] = 800;
                            $config['new_image'] = './assets/upload/barang/' . $data['file_name'];
                            $this->load->library('image_lib', $config);
                            $this->image_lib->resize();

                            $insert[$i]['kode_barang'] = htmlspecialchars($this->input->post('kode_barang'));
                            $insert[$i]['slug'] = htmlspecialchars($slug . '' . $sll);
                            $insert[$i]['gambar'] = $data['file_name'];
                            $insert[$i]['file_size'] = $data['file_size'];
                            $insert[$i]['token'] = htmlspecialchars($this->session->userdata('token'));
                        }
                    }
                    $this->db->insert_batch('tb_barang_tmp', $insert);

                    $slug = url_title($this->input->post('nama_barang'), 'dash', TRUE);
                    $sl = $this->db->get_where('tb_barang', ['nama_barang' => $this->input->post('nama_barang')])->num_rows();
                    $sll = $sl + 1;
                    $data = [
                        'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                        'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                        'slug' => htmlspecialchars($slug . '' . $sll),
                        'berat' => htmlspecialchars($this->input->post('berat')),
                        'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                        'tgl_input' => htmlspecialchars(date('y-m-d')),
                        'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                        'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                        'harga_jual' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual'))),
                        'persen' => htmlspecialchars($this->input->post('persen')),
                        'profit' => htmlspecialchars(str_replace(',', '', $this->input->post('profit'))),
                        'harga_jual1' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual1'))),
                        'persen1' => htmlspecialchars($this->input->post('persen1')),
                        'profit1' => htmlspecialchars(str_replace(',', '', $this->input->post('profit1'))),
                        'harga_jual2' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual2'))),
                        'persen2' => htmlspecialchars($this->input->post('persen2')),
                        'profit2' => htmlspecialchars(str_replace(',', '', $this->input->post('profit2'))),
                        'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                        'jml_stok' => htmlspecialchars($this->input->post('jml_stok')),
                        'minimal_stok' => htmlspecialchars($this->input->post('min_stok')),
                        'satuan' => htmlspecialchars($this->input->post('satuan')),
                        'isi' => htmlspecialchars($this->input->post('isi')),
                        'satuan1' => htmlspecialchars($this->input->post('satuan1')),
                        'isi1' => htmlspecialchars($this->input->post('isi1')),
                        'satuan2' => htmlspecialchars($this->input->post('satuan2')),
                        'isi2' => htmlspecialchars($this->input->post('isi2')),
                        'satuan3' => htmlspecialchars($this->input->post('satuan3')),
                        'isi3' => htmlspecialchars($this->input->post('isi3')),
                        'token' => htmlspecialchars($this->session->userdata('token')),
                    ];

                    $this->db->insert('tb_barang', $data);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Berhasil di Tambahkan!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                }
            }
        } elseif (isset($_POST['ubh_brng_ck'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $id = htmlspecialchars($this->input->post('id'));
            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'id' => $id])->row();

            if (($query > 0) and ($kode_barang != $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Ubah_Barang/') . $id . "';</script>";
            } else {
                $tmbh = $this->input->post('jml_stok');
                $slug = url_title($this->input->post('link'), 'dash', TRUE);
                $data = [
                    'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                    'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                    'slug' => htmlspecialchars($slug),
                    'berat' => htmlspecialchars($this->input->post('berat')),
                    'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                    'tgl_input' => htmlspecialchars(date('y-m-d')),
                    'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                    'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                    'harga_jual' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual'))),
                    'persen' => htmlspecialchars($this->input->post('persen')),
                    'profit' => htmlspecialchars(str_replace(',', '', $this->input->post('profit'))),
                    'harga_jual1' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual1'))),
                    'persen1' => htmlspecialchars($this->input->post('persen1')),
                    'profit1' => htmlspecialchars(str_replace(',', '', $this->input->post('profit1'))),
                    'harga_jual2' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_jual2'))),
                    'persen2' => htmlspecialchars($this->input->post('persen2')),
                    'profit2' => htmlspecialchars(str_replace(',', '', $this->input->post('profit2'))),
                    'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                    'satuan' => htmlspecialchars($this->input->post('satuan')),
                    'isi' => htmlspecialchars($this->input->post('isi')),
                    'satuan1' => htmlspecialchars($this->input->post('satuan1')),
                    'isi1' => htmlspecialchars($this->input->post('isi1')),
                    'satuan2' => htmlspecialchars($this->input->post('satuan2')),
                    'isi2' => htmlspecialchars($this->input->post('isi2')),
                    'satuan3' => htmlspecialchars($this->input->post('satuan3')),
                    'isi3' => htmlspecialchars($this->input->post('isi3')),
                    'minimal_stok' => htmlspecialchars($this->input->post('min_stok')),
                ];

                $this->db->set('jml_stok', $tmbh);
                $this->db->where('id', htmlspecialchars($this->input->post('id')));
                $this->db->update('tb_barang', $data);

                $dataa = [
                    'kode_barang' => $this->input->post('kode_barang'),
                    'slug' => $slug,
                ];

                $this->db->where('kode_barang', $this->input->post('kode_barang'));
                $this->db->update('tb_barang_tmp', $dataa);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Barang Berhasil di Ubah!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang') . "';</script>";
            }
        } elseif (isset($_POST['ubah_gambar'])) {
            if ($this->input->post('ubah_gambar') && !empty($_FILES['file_upload']['name'])) {
                $number = sizeof($_FILES['file_upload']['tmp_name']);
                $files = $_FILES['file_upload'];

                if ($_FILES['file_upload']['error'] != 0) {
                    $this->form_validation->set_message('file_upload', 'Couldn\'t upload the files');
                    return false;
                }

                $config['upload_path'] = 'assets/upload/barang/';
                $config['allowed_types'] = 'jpg|jpeg|jpe|png|gif|bmp';
                $config['encrypt_name'] = true;

                $_FILES['file_upload']['name'] = $files['name'];
                $_FILES['file_upload']['type'] = $files['type'];
                $_FILES['file_upload']['tmp_name'] = $files['tmp_name'];
                $_FILES['file_upload']['error'] = $files['error'];
                $_FILES['file_upload']['size'] = $files['size'];

                $this->upload->initialize($config);
                if ($this->upload->do_upload('file_upload')) {
                    $data = $this->upload->data();
                    chmod($data['full_path'], 0777);

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/upload/barang/' . $data['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['quality'] = '50%';
                    $config['width'] = 400;
                    $config['height'] = 800;
                    $config['new_image'] = './assets/upload/barang/' . $data['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $insert['kode_barang'] = htmlspecialchars($this->input->post('kode_barang'));
                    $insert['slug'] = htmlspecialchars($this->input->post('slug'));
                    $insert['gambar'] = $data['file_name'];
                    $insert['file_size'] = $data['file_size'];
                    $insert['token'] = htmlspecialchars($this->session->userdata('token'));
                }
                $token  = $this->session->userdata('token');
                $query  = $this->db->get_where('tb_barang_tmp', array('token' => $token, 'kd_barang_tmp' => $this->input->post('kode')))->row_array();
                unlink("assets/upload/barang/" . $query['gambar']);

                $this->db->where('kd_barang_tmp', $this->input->post('kode'));
                $this->db->delete('tb_barang_tmp');

                $this->db->insert('tb_barang_tmp', $insert);
                redirect('Barang/Ubah_Barang/' . $this->input->post('id'));
            }
        } elseif (isset($_POST['smpn_brng_bt'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->row();

            if (($query > 0) and ($kode_barang == $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Tambah_Barang') . "';</script>";
            } else {
                if ($_FILES['gambar']['error'] <> 4) {

                    $config['upload_path'] = './assets/upload/barang/';
                    $config['allowed_types'] = 'jpeg|jpg|png|gif|bmp|ico';
                    $config['encrypt_name'] = true;
                    $config['max_size']     = '1024';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('gambar')) {
                        echo "<script>alert('Data Gambar Produk Gagal Upload!'); </script>";
                        echo "<script>window.location='" . site_url('Barang/Tambah_Barang') . "';</script>";
                    } else {
                        $hasil  = $this->upload->data();

                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './assets/upload/barang/' . $hasil['file_name'];
                        $config['create_thumb'] = FALSE;
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 600;
                        $config['height'] = 600;
                        $config['new_image'] = './assets/upload/barang/' . $hasil['file_name'];
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();

                        $data = [
                            'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                            'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                            'berat' => htmlspecialchars($this->input->post('berat')),
                            'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                            'tgl_input' => htmlspecialchars(date('y-m-d')),
                            'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                            'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                            'satuan' => htmlspecialchars($this->input->post('satuann')),
                            'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                            'sub_kategori' => htmlspecialchars($this->input->post('sub_kategori')),
                            'jml_stok' => htmlspecialchars($this->input->post('jml_stok')),
                            'minimal_stok' => htmlspecialchars($this->input->post('min_stok')),
                            'status' => htmlspecialchars($this->input->post('status')),
                            'dropship' => htmlspecialchars($this->input->post('dropship')),
                            'gambar' => htmlspecialchars($hasil['file_name']),
                            'token' => htmlspecialchars($this->session->userdata('token')),
                        ];

                        $this->db->insert('tb_barang', $data);
                        $id_barang = $this->input->post('kode_barang');

                        $warna = str_replace(',', '', $this->input->post('warna'));
                        if ($warna != '') {
                            for ($ii = 0; $ii < count($warna); $ii++) {
                                $ins = [
                                    'kode_barang' => $id_barang,
                                    'warna' => $warna[$ii],
                                    'token' => htmlspecialchars($this->session->userdata('token')),
                                ];
                                $this->db->insert('tb_barang_warna', $ins);
                            }
                        }

                        $ukuran = str_replace(',', '', $this->input->post('ukuran'));
                        if ($ukuran != '') {
                            for ($u = 0; $u < count($ukuran); $u++) {
                                $in = [
                                    'kode_barang' => $id_barang,
                                    'ukuran' => $ukuran[$u],
                                    'token' => htmlspecialchars($this->session->userdata('token')),
                                ];
                                $this->db->insert('tb_barang_ukuran', $in);
                            }
                        }

                        $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                        $harga_jual = str_replace(',', '', $this->input->post('harga_jual'));
                        $persen = $this->input->post('persen');
                        $profit = str_replace(',', '', $this->input->post('profit'));
                        $satuan = $this->input->post('satuan');

                        for ($i = 0; $i < count($harga_jual); $i++) {
                            $dataa = [
                                'id_barang' => $id_barang,
                                'harga_beli' => $harga_beli,
                                'harga_jual' => $harga_jual[$i],
                                'persen' => $persen[$i],
                                'profit' => $profit[$i],
                                'satuan' => $satuan[$i],
                                'token' => htmlspecialchars($this->session->userdata('token')),
                            ];

                            $this->db->insert('tb_barang_harga', $dataa);
                        }

                        if ($zona['reseller'] == 1) {
                            $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                            $harga_reseller = str_replace(',', '', $this->input->post('harga_r'));
                            $persen = $this->input->post('persen_r');
                            $profit = str_replace(',', '', $this->input->post('profit_r'));
                            $satuan = $this->input->post('satuan_r');

                            $dataa = [
                                'id_barang' => $id_barang,
                                'harga_beli' => $harga_beli,
                                'harga_reseller' => $harga_reseller,
                                'persen' => $persen,
                                'profit' => $profit,
                                'satuan' => $satuan,
                                'token' => htmlspecialchars($this->session->userdata('token')),
                            ];

                            $this->db->insert('tb_barang_harga_reseller', $dataa);
                        }

                        if ($this->db->affected_rows() > 0) {
                            echo "<script>alert('Data Barang Berhasil di Tambahkan!'); </script>";
                        }
                        echo "<script>window.location='" . site_url('Barang') . "';</script>";
                    }
                } else {
                    $data = [
                        'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                        'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                        'berat' => htmlspecialchars($this->input->post('berat')),
                        'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                        'tgl_input' => htmlspecialchars(date('y-m-d')),
                        'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                        'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                        'satuan' => htmlspecialchars($this->input->post('satuann')),
                        'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                        'sub_kategori' => htmlspecialchars($this->input->post('sub_kategori')),
                        'warna' => htmlspecialchars($this->input->post('warna')),
                        'ukuran' => htmlspecialchars($this->input->post('ukuran')),
                        'jml_stok' => htmlspecialchars($this->input->post('jml_stok')),
                        'minimal_stok' => htmlspecialchars($this->input->post('min_stok')),
                        'status' => htmlspecialchars($this->input->post('status')),
                        'dropship' => htmlspecialchars($this->input->post('dropship')),
                        'token' => htmlspecialchars($this->session->userdata('token')),
                    ];

                    $this->db->insert('tb_barang', $data);
                    $id_barang = $this->input->post('kode_barang');

                    $warna = str_replace(',', '', $this->input->post('warna'));
                    if ($warna != '') {
                        for ($ii = 0; $ii < count($warna); $ii++) {
                            $ins = [
                                'kode_barang' => $id_barang,
                                'warna' => $warna[$ii],
                                'token' => htmlspecialchars($this->session->userdata('token')),
                            ];
                            $this->db->insert('tb_barang_warna', $ins);
                        }
                    }

                    $ukuran = str_replace(',', '', $this->input->post('ukuran'));
                    if ($ukuran != '') {
                        for ($u = 0; $u < count($ukuran); $u++) {
                            $in = [
                                'kode_barang' => $id_barang,
                                'ukuran' => $ukuran[$u],
                                'token' => htmlspecialchars($this->session->userdata('token')),
                            ];
                            $this->db->insert('tb_barang_ukuran', $in);
                        }
                    }

                    $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                    $harga_jual = str_replace(',', '', $this->input->post('harga_jual'));
                    $persen = $this->input->post('persen');
                    $profit = str_replace(',', '', $this->input->post('profit'));
                    $satuan = $this->input->post('satuan');

                    for ($i = 0; $i < count($harga_jual); $i++) {
                        $dataa = [
                            'id_barang' => $id_barang,
                            'harga_beli' => $harga_beli,
                            'harga_jual' => $harga_jual[$i],
                            'persen' => $persen[$i],
                            'profit' => $profit[$i],
                            'satuan' => $satuan[$i],
                            'token' => htmlspecialchars($this->session->userdata('token')),
                        ];

                        $this->db->insert('tb_barang_harga', $dataa);
                    }

                    if ($zona['reseller'] == 1) {
                        $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                        $harga_reseller = str_replace(',', '', $this->input->post('harga_r'));
                        $persen = $this->input->post('persen_r');
                        $profit = str_replace(',', '', $this->input->post('profit_r'));
                        $satuan = $this->input->post('satuan_r');

                        $dataa = [
                            'id_barang' => $id_barang,
                            'harga_beli' => $harga_beli,
                            'harga_reseller' => $harga_reseller,
                            'persen' => $persen,
                            'profit' => $profit,
                            'satuan' => $satuan,
                            'token' => htmlspecialchars($this->session->userdata('token')),
                        ];

                        $this->db->insert('tb_barang_harga_reseller', $dataa);
                    }

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Berhasil di Tambahkan!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                }
            }
        } elseif (isset($_POST['ubh_brng_bt'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $id = htmlspecialchars($this->input->post('id'));
            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'id' => $id])->row();

            if (($query > 0) and ($kode_barang != $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal ubah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Ubah_Barang/') . $id . "';</script>";
            } else {
                if ($_FILES['gambar']['error'] <> 4) {

                    $config['upload_path'] = './assets/upload/barang/';
                    $config['allowed_types'] = 'jpeg|jpg|png|gif|bmp|ico';
                    $config['encrypt_name'] = true;
                    $config['max_size']     = '1024';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('gambar')) {
                        echo "<script>alert('Data Gambar Produk Gagal Upload!'); </script>";
                        echo "<script>window.location=history.go(-1);</script>";
                    } else {
                        $hasil  = $this->upload->data();

                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './assets/upload/barang/' . $hasil['file_name'];
                        $config['create_thumb'] = FALSE;
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 600;
                        $config['height'] = 600;
                        $config['new_image'] = './assets/upload/barang/' . $hasil['file_name'];
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();

                        $data = [
                            'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                            'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                            'berat' => htmlspecialchars($this->input->post('berat')),
                            'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                            'tgl_input' => htmlspecialchars(date('y-m-d')),
                            'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                            'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                            'satuan' => htmlspecialchars($this->input->post('satuann')),
                            'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                            'sub_kategori' => htmlspecialchars($this->input->post('sub_kategori')),
                            'jml_stok' => htmlspecialchars($this->input->post('jml_stok')),
                            'minimal_stok' => htmlspecialchars($this->input->post('minimal_stok')),
                            'status' => htmlspecialchars($this->input->post('status')),
                            'dropship' => htmlspecialchars($this->input->post('dropship')),
                            'gambar' => htmlspecialchars($hasil['file_name']),
                        ];

                        $token  = $this->session->userdata('token');
                        $id = $this->input->post('id');
                        $query  = $this->db->get_where('tb_barang', array('token' => $token, 'id' => $id))->row_array();
                        unlink("./assets/upload/barang/" . $query['gambar']);

                        $this->db->where('id', $id);
                        $this->db->update('tb_barang', $data);

                        $warna = str_replace(',', '', $this->input->post('warna'));
                        if ($warna != '') {
                            $this->db->delete('tb_barang_warna', array('kode_barang' => $this->input->post('kode_barang')));
                            for ($i = 0; $i < count($warna); $i++) {
                                $ins = [
                                    'kode_barang' => $this->input->post('kode_barang'),
                                    'warna' => $warna[$i],
                                    'token' => htmlspecialchars($this->session->userdata('token')),
                                ];
                                $this->db->insert('tb_barang_warna', $ins);
                            }
                        }

                        $ukuran = str_replace(',', '', $this->input->post('ukuran'));
                        if ($ukuran != '') {
                            $this->db->delete('tb_barang_ukuran', array('kode_barang' => $this->input->post('kode_barang')));
                            for ($u = 0; $u < count($ukuran); $u++) {
                                $in = [
                                    'kode_barang' => $this->input->post('kode_barang'),
                                    'ukuran' => $ukuran[$u],
                                    'token' => htmlspecialchars($this->session->userdata('token')),
                                ];
                                $this->db->insert('tb_barang_ukuran', $in);
                            }
                        }

                        $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                        $harga_jual = str_replace(',', '', $this->input->post('harga_jual'));
                        $persen = $this->input->post('persen');
                        $profit = str_replace(',', '', $this->input->post('profit'));
                        $satuan = $this->input->post('satuan');
                        $iid = $this->input->post('iid');

                        $this->db->delete('tb_barang_harga', array('id_barang' => $this->input->post('kode_barang'), 'token' => $token));
                        for ($ii = 0; $ii < count($harga_jual); $ii++) {
                            $dataa = [
                                'id_barang' => $this->input->post('kode_barang'),
                                'harga_beli' => $harga_beli,
                                'harga_jual' => $harga_jual[$ii],
                                'persen' => $persen[$ii],
                                'profit' => $profit[$ii],
                                'satuan' => $satuan[$ii],
                                'token' => htmlspecialchars($this->session->userdata('token')),
                            ];

                            $this->db->insert('tb_barang_harga', $dataa);
                        }

                        if ($zona['reseller'] == 1) {
                            $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                            $harga_reseller = str_replace(',', '', $this->input->post('harga_r'));
                            $persen = $this->input->post('persen_r');
                            $profit = str_replace(',', '', $this->input->post('profit_r'));
                            $satuan = $this->input->post('satuan_r');

                            $this->db->delete('tb_barang_harga_reseller', array('id_barang' => $this->input->post('kode_barang'), 'token' => $token));
                            if ($harga_reseller != 0) {
                                $dataa = [
                                    'id_barang' => $this->input->post('kode_barang'),
                                    'harga_beli' => $harga_beli,
                                    'harga_reseller' => $harga_reseller,
                                    'persen' => $persen,
                                    'profit' => $profit,
                                    'satuan' => $satuan,
                                    'token' => htmlspecialchars($this->session->userdata('token')),
                                ];
                                $this->db->insert('tb_barang_harga_reseller', $dataa);
                            }
                        }

                        if ($this->db->affected_rows() > 0) {
                            echo "<script>alert('Data Barang Berhasil di Ubah!'); </script>";
                        }
                        echo "<script>window.location='" . site_url('Barang') . "';</script>";
                    }
                } else {
                    $id = $this->input->post('id');
                    $data = [
                        'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                        'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                        'berat' => htmlspecialchars($this->input->post('berat')),
                        'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                        'tgl_input' => htmlspecialchars(date('y-m-d')),
                        'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                        'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                        'satuan' => htmlspecialchars($this->input->post('satuann')),
                        'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                        'sub_kategori' => htmlspecialchars($this->input->post('sub_kategori')),
                        'jml_stok' => htmlspecialchars($this->input->post('jml_stok')),
                        'minimal_stok' => htmlspecialchars($this->input->post('minimal_stok')),
                        'status' => htmlspecialchars($this->input->post('status')),
                        'dropship' => htmlspecialchars($this->input->post('dropship')),
                    ];

                    $this->db->where('id', $id);
                    $this->db->update('tb_barang', $data);

                    $warna = str_replace(',', '', $this->input->post('warna'));
                    if ($warna != '') {
                        $this->db->delete('tb_barang_warna', array('kode_barang' => $this->input->post('kode_barang')));
                        for ($i = 0; $i < count($warna); $i++) {
                            $ins = [
                                'kode_barang' => $this->input->post('kode_barang'),
                                'warna' => $warna[$i],
                                'token' => htmlspecialchars($this->session->userdata('token')),
                            ];
                            $this->db->insert('tb_barang_warna', $ins);
                        }
                    }

                    $ukuran = str_replace(',', '', $this->input->post('ukuran'));
                    if ($ukuran != '') {
                        $this->db->delete('tb_barang_ukuran', array('kode_barang' => $this->input->post('kode_barang')));
                        for ($u = 0; $u < count($ukuran); $u++) {
                            $in = [
                                'kode_barang' => $this->input->post('kode_barang'),
                                'ukuran' => $ukuran[$u],
                                'token' => htmlspecialchars($this->session->userdata('token')),
                            ];
                            $this->db->insert('tb_barang_ukuran', $in);
                        }
                    }

                    $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                    $harga_jual = str_replace(',', '', $this->input->post('harga_jual'));
                    $persen = $this->input->post('persen');
                    $profit = str_replace(',', '', $this->input->post('profit'));
                    $satuan = $this->input->post('satuan');
                    $iid = $this->input->post('iid');

                    $this->db->delete('tb_barang_harga', array('id_barang' => $this->input->post('kode_barang'), 'token' => $token));
                    for ($ii = 0; $ii < count($harga_jual); $ii++) {
                        $dataa = [
                            'id_barang' => $this->input->post('kode_barang'),
                            'harga_beli' => $harga_beli,
                            'harga_jual' => $harga_jual[$ii],
                            'persen' => $persen[$ii],
                            'profit' => $profit[$ii],
                            'satuan' => $satuan[$ii],
                            'token' => htmlspecialchars($this->session->userdata('token')),
                        ];

                        $this->db->insert('tb_barang_harga', $dataa);
                    }

                    if ($zona['reseller'] == 1) {
                        $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                        $harga_reseller = str_replace(',', '', $this->input->post('harga_r'));
                        $persen = $this->input->post('persen_r');
                        $profit = str_replace(',', '', $this->input->post('profit_r'));
                        $satuan = $this->input->post('satuan_r');

                        $this->db->delete('tb_barang_harga_reseller', array('id_barang' => $this->input->post('kode_barang'), 'token' => $token));
                        if ($harga_reseller != 0) {
                            $dataa = [
                                'id_barang' => $this->input->post('kode_barang'),
                                'harga_beli' => $harga_beli,
                                'harga_reseller' => $harga_reseller,
                                'persen' => $persen,
                                'profit' => $profit,
                                'satuan' => $satuan,
                                'token' => htmlspecialchars($this->session->userdata('token')),
                            ];
                            $this->db->insert('tb_barang_harga_reseller', $dataa);
                        }
                    }

                    echo "<script>alert('Data Barang Berhasil di Ubah!'); </script>";
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                }
            }
        } elseif (isset($_POST['smpn_brng_el'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->row();

            if (($query > 0) and ($kode_barang == $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Tambah_Barang') . "';</script>";
            } else {
                $data = [
                    'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                    'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                    'berat' => '',
                    'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                    'tgl_input' => htmlspecialchars(date('y-m-d')),
                    'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                    'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                    'satuan' => htmlspecialchars($this->input->post('satuann')),
                    'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                    'sub_kategori' => htmlspecialchars($this->input->post('sub_kategori')),
                    'warna' => htmlspecialchars($this->input->post('warna')),
                    'ukuran' => htmlspecialchars($this->input->post('ukuran')),
                    'jml_stok' => htmlspecialchars($this->input->post('jml_stok')),
                    'minimal_stok' => htmlspecialchars($this->input->post('min_stok')),
                    'gambar' => '',
                    'token' => htmlspecialchars($this->session->userdata('token')),
                ];

                $this->db->insert('tb_barang', $data);
                $id_barang = $this->input->post('kode_barang');

                $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                $harga_jual = str_replace(',', '', $this->input->post('harga_jual'));
                $persen = $this->input->post('persen');
                $profit = str_replace(',', '', $this->input->post('profit'));
                $satuan = $this->input->post('satuan');

                $dataa = [
                    'id_barang' => $id_barang,
                    'harga_beli' => $harga_beli,
                    'harga_jual' => $harga_jual,
                    'persen' => $persen,
                    'profit' => $profit,
                    'satuan' => $satuan,
                    'token' => htmlspecialchars($this->session->userdata('token')),
                ];

                $this->db->insert('tb_barang_harga', $dataa);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Barang Berhasil di Tambahkan!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang') . "';</script>";
            }
        } elseif (isset($_POST['ubah_brng_el'])) {
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);

            $id = htmlspecialchars($this->input->post('id'));
            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->num_rows();
            $query1 = $this->db->get_where('tb_barang', ['token' => $token, 'id' => $id])->row();

            if (($query > 0) and ($kode_barang != $query1->kode_barang)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal ubah data barang, Kode Barang sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang/Ubah_Barang/') . $id . "';</script>";
            } else {
                $data = [
                    'kode_barang' => htmlspecialchars($this->input->post('kode_barang')),
                    'nama_barang' => htmlspecialchars($this->input->post('nama_barang')),
                    'berat' => '',
                    'deskripsi' => htmlspecialchars($this->input->post('deskripsi')),
                    'tgl_input' => htmlspecialchars(date('y-m-d')),
                    'tgl_tempo' => htmlspecialchars($this->input->post('tgl_tempo')),
                    'harga_beli' => htmlspecialchars(str_replace(',', '', $this->input->post('harga_beli'))),
                    'satuan' => htmlspecialchars($this->input->post('satuann')),
                    'id_kategori' => htmlspecialchars($this->input->post('kode_kategori')),
                    'sub_kategori' => htmlspecialchars($this->input->post('sub_kategori')),
                    'warna' => htmlspecialchars($this->input->post('warna')),
                    'ukuran' => htmlspecialchars($this->input->post('ukuran')),
                    'jml_stok' => htmlspecialchars($this->input->post('jml_stok')),
                    'minimal_stok' => htmlspecialchars($this->input->post('min_stok')),
                    'gambar' => '',
                    'token' => htmlspecialchars($this->session->userdata('token')),
                ];

                $this->db->where('id', $this->input->post('id'));
                $this->db->update('tb_barang', $data);
                $id_barang = $this->input->post('kode_barang');

                $harga_beli = str_replace(',', '', $this->input->post('harga_beli'));
                $harga_jual = str_replace(',', '', $this->input->post('harga_jual'));
                $persen = $this->input->post('persen');
                $profit = str_replace(',', '', $this->input->post('profit'));
                $satuan = $this->input->post('satuan');

                $dataa = [
                    'id_barang' => $id_barang,
                    'harga_beli' => $harga_beli,
                    'harga_jual' => $harga_jual,
                    'persen' => $persen,
                    'profit' => $profit,
                    'satuan' => $satuan,
                    'token' => htmlspecialchars($this->session->userdata('token')),
                ];

                $this->db->where('id_barang_harga', $this->input->post('idd'));
                $this->db->update('tb_barang_harga', $dataa);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Barang Berhasil di Ubah!'); </script>";
                }
                echo "<script>window.location='" . site_url('Barang') . "';</script>";
            }
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Barang';

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['barang'] = $this->db->query("SELECT b.*, b.kode_barang as kode FROM tb_barang b WHERE b.token='$token' GROUP BY b.kode_barang")->num_rows();
        $data['supplier'] = $this->db->get_where('tb_supplier', ['token' => $token])->result();
        $data['kategori'] = $this->db->get_where('tb_kategori_barang', ['token' => $token])->result();
        $data['set'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $retail = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();
        $check = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 39])->row_array();
        $butik = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();
        $electro = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 31])->row_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        if (isset($retail['menu_id'])) :
            $this->load->view('templates/header', $data);
            $this->load->view('barang/barang_retail', $data);
            $this->load->view('templates/footer');
        elseif (isset($check['menu_id'])) :
            $this->load->view('templates/header', $data);
            $this->load->view('barang/barang_check', $data);
            $this->load->view('templates/footer');
        elseif (isset($butik['menu_id'])) :
            $this->load->view('templates/header', $data);
            $this->load->view('barang/barang_butik', $data);
            $this->load->view('templates/footer');
        elseif (isset($electro['menu_id'])) :
            $this->load->view('templates/header', $data);
            $this->load->view('barang/barang_electro', $data);
            $this->load->view('templates/footer');
        else :
            $this->load->view('templates/header', $data);
            $this->load->view('barang/barang', $data);
            $this->load->view('templates/footer');
        endif;
    }

    public function export_bar()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Download Data Barang';

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['barang'] = $this->db->query("SELECT b.*, b.kode_barang as kode FROM tb_barang b WHERE b.token='$token' GROUP BY b.kode_barang")->result_array();

        $data['retail'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();
        $data['check'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 39])->row_array();
        $butik = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();

        if (isset($butik['menu_id'])) :
            $this->load->view('barang/export_barang_butik', $data);
        else :
            $this->load->view('barang/export_barang', $data);
        endif;
    }

    public function detail()
    {
        if ($_POST['kode_barang']) {
            $kd = $_POST['kode_barang'];
            $token = $this->session->userdata('token');

            $data['dataaa'] = $this->db->get_where('tb_barang', ['kode_barang' => $kd])->row();
            $data['barang'] = $this->db->query("SELECT b.*, b.kode_barang as kode FROM tb_barang b WHERE b.token='$token' GROUP BY b.kode_barang")->result_array();

            $this->load->view('barang/_lihat', $data);
        }
    }

    public function detail_barang()
    {
        if ($_POST) {
            $kd = $_POST['kd'];
            $gam = $_POST['gam'];
            $token = $this->session->userdata('token');

            $data['data'] = $this->db->get_where('tb_barang', ['kode_barang' => $kd, 'token' => $token])->row();
            $data['gambar'] = $this->db->get_where('tb_barang_tmp', ['kode_barang' => $kd, 'token' => $token, 'gambar' => $gam])->row();

            $this->load->view('barang/_detail_gambar', $data);
        }
    }

    function cetak_barang()
    {
        $token = $this->session->userdata('token');
        $data['nm_toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $data['barang'] = $this->db->query("SELECT b.*, b.kode_barang as kode FROM tb_barang b WHERE b.token='$token' GROUP BY b.kode_barang")->result_array();
        $this->load->view('barang/cetak_barang', $data);
    }

    function hapus_brng($id, $kd)
    {
        $token = $this->session->userdata('token');
        $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $kd, 'token' => $token]);
        $kd = $query->num_rows();
        if ($kd > 0) {
            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Barang ini tidak bisa di Hapus, Karna barang ini sudah pernah dijual! '); </script>";
            }
            echo "<script>window.location='" . site_url('Barang') . "';</script>";
        } else {
            $this->db->where('id', $id);
            $this->db->where('token', $token);
            $this->db->delete('tb_barang');

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Barang Berhasil di Hapus!'); </script>";
            }
            echo "<script>window.location='" . site_url('Barang') . "';</script>";
        }
    }

    function hapus_brng_cek($id, $kode)
    {
        $token = $this->session->userdata('token');
        $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $kode, 'token' => $token])->num_rows();
        $query1 = $this->db->get_where('tb_checkout', ['kode_barang' => $kode, 'token' => $token])->num_rows();

        if (($query > 0) || ($query1 > 0)) {
            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Barang ini tidak bisa di Hapus, Karna barang ini sudah pernah dijual! '); </script>";
            }
        } else {
            $data  = $this->db->get_where('tb_barang_tmp', array('token' => $token, 'kode_barang' => $kode))->result_array();
            foreach ($data as $dataa) {
                unlink("assets/upload/barang/" . $dataa['gambar']);
            }

            $this->db->where('id', $id);
            $this->db->where('token', $token);
            $this->db->delete('tb_barang');

            $this->db->where('kode_barang', $kode);
            $this->db->where('token', $token);
            $this->db->delete('tb_barang_tmp');

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Barang Berhasil di Hapus!'); </script>";
            }
        }
        echo "<script>window.location='" . site_url('Barang') . "';</script>";
    }

    function hapus_brng_bt($id, $kode)
    {
        $token = $this->session->userdata('token');
        $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $kode, 'token' => $token])->num_rows();
        $query1 = $this->db->get_where('tb_checkout', ['kode_barang' => $kode, 'token' => $token])->num_rows();

        if (($query > 0) || ($query1 > 0)) {
            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Barang ini tidak bisa di Hapus, Karna barang ini sudah pernah dijual! '); </script>";
            }
        } else {
            $data  = $this->db->get_where('tb_barang_produk', array('token' => $token, 'id_barang' => $id))->result_array();
            foreach ($data as $dataa) {
                unlink("assets/upload/barang/" . $dataa['produk']);
            }

            $data1  = $this->db->get_where('tb_barang', array('token' => $token, 'id' => $id))->result_array();
            foreach ($data1 as $dataa1) {
                unlink("assets/upload/barang/" . $dataa1['gambar']);
            }

            $this->db->where('id', $id);
            $this->db->where('token', $token);
            $this->db->delete('tb_barang');

            $this->db->where('id_barang', $id);
            $this->db->where('token', $token);
            $this->db->delete('tb_barang_produk');

            $this->db->where('id_barang', $kode);
            $this->db->where('token', $token);
            $this->db->delete('tb_barang_harga');

            $this->db->where('kode_barang', $kode);
            $this->db->where('token', $token);
            $this->db->delete('tb_barang_warna');

            $this->db->where('kode_barang', $kode);
            $this->db->where('token', $token);
            $this->db->delete('tb_barang_ukuran');

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Barang Berhasil di Hapus!'); </script>";
            }
        }
        echo "<script>window.location='" . site_url('Barang') . "';</script>";
    }

    function hapus_bar()
    {
        $id = $_POST['bar'];

        $this->db->where_in('id', $id);
        $this->db->delete('tb_barang');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data Barang Berhasil di Hapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

        redirect('Barang');
    }

    public function ubah_barang($kd)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Ubah Data Barang';

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['data'] = $this->db->get_where('tb_barang', ['id' => $kd, 'token' => $token])->row();
        $data['kategori'] = $this->db->get_where('tb_kategori_barang', ['token' => $token])->result();
        $data['sub_kategori'] = $this->db->get_where('tb_sub_kategori_barang', ['token' => $token])->result();
        $data['warna'] = $this->db->get_where('tb_warna_barang', ['token' => $token])->result();
        $data['ukuran'] = $this->db->get_where('tb_ukuran_barang', ['token' => $token])->result();
        $data['set'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $data['retail'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();
        $data['check'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 39])->row_array();
        $data['butik'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();
        $data['electro'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 31])->row_array();

        if (isset($data['electro']['menu_id'])) {
            $this->load->view('templates/header', $data);
            $this->load->view('barang/ubah_barang_electro', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('barang/ubah_barang', $data);
            $this->load->view('templates/footer');
        }
    }

    public function tambah_barang()
    {
        $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required|trim|is_unique[tb_barang.kode_barang]', [
            'is_unique' => 'Kode barang ini sudah terdaftar!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $data['judul'] = 'Tambah Data Barang';

            $token = $this->session->userdata('token');
            $role = $this->session->userdata('role_id');
            $user_id = $this->session->userdata('id');

            $data['kategori'] = $this->db->get_where('tb_kategori_barang', ['token' => $token])->result();
            $data['warna'] = $this->db->get_where('tb_warna_barang', ['token' => $token])->result();
            $data['ukuran'] = $this->db->get_where('tb_ukuran_barang', ['token' => $token])->result();
            $data['set'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

            $data['retail'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();
            $data['check'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 39])->row_array();
            $data['butik'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();
            $data['electro'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 31])->row_array();

            if (isset($data['butik']['menu_id'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('barang/tambah_barang_butik', $data);
                $this->load->view('templates/footer');
            } elseif (isset($data['electro']['menu_id'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('barang/tambah_barang_electro', $data);
                $this->load->view('templates/footer');
            } else {
                $this->load->view('templates/header', $data);
                $this->load->view('barang/tambah_barang', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function import_data()
    {
        if (isset($_POST['submit'])) {
            $config = array(
                'upload_path'   => 'assets/upload',
                'allowed_types' => 'xlsx|xls|csv'
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file')) {
                $error = array('error' => $this->upload->display_errors());
                $this->import_data($error);
            } else {
                $data = $this->upload->data();
                @chmod($data['full_path'], 0777);

                $this->load->library('Spreadsheet_Excel_Reader');
                $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

                $this->spreadsheet_excel_reader->read($data['full_path']);
                $sheets = $this->spreadsheet_excel_reader->sheets[0];
                error_reporting(0);

                $data_excel = array();
                for ($i = 2; $i <= $sheets['numRows']; $i++) {
                    if ($sheets['cells'][$i][1] == '') break;

                    $data_excel[$i - 1]['kode_barang']    = $sheets['cells'][$i][1];
                    $data_excel[$i - 1]['nama_barang']   = $sheets['cells'][$i][2];
                    $data_excel[$i - 1]['deskripsi'] = $sheets['cells'][$i][3];
                    $data_excel[$i - 1]['tgl_input'] = date('Y-m-d');
                    $data_excel[$i - 1]['tgl_tempo'] = $sheets['cells'][$i][4];
                    $data_excel[$i - 1]['harga_beli'] = $sheets['cells'][$i][5];
                    $data_excel[$i - 1]['harga_jual'] = $sheets['cells'][$i][6];
                    $data_excel[$i - 1]['persen'] = $sheets['cells'][$i][7];
                    $data_excel[$i - 1]['profit'] = $sheets['cells'][$i][8];
                    $data_excel[$i - 1]['id_kategori'] = $sheets['cells'][$i][9];
                    $data_excel[$i - 1]['jml_stok'] = $sheets['cells'][$i][10];
                    $data_excel[$i - 1]['minimal_stok'] = $sheets['cells'][$i][11];
                    $data_excel[$i - 1]['satuan'] = $sheets['cells'][$i][12];
                    $data_excel[$i - 1]['token'] = $this->session->userdata('token');

                    $kode_barang = $sheets['cells'][$i][1];
                }

                $token = $this->session->userdata('token');
                $dt = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->row();

                if ($kode_barang == $dt->kode_barang) {

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Gagal di Upload, Kode Barang Sudah Tersedia!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                } else {
                    $this->db->insert_batch('tb_barang', $data_excel);
                    unlink($data['full_path']);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Berhasil di Upload!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                }
            }
        } elseif (isset($_POST['submit_rt'])) {
            $config = array(
                'upload_path'   => FCPATH . 'assets/upload/',
                'allowed_types' => 'xlsx|xls|csv'
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file')) {
                $error = array('error' => $this->upload->display_errors());
                $this->import_data($error);
            } else {
                $data = $this->upload->data();
                @chmod($data['full_path'], 0777);

                $this->load->library('Spreadsheet_Excel_Reader');
                $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

                $this->spreadsheet_excel_reader->read($data['full_path']);
                $sheets = $this->spreadsheet_excel_reader->sheets[0];
                error_reporting(0);

                $data_excel = array();
                for ($i = 2; $i <= $sheets['numRows']; $i++) {
                    if ($sheets['cells'][$i][1] == '') break;

                    $data_excel[$i - 1]['kode_barang']    = $sheets['cells'][$i][1];
                    $data_excel[$i - 1]['nama_barang']   = $sheets['cells'][$i][2];
                    $data_excel[$i - 1]['deskripsi'] = $sheets['cells'][$i][3];
                    $data_excel[$i - 1]['tgl_input'] = date('Y-m-d');
                    $data_excel[$i - 1]['tgl_tempo'] = $sheets['cells'][$i][4];
                    $data_excel[$i - 1]['harga_beli'] = $sheets['cells'][$i][5];
                    $data_excel[$i - 1]['harga_jual'] = $sheets['cells'][$i][6];
                    $data_excel[$i - 1]['persen'] = $sheets['cells'][$i][7];
                    $data_excel[$i - 1]['profit'] = $sheets['cells'][$i][8];
                    $data_excel[$i - 1]['harga_jual1'] = $sheets['cells'][$i][9];
                    $data_excel[$i - 1]['persen1'] = $sheets['cells'][$i][10];
                    $data_excel[$i - 1]['profit1'] = $sheets['cells'][$i][11];
                    $data_excel[$i - 1]['harga_jual2'] = $sheets['cells'][$i][12];
                    $data_excel[$i - 1]['persen2'] = $sheets['cells'][$i][13];
                    $data_excel[$i - 1]['profit2'] = $sheets['cells'][$i][14];
                    $data_excel[$i - 1]['id_kategori'] = $sheets['cells'][$i][15];
                    $data_excel[$i - 1]['jml_stok'] = $sheets['cells'][$i][16];
                    $data_excel[$i - 1]['minimal_stok'] = $sheets['cells'][$i][17];
                    $data_excel[$i - 1]['satuan'] = $sheets['cells'][$i][18];
                    $data_excel[$i - 1]['isi'] = $sheets['cells'][$i][19];
                    $data_excel[$i - 1]['satuan1'] = $sheets['cells'][$i][20];
                    $data_excel[$i - 1]['isi1'] = $sheets['cells'][$i][21];
                    $data_excel[$i - 1]['satuan2'] = $sheets['cells'][$i][22];
                    $data_excel[$i - 1]['isi2'] = $sheets['cells'][$i][23];
                    $data_excel[$i - 1]['satuan3'] = $sheets['cells'][$i][24];
                    $data_excel[$i - 1]['isi3'] = $sheets['cells'][$i][25];
                    $data_excel[$i - 1]['token'] = $this->session->userdata('token');

                    $kode_barang = $sheets['cells'][$i][1];
                }

                $token = $this->session->userdata('token');
                $dt = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->row();

                if ($kode_barang == $dt->kode_barang) {

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Gagal di Upload, Kode Barang Sudah Tersedia!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                } else {
                    $this->db->insert_batch('tb_barang', $data_excel);
                    unlink($data['full_path']);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Berhasil di Upload!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                }
            }
        } elseif (isset($_POST['submit_ck'])) {
            $config = array(
                'upload_path'   => FCPATH . 'assets/upload/',
                'allowed_types' => 'xlsx|xls|csv'
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file')) {
                $error = array('error' => $this->upload->display_errors());
                $this->import_data($error);
            } else {
                $data = $this->upload->data();
                @chmod($data['full_path'], 0777);

                $this->load->library('Spreadsheet_Excel_Reader');
                $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

                $this->spreadsheet_excel_reader->read($data['full_path']);
                $sheets = $this->spreadsheet_excel_reader->sheets[0];
                error_reporting(0);

                $data_excel = array();
                for ($i = 2; $i <= $sheets['numRows']; $i++) {
                    if ($sheets['cells'][$i][1] == '') break;

                    $data_excel[$i - 1]['kode_barang']    = $sheets['cells'][$i][1];
                    $data_excel[$i - 1]['nama_barang']   = $sheets['cells'][$i][2];
                    $data_excel[$i - 1]['slug']   = $sheets['cells'][$i][3];
                    $data_excel[$i - 1]['berat']   = $sheets['cells'][$i][4];
                    $data_excel[$i - 1]['deskripsi'] = $sheets['cells'][$i][5];
                    $data_excel[$i - 1]['tgl_input'] = date('Y-m-d');
                    $data_excel[$i - 1]['tgl_tempo'] = $sheets['cells'][$i][6];
                    $data_excel[$i - 1]['harga_beli'] = $sheets['cells'][$i][7];
                    $data_excel[$i - 1]['harga_jual'] = $sheets['cells'][$i][8];
                    $data_excel[$i - 1]['persen'] = $sheets['cells'][$i][9];
                    $data_excel[$i - 1]['profit'] = $sheets['cells'][$i][10];
                    $data_excel[$i - 1]['harga_jual1'] = $sheets['cells'][$i][11];
                    $data_excel[$i - 1]['persen1'] = $sheets['cells'][$i][12];
                    $data_excel[$i - 1]['profit1'] = $sheets['cells'][$i][13];
                    $data_excel[$i - 1]['harga_jual2'] = $sheets['cells'][$i][14];
                    $data_excel[$i - 1]['persen2'] = $sheets['cells'][$i][15];
                    $data_excel[$i - 1]['profit2'] = $sheets['cells'][$i][16];
                    $data_excel[$i - 1]['id_kategori'] = $sheets['cells'][$i][17];
                    $data_excel[$i - 1]['jml_stok'] = $sheets['cells'][$i][18];
                    $data_excel[$i - 1]['minimal_stok'] = $sheets['cells'][$i][19];
                    $data_excel[$i - 1]['satuan'] = $sheets['cells'][$i][20];
                    $data_excel[$i - 1]['isi'] = $sheets['cells'][$i][21];
                    $data_excel[$i - 1]['satuan1'] = $sheets['cells'][$i][22];
                    $data_excel[$i - 1]['isi1'] = $sheets['cells'][$i][23];
                    $data_excel[$i - 1]['satuan2'] = $sheets['cells'][$i][24];
                    $data_excel[$i - 1]['isi2'] = $sheets['cells'][$i][25];
                    $data_excel[$i - 1]['satuan3'] = $sheets['cells'][$i][26];
                    $data_excel[$i - 1]['isi3'] = $sheets['cells'][$i][27];
                    $data_excel[$i - 1]['token'] = $this->session->userdata('token');

                    $kode_barang = $sheets['cells'][$i][1];
                }

                $token = $this->session->userdata('token');
                $dt = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->row();

                if ($kode_barang == $dt->kode_barang) {

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Gagal di Upload, Kode Barang Sudah Tersedia!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                } else {
                    $this->db->insert_batch('tb_barang', $data_excel);
                    unlink($data['full_path']);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Berhasil di Upload!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                }
            }
        } elseif (isset($_POST['submit_bt'])) {
            $config = array(
                'upload_path'   => FCPATH . 'assets/upload/',
                'allowed_types' => 'xlsx|xls|csv'
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file')) {
                $error = array('error' => $this->upload->display_errors());
                $this->import_data($error);
            } else {
                $data = $this->upload->data();
                @chmod($data['full_path'], 0777);

                $this->load->library('Spreadsheet_Excel_Reader');
                $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

                $this->spreadsheet_excel_reader->read($data['full_path']);
                $sheets = $this->spreadsheet_excel_reader->sheets[0];
                error_reporting(0);

                $data_excel = array();
                for ($i = 2; $i < 2000; $i++) {
                    if ($sheets['cells'][$i][1] == '') break;

                    $data_excel[$i - 1]['kode_barang']    = $sheets['cells'][$i][1];
                    $data_excel[$i - 1]['nama_barang']   = $sheets['cells'][$i][2];
                    $data_excel[$i - 1]['deskripsi'] = $sheets['cells'][$i][3];
                    $data_excel[$i - 1]['tgl_input'] = date('Y-m-d');
                    $data_excel[$i - 1]['tgl_tempo'] = $sheets['cells'][$i][4];
                    $data_excel[$i - 1]['harga_beli'] = $sheets['cells'][$i][5];
                    $data_excel[$i - 1]['id_kategori'] = $sheets['cells'][$i][9];
                    $data_excel[$i - 1]['sub_kategori'] = $sheets['cells'][$i][10];
                    $data_excel[$i - 1]['warna'] = $sheets['cells'][$i][11];
                    $data_excel[$i - 1]['ukuran'] = $sheets['cells'][$i][12];
                    $data_excel[$i - 1]['jml_stok'] = $sheets['cells'][$i][13];
                    $data_excel[$i - 1]['minimal_stok'] = $sheets['cells'][$i][14];
                    $data_excel[$i - 1]['satuan'] = $sheets['cells'][$i][15];
                    $data_excel[$i - 1]['berat'] = $sheets['cells'][$i][16];
                    $data_excel[$i - 1]['status'] = 1;
                    $data_excel[$i - 1]['dropship'] = 1;
                    $data_excel[$i - 1]['token'] = $this->session->userdata('token');

                    $kode_barang = $sheets['cells'][$i][1];
                }

                $token = $this->session->userdata('token');
                $dt = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode_barang])->row();

                if ($kode_barang == $dt->kode_barang) {

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Gagal di Upload, Kode Barang Sudah Tersedia!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                } else {
                    $this->db->insert_batch('tb_barang', $data_excel);
                    unlink($data['full_path']);

                    $data_harga = array();
                    for ($i = 2; $i <= $sheets['numRows']; $i++) {
                        if ($sheets['cells'][$i][1] == '') break;

                        $harga = explode(', ', $sheets['cells'][$i][6]);
                        $persen = explode(', ', $sheets['cells'][$i][7]);
                        $profit = explode(', ', $sheets['cells'][$i][8]);
                        for ($h = 0; $h < count($harga); $h++) {
                            $data_harga[] = [
                                'id_barang' => $sheets['cells'][$i][1],
                                'harga_beli' => $sheets['cells'][$i][5],
                                'harga_jual' => $harga[$h],
                                'persen' => $persen[$h],
                                'profit' => $profit[$h],
                                'satuan' => $sheets['cells'][$i][15],
                                'token' => $this->session->userdata('token')
                            ];
                        }
                    }

                    $this->db->insert_batch('tb_barang_harga', $data_harga);

                    $data_warna = array();
                    for ($i = 2; $i <= $sheets['numRows']; $i++) {
                        if ($sheets['cells'][$i][1] == '') break;

                        $warna = explode(',', $sheets['cells'][$i][11]);
                        for ($ii = 0; $ii < count($warna); $ii++) {
                            $data_warna[] = [
                                'kode_barang' => $sheets['cells'][$i][1],
                                'warna' => $warna[$ii],
                                'token' => $this->session->userdata('token')
                            ];
                        }
                    }
                    $this->db->insert_batch('tb_barang_warna', $data_warna);

                    $data_ukuran = array();
                    for ($i = 2; $i <= $sheets['numRows']; $i++) {
                        if ($sheets['cells'][$i][1] == '') break;

                        $ukuran = explode(',', $sheets['cells'][$i][12]);
                        for ($ii = 0; $ii < count($ukuran); $ii++) {
                            $data_ukuran[] = [
                                'kode_barang' => $sheets['cells'][$i][1],
                                'ukuran' => $ukuran[$ii],
                                'token' => $this->session->userdata('token')
                            ];
                        }
                    }
                    $this->db->insert_batch('tb_barang_ukuran', $data_ukuran);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Barang Berhasil di Upload!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Barang') . "';</script>";
                }
            }
        }
    }

    public function cetak_barcode()
    {
        $token = $this->session->userdata('token');
        $data['barcode'] = $this->db->get_where('tb_barang', ['kode_barang' => $_POST['kode_bar']])->row_array();
        $data['nm_toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($data['nm_toko']['barcode'] == 'standart') {
            $this->load->view('barang/barcode', $data);
        } elseif ($data['nm_toko']['barcode'] == '1') {
            $this->load->view('barang/barcode1', $data);
        } elseif ($data['nm_toko']['barcode'] == '2') {
            $this->load->view('barang/barcode2', $data);
        } elseif ($data['nm_toko']['barcode'] == '3') {
            $this->load->view('barang/barcode3', $data);
        }
    }

    function barcode($code)
    {
        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //generate barcode
        Zend_Barcode::render('code128', 'image', array('text' => $code), array());
    }

    function auto_bar()
    {
        if (isset($_GET['term'])) {
            $result = $this->Data_model->getAuto2($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'  => $row->kode_barang . ' / ' . $row->nama_barang,
                        'value'  => $row->kode_barang,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    public function retur_barang()
    {
        if ($_POST['id']) {
            $kd = $_POST['id'];
            $token = $this->session->userdata('token');
            $data['data'] = $this->db->query("SELECT b.id, b.kode_barang, b.nama_barang, b.jml_stok, b.kode_supplier FROM tb_barang b WHERE b.id='$kd'")->row_array();
            $kode = $data['data']['kode_barang'];
            $data['sup'] = $this->db->query("SELECT * FROM tb_pembelian p INNER JOIN tb_supplier s ON s.kode_sup=p.kd_supplier INNER JOIN tb_detail_pembelian d ON d.no_faktur=p.id_pembelian WHERE p.token='$token' AND d.kode_barang='$kode' GROUP BY p.kd_supplier")->result_array();

            $this->load->view('barang/_retur', $data);
        }
    }

    public function link_check()
    {
        if ($_POST['id']) {
            $kd = $_POST['id'];
            $token = $this->session->userdata('token');
            $data['br'] = $this->db->query("SELECT b.id, b.kode_barang, b.nama_barang, b.jml_stok, b.satuan, b.slug, b.token FROM tb_barang b WHERE b.id='$kd'")->row_array();
            $kode = $data['br']['kode_barang'];
            $data['sup'] = $this->db->get_where('tb_supplier', ['token' => $token])->result_array();
            $data['asal'] = $this->db->get_where('setting_app', ['token' => $token])->row();

            $this->load->view('barang/_link_check', $data);
        }
    }

    function aksi_retur()
    {
        if (isset($_POST['smpn_beli'])) {
            $token = $this->session->userdata('token');
            $id = htmlspecialchars($this->input->post('id'));
            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $kode_supplier = htmlspecialchars($this->input->post('kode_supplier'));
            $jumlah_barang = htmlspecialchars($this->input->post('jumlah_barang'));
            $alasan = htmlspecialchars($this->input->post('alasan'));

            $data = [
                'kode_barang' => $kode_barang,
                'kode_supplier' => $kode_supplier,
                'jumlah_barang' => $jumlah_barang,
                'alasan' => $alasan,
                'tgl_pem' => date('y-m-d'),
                'token' => $token
            ];

            $query = $this->db->get_where('tb_barang', ['kode_barang' => $kode_barang, 'token' => $token])->row_array();
            $stok = $query['jml_stok'] - $jumlah_barang;

            $this->db->set('jml_stok', $stok);
            $this->db->where('id', $id);
            $this->db->update('tb_barang');

            $this->db->insert('tb_retur_pembelian', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Barang Berhasil di Retur!'); </script>";
            }
            echo "<script>window.location='" . site_url('Barang') . "';</script>";
        }
    }

    function get_sub_kategori()
    {
        $id = $this->input->post('id', TRUE);
        $data = $this->Barang_model->get_sub_kategori($id)->result();
        echo json_encode($data);
    }

    function auto_barang_butik()
    {
        if (isset($_GET['term'])) {
            $result = $this->Barang_model->getAutoBrng($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'  => $row->kode_barang . ' / ' . $row->nama_barang,
                        'value'  => $row->kode_barang,
                        'nama_barang'   => $row->nama_barang,
                        'harga_beli'   => $row->harga_beli,
                        'satuan'   => $row->satuan,
                        'kty'   => $row->kty,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    function serial()
    {
        if ($_POST) {
            $data = [
                'serial_num' => htmlspecialchars($this->input->post('serial_num')),
                'expired' => htmlspecialchars($this->input->post('expired')),
                'kode_bar' => htmlspecialchars($this->input->post('kod_bar')),
                'status' => '1',
                'token' => htmlspecialchars($this->session->userdata('token')),
            ];

            $this->db->insert('tb_serial', $data);
        }
    }

    function get_serial()
    {
        $token = $this->session->userdata('token');
        $kode = $this->input->post('kod_bar');

        $no = 1;
        $query = $this->db->get_where('tb_serial', ['kode_bar' => $kode, 'token' => $token])->result();
        foreach ($query as $data) {
            if ($data->status == '1') {
                $status = 'Belum';
            } else {
                $status = 'Sudah';
            }
            echo '
            <tr align="center">
                <th>' . $no++ . '</th>
                <td>' . $data->serial_num . '</td>
                <td>' . $data->expired . '</td>
                <td>' . $data->kode_bar . '</td>
                <td>' . $status . '</td>
                <td align="center"><button value="' . $data->id_serial . '" class="badge badge-danger btnHapus">hapus</button></td>
            </tr>
            ';
        }
    }

    function del_serial($id)
    {
        $this->db->where('id_serial', $id);
        $this->db->delete('tb_serial');
    }

    public function cek_serial()
    {
        if ($_POST['id']) {
            $kd = $_POST['id'];
            $token = $this->session->userdata('token');
            $data['data'] = $this->db->get_where('tb_serial', ['kode_bar' => $kd, 'token' => $token])->result();

            $this->load->view('barang/_serial', $data);
        }
    }

    function get_barang()
    {
        $token = $this->session->userdata('token');
        $query = $this->db->get_where('tb_barang', ['token' => $token])->result();

        $no = 1;
        foreach ($query as $data) {
            echo '
            <tr>
                <td align="center">' . $no++ . '</td>
                <td>' . $data->kode_barang . '</td>
                <td>' . $data->nama_barang . '</td>
                <td align="center">Rp. ' . number_format($data->harga_beli) . '</td>
                <td align="center">Rp. ' . number_format($data->harga_jual) . '</td>
                <td align="center">' . $data->jml_stok . '</td>
                <td align="center"><a href="" class="btn btn-warning btn-sm" data-target="#mRetur" data-toggle="modal" data-id="' . $data->id . '"><i class="fas fa-undo"></i> Retur</a></td>
                <td><a href="' . base_url('Barang/Ubah_Barang/') . $data->id . '"><i class="fas fa-edit"></i></a> <a href="' . base_url('Barang/Hapus_brng/') . $data->id . '/' . $data->kode_barang . '" onclick="return confirm("Yakin anda ?")"><i class="fas fa-trash text-danger"></i></a></td>
            </tr>
            ';
        }
    }

    function get_barangB()
    {
        $token = $this->session->userdata('token');
        $this->db->select('*, tb_barang.kode_barang as kode');
        $this->db->from('tb_barang');
        $this->db->where('tb_barang.token', $token);
        $this->db->group_by('tb_barang.kode_barang');
        // $this->db->limit(2000);
        $query = $this->db->get()->result();

        $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        echo '<table id="ambilBarangBTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead style="text-align:center; ">
            <tr>
                <th width="5%">#</th>
                <th width="15%">Kode</th>
                <th width="25%">Nama Barang</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>';
        if ($set['reseller'] == 1) {
            echo '<th>Harga Reseller</th>';
        }
        echo '<th width="10%">Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>';
        echo '<tbody>';
        $no = 1;
        $modal = 0;
        $jual = 0;
        $stok = 0;
        $res = 0;
        foreach ($query as $data) {
            $kode = $data->kode;
            $token = $this->session->userdata('token');

            $query = $this->db->query("SELECT * FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'");
            if ($query->num_rows() <= 1) {
                $harga = 'Rp. ' . number_format($query->row()->harga_jual);
            } else {
                $min = $this->db->query("SELECT min(harga_jual) as harga FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'")->row();
                $max = $this->db->query("SELECT max(harga_jual) as harga FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'")->row();
                $harga = 'Rp. ' . number_format($min->harga) . ' s/d ' . number_format($max->harga);
            }
            $query1 = $this->db->query("SELECT * FROM tb_barang_harga_reseller WHERE token='$token' AND id_barang='$kode'")->row();
            $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();
            echo '
                <tr>
                    <td align="center">' . $no++ . '</td>
                    <td>' . $data->kode . '</td>
                    <td>' . $data->nama_barang . '</td>
                    <td align="center">Rp. ' . number_format($data->harga_beli) . '</td>
                    <td align="center">' . $harga . '</td>';
            if ($set['reseller'] == 1) {
                echo '<td align="center">Rp. ' . number_format(!empty($query1->id_barang) ? $query1->harga_reseller : 0) . '</td>';
            }
            echo '<td align="center">' . number_format($data->jml_stok) . '</td>
                    <td align="center"><a href="' . base_url('Barang/Ubah_Barang/') . $data->id . '"><i class="fas fa-edit"></i></a> <a href="' . base_url('Barang/hapus_brng_bt/') . $data->id . '/' . $data->kode . '" onclick="return confirm("Yakin anda ?")"><i class="fas fa-trash text-danger"></i></a></td>
                </tr>';
            $modal += $data->harga_beli;
            $stok += $data->jml_stok;
        }

        $hjual = $this->db->get_where('tb_barang_harga', ['token' => $token])->result();
        foreach ($hjual as $hju) {
            $jual += $hju->harga_jual;
        }

        $hres = $this->db->get_where('tb_barang_harga_reseller', ['token' => $token])->result();
        foreach ($hres as $hre) {
            $res += $hre->harga_reseller;
        }

        echo '
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" align="center"><b>TOTAL</b></td>
                <td align="center">Rp. ' . number_format($modal) . '</td>
                <td align="center">Rp. ' . number_format($jual) . '</td>';
        if ($set['reseller'] == 1) {
            echo '<td align="center">Rp. ' . number_format($res) . '</td>';
        }
        echo '<td align="center">' . number_format($stok) . '</td>
                <td></td>
            </tr>
        </tfoot>
        </table>';
    }

    function get_barangBHarga()
    {
        if ($_POST) {
            $kode = $_POST['kode'];
            $token = $this->session->userdata('token');
            // $this->db->select('*');
            // $this->db->from('tb_barang_harga');
            // $this->db->where('token', $token);
            // $this->db->where('id_barang', $kode);
            // $query = $this->db->get()->result();

            $query = $this->db->query("SELECT * FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'");
            if ($query->num_rows() <= 1) {
                $harga = 'Rp. ' . number_format($query->row()->harga_jual);
            } else {
                $min = $this->db->query("SELECT min(harga_jual) as harga FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'")->row();
                $max = $this->db->query("SELECT max(harga_jual) as harga FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'")->row();
                $harga = 'Rp. ' . number_format($min->harga) . ' s/d ' . number_format($max->harga);
            }

            echo json_encode($harga);
        }
    }

    function get_barangC()
    {
        $token = $this->session->userdata('token');
        $this->db->select('*, tb_barang.kode_barang as kode');
        $this->db->from('tb_barang');
        $this->db->where('tb_barang.token', $token);
        $this->db->group_by('tb_barang.kode_barang');
        $query = $this->db->get()->result();

        echo json_encode($query);
    }


    function get_barangR()
    {
        $token = $this->session->userdata('token');
        $this->db->select('*, tb_barang.kode_barang as kode');
        $this->db->from('tb_barang');
        $this->db->where('tb_barang.token', $token);
        $this->db->group_by('tb_barang.kode_barang');
        $query = $this->db->get()->result();

        echo json_encode($query);
    }

    function get_barangE()
    {
        $token = $this->session->userdata('token');
        $this->db->select('*, tb_barang.kode_barang as kode');
        $this->db->from('tb_barang');
        $this->db->where('tb_barang.token', $token);
        $this->db->group_by('tb_barang.kode_barang');
        $query = $this->db->get()->result();

        $no = 1;
        foreach ($query as $data) {
            $kode = $data->kode;
            $token = $this->session->userdata('token');

            $harga = $this->db->query("SELECT * FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'")->row();

            $query1 = $this->db->query("SELECT * FROM tb_barang_harga_reseller WHERE token='$token' AND id_barang='$kode'")->row();
            $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();
            echo '
                <tr>
                    <td align="center">' . $no++ . '</td>
                    <td>' . $data->kode . '</td>
                    <td>' . $data->nama_barang . '</td>
                    <td align="center">Rp. ' . number_format($data->harga_beli) . '</td>
                    <td align="center">Rp. ' . number_format($harga->harga_jual) . '</td>
                    <td align="center">' . number_format($data->jml_stok) . '</td>
                    <td align="center"><a href="" class="btn btn-warning btn-sm" data-target="#mSerial" data-toggle="modal" data-id="' . $data->kode . '"><i class="fas fa-key"></i> Serial</a></td>
                    <td align="center"><a href="' . base_url('Barang/Ubah_Barang/') . $data->id . '"><i class="fas fa-edit"></i></a> <a href="' . base_url('Barang/hapus_brng/') . $data->id . '/' . $data->kode . '" onclick="return confirm("Yakin anda ?")"><i class="fas fa-trash text-danger"></i></a></td>
                </tr>
            ';
        }
    }
}
