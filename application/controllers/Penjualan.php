<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Data_model');
        $this->load->model('Laporan_model');
        $this->load->model('Akuntansi_model');

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Transaksi Penjualan';
        $token = $data['user']['token'];
        $petugas = $this->session->userdata('username');

        $data['petugas'] = $this->db->get_where('user', ['token' => $token, 'role_id' => 3])->result_array();
        $data['penjualan'] = $this->db->query("SELECT * FROM tb_penjualan p WHERE p.token='$token' ORDER BY timestmp DESC ")->result();
        $data['penjualan2'] = $this->db->query("SELECT * FROM tb_penjualan p WHERE p.token='$token' AND p.petugas='$petugas' ORDER BY timestmp DESC ")->result();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/penjualan', $data);
        $this->load->view('templates/footer');
    }

    function hps_pen($id)
    {
        $token = $this->session->userdata('token');
        $sql = $this->db->query("SELECT a.*, b.nama_barang, b.satuan  FROM tb_detail_penjualan a LEFT JOIN tb_barang b ON a.kode_barang = b.kode_barang WHERE a.no_transaksi = '$id' AND a.token='$token'");

        foreach ($sql->result_array() as $dtt) {
            $char[] = $dtt;
        }

        foreach ($char as $row) {

            $simpan = $this->db->query("UPDATE tb_barang SET jml_stok = jml_stok + '$row[qty]' WHERE kode_barang = '$row[kode_barang]' AND token = '$row[token]'");
        }

        $this->db->where('no_transaksi', $id);
        $this->db->delete('tb_detail_penjualan');
        $this->db->where('no_transaksi', $id);
        $this->db->delete('tb_penjualan');

        $this->db->where('no_transaksi', $id);
        $this->db->delete('tb_jurnal');
        $this->db->where('no_transaksi', $id);
        $this->db->delete('tb_jurnal_tmp');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Barang Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Penjualan') . "';</script>";
    }

    function aksi()
    {
        if (isset($_POST['ubh'])) {

            $user = $this->db->get_where('user', ['token' => $this->session->userdata('token')])->row_array();
            if ($user['coupon'] == 'new') {
                $uang = str_replace(',', '', $this->input->post('uang'));

                $bayar = $uang + $this->input->post('uang_muka');
                $this->db->set('status', 'Lunas');
                $this->db->set('bayar', $bayar);
                $this->db->where('no_transaksi', $this->input->post('no_transaksi'));
                $this->db->update('tb_penjualan');

                $datta = [
                    'no_jurnal' => $this->input->post('no_jurnal'),
                    'tgl_jurnal' => date('Y-m-d'),
                    'keterangan' => 'Pendapatan Penjualan dengan Nomor Transaksi ' . $this->input->post('no_transaksi'),
                    'token' => $this->session->userdata('token'),
                    'no_transaksi' => $this->input->post('no_transaksi')
                ];

                $this->db->insert('tb_jurnal_tmp', $datta);

                $tok = $this->session->userdata('token');
                $metodePem = $this->input->post('metodePem');
                if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) {
                    if ($metodePem == 'Transfer') {
                        $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (113,411,112,511) ORDER BY kode_akun='113', kategori='HL' DESC")->result_array();
                    } else {
                        $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (111,112,411,511) ORDER BY kategori='HL' DESC")->result_array();
                    }
                } else {
                    $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (111,112,411,511) ORDER BY kategori='HL' DESC")->result_array();
                }

                foreach ($ak as $ro) {
                    if ($metodePem == 'Transfer') {
                        if ($ro['kode_akun'] == '113') {
                            // $ka = 'D';
                            $dt1 = [
                                'no_jurnal' => $this->input->post('no_jurnal'),
                                'id_akun' => $ro['id_akun'],
                                'nominal' => $uang,
                                'tipe' => 'D',
                                'token' => $this->session->userdata('token'),
                                'no_transaksi' => $this->input->post('no_transaksi')
                            ];

                            $this->db->insert('tb_jurnal', $dt1);
                        } else if ($ro['kode_akun'] == '411') {
                            // $ka = 'K';
                            $dt1 = [
                                'no_jurnal' => $this->input->post('no_jurnal'),
                                'id_akun' => $ro['id_akun'],
                                'nominal' => $uang,
                                'tipe' => 'K',
                                'token' => $this->session->userdata('token'),
                                'no_transaksi' => $this->input->post('no_transaksi')
                            ];

                            $this->db->insert('tb_jurnal', $dt1);
                        }
                    } else {
                        if ($ro['kode_akun'] == '111') {
                            // $ka = 'D';
                            $dt1 = [
                                'no_jurnal' => $this->input->post('no_jurnal'),
                                'id_akun' => $ro['id_akun'],
                                'nominal' => $uang,
                                'tipe' => 'D',
                                'token' => $this->session->userdata('token'),
                                'no_transaksi' => $this->input->post('no_transaksi')
                            ];

                            $this->db->insert('tb_jurnal', $dt1);
                        } else if ($ro['kode_akun'] == '411') {
                            // $ka = 'K';
                            $dt1 = [
                                'no_jurnal' => $this->input->post('no_jurnal'),
                                'id_akun' => $ro['id_akun'],
                                'nominal' => $uang,
                                'tipe' => 'K',
                                'token' => $this->session->userdata('token'),
                                'no_transaksi' => $this->input->post('no_transaksi')
                            ];

                            $this->db->insert('tb_jurnal', $dt1);
                        }
                    }

                    if ($ro['kode_akun'] == '112') {
                        // $ka = 'K';
                        $dt1 = [
                            'no_jurnal' => $this->input->post('no_jurnal'),
                            'id_akun' => $ro['id_akun'],
                            'nominal' => $this->input->post('modal'),
                            'tipe' => 'K',
                            'token' => $this->session->userdata('token'),
                            'no_transaksi' => $this->input->post('no_transaksi')
                        ];

                        $this->db->insert('tb_jurnal', $dt1);
                    } else if ($ro['kode_akun'] == '511') {
                        // $ka = 'K';
                        $dt1 = [
                            'no_jurnal' => $this->input->post('no_jurnal'),
                            'id_akun' => $ro['id_akun'],
                            'nominal' => $this->input->post('modal'),
                            'tipe' => 'D',
                            'token' => $this->session->userdata('token'),
                            'no_transaksi' => $this->input->post('no_transaksi')
                        ];

                        $this->db->insert('tb_jurnal', $dt1);
                    }
                }
            }

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Status Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Penjualan') . "';</script>";
        } elseif (isset($_POST['retur_jual'])) {
            $token = $this->session->userdata('token');
            $no_transaksi = htmlspecialchars($this->input->post('no_transaksi'));
            $kode_pelanggan = htmlspecialchars($this->input->post('kode_pelanggan'));
            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $qty = htmlspecialchars($this->input->post('qty'));
            $harga = htmlspecialchars($this->input->post('harga'));
            $stok = htmlspecialchars($this->input->post('stok'));
            $kd_penjualan = htmlspecialchars($this->input->post('kd_penjualan'));
            $id = htmlspecialchars($this->input->post('id'));
            $jml_retur = htmlspecialchars($this->input->post('jml_retur'));

            $barang = $this->db->get_where('tb_barang', ['kode_barang' => $kode_barang, 'id' => $id, 'token' => $token])->row_array();
            $dt_pen = $this->db->query("SELECT *, sum(harga*qty) as sub_total FROM tb_detail_penjualan WHERE kode_barang='$kode_barang' AND no_transaksi='$no_transaksi' AND token='$token'")->row_array();

            $stok_br = $barang['jml_stok'] + $jml_retur;
            $stok_bl = $dt_pen['qty'] - $jml_retur;

            $data = [
                'no_transaksi' => $no_transaksi,
                'kode_barang' => $kode_barang,
                'harga' => $harga,
                'kode_pelanggan' => $kode_pelanggan,
                'jml_retur' => $jml_retur,
                'tgl_beli' => date('y-m-d'),
                'token' => $token
            ];

            $this->db->insert('tb_retur_penjualan', $data);

            if ($jml_retur <= $dt_pen['qty']) {
                $this->db->set('jml_stok', $stok_br);
                $this->db->where('id', $id);
                $this->db->update('tb_barang');

                $this->db->set('qty', $stok_bl);
                $this->db->where('kode_barang', $kode_barang);
                $this->db->where('no_transaksi', $no_transaksi);
                $this->db->update('tb_detail_penjualan');
            }

            $pen = $this->db->query("SELECT *, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$no_transaksi' AND token='$token' GROUP BY kode_barang")->row_array();

            $nt = $pen['no_transaksi'];
            $kd = $pen['kode_barang'];

            if ($pen['kty'] < 1) {
                $this->db->query("DELETE FROM tb_detail_penjualan WHERE kode_barang ='$kd' AND no_transaksi = '$nt'");
            }

            $ntr = $this->db->query("SELECT * FROM tb_detail_penjualan WHERE no_transaksi='$no_transaksi' AND token='$token'")->row_array();

            if (empty($ntr)) {
                $this->db->query("DELETE FROM tb_penjualan WHERE no_transaksi = '$no_transaksi' AND token='$token'");
                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Barang Berhasil di Retur!'); </script>";
                }
                echo "<script>window.location='" . site_url('Penjualan') . "';</script>";
            }

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Barang Berhasil di Retur!'); </script>";
            }
            echo "<script>window.location='" . site_url('Penjualan/Dtl_penjualan/') . $no_transaksi . "';</script>";
        }
    }

    public function hapus_pen($id)
    {
        $token = $this->session->userdata('token');
        $this->db->select('*,tb_detail_penjualan.kode_barang as kode');
        $this->db->join('tb_barang', 'tb_barang.kode_barang=tb_detail_penjualan.kode_barang');
        $this->db->where('no_transaksi', $id);
        $this->db->where('tb_detail_penjualan.token', $token);
        $sqll = $this->db->get('tb_detail_penjualan');

        foreach ($sqll->result_array() as $dtt) {
            $char[] = $dtt;
        }

        foreach ($char as $row) {

            $simpan = $this->db->query("UPDATE tb_barang SET jml_stok = jml_stok + '$row[qty]' WHERE kode_barang = '$row[kode]' AND token = '$row[token]'");
        }

        $this->db->where('no_transaksi', $id);
        $this->db->delete('tb_detail_penjualan');
        $this->db->where('no_transaksi', $id);
        $this->db->delete('tb_penjualan');

        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Data Penjualan Berhasil di Hapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Penjualan');
    }

    public function ubh_status()
    {
        if ($_POST['no_transaksi']) {
            $kd = $_POST['no_transaksi'];
            $total_bayar = 0;
            $token = $this->session->userdata('token');

            $data['data'] = $this->db->query("SELECT p.*, pl.* FROM tb_penjualan p LEFT JOIN tb_pelanggan pl ON p.kode_pelanggan=pl.kode_pel WHERE p.no_transaksi='$kd'")->row_array();
            $penjualan = $this->db->query("SELECT p.*, p.diskon as disc FROM tb_penjualan p WHERE p.no_transaksi='$kd' AND p.token='$token'")->row_array();

            $list_pen = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty, sum(modal) as modal FROM tb_detail_penjualan WHERE no_transaksi='$kd' AND token='$token' GROUP BY harga, kode_barang, varian, ukuran ORDER BY kode_barang")->result_array();
            $modal = 0;
            foreach ($list_pen as $dat) {
                $modal += $dat['modal'];
            }

            $total = $penjualan['total'] - (($penjualan['total'] * $penjualan['diskon']) / 100);
            $data['total_bayar'] = $total;
            $data['uang_muka'] = $penjualan['bayar'];
            $data['modal'] = $modal;
            $data['no_jurnal'] = $this->Akuntansi_model->no_jurnal();
            $data['rekening'] = $this->db->get_where('tb_rekening', ['token' => $token])->result();

            $this->load->view('transaksi/_ubah_status', $data);
        }
    }

    public function retur_jual()
    {
        if ($_POST) {
            $kd = $_POST['no_transaksi'];
            $id = $_POST['id'];
            $token = $this->session->userdata('token');
            $data['data'] = $this->db->query("SELECT p.*, pl.* FROM tb_penjualan p LEFT JOIN tb_pelanggan pl ON p.kode_pelanggan=pl.kode_pel WHERE p.no_transaksi='$kd' AND p.token='$token'")->row_array();
            $data['list_pen'] = $this->db->get_where('tb_detail_penjualan', ['kd_penjualan' => $id, 'token' => $token])->row_array();

            $this->load->view('transaksi/_retur_jual', $data);
        }
    }

    public function dtl_penjualan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Detail Penjualan';
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['penjualan'] = $this->db->query("SELECT p.*, p.diskon as disc FROM tb_penjualan p WHERE p.no_transaksi='$id' AND p.token='$token'")->row_array();

        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 27])->row_array();
        $data['akses1'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
        $data['akses2'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 39])->row_array();
        $data['akses3'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();
        $data['akses4'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();

        if (($akses3['menu_id'] = 40) && ($akses2['menu_id'] = 39) && ($akses2['menu_id'] = 29)) {
            $data['list_pen'] = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$id' AND token='$token' GROUP BY harga, kode_barang, varian, ukuran ORDER BY kode_barang")->result_array();
        } else {
            $data['list_pen'] = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$id' AND token='$token' GROUP BY kode_barang")->result_array();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/dtl_penjualan', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_harian()
    {
        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        if ($this->input->post('petugas') && $this->input->post('tgl_akhir')) {
            $data['data'] = $this->Laporan_model->cariData();
        }
        $this->load->view('transaksi/cetak_harian', $data);
    }

    public function cetak_harian_user()
    {
        $token = $this->session->userdata('token');
        $petugas = $this->session->userdata('username');
        $ke = $this->input->post('tgl_akhir');

        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->db->where('petugas', $petugas);
        $this->db->where('tgl_transaksi', $ke);
        $this->db->where('token', $token);
        $data['penjua'] = $this->db->get('tb_penjualan')->result_array();

        $this->load->view('transaksi/cetak_harian_user', $data);
    }

    public function cetak_bulan()
    {
        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        if ($this->input->post('petugas') && $this->input->post('tgl_akhir') && $this->input->post('tgl_awal')) {
            $data['data'] = $this->Laporan_model->minggu();
        }
        $this->load->view('transaksi/cetak_bulan', $data);
    }

    public function cetak_bulan_user()
    {
        $token = $this->session->userdata('token');
        $petugas = $this->session->userdata('username');
        $ke = $this->input->post('tgl_akhir', true);
        $k = $this->input->post('tgl_awal', true);

        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $data['data'] = $this->db->query("SELECT * FROM tb_penjualan WHERE tb_penjualan.token='$token' AND petugas='$petugas' AND tgl_transaksi BETWEEN '$k' and '$ke' ORDER BY tgl_transaksi DESC")->result_array();
        $this->load->view('transaksi/cetak_bulan_user', $data);
    }

    public function cetak_keuntungan()
    {
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);

        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($_POST['filter'] == 'semua') {
            $data['dataa'] = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($_POST['filter'] == 2) {
            $data['dataa'] = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' AND MONTH(a.timee)='$bulan' AND YEAR(a.timee)='$tahun' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($_POST['filter'] == 3) {
            $data['dataa'] = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' AND YEAR(a.timee)='$tahun' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($_POST['filter'] == 1) {
            $data['dataa'] = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' AND a.tgl_penjualan='$tanggal' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($_POST['filter'] == 4) {
            $data['dataa'] = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.potongan) as tot, a.no_transaksi, b.no_transaksi, b.status FROM tb_detail_penjualan a, tb_penjualan b WHERE a.no_transaksi=b.no_transaksi AND b.status='Lunas' AND a.token='$token' AND a.tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY a.kode_barang, a.modal, a.harga");
        }
        $data['tahun'] = $this->db->query("SELECT tgl_penjualan, token FROM tb_detail_penjualan WHERE token='$token' GROUP BY year(tgl_penjualan)")->result_array();
        $this->load->view('transaksi/cetak_uang', $data);
    }

    public function piutang()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Transaksi Penjualan Piutang';
        $token = $data['user']['token'];
        $petugas = $this->session->userdata('username');

        $data['petugas'] = $this->db->get_where('user', ['token' => $token, 'role_id' => 3])->result_array();
        $data['penjualan'] = $this->db->query("SELECT * FROM tb_penjualan p WHERE p.token='$token' AND p.status='Hutang' ORDER BY timestmp DESC ")->result();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/piutang', $data);
        $this->load->view('templates/footer');
    }
}
