<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    public function cariData()
    {
        $key = $this->input->post('petugas', true);
        $ke = $this->input->post('tgl_akhir', true);
        $token = $this->session->userdata('token');
        if ($key == 'Semua') {
            $this->db->where('tgl_transaksi', $ke);
            $this->db->where('token', $token);
            return $this->db->get('tb_penjualan')->result_array();
        } else {
            $this->db->where('petugas', $key);
            $this->db->where('tgl_transaksi', $ke);
            $this->db->where('token', $token);
            return $this->db->get('tb_penjualan')->result_array();
        }
    }

    public function minggu()
    {
        $key = $this->input->post('petugas', true);
        $ke = $this->input->post('tgl_akhir', true);
        $k = $this->input->post('tgl_awal', true);
        $token = $this->session->userdata('token');
        if ($key == 'Semua') {
            return $this->db->query("SELECT * FROM tb_penjualan WHERE tb_penjualan.token='$token' AND tgl_transaksi BETWEEN '$k' and '$ke' ORDER BY tgl_transaksi DESC")->result_array();
        } else {
            return $this->db->query("SELECT * FROM tb_penjualan WHERE tb_penjualan.token='$token' AND petugas='$key' AND tgl_transaksi BETWEEN '$k' and '$ke' ORDER BY tgl_transaksi DESC")->result_array();
        }
    }

    public function cariBulan()
    {
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $retail = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();

        if ($filter == '3') {
            return $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' AND YEAR(a.timee)='$tahun' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' AND MONTH(a.timee)='$bulan' AND YEAR(a.timee)='$tahun' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' AND a.tgl_penjualan='$tanggal' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($filter == '4') {
            return $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' AND a.tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY a.kode_barang, a.modal, a.harga");
        }
    }

    public function cariSupplier()
    {
        $tanggal = $this->input->post('tanggal', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $token = $this->session->userdata('token');

        if ($filter == '3') {
            return $this->db->query("SELECT * FROM tb_retur_pembelian r WHERE r.token='$token' AND YEAR(r.tgl_pem)='$tahun' ORDER BY r.id_retur_pembelian");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT * FROM tb_retur_pembelian r WHERE r.token='$token' AND MONTH(r.tgl_pem)='$bulan' AND YEAR(r.tgl_pem)='$tahun' ORDER BY r.id_retur_pembelian");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT * FROM tb_retur_pembelian r WHERE r.token='$token' AND r.tgl_pem='$tanggal' ORDER BY r.id_retur_pembelian");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT * FROM tb_retur_pembelian r WHERE r.token='$token'");
        }
    }

    public function cariCustomer()
    {
        $tanggal = $this->input->post('tanggal', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $token = $this->session->userdata('token');

        if ($filter == '3') {
            return $this->db->query("SELECT r.*, p.kode_pel, p.nama_pel FROM tb_retur_penjualan r LEFT JOIN tb_pelanggan p ON p.kode_pel = r.kode_pelanggan WHERE r.token='$token' AND YEAR(r.tgl_beli)='$tahun' ORDER BY r.id_retur_penjualan DESC");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT r.*, p.kode_pel, p.nama_pel FROM tb_retur_penjualan r LEFT JOIN tb_pelanggan p ON p.kode_pel = r.kode_pelanggan WHERE r.token='$token' AND MONTH(r.tgl_beli)='$bulan' AND YEAR(r.tgl_beli)='$tahun' ORDER BY r.id_retur_penjualan");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT r.*, p.kode_pel, p.nama_pel FROM tb_retur_penjualan r LEFT JOIN tb_pelanggan p ON p.kode_pel = r.kode_pelanggan WHERE r.token='$token' AND r.tgl_beli='$tanggal' ORDER BY r.id_retur_penjualan");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT r.*, p.kode_pel, p.nama_pel FROM tb_retur_penjualan r LEFT JOIN tb_pelanggan p ON p.kode_pel = r.kode_pelanggan WHERE r.token='$token'");
        }
    }

    public function cariPembelian()
    {
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $filter = $this->input->post('filter', true);
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $retail = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();

        if ($filter == '3') {
            return $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND YEAR(p.timestmp)='$tahun' ORDER BY p.timestmp DESC");
        } elseif ($filter == '2') {
            return $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND MONTH(p.timestmp)='$bulan' AND YEAR(p.timestmp)='$tahun'  ORDER BY p.timestmp DESC");
        } elseif ($filter == 'semua') {
            return $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' ORDER BY p.timestmp DESC");
        } elseif ($filter == '1') {
            return $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND p.tgl_transaksi='$tanggal' ORDER BY p.timestmp DESC");
        } elseif ($filter == '4') {
            return $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND p.tgl_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.timestmp DESC");
        }
    }

    public function cariReport()
    {
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);
        $report = $this->input->post('report', true);

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $retail = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();

        if ($report == 'harian') {
            $this->db->select('*, sum(qty) as kkty');
            $this->db->where('tgl_order_detail', $tanggal);
            $this->db->where('status_bayar', '1');
            $this->db->where('token', $token);
            $this->db->group_by('id_barang');
            return $this->db->get('tb_shop_detail')->result_array();
        } elseif ($report == 'minggu') {
            return $this->db->query("SELECT *, sum(qty) as kkty FROM tb_shop_detail WHERE token='$token' AND status_bayar='1' AND tgl_order_detail BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY id_barang")->result_array();
        }
    }

    public function rpel()
    {
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);
        $report = $this->input->post('report', true);
        $kd_pelanggan = $this->input->post('kd_pelanggan', true);

        $token = $this->session->userdata('token');
        $data = $this->db->get_where('tb_pelanggan', ['token' => $token, 'kd_pelanggan' => $kd_pelanggan])->row();
        $pel = $data->nama_pel;

        if ($report == 'harian') {
            $this->db->where('kode_pelanggan', $pel);
            $this->db->where('tgl_transaksi', $tanggal);
            $this->db->where('token', $token);
            return $this->db->get('tb_penjualan')->result_array();
        } elseif ($report == 'minggu') {
            return $this->db->query("SELECT * FROM tb_penjualan WHERE tb_penjualan.token='$token' AND kode_pelanggan='$pel' AND tgl_transaksi BETWEEN '$tgl_awal' and '$tgl_akhir' ORDER BY tgl_transaksi DESC")->result_array();
        }
    }

    public function cariCusView()
    {
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);
        $report = $this->input->post('report', true);
        $id_shop_pel = $this->input->post('id_shop_pel', true);

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $retail = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();

        if ($report == 'harian') {
            $this->db->select('*, sum(d.qty) as kkty');
            $this->db->join('tb_shop s', 's.order_id=d.order_id');
            $this->db->where('s.id_shop_pel', $id_shop_pel);
            $this->db->where('d.tgl_order_detail', $tanggal);
            $this->db->where('d.status_bayar', 1);
            $this->db->where('d.token', $token);
            $this->db->group_by('d.id_barang');
            return $this->db->get('tb_shop_detail d')->result_array();
        } elseif ($report == 'minggu') {
            return $this->db->query("SELECT *, sum(qty) as kkty FROM tb_shop_detail d LEFT JOIN tb_shop s ON s.order_id=d.order_id WHERE s.id_shop_pel='$id_shop_pel' AND d.token='$token' AND d.status_bayar='1' AND d.tgl_order_detail BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY d.id_barang")->result_array();
        }
    }
}
