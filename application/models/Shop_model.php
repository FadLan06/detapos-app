<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop_model extends CI_Model
{
    function order_id()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('RIGHT(tb_shop.order_id,5) as order_id', FALSE);
        $this->db->where('tgl_order', date('Y-m-d'));
        $this->db->order_by('order_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_shop');  //cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) {
            //cek kode jika telah tersedia    
            $data = $query->row();
            $kode = intval($data->order_id) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $tgl = date('dmyhis');
        $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodetampil = $tgl . $batas;  //format kode
        return $kodetampil;
    }
}
