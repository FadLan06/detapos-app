<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Gambar Produk';

        $token = $this->session->userdata('token');
        $data['barang'] = $this->db->query("SELECT b.*, b.kode_barang as kode FROM tb_barang b WHERE b.token='$token' GROUP BY b.kode_barang")->result_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('barang/produk', $data);
        $this->load->view('templates/footer');
    }

    function aksi()
    {
        if (isset($_POST['simpan'])) {
            if ($_FILES['gambar']['error'] <> 4) {

                $config['upload_path'] = './assets/upload/barang/';
                $config['allowed_types'] = '*';
                $config['encrypt_name'] = true;
                $config['max_size']     = '1024';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('gambar')) {
                    echo "<script>alert('Data Gambar Produk Gagal Upload!'); </script>";
                    echo "<script>window.location='" . site_url('Produk') . "';</script>";
                } else {
                    $hasil  = $this->upload->data();

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/upload/barang/' . $hasil['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['quality'] = '50%';
                    $config['width'] = 600;
                    $config['height'] = 600;
                    $config['new_image'] = './assets/upload/barang/' . $hasil['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $data = [
                        'id_barang' => htmlspecialchars($this->input->post('id_barang')),
                        'nama_produk' => htmlspecialchars($this->input->post('nama_produk')),
                        'produk' => htmlspecialchars($hasil['file_name']),
                        'token' => htmlspecialchars($this->session->userdata('token')),
                    ];

                    $this->db->insert('tb_barang_produk', $data);

                    if ($this->db->affected_rows() > 0) {
                        echo "<script>alert('Data Gambar Produk Berhasil di Tambahkan!'); </script>";
                    }
                    echo "<script>window.location='" . site_url('Produk') . "';</script>";
                }
            }
        }
    }

    function data_barang()
    {
        $token = $this->session->userdata('token');
        $barang = $this->db->query("SELECT b.*, b.kode_barang as kode FROM tb_barang b WHERE b.token='$token' AND b.gambar!='' GROUP BY b.kode_barang")->result();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $akses = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $no = 1;
        foreach ($barang as $data) {
            $dt = $this->db->get_where('tb_barang_produk', ['token' => $token, 'id_barang' => $data->id]);
            if (($akses->tambah != 1) || ($akses->hapus != 1)) {
                $ak = 'disabled';
            } elseif ($dt->num_rows() >= 4) {
                $jum = 'disabled';
            } else {
                $ak = '';
                $jum = '';
            }
            echo '<tr>
                <td align="center">' . $no++ . '</td>
                <td>' . $data->kode . '</td>
                <td>' . $data->nama_barang . '</td>
                <td align="center"><img src="' . base_url('assets/upload/barang/') . $data->gambar . '" width="100px"></td>
                <td>';
            foreach ($dt->result() as $pro) {
                echo '<img src="' . base_url('assets/upload/barang/') . $pro->produk . '" width="90px" class="mt-1 mr-1">';
            }
            echo '</td>
                <td align="center">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#tmbhProduk' . $data->id . '" class="btn btn-deta btn-sm ' . $ak . ' ' . $jum . '" title="tambah"><i class="fas fa-plus-circle"></i></a> 
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#hapusProduk' . $data->id . '" id="' . $data->id . '" class="btn btn-danger hapus_gam btn-sm ' . $ak . '" title="hapus"><i class="fas fa-trash"></i></a>
                </td>
            </tr>';
        }
    }

    function data_produk()
    {
        $id = $this->input->post('id');
        $token = $this->session->userdata('token');
        $dt = $this->db->get_where('tb_barang_produk', ['token' => $token, 'id_barang' => $id])->result();
        echo json_encode($dt);
    }

    function delete()
    {
        $token = $this->session->userdata('token');
        $data  = $this->db->get_where('tb_barang_produk', array('token' => $token, 'id_produk' => $_POST['id']))->result_array();
        foreach ($data as $dataa) {
            unlink("assets/upload/barang/" . $dataa['produk']);
        }

        $this->db->where("id_produk", $_POST['id']);
        $this->db->where("token", $token);
        $this->db->delete("tb_barang_produk");
    }
}
