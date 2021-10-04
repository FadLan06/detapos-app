<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaran extends CI_Controller
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
        $data['judul'] = 'Data Transaksi Pengeluaran';
        $token = $this->session->userdata('token');
        $data['petugas'] = $this->session->userdata('username');

        $data['no_jurnal'] = $this->Akuntansi_model->no_jurnal();
        $data['no_seri'] = $this->Supplier_model->no_seri();
        $data['pengeluaran'] = $this->db->get_where('tb_pengeluaran', ['token' => $token])->result_array();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('pengeluaran/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        if (isset($_POST['simpan'])) {
            $no_seri = $this->input->post('no_seri');
            $nominal = str_replace(',', '', $this->input->post('nominal'));
            $uraian = $this->input->post('uraian');
            $tanggal = $this->input->post('tanggal');
            $petugas = $this->session->userdata('username');
            $metodePem = $this->input->post('metodePem');

            $data = [
                'no_seri' => $no_seri,
                'uraian' => $uraian,
                'tanggal' => $tanggal,
                'petugas' => $petugas,
                'nominal' => $nominal,
                'token' => $this->session->userdata('token')
            ];
            $this->db->insert('tb_pengeluaran', $data);

            $akun = $this->db->get_where('tb_akun', ['token' => $this->session->userdata('token'), 'kode_akun' => '201'])->row_array();
            if (empty($akun['kode_akun'])) {
                $ak = [
                    'kode_akun' => '201',
                    'nama_akun' => 'Beban Pengeluaran',
                    'kategori' => 'HL',
                    'token' => $this->session->userdata('token')
                ];
                $this->db->insert('tb_akun', $ak);
            }

            $user = $this->db->get_where('user', ['token' => $this->session->userdata('token')])->row_array();
            if ($user['coupon'] == 'new') {
                $datta = [
                    'no_jurnal' => $this->input->post('no_jurnal'),
                    'tgl_jurnal' => date('Y-m-d'),
                    'keterangan' => $uraian . ' dengan Nomor Seri ' . $no_seri,
                    'token' => $this->session->userdata('token'),
                    'no_seri' => $no_seri
                ];

                $this->db->insert('tb_jurnal_tmp', $datta);

                $tok = $this->session->userdata('token');
                $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (111,201) ORDER BY kategori='HL' DESC")->result_array();

                foreach ($ak as $ro) {
                    if ($ro['kode_akun'] == '201') {
                        // $ka = 'K';
                        $dt1 = [
                            'no_jurnal' => $this->input->post('no_jurnal'),
                            'id_akun' => $ro['id_akun'],
                            'nominal' => $nominal,
                            'tipe' => 'D',
                            'token' => $this->session->userdata('token'),
                            'no_seri' => $no_seri
                        ];

                        $this->db->insert('tb_jurnal', $dt1);
                    } else if ($ro['kode_akun'] == '111') {
                        // $ka = 'K';
                        $dt1 = [
                            'no_jurnal' => $this->input->post('no_jurnal'),
                            'id_akun' => $ro['id_akun'],
                            'nominal' => $nominal,
                            'tipe' => 'K',
                            'token' => $this->session->userdata('token'),
                            'no_seri' => $no_seri
                        ];

                        $this->db->insert('tb_jurnal', $dt1);
                    }
                }
            }

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Pengeluaran Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Pengeluaran') . "';</script>";
        }
    }

    function hapus($id)
    {
        $token = $this->session->userdata('token');

        $this->db->where('no_seri', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_pengeluaran');

        $this->db->where('no_seri', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_jurnal');

        $this->db->where('no_seri', $id);
        $this->db->where('token', $token);
        $this->db->delete('tb_jurnal_tmp');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Pengeluaran Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Pengeluaran') . "';</script>";
    }
}
