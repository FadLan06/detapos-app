<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
    public function getAutoSup($title)
    {
        $token = $this->session->userdata('token');

        return $this->db->query("SELECT * FROM tb_supplier WHERE (token='$token') AND (kode_sup LIKE '%$title%' OR nama_toko LIKE '%$title%') ORDER BY kode_sup ASC limit 10")->result();
    }

    public function getAutoBrng($title)
    {
        $token = $this->session->userdata('token');

        return $this->db->query("SELECT * FROM tb_barang WHERE (token='$token') AND (kode_barang LIKE '%$title%' OR nama_barang LIKE '%$title%') ORDER BY kode_barang ASC limit 10")->result();
    }

    function simpan_barang($kd_brng, $nm_brng, $hrga_jl, $hrga_pk, $petugas, $jumlah, $potongan, $timee, $token)
    {
        $hasil = $this->db->query("INSERT INTO tb_detail_pembelian_tmp (kode_barang,nama_barang,harga_jual,harga_beli,petugas,potongan,jumlah,timee,token)VALUES('$kd_brng','$nm_brng','$hrga_jl','$hrga_pk','$petugas','$potongan','$jumlah','$timee','$token')");
        return $hasil;
    }

    function hapus($id)
    {
        $token = $this->session->userdata('token');
        $this->db->where("kode_barang", $id);
        $this->db->where("token", $token);
        $this->db->delete("tb_detail_pembelian_tmp");
    }

    function no_faktur()
    {
        $token = $this->session->userdata('token');
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);

        $this->db->select('RIGHT(tb_pembelian.no_faktur,5) as no_faktur', FALSE);
        $this->db->where('token', $token);
        $this->db->order_by('no_faktur', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_pembelian');  //cek dulu apakah ada sudah ada kode di tabel.
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->no_faktur) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = "INV" . $batas;  //format kode
        return $kodetampil;
    }

    function no_seri()
    {
        $token = $this->session->userdata('token');
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);

        $this->db->select('RIGHT(tb_pengeluaran.no_seri,5) as no_seri', FALSE);
        $this->db->where('token', $token);
        $this->db->order_by('no_seri', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_pengeluaran');  //cek dulu apakah ada sudah ada kode di tabel.
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->no_seri) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = "SR" . $batas;  //format kode
        return $kodetampil;
    }
}
