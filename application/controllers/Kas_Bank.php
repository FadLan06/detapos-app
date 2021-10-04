<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kas_Bank extends CI_Controller
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
        $data['judul'] = 'Kas & Bank';

        $token = $this->session->userdata('token');
        $data['jurnal'] = $this->db->get_where('tb_jurnal', ['token' => $token]);
        $data['akunn'] = $this->db->get_where('tb_akun', ['token' => $token])->result();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();

        if ($this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['tgl'] = $this->Akuntansi_model->cariJurnal();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/kas_bank', $data);
        $this->load->view('templates/footer');
    }

    function viewKasBank()
    {
        $token = $this->session->userdata('token');
        $data = $this->db->query("SELECT j.tipe, j.id_akun as idakun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE (a.nama_akun LIKE 'Kas' OR a.nama_akun LIKE 'Kas%' OR a.nama_akun LIKE 'Bank%') AND j.token='$token' GROUP BY idakun ORDER BY a.kode_akun ASC")->result_array();

        $no = 1;
        foreach ($data as $kas) {
            $total_debet = "0";
            $total_kredit = "0";
            $saldo_debet = "0";
            $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.id_akun='$kas[idakun]' ");
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
            echo '
                <tr>
                    <td align="center">' . $no++ . '</td>
                    <td>' . $kas['kode_akun'] . '</td>
                    <td><a href="' . base_url('Kas_Bank/View/' . $kas['idakun']) . '">' . $kas['nama_akun'] . '</a></td>
                    <td align="center">Rp. 0</td>
                    <td align="center">Rp. ' . number_format($saldo_debet) . '</td>
                </tr>
            ';
        }
    }

    public function view()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Kas & Bank';

        $token = $this->session->userdata('token');
        $data['jurnal'] = $this->db->get_where('tb_jurnal', ['token' => $token]);
        $data['akun'] = $this->db->get_where('tb_akun', ['token' => $token, 'id_akun' => $this->uri->segment(3)])->row_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();


        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/view', $data);
        $this->load->view('templates/footer');
    }

    function viewDetail()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $token = $this->session->userdata('token');

            $total_debet = "0";
            $total_kredit = "0";
            $no = 1;
            $akun = $this->db->query("SELECT * from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.id_akun=tb_akun.id_akun and tb_jurnal.id_akun='$id' and tb_jurnal_tmp.token='$token' ");
            foreach ($akun->result_array() as $r) {
                if ($r['tipe'] == 'D') {
                    $nominal_debet = $r['nominal'];
                    $nominal_kredit = "0";
                    $total_debet    +=    $nominal_debet;
                    $tipe = $r['tipe'];
                } elseif ($r['tipe'] == 'K') {
                    $nominal_kredit = $r['nominal'];
                    $nominal_debet = "0";
                    $total_kredit    +=    $nominal_kredit;
                }

                if ($r['kategori'] == 'HL') {
                    $saldo = $total_debet - $total_kredit;
                    $posisi = "Debet";
                } elseif ($r['kategori'] == 'HT') {
                    $saldo = $total_kredit - $total_debet;
                    $posisi = "Kredit";
                }
                echo '
                    <tr>
                        <td align="center">' . $no++ . '</td>
                        <td><i>' . $r['keterangan'] . '</i></td>
                        <td>' . date('d F Y', strtotime($r['tgl_jurnal'])) . '</td>
                        <td align="center">Rp. ' . number_format($nominal_debet, 0, ",", ".") . '</td>
                        <td align="center">Rp. ' . number_format($nominal_kredit, 0, ",", ".") . '</td>
                        <td align="center">Rp. ' . number_format($saldo, 0, ",", ".") . '</td>
                    </tr>
                ';
            }
        }
    }
}
