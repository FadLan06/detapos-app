<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends CI_Model
{

	function stok()
	{
		$token = $this->session->userdata('token');
		$hasil = $this->db->get_where('tb_barang', ['token' => $token])->result_array();
		foreach ($hasil as $dat) {
			$bra = $this->db->query("SELECT * FROM tb_barang WHERE token='$token' AND jml_stok <= $dat[minimal_stok]");
			return $bra->result();
		}
	}

	function tempo()
	{
		$token = $this->session->userdata('token');
		$tgl_skrng = date('Y-m-d');
		$hasil = $this->db->query("SELECT * FROM tb_barang WHERE token = '$token' AND tgl_tempo = '$tgl_skrng'");
		return $hasil->result();
	}

	function get_sub_kategori($id)
	{
		$query = $this->db->get_where('tb_sub_kategori_barang', array('kode_kategori' => $id));
		return $query;
	}

	public function getAutoBrng($title)
	{
		$token = $this->session->userdata('token');

		return $this->db->query("SELECT *, sum(p.jumlah) as kty FROM tb_detail_pembelian p WHERE (p.token='$token') AND (p.kode_barang LIKE '%$title%' OR p.nama_barang LIKE '%$title%') GROUP BY p.kode_barang ORDER BY p.kode_barang ASC limit 10")->result();
	}
}
