<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekon_model extends CI_Model
{
    function no_rekon()
    {

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $this->db->select('RIGHT(tb_rekon_tmp.no_rekon,5) as no_rekon', FALSE);
        $this->db->where('tgl_rekon_tmp', date('Y-m-d'));
        $this->db->order_by('no_rekon', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_rekon_tmp');  //cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) {
            //cek kode jika telah tersedia    
            $data = $query->row();
            $kode = intval($data->no_rekon) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $tgl = date('dmy');
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = "RE" . $tgl . $batas;  //format kode
        return $kodetampil;
    }

    public function cari()
    {
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $token = $this->session->userdata('token');

        if ($filter == '3') {
            return $this->db->query("SELECT * FROM tb_rekon_tmp r WHERE r.token='$token' AND year(r.tgl_rekon_tmp)='$tahun'");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT * FROM tb_rekon_tmp r WHERE r.token='$token' AND month(r.tgl_rekon_tmp)='$bulan' AND year(r.tgl_rekon_tmp)='$tahun'");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT * FROM tb_rekon_tmp r WHERE r.token='$token' AND r.tgl_rekon_tmp='$tanggal'");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT * FROM tb_rekon_tmp r WHERE r.token='$token' ORDER BY r.tgl_rekon_tmp ASC");
        } elseif ($filter == '4') {
            return $this->db->query("SELECT * FROM tb_rekon_tmp r WHERE r.token='$token' AND r.tgl_rekon_tmp BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY r.tgl_rekon_tmp ASC");
        }
    }

    public function cariFinal()
    {
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $token = $this->session->userdata('token');

        if ($filter == '3') {
            return $this->db->query("SELECT r.tgl_final, r.token FROM tb_rekon_final r WHERE r.token='$token' AND year(r.tgl_final)='$tahun' GROUP BY r.tgl_final ORDER BY r.tgl_final DESC");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT r.tgl_final, r.token FROM tb_rekon_final r WHERE r.token='$token' AND month(r.tgl_final)='$bulan' AND year(r.tgl_final)='$tahun' GROUP BY r.tgl_final ORDER BY r.tgl_final DESC");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT r.tgl_final, r.token FROM tb_rekon_final r WHERE r.token='$token' AND r.tgl_final='$tanggal' GROUP BY r.tgl_final ORDER BY r.tgl_final DESC");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT r.tgl_final, r.token FROM tb_rekon_final r WHERE r.token='$token' GROUP BY r.tgl_final ORDER BY r.tgl_final DESC");
        } elseif ($filter == '4') {
            return $this->db->query("SELECT r.tgl_final, r.token FROM tb_rekon_final r WHERE r.token='$token' AND r.tgl_final BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY r.tgl_final ORDER BY r.tgl_final DESC");
        }
    }

    function no_setoran()
    {

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $this->db->select('RIGHT(tb_setoran.no_setoran,5) as no_setoran', FALSE);
        $this->db->where('tgl_setoran', date('Y-m-d'));
        $this->db->order_by('no_setoran', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_setoran');  //cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) {
            //cek kode jika telah tersedia    
            $data = $query->row();
            $kode = intval($data->no_setoran) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $tgl = date('dmy');
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = "SET" . $tgl . $batas;  //format kode
        return $kodetampil;
    }

    public function cariSet()
    {
        $tanggal = $this->input->post('tanggal', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $token = $this->session->userdata('token');

        if ($filter == '3') {
            return $this->db->query("SELECT * FROM tb_setoran WHERE token='$token' AND YEAR(tgl_setoran)='$tahun'");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT * FROM tb_setoran WHERE token='$token' AND MONTH(tgl_setoran)='$bulan' AND YEAR(tgl_setoran)='$tahun'");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT * FROM tb_setoran WHERE token='$token' AND tgl_setoran='$tanggal'");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT * FROM tb_setoran WHERE token='$token'");
        }
    }
}
