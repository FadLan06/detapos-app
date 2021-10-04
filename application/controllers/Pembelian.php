<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Supplier_model');
        $this->load->model('Laporan_model');
        $this->load->model('Akuntansi_model');

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Transaksi Pembelian';
        $token = $this->session->userdata('token');
        $petugas = $this->session->userdata('username');

        $data['petugas'] = $this->db->get_where('user', ['token' => $token, 'role_id' => 3])->result_array();
        $data['pembelian'] = $this->db->query("SELECT * FROM tb_pembelian p WHERE p.token='$token' ORDER BY p.timestmp DESC ")->result();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('pembelian/index', $data);
        $this->load->view('templates/footer');
    }

    public function transaksi()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Tambah Data Transaksi Pembelian';
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['no_faktur'] = $this->Supplier_model->no_faktur();
        $data['no_jurnal'] = $this->Akuntansi_model->no_jurnal();

        $akses4 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();

        if (isset($akses4['menu_id'])) {
            $this->load->view('templates/header', $data);
            $this->load->view('pembelian/tambah_butik', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('pembelian/tambah', $data);
            $this->load->view('templates/footer');
        }
    }

    public function invoice($id, $kd)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['nm_toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $data['pembelian'] = $this->db->query("SELECT *, sum(harga_beli*jumlah) as sub_total, sum(jumlah) as kty FROM tb_detail_pembelian WHERE no_faktur='$kd' AND token='$token' GROUP BY kode_barang")->result_array();
        $data['tra'] = $this->db->query("SELECT * FROM tb_pembelian p WHERE p.no_faktur='$id' AND p.token='$token'")->row_array();

        $this->load->view('pembelian/invoice', $data);
    }

    function auto_sup()
    {
        if (isset($_GET['term'])) {
            $result = $this->Supplier_model->getAutoSup($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'  => $row->kode_sup . ' / ' . $row->nama_toko,
                        'value'  => $row->kode_sup,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    function auto_barang()
    {
        if (isset($_GET['term'])) {
            $result = $this->Supplier_model->getAutoBrng($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'  => $row->kode_barang . ' / ' . $row->nama_barang,
                        'value'  => $row->kode_barang,
                        'nm_brng'   => $row->nama_barang,
                        'hrga_pk'   => $row->harga_beli,
                        'satuan'   => $row->satuan,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    function auto_barang_butik()
    {
        if (isset($_GET['term'])) {
            $result = $this->Supplier_model->getAutoBrng($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'  => $row->kode_barang . ' / ' . $row->nama_barang,
                        'value'  => $row->kode_barang,
                        'nm_brng'   => $row->nama_barang,
                        'hrga_pk'   => $row->harga_beli,
                        'satuan'   => $row->satuan,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    function data_barang_butik()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $this->session->userdata('token');
        $data = $this->db->query("SELECT *, sum(harga_beli * jumlah - potongan) as sub_total, sum(jumlah) as kty, count(id_pembelian) as beli FROM tb_detail_pembelian_tmp WHERE token='$token' GROUP BY kode_barang ORDER BY kode_barang")->result();;
        echo json_encode($data);
    }

    function data_barang()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $this->session->userdata('token');
        $data = $this->db->query("SELECT *, sum(harga_beli * jumlah - potongan) as sub_total, sum(jumlah) as kty, count(id_pembelian) as beli FROM tb_detail_pembelian_tmp WHERE token='$token' GROUP BY kode_barang ORDER BY kode_barang")->result();;
        echo json_encode($data);
    }

    function simpan_barang()
    {
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);

        $kd_brng = htmlspecialchars($this->input->post('kd_brng'));
        $nm_brng = htmlspecialchars($this->input->post('nm_brng'));
        $hrga_pk = htmlspecialchars($this->input->post('hrga_pk'));
        $satuan = htmlspecialchars($this->input->post('satuan'));
        $petugas = htmlspecialchars($this->session->userdata('username'));
        $jumlah = htmlspecialchars($this->input->post('jumlah'));
        $potongan = htmlspecialchars($this->input->post('potongan'));
        $timee = date('Y-m-d H:i:s');
        $token = htmlspecialchars($this->session->userdata('token'));

        // $data = $this->Supplier_model->simpan_barang($kd_brng, $nm_brng, $hrga_jl, $hrga_pk, $petugas, $jumlah, $potongan, $timee, $token);
        $data = [
            'kode_barang' => $kd_brng,
            'nama_barang' => $nm_brng,
            'harga_beli' => $hrga_pk,
            'satuan' => $satuan,
            'jumlah' => $jumlah,
            'potongan' => $potongan,
            'petugas' => $petugas,
            'timee' => $timee,
            'token' => $token,
        ];
        $dt = $this->db->insert('tb_detail_pembelian_tmp', $data);
        echo json_encode($dt);
    }

    function hapus()
    {
        $this->Supplier_model->hapus($_POST["id"]);
    }

    public function smpn_pem()
    {
        if (isset($_POST['cetak'])) {
            $dt = $this->db->query("SELECT * FROM tb_detail_pembelian_tmp WHERE token='" . $this->session->userdata('token') . "'");
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);
            if ($dt->num_rows() > 0) {

                $no_faktur = $this->input->post('no_faktur');
                $total_bl = $this->input->post('total_bl');
                $kd_sup = $this->input->post('kd_sup');
                $tgl = date('Y-m-d');
                $petugas = $this->session->userdata('username');
                $diskon = $this->input->post('diskon');

                $data = [
                    'no_faktur' => $no_faktur,
                    'kd_supplier' => $kd_sup,
                    'tgl_transaksi' => $tgl,
                    'petugas' => $petugas,
                    'timestmp' => date('Y-m-d H:i:s'),
                    'total' => $total_bl,
                    'diskon' => $diskon,
                    'token' => $this->session->userdata('token')
                ];
                $this->db->insert('tb_pembelian', $data);
                $id_pembelian = $this->db->insert_id();

                foreach ($dt->result_array() as $dtt) {
                    $char[] = $dtt;
                }

                foreach ($char as $row) {
                    $dataa = [
                        'no_faktur' => $id_pembelian,
                        'kode_barang' => $row['kode_barang'],
                        'harga_beli' => $row['harga_beli'],
                        'jumlah' => $row['jumlah'],
                        'harga_jual' => $row['harga_jual'],
                        'petugas' => $row['petugas'],
                        'timee' => $row['timee'],
                        'token' => $row['token']

                    ];

                    $this->db->insert('tb_detail_pembelian', $dataa);
                }

                redirect('Pembelian/Invoice/' . $no_faktur . '/' . $id_pembelian);
            }
        } else if (isset($_POST['simpan'])) {
            $dt = $this->db->query("SELECT * FROM tb_detail_pembelian_tmp WHERE token='" . $this->session->userdata('token') . "'");
            $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
            date_default_timezone_set($zona['zona']);
            if ($dt->num_rows() > 0) {

                $no_faktur = $this->input->post('no_faktur');
                $total_bl = $this->input->post('total_bl');
                $kd_sup = $this->input->post('kd_sup');
                $tgl = date('Y-m-d');
                $petugas = $this->session->userdata('username');
                $diskon = $this->input->post('diskon');
                $metodePem = $this->input->post('metodePem');

                $data = [
                    'no_faktur' => $no_faktur,
                    'kd_supplier' => $kd_sup,
                    'tgl_transaksi' => $tgl,
                    'petugas' => $petugas,
                    'timestmp' => date('Y-m-d H:i:s'),
                    'total' => $total_bl,
                    'diskon' => $diskon,
                    'token' => $this->session->userdata('token')
                ];
                $this->db->insert('tb_pembelian', $data);
                $id_pembelian = $this->db->insert_id();

                foreach ($dt->result_array() as $dtt) {
                    $char[] = $dtt;
                }

                foreach ($char as $row) {
                    $dataa = [
                        'no_faktur' => $id_pembelian,
                        'kode_barang' => $row['kode_barang'],
                        'nama_barang' => $row['nama_barang'],
                        'harga_beli' => $row['harga_beli'],
                        'satuan' => $row['satuan'],
                        'jumlah' => $row['jumlah'],
                        'potongan' => $row['potongan'],
                        'petugas' => $row['petugas'],
                        'timee' => $row['timee'],
                        'token' => $row['token']

                    ];

                    $this->db->insert('tb_detail_pembelian', $dataa);

                    $this->db->where('kode_barang', $row['kode_barang']);
                    $this->db->where('petugas', $row['petugas']);
                    $this->db->where('token', $row['token']);
                    $this->db->delete('tb_detail_pembelian_tmp');
                }

                $user = $this->db->get_where('user', ['token' => $this->session->userdata('token')])->row_array();
                if ($user['coupon'] == 'new') {
                    $datta = [
                        'no_jurnal' => $this->input->post('no_jurnal'),
                        'tgl_jurnal' => date('Y-m-d'),
                        'keterangan' => 'Pembelian Produk dengan Nomor Invoice ' . $no_faktur,
                        'token' => $this->session->userdata('token'),
                        'invoice' => $no_faktur
                    ];

                    $this->db->insert('tb_jurnal_tmp', $datta);

                    $tok = $this->session->userdata('token');
                    $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (111,112,411,511) ORDER BY kategori='HL' DESC")->result_array();


                    foreach ($ak as $ro) {
                        if ($ro['kode_akun'] == '112') {
                            // $ka = 'K';
                            $dt1 = [
                                'no_jurnal' => $this->input->post('no_jurnal'),
                                'id_akun' => $ro['id_akun'],
                                'nominal' => $total_bl,
                                'tipe' => 'D',
                                'token' => $this->session->userdata('token'),
                                'invoice' => $no_faktur
                            ];

                            $this->db->insert('tb_jurnal', $dt1);
                        } else if ($ro['kode_akun'] == '111') {
                            // $ka = 'K';
                            $dt1 = [
                                'no_jurnal' => $this->input->post('no_jurnal'),
                                'id_akun' => $ro['id_akun'],
                                'nominal' => $total_bl,
                                'tipe' => 'K',
                                'token' => $this->session->userdata('token'),
                                'invoice' => $no_faktur
                            ];

                            $this->db->insert('tb_jurnal', $dt1);
                        }
                    }
                }

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Pembelian Berhasil di Tambahkan!'); </script>";
                }
                echo "<script>window.location='" . site_url('Pembelian') . "';</script>";
            }
        }
    }

    public function hapuss($id, $kd)
    {
        $token = $this->session->userdata('token');
        $this->db->select('*');
        $this->db->join('tb_barang', 'tb_barang.kode_barang=tb_detail_pembelian.kode_barang');
        $this->db->where('no_faktur', $kd);
        $this->db->where('tb_detail_pembelian.token', $token);
        $daa = $this->db->get('tb_detail_pembelian');

        foreach ($daa->result_array() as $dtt) {
            $char[] = $dtt;
        }

        foreach ($char as $row) {

            $simpan = $this->db->query("UPDATE tb_barang SET jml_stok = jml_stok - '$row[jumlah]' WHERE kode_barang = '$row[kode_barang]' AND token = '$row[token]'");
        }

        $this->db->where('no_faktur', $kd);
        $this->db->where('token', $token);
        $this->db->delete('tb_detail_pembelian');

        $this->db->where('no_faktur', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_pembelian');

        $this->db->where('invoice', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_jurnal');

        $this->db->where('invoice', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_jurnal_tmp');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Pembelian Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Pembelian') . "';</script>";
    }

    public function detail($id, $kd)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Detail Pembelian';
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['pembelian'] = $this->db->query("SELECT *, sum(harga_beli*jumlah-potongan) as sub_total, sum(jumlah) as kty FROM tb_detail_pembelian WHERE no_faktur='$kd' AND token='$token' GROUP BY kode_barang")->result_array();
        $data['tra'] = $this->db->query("SELECT * FROM tb_pembelian p WHERE p.no_faktur='$id' AND p.token='$token'")->row_array();

        $akses4 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();

        if (isset($akses4['menu_id'])) {
            $this->load->view('templates/header', $data);
            $this->load->view('pembelian/detail_butik', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('pembelian/detail', $data);
            $this->load->view('templates/footer');
        }
    }

    public function cetak()
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
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' ORDER BY p.timestmp DESC");
        } elseif ($_POST['filter'] == 2) {
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND MONTH(p.timestmp)='$bulan' AND YEAR(p.timestmp)='$tahun'  ORDER BY p.timestmp DESC");
        } elseif ($_POST['filter'] == 3) {
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND YEAR(p.timestmp)='$tahun' ORDER BY p.timestmp DESC");
        } elseif ($_POST['filter'] == 1) {
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND p.tgl_transaksi='$tanggal' ORDER BY p.timestmp DESC");
        } elseif ($_POST['filter'] == 4) {
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND p.tgl_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.timestmp DESC");
        }
        $data['tahun'] = $this->db->query("SELECT timee, token FROM tb_detail_pembelian WHERE token='$token' GROUP BY year(timee)")->result_array();

        $this->load->view('pembelian/cetak', $data);
    }

    public function export()
    {
        $data['judul'] = 'Export Data Pembelian Barang';

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
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' ORDER BY p.timestmp DESC");
        } elseif ($_POST['filter'] == 2) {
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND MONTH(p.timestmp)='$bulan' AND YEAR(p.timestmp)='$tahun'  ORDER BY p.timestmp DESC");
        } elseif ($_POST['filter'] == 3) {
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND YEAR(p.timestmp)='$tahun' ORDER BY p.timestmp DESC");
        } elseif ($_POST['filter'] == 1) {
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND p.tgl_transaksi='$tanggal' ORDER BY p.timestmp DESC");
        } elseif ($_POST['filter'] == 4) {
            $data['pembelian'] = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND p.tgl_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.timestmp DESC");
        }
        $data['tahun'] = $this->db->query("SELECT timee, token FROM tb_detail_pembelian WHERE token='$token' GROUP BY year(timee)")->result_array();

        $this->load->view('pembelian/export', $data);
    }

    public function retur_barang()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $no_faktur = $_POST['no_faktur'];
            $token = $this->session->userdata('token');
            $data['data'] = $this->db->get_where('tb_pembelian', ['token' => $token, 'id_pembelian' => $no_faktur])->row_array();
            $data['pem'] = $this->db->get_where('tb_detail_pembelian', ['token' => $token, 'no_faktur' => $no_faktur, 'kd_pembelian' => $id])->row_array();

            $this->load->view('pembelian/_retur', $data);
        }
    }

    function aksi_retur()
    {
        if (isset($_POST['smpn_beli'])) {
            $token = $this->session->userdata('token');
            $kode_barang = htmlspecialchars($this->input->post('kode_barang'));
            $kode_supplier = htmlspecialchars($this->input->post('kode_supplier'));
            $jumlah_barang = htmlspecialchars($this->input->post('jumlah_barang'));
            $alasan = htmlspecialchars($this->input->post('alasan'));
            $id_pembelian = htmlspecialchars($this->input->post('id_pembelian'));
            $no_faktur = htmlspecialchars($this->input->post('no_faktur'));

            $barang = $this->db->get_where('tb_barang', ['kode_barang' => $kode_barang, 'token' => $token])->row_array();
            $dt_pen = $this->db->query("SELECT *, sum(harga_beli*jumlah-potongan) as sub_total FROM tb_detail_pembelian WHERE kode_barang='$kode_barang' AND no_faktur='$id_pembelian' AND token='$token'")->row_array();

            $stok_br = $barang['jml_stok'] - $jumlah_barang;
            $stok_bl = $dt_pen['jumlah'] - $jumlah_barang;

            $data = [
                'kode_barang' => $kode_barang,
                'kode_supplier' => $kode_supplier,
                'jumlah_barang' => $jumlah_barang,
                'alasan' => $alasan,
                'tgl_pem' => date('y-m-d'),
                'token' => $token
            ];

            $this->db->insert('tb_retur_pembelian', $data);

            if ($jumlah_barang <= $dt_pen['jumlah']) {

                $this->db->set('jml_stok', $stok_br);
                $this->db->where('kode_barang', $kode_barang);
                $this->db->where('token', $token);
                $this->db->update('tb_barang');

                $this->db->set('jumlah', $stok_bl);
                $this->db->where('kode_barang', $kode_barang);
                $this->db->where('no_faktur', $id_pembelian);
                $this->db->where('token', $token);
                $this->db->update('tb_detail_pembelian');
            }

            $pen = $this->db->query("SELECT *, sum(jumlah) as kty FROM tb_detail_pembelian WHERE no_faktur='$id_pembelian' AND kode_barang='$kode_barang' AND token='$token' GROUP BY kode_barang")->row_array();

            $nt = $pen['no_faktur'];
            $kd = $pen['kode_barang'];
            $tk = $pen['token'];

            if ($pen['kty'] < 1) {
                $this->db->query("DELETE FROM tb_detail_pembelian WHERE kode_barang ='$kd' AND no_faktur='$nt' AND token='$tk'");
            }

            $ntr = $this->db->query("SELECT * FROM tb_detail_pembelian WHERE no_faktur='$id_pembelian' AND token='$token'");

            if ($ntr->num_rows() <= 1) {
                $this->db->query("DELETE FROM tb_pembelian WHERE id_pembelian = '$id_pembelian' AND token='$token'");
                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Pembelian Berhasil di Retur1!'); </script>";
                }
                echo "<script>window.location='" . site_url('Pembelian') . "';</script>";
            }

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Pembelian Berhasil di Retur!'); </script>";
            }
            echo "<script>window.location='" . site_url('Pembelian/Detail/') . $no_faktur . "/" . $id_pembelian . "';</script>";
        }
    }
}
