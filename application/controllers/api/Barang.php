<?php
header('Access-Control-Allow-Origin: *');

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Barang extends RestController
{

    function __construct()
    {
        parent::__construct();
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $data = $this->db->get('tb_barang')->result_array();
        } else {
            $data = $this->db->get_where('tb_barang', ['id' => $id])->result_array();
        }

        if ($data) {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function harga_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $data = $this->db->get('tb_barang_harga')->result_array();
        } else {
            $data = $this->db->get_where('tb_barang_harga', ['id_barang_harga' => $id])->result_array();
        }

        if ($data) {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function join_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $this->db->select('*, tb_barang_harga.harga_jual as hg_jual');
            $this->db->from('tb_barang_harga');
            $this->db->join('tb_barang', 'tb_barang.kode_barang = tb_barang_harga.id_barang');
            $data = $this->db->get()->result_array();
        } else {
            $this->db->select('*, tb_barang_harga.harga_jual as hg_jual');
            $this->db->from('tb_barang_harga');
            $this->db->join('tb_barang', 'tb_barang.kode_barang = tb_barang_harga.id_barang');
            $this->db->where('tb_barang_harga.id_barang', $id);
            $data = $this->db->get()->result_array();
        }

        if ($data) {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function join_post()
    {
        $token = $this->post('token');
        if ($token != null) {
            $barang = $this->db->get_where('tb_barang', ['token' => $token])->result_array();
            foreach ($barang as $dt) {
                if ($dt['harga_jual'] == '') {
                    $harga = 'baru';

                    $this->db->select('*, tb_barang_harga.harga_jual as hg_jual');
                    $this->db->from('tb_barang_harga');
                    $this->db->join('tb_barang', 'tb_barang.kode_barang = tb_barang_harga.id_barang');
                    $this->db->group_by('tb_barang.kode_barang');
                    $this->db->where('tb_barang.token', $token);
                    $data = $this->db->get()->result_array();
                } else {
                    $harga = 'lama';
                    $data = $this->db->get_where('tb_barang', ['token' => $token])->result_array();
                }
            }
        }

        if ($data) {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function join_produk_post()
    {
        $token = $this->post('token');
        if ($token) {
            $this->db->select('*');
            $this->db->from('tb_barang');
            $this->db->where('tb_barang.token', $token);
            $this->db->group_by('tb_barang.kode_barang');
            $data = $this->db->get()->result_array();
        }

        if ($data) {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function vue_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $data = $this->db->get('tb_barang')->result_array();
        } else {
            $data = $this->db->get_where('tb_barang', ['token' => $id])->result_array();
        }

        if ($data) {
            $this->response($data, 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function harga_post()
    {
        $token = $this->post('token');
        $kode = $this->post('kode');

        if ($kode != null) {
            $this->db->select('*');
            $this->db->from('tb_barang_harga');
            $this->db->where('id_barang', $kode);
            $this->db->where('token', $token);
            $this->db->order_by('harga_jual', 'ASC');
            $data = $this->db->get()->result_array();
        }

        if ($data) {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }
}
