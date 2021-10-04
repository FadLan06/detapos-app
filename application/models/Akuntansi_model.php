<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akuntansi_model extends CI_Model
{
    function no_jurnal()
    {

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $token = $this->session->userdata('token');
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
        $pot = substr($this->session->userdata('token'), -3);
        $tgl = date('dmy');
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = $pot . $tgl . $batas;  //format kode
        return $kodetampil;
    }

    function no_jurnall()
    {

        $zona = $this->db->get_where('setting_app', ['token' => $this->uri->segment(2)])->row_array();
        date_default_timezone_set($zona['zona']);
        $token = $this->session->userdata('token');
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
        $pot = substr($this->session->userdata('token'), -3);
        $tgl = date('dmy');
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = $pot . $tgl . $batas;  //format kode
        return $kodetampil;
    }

    function no_jurnalll()
    {
        date_default_timezone_set('Asia/Jakarta');
        $token = $this->session->userdata('token');
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
        $pot = substr($this->session->userdata('token'), -3);
        $tgl = date('dmy');
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = $pot . $tgl . $batas;  //format kode
        return $kodetampil;
    }

    function cariLaba($tanggal, $bulan, $tahun, $filter, $token)
    {
        if ($filter == '3') {
            return $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$tahun' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') AND (tb_akun.nama_akun LIKE '%Beban%' OR tb_akun.nama_akun LIKE '%Pendapatan%' OR tb_akun.nama_akun LIKE '%Harga Pokok Penjualan%') group by tb_akun.nama_akun ORDER BY tb_jurnal.id_akun ASC");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') AND (tb_akun.nama_akun LIKE '%Beban%' OR tb_akun.nama_akun LIKE '%Pendapatan%' OR tb_akun.nama_akun LIKE '%Harga Pokok Penjualan%') group by tb_akun.nama_akun ORDER BY tb_jurnal.id_akun ASC");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$tanggal' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') AND (tb_akun.nama_akun LIKE '%Beban%' OR tb_akun.nama_akun LIKE '%Pendapatan%' OR tb_akun.nama_akun LIKE '%Harga Pokok Penjualan%') group by tb_akun.nama_akun ORDER BY tb_jurnal.id_akun ASC");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') AND (tb_akun.nama_akun LIKE '%Beban%' OR tb_akun.nama_akun LIKE '%Pendapatan%' OR tb_akun.nama_akun LIKE '%Harga Pokok Penjualan%') group by tb_akun.nama_akun ORDER BY tb_jurnal.id_akun ASC");
        }
    }

    public function cariNeraca()
    {
        $tanggal = $this->input->post('tanggal', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $token = $this->session->userdata('token');

        if ($filter == '3') {
            return $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$tahun' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$bulan' AND year(tb_jurnal_tmp.tgl_jurnal)='$tahun' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$tanggal' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
        }
    }

    public function cariJurnal()
    {
        $tanggal = $this->input->post('tanggal', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $token = $this->session->userdata('token');

        if ($filter == '3') {
            return $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.token='$token' AND year(tb_jurnal_tmp.tgl_jurnal)='$tahun' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$bulan' AND year(tb_jurnal_tmp.tgl_jurnal)='$tahun' AND tb_jurnal.token='$token' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$tanggal' AND tb_jurnal.token='$token' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.token='$token' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
        }
    }
}
