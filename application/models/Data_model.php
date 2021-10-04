<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_model extends CI_Model
{

    public function insert($data)
    {

        $res = $this->db->insert_batch('tb_barang', $data);
        if ($res) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getbarang()
    {
        $this->db->select('*');
        $this->db->select('tb_barang.kode_barang as kode');
        // $this->db->select('tb_detail_penjualan.qty');
        $this->db->join('tb_barang', 'tb_detail_penjualan.kode_barang = tb_barang.kode_barang');
        $this->db->from('tb_detail_penjualan');
        $query = $this->db->get();
        return $query;
    }

    function no_kwitansi()
    {
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);

        $token = $this->session->userdata('token');
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
        $pot = substr($this->session->userdata('token'), -3);
        $tgl = date('dmy');
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodetampil = $pot . $tgl . $batas;  //format kode
        return $kodetampil;
    }

    function no_kwitansi1()
    {
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $data['user']['date_created'];
        $this->db->select('RIGHT(tb_penjualan.no_transaksi,5) as no_transaksi', FALSE);
        $this->db->where('tgl_transaksi', date('Y-m-d'));
        // $this->db->where('token', $token);
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
        $pot = substr($this->session->userdata('token'), -3);
        $tgl = date('Ymd');
        $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodetampil = $pot . '.' . $tgl . '.' . $batas;  //format kode
        return $kodetampil;
    }

    function getAutoWarkop($kode)
    {
        $token = $this->session->userdata('token');
        $hsl = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$kode' AND token='$token'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'nama_barang' => $data->nama_barang,
                    'harga' => $data->harga_jual,
                    'harga_beli' => $data->harga_beli,
                );
            }
        }
        return $hasil;
    }

    public function getAuto($title)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $this->session->userdata('token');

        return $this->db->query("SELECT * FROM tb_barang WHERE (token='$token') AND (kode_barang LIKE '%$title%' OR nama_barang LIKE '%$title%') ORDER BY kode_barang ASC limit 10")->result();
    }

    public function getAuto1($title)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $this->session->userdata('token');

        return $this->db->query("SELECT * FROM tb_pelanggan WHERE (token='$token') AND (kode_pel LIKE '%$title%' OR nama_pel LIKE '%$title%') ORDER BY kode_pel ASC limit 10")->result();
    }

    public function getAuto2($title)
    {
        $this->db->like('kode_barang', $title, 'BOTH');
        // $this->db->like('nama_barang', $title, 'BOTH');
        $this->db->order_by('kode_barang', 'ASC');
        $this->db->limit(10);
        return $this->db->get('tb_barang')->result();
    }

    public function getAuto3($title)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $this->session->userdata('token');

        return $this->db->query("SELECT *, h.harga_jual as hjual FROM tb_barang b, tb_barang_harga h WHERE (h.id_barang = b.kode_barang) AND (b.token='$token') AND (b.kode_barang LIKE '%$title%' OR b.nama_barang LIKE '%$title%') ORDER BY b.kode_barang ASC limit 10")->result();
    }

    function simpan_barang($kobar, $nabar, $harga, $harga_beli, $potongan, $petugas, $qty, $timee, $token)
    {
        $hasil = $this->db->query("INSERT INTO tb_detail_penjualan_tmp (kode_barang,nama_barang,modal,harga,potongan,petugas,qty,timee,token)VALUES('$kobar','$nabar','$harga_beli','$harga','$potongan','$petugas','$qty','$timee','$token')");
        return $hasil;
    }

    function simpan_barang_butik($kobar, $nabar, $harga, $harga_beli, $potongan, $ukuran, $varian, $petugas, $qty, $timee, $token)
    {
        $hasil = $this->db->query("INSERT INTO tb_detail_penjualan_tmp (kode_barang,nama_barang,modal,harga,potongan,ukuran,varian,petugas,qty,timee,token)VALUES('$kobar','$nabar','$harga_beli','$harga','$potongan','$ukuran','$varian','$petugas','$qty','$timee','$token')");
        return $hasil;
    }

    function simpan_barang_elec($kobar, $nabar, $serial_num, $harga, $harga_beli, $potongan, $petugas, $qty, $timee, $token)
    {
        $hasil = $this->db->query("INSERT INTO tb_detail_penjualan_tmp (kode_barang,nama_barang,serial_num,modal,harga,potongan,petugas,qty,timee,token)VALUES('$kobar','$nabar','$serial_num','$harga_beli','$harga','$potongan','$petugas','$qty','$timee','$token')");
        return $hasil;
    }

    function simpan_barang_warkop($kobar, $nabar, $harga, $harga_beli, $petugas, $qty, $timee, $token)
    {
        $hasil = $this->db->query("INSERT INTO tb_detail_penjualan_tmp (kode_barang,nama_barang,modal,harga,petugas,qty,timee,token)VALUES('$kobar','$nabar','$harga_beli','$harga','$petugas','$qty','$timee','$token')");
        return $hasil;
    }

    function ubh_sta($status)
    {
        if ($status == 'Lunas') {
            $this->db->set('status', 'Hutang');
            $this->db->where('status', $status);
            $this->db->update('tb_penjualan');
        } elseif ($status == 'Hutang') {
            $this->db->set('status', 'Lunas');
            $this->db->where('status', $status);
            $this->db->update('tb_penjualan');
        }
    }

    function delete($id)
    {
        $token = $this->session->userdata('token');
        $this->db->where("kode_barang", $id);
        $this->db->where("token", $token);
        $this->db->delete("tb_detail_penjualan_tmp");
    }

    function delete_rt($id, $hg)
    {
        $token = $this->session->userdata('token');
        $this->db->where("kode_barang", $id);
        $this->db->where("harga", $hg);
        $this->db->where("token", $token);
        $this->db->delete("tb_detail_penjualan_tmp");
    }

    function delete_bt($id, $hg, $vr, $uk)
    {
        $token = $this->session->userdata('token');
        $this->db->where("kode_barang", $id);
        $this->db->where("harga", $hg);
        $this->db->where("varian", $vr);
        $this->db->where("ukuran", $uk);
        $this->db->where("token", $token);
        $this->db->delete("tb_detail_penjualan_tmp");
    }

    function barang($token)
    {
        $query = $this->db->get_where('tb_barang', ['token' => $token]);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function supplier($token)
    {
        $query = $this->db->get_where('tb_supplier', ['token' => $token]);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function pelanggan($token)
    {
        $query = $this->db->get_where('tb_pelanggan', ['token' => $token]);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function penjualan($token)
    {
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $waktu = date('Y-m-d');
        $query = $this->db->get_where('tb_penjualan', ['tgl_transaksi' => $waktu, 'token' => $token]);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function users()
    {
        $query = $this->db->get_where('user', ['role_id' => 2]);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function users_aktif()
    {
        $query = $this->db->get_where('user', ['role_id' => 2, 'is_active' => 1]);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function users_nonaktif()
    {
        $query = $this->db->get_where('user', ['role_id' => 2, 'is_active' => 0]);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function kabupaten($provId)
    {

        $kabupaten = "<option value='0'><-- Pilih Kota/Kabupaten--></pilih>";

        $this->db->order_by('nama', 'ASC');
        $kab = $this->db->get_where('tb_kabupaten', array('id_prov' => $provId));

        foreach ($kab->result_array() as $data) {
            $kabupaten .= "<option value='$data[id_kab]'>$data[nama]</option>";
        }

        return $kabupaten;
    }

    function modal($token)
    {
        $query = $this->db->get_where('tb_barang', ['token' => $token]);
        $total = 0;
        foreach ($query->result() as $data) {
            $total += $data->harga_beli;
        }

        if ($query->num_rows() > 0) {
            return $total;
        } else {
            return 0;
        }
    }

    function pendapatan($token)
    {
        $data = $this->db->query("SELECT *, sum(j.nominal) as ttl_kredit FROM tb_jurnal j LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE j.token='$token' AND a.nama_akun LIKE '%Pendapatan%'")->row_array();

        return $data['ttl_kredit'];
    }

    function pengeluaran($token)
    {
        $data = $this->db->query("SELECT *, sum(j.nominal) as ttl_debet FROM tb_jurnal j LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE j.token='$token' AND a.nama_akun LIKE '%Beban%'")->row_array();


        return $data['ttl_debet'];
    }
}
