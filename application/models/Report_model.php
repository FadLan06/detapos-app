<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
    public function cari()
    {
        $bulan = $this->input->post('bulan', true);
        $bulan1 = $this->input->post('bulan1', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $barang = $this->input->post('barang', true);
        $token = $this->session->userdata('token');

        if ($filter == '3') {
            return $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' AND YEAR(p.timee)='$tahun' GROUP BY b.kode_barang, b.harga_jual ORDER BY kty DESC");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty, MONTH(p.timee) as bulan, YEAR(p.timee) as tahun FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' AND MONTH(p.timee) BETWEEN '$bulan' AND '$bulan1' AND YEAR(p.timee)='$tahun' AND b.kode_barang='$barang' GROUP BY b.kode_barang, b.harga_jual, MONTH(p.timee) ORDER BY kty DESC");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' AND MONTH(p.timee)='$bulan' AND YEAR(p.timee)='$tahun' GROUP BY b.kode_barang, b.harga_jual ORDER BY kty DESC");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' GROUP BY b.kode_barang, b.harga_jual ORDER BY kty DESC");
        }
    }

    public function getAuto($title)
    {
        $token = $this->session->userdata('token');

        return $this->db->query("SELECT * FROM tb_barang WHERE (token='$token') AND (kode_barang LIKE '%$title%' OR nama_barang LIKE '%$title%') ORDER BY kode_barang ASC limit 10")->result();
    }
}
