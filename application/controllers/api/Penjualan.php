<?php
header('Access-Control-Allow-Origin: *');

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Penjualan extends RestController
{

    function __construct()
    {
        parent::__construct();
    }

    public function index_get()
    {
        $token = $this->get('token');
        $petugas = $this->get('petugas');
        $role_id = $this->get('role_id');
        if ($role_id == '2') {
            $data = $this->db->query("SELECT * FROM tb_penjualan p WHERE p.token='$token' ORDER BY timestmp DESC ")->result_array();
        } elseif ($role_id == '3') {
            $data = $this->db->query("SELECT * FROM tb_penjualan p WHERE p.token='$token' AND p.petugas='$petugas' ORDER BY timestmp DESC ")->result_array();
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

    public function detail_get()
    {
        $token = $this->get('token');
        $id = $this->get('no_transaksi');

        // $data = $this->db->query("SELECT p.no_transaksi, p.kode_barang, p.modal, p.tgl_penjualan, p.harga, p.token, b.kode_barang as kode, b.nama_barang, b.gambar, sum(p.harga*p.qty-p.potongan) as sub_total, sum(p.qty) as kty, j.bayar, p.varian, p.ukuran, sum(p.potongan) as potongan FROM tb_detail_penjualan p LEFT JOIN tb_barang b ON b.kode_barang=p.kode_barang LEFT JOIN tb_penjualan j ON j.no_transaksi=p.no_transaksi WHERE p.no_transaksi='$id' AND p.token='$token' GROUP BY p.harga, p.kode_barang, p.ukuran, p.varian ORDER BY p.kode_barang")->result_array();
        $this->db->select('*, sum(p.harga*p.qty-p.potongan) as sub_total, sum(p.qty) as kty, sum(p.potongan) as potongan');
        $this->db->from('tb_detail_penjualan p');
        $this->db->join('tb_barang b', 'b.kode_barang=p.kode_barang', 'left');
        $this->db->join('tb_penjualan j', 'j.no_transaksi=p.no_transaksi', 'left');
        $this->db->where('p.no_transaksi', $id);
        $this->db->where('p.token', $token);
        $this->db->group_by('p.harga, p.kode_barang, p.ukuran, p.varian');
        $this->db->order_by('p.kode_barang', 'ASC');
        $data = $this->db->get()->result_array();

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

    public function barang_get()
    {
        $token = $this->get('token');
        $kode = $this->get('kode');

        $data = $this->db->get_where('tb_barang', ['token' => $token, 'kode_barang' => $kode])->result();

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

    // DETAIL PENJUALAN TMP

    public function detail_tmp_get()
    {
        $id = $this->get('token');
        if ($id === null) {
            $data = 'not found';
        } else {
            $data = $this->db->query("SELECT *, sum(harga * qty - potongan) as sub_total, sum(modal * qty) as hg_pokok, sum(qty) as kty, sum(potongan) as potongan FROM tb_detail_penjualan_tmp WHERE token='$id' GROUP BY kode_barang, varian, ukuran, harga ORDER BY kode_barang")->result_array();
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

    function detail_tmp_post()
    {
        $data = array(
            'kode_barang'          => $this->post('kode_barang'),
            'nama_barang'    => $this->post('nama_barang'),
            'modal'    => $this->post('harga_beli'),
            'harga'    => $this->post('harga_jual'),
            'qty'    => $this->post('qty'),
            'petugas'    => $this->post('petugas'),
            'potongan'    => $this->post('potongan'),
            'ukuran'    => $this->post('ukuran'),
            'varian'    => $this->post('varian'),
            'timee'    => $this->post('timee'),
            'token'    => $this->post('token')
        );
        $insert = $this->db->insert('tb_detail_penjualan_tmp', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function detail_tmp_delete($id)
    {
        // $id = $this->delete('id_penjualan');
        $this->db->where('id_penjualan', $id);
        $delete = $this->db->delete('tb_detail_penjualan_tmp');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function detail_tmp_put()
    {
        $id = $this->put('id_penjualan');
        $token = $this->put('token');
        $aksi = $this->put('aksi');
        $qty = 1;

        if ($aksi == 'kurang') {
            $query = $this->db->get_where('tb_detail_penjualan_tmp', ['token' => $token, 'id_penjualan' => $id])->row_array();
            $kurang = $query['qty'] - $qty;

            if ($query['qty'] >= 1) {
                $this->db->set('qty', $kurang);
                $this->db->where('id_penjualan', $id);
                $this->db->where('token', $token);
                $update = $this->db->update('tb_detail_penjualan_tmp');

                if ($update) {
                    $this->response(array('status' => 'success'), 201);
                } else {
                    $this->response(array('status' => 'fail', 502));
                }
            } else {
                $this->db->where('id_penjualan', $id);
                $this->db->where('token', $token);
                $delete = $this->db->delete('tb_detail_penjualan_tmp');

                if ($delete) {
                    $this->response(array('status' => 'success'), 201);
                } else {
                    $this->response(array('status' => 'fail', 502));
                }
            }
        } else {
            $query = $this->db->get_where('tb_detail_penjualan_tmp', ['token' => $token, 'id_penjualan' => $id])->row_array();
            $kurang = $query['qty'] + $qty;

            if ($query['qty'] >= 1) {
                $this->db->set('qty', $kurang);
                $this->db->where('id_penjualan', $id);
                $this->db->where('token', $token);
                $update = $this->db->update('tb_detail_penjualan_tmp');

                if ($update) {
                    $this->response(array('status' => 'success'), 201);
                } else {
                    $this->response(array('status' => 'fail', 502));
                }
            }
        }
    }

    function detaill_tmp_delete()
    {
        $kode_barang = $this->delete('kode_barang');
        $ukuran = $this->delete('ukuran');
        $varian = $this->delete('varian');
        $harga = $this->delete('harga');
        $token = $this->delete('token');
        $petugas = $this->delete('petugas');

        $this->db->where("kode_barang", $kode_barang);
        $this->db->where("varian", $varian);
        $this->db->where("ukuran", $ukuran);
        $this->db->where("harga", $harga);
        $this->db->where("petugas", $petugas);
        $this->db->where("token", $token);
        $delete = $this->db->delete("tb_detail_penjualan_tmp");
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function warna_get()
    {
        $token = $this->get('token');
        $kode_barang = $this->get('kode_barang');

        $data = $this->db->get_where('tb_barang_warna', ['kode_barang' => $kode_barang, 'token' => $token])->result_array();

        if ($data) {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'not found'
            ], 404);
        }
    }

    function ukuran_get()
    {
        $token = $this->get('token');
        $kode_barang = $this->get('kode_barang');

        $data = $this->db->get_where('tb_barang_ukuran', ['kode_barang' => $kode_barang, 'token' => $token])->result_array();

        if ($data) {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'not found'
            ], 404);
        }
    }

    // TB PENJUALAN
    function index_post()
    {
        $no_transaksi = $this->post('no_transaksi');
        $status = $this->post('status');
        $totval = $this->post('ttl_harga');
        $totpok = $this->post('ttl_modal');
        $nama_pel = $this->post('nama_pel');
        $no_hp = $this->post('no_hp');

        $data = array(
            'no_transaksi'          => $no_transaksi,
            'kode_pelanggan'    => $nama_pel,
            'tgl_transaksi'    => $this->post('tgl_transaksi'),
            'petugas'    => $this->post('petugas'),
            'status'    => $status,
            'timestmp'    => $this->post('timestmp'),
            'bayar'    => $this->post('bayar'),
            'total'    => $this->post('ttl_harga'),
            'diskon'    => $this->post('diskon'),
            'token'    => $this->post('token')
        );
        $insert = $this->db->insert('tb_penjualan', $data);

        $dt = $this->db->query("SELECT * FROM tb_detail_penjualan_tmp WHERE token='" . $this->post('token') . "' AND petugas='" . $this->post('petugas') . "' ");
        foreach ($dt->result_array() as $dtt) {
            $char[] = $dtt;
        }

        foreach ($char as $row) {
            $dataa = [
                'no_transaksi' => $no_transaksi,
                'kode_barang' => $row['kode_barang'],
                'modal' => $row['modal'],
                'tgl_penjualan' => date('Y-m-d'),
                'qty' => $row['qty'],
                'harga' => $row['harga'],
                'potongan' => $row['potongan'],
                'ukuran' => $row['ukuran'],
                'varian' => $row['varian'],
                'total' => 0,
                'petugas' => $row['petugas'],
                'timee' => $row['timee'],
                'token' => $row['token']

            ];

            $this->db->insert('tb_detail_penjualan', $dataa);

            $this->db->where('kode_barang', $row['kode_barang']);
            $this->db->where('petugas', $row['petugas']);
            $this->db->where('token', $row['token']);
            $this->db->delete('tb_detail_penjualan_tmp');
        }

        if ($nama_pel != '') {
            $pl = $this->db->get_where('tb_pelanggan', ['token' => $this->post('token'), 'nama_pel' => $nama_pel])->row_array();
            if ($nama_pel != $pl['nama_pel']) {
                $pel = [
                    'kode_pel' => rand(1, 9999),
                    'nama_pel' => $nama_pel,
                    'no_hp' => $no_hp,
                    'diskon' => 0,
                    'token'    => $this->post('token')
                ];

                $this->db->insert('tb_pelanggan', $pel);
            }
        }

        //AKUNTANSI
        if ($status == 'Lunas') {
            $user = $this->db->get_where('user', ['token' => $this->post('token')])->row_array();
            if ($user['coupon'] == 'new') {
                $datta = [
                    'no_jurnal' => $this->post('no_jurnal'),
                    'tgl_jurnal' => date('Y-m-d'),
                    'keterangan' => 'Pendapatan Penjualan dengan Nomor Transaksi ' . $no_transaksi,
                    'token' => $this->post('token'),
                    'no_transaksi' => $no_transaksi
                ];

                $this->db->insert('tb_jurnal_tmp', $datta);

                $tok = $this->post('token');
                $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (111,112,411,511)")->result_array();
                // foreach ($ak as $aku) {
                //     $ch[] = $aku;
                // }

                foreach ($ak as $ro) {
                    if ($ro['kode_akun'] == '111') {
                        // $ka = 'D';
                        $dt1 = [
                            'no_jurnal' => $this->post('no_jurnal'),
                            'id_akun' => $ro['id_akun'],
                            'nominal' => $totval,
                            'tipe' => 'D',
                            'token' => $this->post('token'),
                            'no_transaksi' => $no_transaksi
                        ];

                        $this->db->insert('tb_jurnal', $dt1);
                    } else if ($ro['kode_akun'] == '411') {
                        // $ka = 'K';
                        $dt1 = [
                            'no_jurnal' => $this->post('no_jurnal'),
                            'id_akun' => $ro['id_akun'],
                            'nominal' => $totval,
                            'tipe' => 'K',
                            'token' => $this->post('token'),
                            'no_transaksi' => $no_transaksi
                        ];

                        $this->db->insert('tb_jurnal', $dt1);
                    } else if ($ro['kode_akun'] == '112') {
                        // $ka = 'K';
                        $dt1 = [
                            'no_jurnal' => $this->post('no_jurnal'),
                            'id_akun' => $ro['id_akun'],
                            'nominal' => $totpok,
                            'tipe' => 'D',
                            'token' => $this->post('token'),
                            'no_transaksi' => $no_transaksi
                        ];

                        $this->db->insert('tb_jurnal', $dt1);
                    } else if ($ro['kode_akun'] == '511') {
                        // $ka = 'K';
                        $dt1 = [
                            'no_jurnal' => $this->post('no_jurnal'),
                            'id_akun' => $ro['id_akun'],
                            'nominal' => $totpok,
                            'tipe' => 'K',
                            'token' => $this->post('token'),
                            'no_transaksi' => $no_transaksi
                        ];

                        $this->db->insert('tb_jurnal', $dt1);
                    }
                }
            }
        }

        if ($insert) {
            $this->response(array('status' => 'Success'), 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function jurnal_post()
    {
        $token = $this->post('token');
        $zona = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        date_default_timezone_set($zona['zona']);
        $this->db->select('RIGHT(tb_jurnal_tmp.no_jurnal,5) as no_jurnal', FALSE);
        $this->db->where('tgl_jurnal', date('Y-m-d'));
        $this->db->where('token', $token);
        $this->db->order_by('no_jurnal', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_jurnal_tmp');  //cek dulu apakah ada sudah ada kode di tabel.
        if ($query->num_rows() <> 0) {
            //cek kode jika telah tersedia
            $data = $query->row();
            $kode = intval($data->no_jurnal) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $pot = substr($token, -3);
        $tgl = date('dmy');
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = $pot . $tgl . $batas;  //format kode

        if ($query) {
            $this->response([
                'status' => TRUE,
                'data' => $kodetampil
            ], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function transaksi_post()
    {
        $token = $this->post('token');
        $zona = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        date_default_timezone_set($zona['zona']);

        $this->db->select('RIGHT(tb_penjualan.no_transaksi,5) as no_transaksi', FALSE);
        $this->db->where('tgl_transaksi', date('Y-m-d'));
        $this->db->where('token', $token);
        $this->db->order_by('no_transaksi', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_penjualan');  //cek dulu apakah ada sudah ada kode di tabel.
        if ($query->num_rows() <> 0) {
            //cek kode jika telah tersedia
            $data = $query->row();
            $kode = intval($data->no_transaksi) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $pot = substr($token, -3);
        $tgl = date('dmy');
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = $pot . $tgl . $batas;  //format kode

        if ($query) {
            $this->response([
                'status' => TRUE,
                'data' => $kodetampil
            ], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function cetak_get($id)
    {
        $token = $this->get('token');
        $penjualan = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$id' AND token='$token' GROUP BY harga, kode_barang ORDER BY kode_barang")->result_array();

        if ($penjualan) {
            $this->response([
                'status' => TRUE,
                'data' => $penjualan
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    function toko_get()
    {
        $token = $this->get('token');
        $nm_toko = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($nm_toko) {
            $this->response([
                'status' => TRUE,
                'data' => $nm_toko
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    function pelanggan_get()
    {
        $token = $this->get('token');
        $pel = $this->db->get_where('tb_pelanggan', ['token' => $token])->result_array();

        if ($pel) {
            $this->response([
                'status' => TRUE,
                'data' => $pel
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }
}
