<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal_umum extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
        $this->load->model('Akuntansi_model');
    }

    function aksi()
    {
        if (isset($_POST['tmbh_jurnal'])) {
            $data = [
                'tgl_jurnal' => htmlspecialchars($this->input->post('tgl_jurnal')),
                'id_akun' => htmlspecialchars($this->input->post('id_akun')),
                'keterangan' => htmlspecialchars($this->input->post('keterangan')),
                'nominal' => htmlspecialchars(str_replace(',', '', $this->input->post('nominal'))),
                'tipe' => htmlspecialchars($this->input->post('tipe')),
                'token' => htmlspecialchars($this->session->userdata('token'))
            ];

            $this->db->insert('tb_jurnal', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil di Tambahkan! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Jurnal_Umum');
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'JURNAL UMUM';

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
        $this->load->view('akuntansi/jurnal_umum', $data);
        $this->load->view('templates/footer');
    }

    public function dt_jurnal()
    {
        if ($_POST['no_jurnal']) {
            $kd = $_POST['no_jurnal'];
            $token = $this->session->userdata('token');

            $this->db->order_by('id_akun', 'ASC');
            $data['data'] = $this->db->get_where('tb_jurnal', ['no_jurnal' => $kd, 'token' => $token, 'tipe' => 'D'])->result_array();
            $this->db->order_by('id_akun', 'ASC');
            $data['dataa'] = $this->db->get_where('tb_jurnal', ['no_jurnal' => $kd, 'token' => $token, 'tipe' => 'K'])->result_array();
            $data['data1'] = $this->db->get_where('tb_jurnal_tmp', ['no_jurnal' => $kd, 'token' => $token])->row_array();
            $data['akunn'] = $this->db->get_where('tb_akun', ['token' => $token])->result();

            $this->load->view('akuntansi/_jurnal', $data);
        }
    }

    function cetak_jurnal()
    {
        $token = $this->session->userdata('token');
        $data['jurnal'] = $this->db->get_where('tb_jurnal', ['token' => $token]);

        if ($_POST['filter'] == 'semua') {
            $data['tgl'] = $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.token='$token' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
        } elseif ($_POST['filter'] == 1) {
            $data['tgl'] = $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$_POST[tanggal]' AND tb_jurnal.token='$token' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
        } elseif ($_POST['filter'] == 2) {
            $data['tgl'] = $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.token='$token' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
        } elseif ($_POST['filter'] == 3) {
            $data['tgl'] = $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.token='$token' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
        }

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('akuntansi/cetak_jurnal', $data);
    }

    function act_jurnal()
    {
        if (isset($_POST['tmbh_jurnall'])) {
            $this->db->select('RIGHT(tb_jurnal_tmp.no_jurnal,5) as no_jurnal', FALSE);
            $this->db->where('tgl_jurnal', $this->input->post('tgl_jurnal'));
            $this->db->where('token', $this->session->userdata('token'));
            $this->db->order_by('no_jurnal', 'DESC');
            $this->db->limit(1);
            $query = $this->db->get('tb_jurnal_tmp');  //cek dulu apakah ada sudah ada kode di tabel.
            if ($query->num_rows() <> 0) {
                //cek kode jika telah tersedia
                $data = $query->row();
                $kode = intval($data->no_jurnal) + 1;
            } else {
                $kode = 1;  //cek jika kode belum terdapat pada table
            }
            $pot = substr($this->session->userdata('token'), -3);
            $tgl = date('dmy', strtotime($this->input->post('tgl_jurnal')));
            $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
            $kodetampil = $pot . $tgl . $batas;

            $data = [
                'no_jurnal' => $kodetampil,
                'tgl_jurnal' => $this->input->post('tgl_jurnal'),
                'keterangan' => $this->input->post('keterangan'),
                'token' => $this->session->userdata('token'),
            ];

            $this->db->insert('tb_jurnal_tmp', $data);

            $no_jurnal = $kodetampil;
            $id_akunD = $this->input->post('id_akunD');
            // $id_akunK = $this->input->post('id_akunK');
            $tipe = $this->input->post('tipe');
            $nominal = str_replace(',', '', $this->input->post('nominal'));
            $token = $this->session->userdata('token');
            for ($i = 0; $i < count($id_akunD); $i++) {
                $dt = [
                    'no_jurnal' => $no_jurnal,
                    'id_akun' => $id_akunD[$i],
                    'nominal' => $nominal[$i],
                    'tipe' => $tipe[$i],
                    'token' => $token
                ];

                $this->db->insert('tb_jurnal', $dt);
            }

            // for ($i = 0; $i < count($id_akunK); $i++) {
            //     $dt = [
            //         'no_jurnal' => $no_jurnal,
            //         'id_akun' => $id_akunK[$i],
            //         'nominal' => $nominal[$i],
            //         'tipe' => 'K',
            //         'token' => $token
            //     ];

            //     $this->db->insert('tb_jurnal', $dt);
            // }

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Jurnal Umum Berhasil di Tambahkan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Jurnal_Umum') . "';</script>";
        } elseif (isset($_POST['ubah_jurnall'])) {
            $data = [
                'tgl_jurnal' => $this->input->post('tgl_jurnal'),
                'keterangan' => $this->input->post('keterangan')
            ];

            $this->db->where('id_jurnal_tmp', $this->input->post('id_jurnal_tmp'));
            $this->db->update('tb_jurnal_tmp', $data);

            $no_jurnal = $this->input->post('no_jurnal');
            $id_jurnalD = $this->input->post('id_jurnalD');
            $id_jurnalK = $this->input->post('id_jurnalK');
            $id_akunD = $this->input->post('id_akunD');
            $id_akunK = $this->input->post('id_akunK');
            $tipe = $this->input->post('tipe');
            $nominal = str_replace(',', '', $this->input->post('nominal'));
            $token = $this->session->userdata('token');
            for ($ii = 0; $ii < count($id_akunD); $ii++) {
                $dtt = [
                    // 'no_jurnal' => $no_jurnal,
                    'id_akun' => $id_akunD[$ii],
                    'nominal' => $nominal[$ii],
                    'tipe' => 'D'
                ];

                $this->db->where('id_jurnal', $id_jurnalD[$ii]);
                $this->db->update('tb_jurnal', $dtt);
            }
            for ($ii = 0; $ii < count($id_akunK); $ii++) {
                $dtt = [
                    // 'no_jurnal' => $no_jurnal,
                    'id_akun' => $id_akunK[$ii],
                    'nominal' => $nominal[$ii],
                    'tipe' => 'K'
                ];

                $this->db->where('id_jurnal', $id_jurnalK[$ii]);
                $this->db->update('tb_jurnal', $dtt);
            }

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Jurnal Umum Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Jurnal_Umum') . "';</script>";
        }
    }

    function hps_trans($id)
    {
        $this->db->where('no_jurnal', $id);
        $this->db->delete('tb_jurnal');

        $this->db->where('no_jurnal', $id);
        $this->db->delete('tb_jurnal_tmp');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Jurnal Umum Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Jurnal_Umum') . "';</script>";
    }
}
