<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Neraca_saldo extends CI_Controller
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
        $data['judul'] = 'NERACA SALDO';

        $token = $this->session->userdata('token');
        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        if ($this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['data'] = $this->Akuntansi_model->cariNeraca();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/neraca_saldo', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_neraca()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'NERACA SALDO';

        $token = $this->session->userdata('token');

        if ($_POST['filter'] == 'semua') {
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
        } elseif ($_POST['filter'] == '1') {
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$_POST[tanggal]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
        } elseif ($_POST['filter'] == '2') {
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
        } elseif ($_POST['filter'] == '3') {
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
        }

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('akuntansi/cetak_neraca', $data);
    }

    function cari()
    {
        if (isset($_POST)) {
            $filter = $this->input->post('filter');
            $tanggal = $this->input->post('tanggal');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $token = $this->session->userdata('token');

            if ($filter == 'semua') {
                $data = $this->db->query("SELECT tb_akun.kode_akun, tb_akun.nama_akun, tb_jurnal.id_akun from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
                $no = 1;
                $ts_debet = "0";
                $ts_kredit = "0";
                foreach ($data->result_array() as $d) {
                    $total_debet = "0";
                    $total_kredit = "0";
                    $saldo_debet = "0";
                    $saldo_kredit = "0";
                    $neraca = $this->db->query("SELECT tb_jurnal.nominal, tb_jurnal.tipe, tb_akun.kategori  from tb_jurnal LEFT JOIN tb_akun ON tb_jurnal.id_akun=tb_akun.id_akun where tb_jurnal.token='$token' and tb_jurnal.id_akun='$d[id_akun]' ");

                    foreach ($neraca->result() as $n) {
                        if ($n->tipe == 'D') {
                            $debet = $n->nominal;
                            $kredit = "0";
                        } elseif ($n->tipe == 'K') {
                            $kredit = $n->nominal;
                            $debet = "0";
                        }
                        $total_debet += $debet;
                        $total_kredit += $kredit;

                        if ($n->kategori == 'HL') {
                            $saldo_debet = $total_debet - $total_kredit;
                            $posisi = "Debet";
                        } elseif ($n->kategori == 'HT') {
                            $saldo_kredit = $total_kredit - $total_debet;
                            $posisi = "Kredit";
                        }
                    }

                    $ts_kredit += $saldo_kredit;
                    $ts_debet += $saldo_debet;

                    echo '
                        <tr align="center">
                            <td>' . $no++ . '</td>
                            <td>' . $d['kode_akun'] . '</td>
                            <td align="left">' . $d['nama_akun'] . '</td>
                            <td align="right">Rp. ' . number_format($saldo_debet, 0, ",", ".") . '</td>
                            <td align="right">Rp. ' . number_format($saldo_kredit, 0, ",", ".") . '</td>
                        </tr>
                    ';
                }
                echo '
                    <tr>
                        <td colspan="3" align="center" style="border-top: 2px solid #008FD4"><b>Total</b></td>
                        <td align="center" style="border-top: 2px solid #008FD4">Rp.' . number_format($ts_debet, 0, ",", ".") . '</td>
                        <td align="center" style="border-top: 2px solid #008FD4">Rp.' . number_format($ts_kredit, 0, ",", ".") . '</td>
                    </tr>
                ';
            } elseif ($filter == '1') {
                $data = $this->db->query("SELECT tb_akun.kode_akun, tb_akun.nama_akun, tb_jurnal.id_akun from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$tanggal' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
                if ($data->row() > null) {
                    $no = 1;
                    $ts_debet = "0";
                    $ts_kredit = "0";
                    foreach ($data->result_array() as $d) {
                        $total_debet = "0";
                        $total_kredit = "0";
                        $saldo_debet = "0";
                        $saldo_kredit = "0";

                        $neraca = $this->db->query("SELECT tb_jurnal.nominal, tb_jurnal.tipe, tb_akun.kategori  from tb_jurnal LEFT JOIN tb_akun ON tb_jurnal.id_akun=tb_akun.id_akun LEFT JOIN tb_jurnal_tmp ON tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal where tb_jurnal_tmp.tgl_jurnal='$tanggal' AND tb_jurnal.token='$token' and tb_jurnal.id_akun='$d[id_akun]' ");

                        foreach ($neraca->result() as $n) {
                            if ($n->tipe == 'D') {
                                $debet = $n->nominal;
                                $kredit = "0";
                            } elseif ($n->tipe == 'K') {
                                $kredit = $n->nominal;
                                $debet = "0";
                            }
                            $total_debet += $debet;
                            $total_kredit += $kredit;

                            if ($n->kategori == 'HL') {
                                $saldo_debet = $total_debet - $total_kredit;
                                $posisi = "Debet";
                            } elseif ($n->kategori == 'HT') {
                                $saldo_kredit = $total_kredit - $total_debet;
                                $posisi = "Kredit";
                            }
                        }

                        $ts_kredit += $saldo_kredit;
                        $ts_debet += $saldo_debet;

                        echo '
                            <tr align="center">
                                <td>' . $no++ . '</td>
                                <td>' . $d['kode_akun'] . '</td>
                                <td align="left">' . $d['nama_akun'] . '</td>
                                <td align="right">Rp. ' . number_format($saldo_debet, 0, ",", ".") . '</td>
                                <td align="right">Rp. ' . number_format($saldo_kredit, 0, ",", ".") . '</td>
                            </tr>
                        ';
                    }
                    echo '
                        <tr>
                            <td colspan="3" align="center" style="border-top: 2px solid #008FD4"><b>Total</b></td>
                            <td align="center" style="border-top: 2px solid #008FD4">Rp.' . number_format($ts_debet, 0, ",", ".") . '</td>
                            <td align="center" style="border-top: 2px solid #008FD4">Rp.' . number_format($ts_kredit, 0, ",", ".") . '</td>
                        </tr>
                    ';
                } else {
                    echo '
                    <tr>
                        <td colspan="5" align="center"><i>----------- Tidak Ada Data -----------</i></td>
                    </tr>
                ';
                }
            } elseif ($filter == '2') {
                $data = $this->db->query("SELECT tb_akun.kode_akun, tb_akun.nama_akun, tb_jurnal.id_akun from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$bulan' AND year(tb_jurnal_tmp.tgl_jurnal)='$tahun' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
                if ($data->row() > null) {
                    $no = 1;
                    $ts_debet = "0";
                    $ts_kredit = "0";
                    foreach ($data->result_array() as $d) {
                        $total_debet = "0";
                        $total_kredit = "0";
                        $saldo_debet = "0";
                        $saldo_kredit = "0";
                        $neraca = $this->db->query("SELECT tb_jurnal.nominal, tb_jurnal.tipe, tb_akun.kategori from tb_jurnal LEFT JOIN tb_akun ON tb_jurnal.id_akun=tb_akun.id_akun LEFT JOIN tb_jurnal_tmp ON tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal where month(tb_jurnal_tmp.tgl_jurnal)='$bulan' AND year(tb_jurnal_tmp.tgl_jurnal)='$tahun' AND tb_jurnal.token='$token' and tb_jurnal.id_akun='$d[id_akun]' ");

                        foreach ($neraca->result() as $n) {
                            if ($n->tipe == 'D') {
                                $debet = $n->nominal;
                                $kredit = "0";
                            } elseif ($n->tipe == 'K') {
                                $kredit = $n->nominal;
                                $debet = "0";
                            }
                            $total_debet += $debet;
                            $total_kredit += $kredit;

                            if ($n->kategori == 'HL') {
                                $saldo_debet = $total_debet - $total_kredit;
                                $posisi = "Debet";
                            } elseif ($n->kategori == 'HT') {
                                $saldo_kredit = $total_kredit - $total_debet;
                                $posisi = "Kredit";
                            }
                        }

                        $ts_kredit += $saldo_kredit;
                        $ts_debet += $saldo_debet;

                        echo '
                            <tr align="center">
                                <td>' . $no++ . '</td>
                                <td>' . $d['kode_akun'] . '</td>
                                <td align="left">' . $d['nama_akun'] . '</td>
                                <td align="right">Rp. ' . number_format($saldo_debet, 0, ",", ".") . '</td>
                                <td align="right">Rp. ' . number_format($saldo_kredit, 0, ",", ".") . '</td>
                            </tr>
                        ';
                    }
                    echo '
                        <tr>
                            <td colspan="3" align="center" style="border-top: 2px solid #008FD4"><b>Total</b></td>
                            <td align="center" style="border-top: 2px solid #008FD4">Rp.' . number_format($ts_debet, 0, ",", ".") . '</td>
                            <td align="center" style="border-top: 2px solid #008FD4">Rp.' . number_format($ts_kredit, 0, ",", ".") . '</td>
                        </tr>
                    ';
                } else {
                    echo '
                        <tr>
                            <td colspan="5" align="center"><i>----------- Tidak Ada Data -----------</i></td>
                        </tr>
                    ';
                }
            } elseif ($filter == '3') {
                $data = $this->db->query("SELECT tb_akun.kode_akun, tb_akun.nama_akun, tb_jurnal.id_akun from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$tahun' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun order by tb_akun.kode_akun ASC");
                if ($data->row() > null) {
                    $no = 1;
                    $ts_debet = "0";
                    $ts_kredit = "0";
                    foreach ($data->result_array() as $d) {
                        $total_debet = "0";
                        $total_kredit = "0";
                        $saldo_debet = "0";
                        $saldo_kredit = "0";
                        $neraca = $this->db->query("SELECT tb_jurnal.nominal, tb_jurnal.tipe, tb_akun.kategori from tb_jurnal LEFT JOIN tb_akun ON tb_jurnal.id_akun=tb_akun.id_akun LEFT JOIN tb_jurnal_tmp ON tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal where year(tb_jurnal_tmp.tgl_jurnal)='$tahun' AND tb_jurnal.token='$token' and tb_jurnal.id_akun='$d[id_akun]' ");

                        foreach ($neraca->result() as $n) {
                            if ($n->tipe == 'D') {
                                $debet = $n->nominal;
                                $kredit = "0";
                            } elseif ($n->tipe == 'K') {
                                $kredit = $n->nominal;
                                $debet = "0";
                            }
                            $total_debet += $debet;
                            $total_kredit += $kredit;

                            if ($n->kategori == 'HL') {
                                $saldo_debet = $total_debet - $total_kredit;
                                $posisi = "Debet";
                            } elseif ($n->kategori == 'HT') {
                                $saldo_kredit = $total_kredit - $total_debet;
                                $posisi = "Kredit";
                            }
                        }

                        $ts_kredit += $saldo_kredit;
                        $ts_debet += $saldo_debet;

                        echo '
                            <tr align="center">
                                <td>' . $no++ . '</td>
                                <td>' . $d['kode_akun'] . '</td>
                                <td align="left">' . $d['nama_akun'] . '</td>
                                <td align="right">Rp. ' . number_format($saldo_debet, 0, ",", ".") . '</td>
                                <td align="right">Rp. ' . number_format($saldo_kredit, 0, ",", ".") . '</td>
                            </tr>
                        ';
                    }
                    echo '
                        <tr>
                            <td colspan="3" align="center" style="border-top: 2px solid #008FD4"><b>Total</b></td>
                            <td align="center" style="border-top: 2px solid #008FD4">Rp.' . number_format($ts_debet, 0, ",", ".") . '</td>
                            <td align="center" style="border-top: 2px solid #008FD4">Rp.' . number_format($ts_kredit, 0, ",", ".") . '</td>
                        </tr>
                    ';
                } else {
                    echo '
                        <tr>
                            <td colspan="5" align="center"><i>----------- Tidak Ada Data -----------</i></td>
                        </tr>
                    ';
                }
            }
        }
    }

    function viewFilter()
    {
        if ($_POST) {
            echo '<form action="' . base_url('Neraca_saldo/Cetak_Neraca') . '" method="post" target="_blank">
            <input type="hidden" name="filter" id="filter" class="form-control" value="' . $_POST['filter'] . '">
            <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="' . $_POST['tanggal'] . '">
            <input type="hidden" name="bulan" id="bulan" class="form-control" value="' . $_POST['bulan'] . '">
            <input type="hidden" name="tahun" id="tahun" class="form-control" value="' . $_POST['tahun'] . '">
            <a href="' . site_url('Neraca_saldo') . '" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
            <button class="btn btn-danger btn-sm" type="submit" onclick="return valid();"><i class="fas fa-print"></i> Cetak</button>
        </form>';
        }
    }
}
