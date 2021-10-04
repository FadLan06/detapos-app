<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profit extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $this->load->model('Akuntansi_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $data['user']['token'];
        $data['judul'] = 'SHARING PROFIT';

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/profit', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_profit()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $data['user']['token'];
        $data['judul'] = 'Sharing Profit';

        $data['data'] = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Beban%' OR a.nama_akun LIKE '%Pendapatan%' OR a.nama_akun LIKE '%Harga Pokok Penjualan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
        $data['dataa'] = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Biaya Iklan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
        $data['dataaa'] = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Pajak%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
        $data['profit'] = $this->db->get_where('tb_jurnal_profit', ['token' => $token]);

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('akuntansi/cetak_profit', $data);
    }

    function viewProfit()
    {
        if ($_POST) {

            $this->load->model('Akuntansi_model');
            $tanggal = $this->input->post('tanggal');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $filter = $this->input->post('filter');
            $token = $this->session->userdata('token');

            $data = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Beban%' OR a.nama_akun LIKE '%Pendapatan%' OR a.nama_akun LIKE '%Harga Pokok Penjualan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
            $dataa = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Biaya Iklan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
            $dataaa = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Pajak%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");
            $profit = $this->db->get_where('tb_jurnal_profit', ['token' => $token]);

            if ($data->row() > null) :
                $no = 1;
                $gro = 1;
                $ts_debet = "0";
                $ts_kredit = "0";
                $ts_iklan = "0";
                $ts_pajak = "0";
                foreach ($data->result_array() as $k) :
                    if ($k['tipe'] == 'K') :
                        $total_kredit = "0";
                        $saldo_kredit = "0";
                        $token = $this->session->userdata('token');
                        if ($filter == 'semua') {
                            $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun as idakun from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$k[nama_akun]'");
                        } elseif ($filter == '1') {
                            $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE t.tgl_jurnal='$tanggal' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");
                        } elseif ($filter == '2') {
                            $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE MONTH(t.tgl_jurnal)='$bulan' AND YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");
                        } elseif ($filter == '3') {
                            $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");
                        }

                        foreach ($neraca->result_array() as $n) :
                            if ($n['tipe'] == 'K') {
                                $kredit = $n['nominal'];
                                $debet = "0";
                            }
                            $total_kredit += $kredit;

                            if ($n['kategori'] == 'HT') {
                                $saldo_kredit = $total_kredit;
                                $posisi = "Kredit";
                            }
                        endforeach;
                        if ($saldo_kredit != '0') :
                            echo '
                                <tr>
                                    <td align="center">' . $no++ . '</td>
                                    <td align="center">' . $k['kode_akun'] . '</td>
                                    <td>' . $k['nama_akun'] . '</td>
                                    <td width="3%" align="center">Rp. </td>
                                    <td align="right">' . number_format($saldo_kredit, 0, ",", ".") . '</td>
                                </tr>
                            ';
                        endif;
                        $ts_kredit = abs($saldo_kredit - $ts_kredit);
                    endif;
                endforeach;
                echo '
                <tr>
                    <td colspan="3" align="Center"><b>Laba Kotor 1</b></td>
                    <td align="center" width="3%">Rp.</td>
                    <td align="right"><b>' . number_format($ts_kredit, 0, ",", ".") . '</b></td>
                </tr>
                ';
                foreach ($dataa->result_array() as $i) :
                    if ($i['tipe'] == 'D') :
                        $total_iklan = "0";
                        $saldo_iklan = "0";
                        $token = $this->session->userdata('token');
                        if ($filter == 'semua') {
                            $iklan = $this->db->query("SELECT *, tb_jurnal.id_akun as idakun from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$i[nama_akun]'");
                        } elseif ($filter == '1') {
                            $iklan = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE t.tgl_jurnal='$tanggal' AND j.token='$token' AND a.kode_akun='$i[kode_akun]'");
                        } elseif ($filter == '2') {
                            $iklan = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE MONTH(t.tgl_jurnal)='$bulan' AND YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$i[kode_akun]'");
                        } elseif ($filter == '3') {
                            $iklan = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$i[kode_akun]'");
                        }

                        foreach ($iklan->result_array() as $ik) :
                            $debetI = $ik['nominal'];
                            $total_iklan += $debetI;
                            $saldo_iklan = $total_iklan;
                        endforeach;

                        echo '
                        <tr>
                            <td align="center">' . $no++ . '</td>
                            <td align="center">' . $i['kode_akun'] . '</td>
                            <td>' . $i['nama_akun'] . '</td>
                            <td width="3%" align="center">Rp. </td>
                            <td align="right">' . number_format($saldo_iklan, 0, ",", ".") . '</td>
                        </tr>
                        ';
                        $ts_iklan = abs($saldo_iklan - $ts_iklan);
                    endif;
                endforeach;

                $ts_lb2 = $ts_kredit - $ts_iklan;
                echo '
                <tr>
                    <td colspan="3" align="Center"><b>Laba Kotor 2</b></td>
                    <td align="center" width="3%">Rp.</td>
                    <td align="right"><b>' . number_format($ts_lb2) . '</b></td>
                </tr>
                ';

                $gross = $this->db->get_where('tb_jurnal_profit', ['token' => $token, 'status' => '1'])->row();
                $sen = $gross->persentase;
                $profit1 = $ts_lb2 * ($sen / 100);
                $ts_lb3 = $ts_lb2 - $profit1;
                echo '
                <tr>
                    <td colspan="2" align="center"><b>Sharing Profit ' . $gro++ . '</b></td>
                    <td>' . $gross->keterangan . ' (' . $gross->persentase . '%)</td>
                    <td width="3%" align="center">Rp. </td>
                    <td align="right">' . number_format($profit1) . '</td>
                </tr>
                ';

                echo '
                <tr>
                    <td colspan="3" align="Center"><b>Laba Kotor 3</b></td>
                    <td align="center" width="3%">Rp.</td>
                    <td align="right"><b>' . number_format($ts_lb3) . '</b></td>
                </tr>
                ';
                foreach ($data->result_array() as $d) :
                    if ($d['tipe'] == 'D') :
                        $total_debet = "0";
                        $saldo_debet = "0";

                        $token = $this->session->userdata('token');
                        if ($filter == 'semua') {
                            $neraca1 = $this->db->query("SELECT *, tb_jurnal.id_akun as idakun from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
                        } elseif ($filter == '1') {
                            $neraca1 = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE t.tgl_jurnal='$tanggal' AND j.token='$token' AND a.kode_akun='$d[kode_akun]'");
                        } elseif ($filter == '2') {
                            $neraca1 = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE MONTH(t.tgl_jurnal)='$bulan' AND YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$d[kode_akun]'");
                        } elseif ($filter == '3') {
                            $neraca1 = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$d[kode_akun]'");
                        }

                        foreach ($neraca1->result_array() as $nn) :

                            if ($nn['tipe'] == 'D') {
                                $debet = $nn['nominal'];
                                $kredit = "0";
                            }
                            $total_debet += $debet;

                            if ($nn['kategori'] == 'HL') {
                                $saldo_debet = $total_debet;
                                $posisi = "Debet";
                            }

                        endforeach;

                        if ($saldo_debet != '0') :
                            echo '
                                <tr>
                                    <td align="center">' . $no++ . '</td>
                                    <td align="center">' . $d['kode_akun'] . '</td>
                                    <td>' . $d['nama_akun'] . '</td>
                                    <td width="3%" align="center">Rp. </td>
                                    <td align="right">' . number_format($saldo_debet, 0, ",", ".") . '</td>
                                </tr>
                            ';
                        endif;
                        $ts_debet += $saldo_debet;
                    endif;
                endforeach;

                if ($ts_debet != '0') :
                    echo '
                    <tr>
                        <td colspan="3" align="Center"><b>Beban Operasional </b></td>
                        <td align="center" width="3%">Rp.</td>
                        <td align="right"><b>' . number_format($ts_debet, 0, ",", ".") . '</b></td>
                    </tr>';
                endif;

                $ts_lsp = $ts_lb3 - $ts_debet;
                echo '
                <tr>
                    <td colspan="3" align="Center"><b>Laba Sebelum Pajak</b></td>
                    <td align="center" width="3%">Rp.</td>
                    <td align="right"><b>' . number_format($ts_lsp, 0, ",", ".") . '</b></td>
                </tr>';
                foreach ($dataaa->result_array() as $p) :
                    if ($p['tipe'] == 'D') :
                        $total_pajak = "0";
                        $saldo_pajak = "0";
                        $token = $this->session->userdata('token');
                        if ($filter == 'semua') {
                            $pajak = $this->db->query("SELECT *, tb_jurnal.id_akun as idakun from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$p[nama_akun]'");
                        } elseif ($filter == '1') {
                            $pajak = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE t.tgl_jurnal='$tanggal' AND j.token='$token' AND a.kode_akun='$p[kode_akun]'");
                        } elseif ($filter == '2') {
                            $pajak = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE MONTH(t.tgl_jurnal)='$bulan' AND YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$p[kode_akun]'");
                        } elseif ($filter == '3') {
                            $pajak = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$p[kode_akun]'");
                        }

                        foreach ($pajak->result_array() as $ik) :
                            $debetI = $ik['nominal'];
                            $total_pajak += $debetI;
                            $saldo_pajak = $total_pajak;

                        endforeach;
                        echo '
                        <tr>
                            <td colspan="3" align="Center"><b>Pajak</b></td>
                            <td align="center" width="3%">Rp.</td>
                            <td align="right"><b>' . number_format($saldo_pajak) . '</b></td>
                        </tr>';
                        $ts_pajak = abs($saldo_pajak - $ts_pajak);
                    endif;
                endforeach;

                $bersih = $ts_lsp - $ts_pajak;
                echo '<tr>
                    <td colspan="3" align="Center">';
                if ($ts_kredit > $ts_debet) :
                    echo '<b class="text-success">Laba Bersih</b>';
                elseif ($ts_kredit < $ts_debet) :
                    echo '<b class="text-danger">Rugi</b>';
                else :
                    echo '<b>BALANCE</b>';
                endif;
                echo '</td>
                    <td align="center" width="3%">Rp.</td>
                    <td align="right"><b>' . number_format($bersih, 0, ",", ".") . '</b></td>
                </tr>
                ';

                echo '
                <tr>
                    <td colspan="5" align="center" height="30px"> </td>
                </tr>
                ';

                foreach ($profit->result() as $pro) {
                    if ($pro->status != '1') {
                        $jum = $bersih * $pro->persentase / 100;
                        echo '
                        <tr>
                            <td colspan="2" align="center"><b>Sharing Profit ' . $gro++ . '</b></td>
                            <td>' . $pro->keterangan . ' (' . $pro->persentase . '%)</td>
                            <td width="3%" align="center">Rp. </td>
                            <td align="right">' . number_format($jum) . '</td>
                        </tr>
                        ';
                    }
                }
            else :
                echo '<tr>
                        <td colspan="5">
                            <i>
                                <center>
                                    -----------
                                    Tidak Ada Data Laba Rugi
                                    -----------
                                </center>
                            </i>
                        </td>
                    </tr>';
            endif;
        }
    }

    function viewFilter()
    {
        if ($_POST) {
            echo '<form action="' . base_url('Profit/Cetak_Profit') . '" method="post" target="_blank">
            <input type="hidden" name="filter" id="filter" class="form-control" value="' . $_POST['filter'] . '">
            <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="' . $_POST['tanggal'] . '">
            <input type="hidden" name="bulan" id="bulan" class="form-control" value="' . $_POST['bulan'] . '">
            <input type="hidden" name="tahun" id="tahun" class="form-control" value="' . $_POST['tahun'] . '">
            <a href="' . site_url('Profit') . '" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
            <button class="btn btn-primary btn-sm" type="submit" onclick="return valid();"><i class="fas fa-print"></i> Cetak</button>
        </form>';
        }
    }

    public function tambah()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $data['user']['token'];
        $data['judul'] = 'TAMBAH SHARING PROFIT';

        $data['profit'] = $this->db->get_where('tb_jurnal_profit', ['token' => $token]);

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/profit_tambah', $data);
        $this->load->view('templates/footer');
    }

    function aksi()
    {
        if (isset($_POST['tmbh'])) {
            $status = htmlspecialchars($this->input->post('status'));
            $aksi = $this->db->get_where('tb_jurnal_profit', ['status' => '1', 'token' => $this->session->userdata('token')])->row_array();
            if ($aksi['status'] == $status) {
                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Proses gagal!, Tidak boleh status UTAMA lebih dari 1.'); </script>";
                }
            } else {
                $data = [
                    'keterangan' => htmlspecialchars($this->input->post('keterangan')),
                    'persentase' => htmlspecialchars($this->input->post('persentase')),
                    'status' => htmlspecialchars($this->input->post('status')),
                    'token' => htmlspecialchars($this->session->userdata('token'))
                ];

                $this->db->insert('tb_jurnal_profit', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Berhasil di Tambahkan!'); </script>";
                }
            }
            echo "<script>window.location='" . site_url('Profit/Tambah') . "';</script>";
        } elseif (isset($_POST['ubah'])) {
            $data = [
                'keterangan' => htmlspecialchars($this->input->post('keterangan')),
                'persentase' => htmlspecialchars($this->input->post('persentase')),
                'status' => htmlspecialchars($this->input->post('status'))
            ];

            $this->db->where('id_jurnal_profit', $this->input->post('id_jurnal_profit'));
            $this->db->update('tb_jurnal_profit', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Profit/Tambah') . "';</script>";
        }
    }

    function hapus($id)
    {
        $this->db->where('id_jurnal_profit', $id);
        $this->db->delete('tb_jurnal_profit');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Profit/Tambah') . "';</script>";
    }
}
