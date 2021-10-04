<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laba_rugi extends CI_Controller
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
        $data['judul'] = 'LABA RUGI';

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/laba_rugi', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_laba()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $data['user']['token'];
        $data['judul'] = 'LABA RUGI';

        $data['data'] = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Beban%' OR a.nama_akun LIKE '%Pendapatan%' OR a.nama_akun LIKE '%Harga Pokok Penjualan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('akuntansi/cetak_laba', $data);
    }

    function viewLaba()
    {
        if ($_POST) {

            $this->load->model('Akuntansi_model');
            $tanggal = $this->input->post('tanggal');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $filter = $this->input->post('filter');
            $token = $this->session->userdata('token');

            $data = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE (a.nama_akun LIKE '%Beban%' OR a.nama_akun LIKE '%Pendapatan%' OR a.nama_akun LIKE '%Harga Pokok Penjualan%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC");

            if ($data->row() > null) :
                $no = 1;
                $ts_debet = "0";
                $ts_kredit = "0";
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
                        echo '
                        <tr>
                            <td align="center">' . $no++ . '</td>
                            <td align="center">' . $k['kode_akun'] . '</td>
                            <td>' . $k['nama_akun'] . '</td>
                            <td width="3%" align="center">Rp. </td>
                            <td align="right">' . number_format($saldo_kredit, 0, ",", ".") . '</td>
                        </tr>
                        ';
                        $ts_kredit = abs($saldo_kredit - $ts_kredit);
                    endif;
                endforeach;
                echo '
                <tr>
                    <td colspan="3" align="Center"><b>Laba Kotor </b></td>
                    <td align="center" width="3%">Rp.</td>
                    <td align="right"><b>' . number_format($ts_kredit, 0, ",", ".") . '</b></td>
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
                        echo '
                        <tr>
                            <td align="center">' . $no++ . '</td>
                            <td align="center">' . $d['kode_akun'] . '</td>
                            <td>' . $d['nama_akun'] . '</td>
                            <td width="3%" align="center">Rp. </td>
                            <td align="right">' . number_format($saldo_debet, 0, ",", ".") . '</td>
                        </tr>
                        ';
                        $ts_debet += $saldo_debet;
                    endif;
                    $bersih = $ts_kredit - $ts_debet;
                endforeach;
                echo '
                <tr>
                    <td colspan="3" align="Center"><b>Beban Operasional </b></td>
                    <td align="center" width="3%">Rp.</td>
                    <td align="right"><b>' . number_format($ts_debet, 0, ",", ".") . '</b></td>
                </tr>
                <tr>
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
            echo '<form action="' . base_url('Laba_rugi/Cetak_Laba') . '" method="post" target="_blank">
            <input type="hidden" name="filter" id="filter" class="form-control" value="' . $_POST['filter'] . '">
            <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="' . $_POST['tanggal'] . '">
            <input type="hidden" name="bulan" id="bulan" class="form-control" value="' . $_POST['bulan'] . '">
            <input type="hidden" name="tahun" id="tahun" class="form-control" value="' . $_POST['tahun'] . '">
            <a href="' . site_url('Laba_rugi') . '" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
            <button class="btn btn-danger btn-sm" type="submit" onclick="return valid();"><i class="fas fa-print"></i> Cetak</button>
        </form>';
        }
    }
}
