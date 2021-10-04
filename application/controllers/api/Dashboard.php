<?php
header('Access-Control-Allow-Origin: *');

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Dashboard extends RestController
{

    function __construct()
    {
        parent::__construct();
    }

    public function grafik_get()
    {
        $token = $this->get('token');

        $awal = date('Y-m-' . '1');
        $bulan = date('m');
        $tahun = date('Y');
        $jumlah = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $akhir = date('Y-m-' . $jumlah);

        $data = $this->db->query("SELECT * FROM tb_penjualan WHERE token='$token' AND tgl_transaksi BETWEEN '$awal' and '$akhir'")->result();

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

    public function dhari_get()
    {
        $token = $this->get('token');

        $data = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Pendapatan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
        foreach ($data->result_array() as $k) :
            if ($k['tipe'] == 'K') :
                $total_kredit = "0";
                $saldo_kredit = "0";
                $tanggal = date('Y-m-d');

                $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE t.tgl_jurnal='$tanggal' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");

                foreach ($neraca->result_array() as $n) :
                    if ($n['tipe'] == 'K') {
                        $kredit = $n['nominal'];
                    }
                    $total_kredit += $kredit;

                    if ($n['kategori'] == 'HT') {
                        $saldo_kredit = $total_kredit;
                    }
                endforeach;
            endif;
        endforeach;

        if ($data) {
            if ($saldo_kredit == null) {
                $this->response([
                    'status' => TRUE,
                    'data' => 0
                ], 200);
            } else {
                $this->response([
                    'status' => TRUE,
                    'data' => $saldo_kredit
                ], 200);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function dminggu_get()
    {
        $token = $this->get('token');

        $data = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Pendapatan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
        foreach ($data->result_array() as $k) :
            if ($k['tipe'] == 'K') :
                $total_kredit = "0";
                $saldo_kredit = "0";
                $bulan = date('m');
                $tahun = date('Y');

                $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE WEEKOFYEAR(t.tgl_jurnal)=WEEKOFYEAR(NOW()) AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");

                foreach ($neraca->result_array() as $n) :
                    if ($n['tipe'] == 'K') {
                        $kredit = $n['nominal'];
                    }
                    $total_kredit += $kredit;

                    if ($n['kategori'] == 'HT') {
                        $saldo_kredit = $total_kredit;
                    }
                endforeach;
            endif;
        endforeach;

        if ($data) {
            if ($saldo_kredit == null) {
                $this->response([
                    'status' => TRUE,
                    'data' => 0
                ], 200);
            } else {
                $this->response([
                    'status' => TRUE,
                    'data' => $saldo_kredit
                ], 200);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function dbulan_get()
    {
        $token = $this->get('token');

        $data = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Pendapatan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
        foreach ($data->result_array() as $k) :
            if ($k['tipe'] == 'K') :
                $total_kredit = "0";
                $saldo_kredit = "0";
                $bulan = date('m');
                $tahun = date('Y');

                // $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE MONTH(t.tgl_jurnal)='$bulan' AND YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");

                $neraca = $this->db->query("SELECT tb_jurnal.nominal, tb_jurnal.tipe, tb_akun.kategori from tb_jurnal LEFT JOIN tb_akun ON tb_jurnal.id_akun=tb_akun.id_akun LEFT JOIN tb_jurnal_tmp ON tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal where month(tb_jurnal_tmp.tgl_jurnal)='$bulan' AND year(tb_jurnal_tmp.tgl_jurnal)='$tahun' AND tb_jurnal.token='$token' and tb_jurnal.id_akun='$k[id_akun]' ");

                foreach ($neraca->result_array() as $n) :
                    if ($n['tipe'] == 'K') {
                        $kredit = $n['nominal'];
                    }
                    $total_kredit += $kredit;

                    if ($n['kategori'] == 'HT') {
                        $saldo_kredit = $total_kredit;
                    }
                endforeach;
            endif;
        endforeach;

        if ($data) {
            if ($saldo_kredit == null) {
                $this->response([
                    'status' => TRUE,
                    'data' => 0
                ], 200);
            } else {
                $this->response([
                    'status' => TRUE,
                    'data' => $saldo_kredit
                ], 200);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function dtahun_get()
    {
        $token = $this->get('token');

        $data = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Pendapatan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
        foreach ($data->result_array() as $k) :
            if ($k['tipe'] == 'K') :
                $total_kredit = "0";
                $saldo_kredit = "0";
                $tahun = date('Y');

                $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");
                foreach ($neraca->result_array() as $n) :
                    if ($n['tipe'] == 'K') {
                        $kredit = $n['nominal'];
                    }
                    $total_kredit += $kredit;

                    if ($n['kategori'] == 'HT') {
                        $saldo_kredit = $total_kredit;
                    }
                endforeach;
            endif;
        endforeach;

        if ($data) {
            if ($saldo_kredit == null) {
                $this->response([
                    'status' => TRUE,
                    'data' => 0
                ], 200);
            } else {
                $this->response([
                    'status' => TRUE,
                    'data' => $saldo_kredit
                ], 200);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function log_get()
    {
        $token = $this->get('token');
        $data = $this->db->query("SELECT * FROM tb_log WHERE token='$token' ORDER BY id_log DESC LIMIT 10")->result_array();

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

    public function laba_get()
    {
        $token = $this->get('token');
        $data = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Beban%' OR a.nama_akun LIKE '%Pendapatan%' OR a.nama_akun LIKE '%Harga Pokok Penjualan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
        $ts_debet = "0";
        $ts_kredit = "0";
        foreach ($data->result_array() as $k) :
            if ($k['tipe'] == 'K') :
                $total_kredit = "0";
                $saldo_kredit = "0";
                $bulan = date('m');
                $tahun = date('Y');

                $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE MONTH(t.tgl_jurnal)='$bulan' AND YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");

                foreach ($neraca->result_array() as $n) :
                    if ($n['tipe'] == 'K') {
                        $kredit = $n['nominal'];
                    }
                    $total_kredit += $kredit;

                    if ($n['kategori'] == 'HT') {
                        $saldo_kredit = $total_kredit;
                    }
                endforeach;
                $ts_kredit = abs($saldo_kredit - $ts_kredit);
            elseif ($k['tipe'] == 'D') :
                $total_debet = "0";
                $saldo_debet = "0";
                $bulan = date('m');
                $tahun = date('Y');

                $neraca1 = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE MONTH(t.tgl_jurnal)='$bulan' AND YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");
                foreach ($neraca1->result_array() as $nn) :
                    if ($nn['tipe'] == 'D') {
                        $debet = $nn['nominal'];
                        $kredit = "0";
                    }
                    $total_debet += $debet;

                    if ($nn['kategori'] == 'HL') {
                        $saldo_debet = $total_debet;
                    }
                endforeach;
                $ts_debet += $saldo_debet;
            endif;
            $bersih = $ts_kredit - $ts_debet;
        endforeach;

        if ($data) {
            if ($bersih == null) {
                $this->response([
                    'status' => TRUE,
                    'data' => 0
                ], 200);
            } else {
                $this->response([
                    'status' => TRUE,
                    'data' => $bersih
                ], 200);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function laba_hari_get()
    {
        $token = $this->get('token');
        $data = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Beban%' OR a.nama_akun LIKE '%Pendapatan%' OR a.nama_akun LIKE '%Harga Pokok Penjualan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
        $ts_debet = "0";
        $ts_kredit = "0";
        foreach ($data->result_array() as $k) :
            if ($k['tipe'] == 'K') :
                $total_kredit = "0";
                $saldo_kredit = "0";
                $tanggal = date('Y-m-d');

                $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE t.tgl_jurnal='$tanggal' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");

                foreach ($neraca->result_array() as $n) :
                    if ($n['tipe'] == 'K') {
                        $kredit = $n['nominal'];
                    }
                    $total_kredit += $kredit;

                    if ($n['kategori'] == 'HT') {
                        $saldo_kredit = $total_kredit;
                    }
                endforeach;
                $ts_kredit = abs($saldo_kredit - $ts_kredit);
            elseif ($k['tipe'] == 'D') :
                $total_debet = "0";
                $saldo_debet = "0";
                $tanggal = date('Y-m-d');

                $neraca1 = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE t.tgl_jurnal='$tanggal' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");
                foreach ($neraca1->result_array() as $nn) :
                    if ($nn['tipe'] == 'D') {
                        $debet = $nn['nominal'];
                        $kredit = "0";
                    }
                    $total_debet += $debet;

                    if ($nn['kategori'] == 'HL') {
                        $saldo_debet = $total_debet;
                    }
                endforeach;
                $ts_debet += $saldo_debet;
            endif;
            $bersih = $ts_kredit - $ts_debet;
        endforeach;

        if ($data) {
            if ($bersih == null) {
                $this->response([
                    'status' => TRUE,
                    'data' => 0
                ], 200);
            } else {
                $this->response([
                    'status' => TRUE,
                    'data' => $bersih
                ], 200);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function terlaris_get()
    {
        $token = $this->get('token');
        $data = $this->db->query("SELECT a.*, sum(a.qty) as total FROM tb_detail_penjualan a WHERE a.token='$token' GROUP BY a.kode_barang ORDER BY total DESC LIMIT 10")->result();

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
