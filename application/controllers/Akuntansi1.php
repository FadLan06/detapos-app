<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akuntansi1 extends CI_Controller
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
        if (isset($_POST['tmbh_akun'])) {
            $kode_akun = htmlspecialchars($this->input->post('kode_akun'));
            $aksi = $this->db->get_where('tb_akun', ['kode_akun' => $kode_akun, 'token' => $this->session->userdata('token')]);
            $dat = $aksi->num_rows();
            if ($dat > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Proses gagal!, Tidak boleh kode akun yang sama. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                $data = [
                    'kode_akun' => htmlspecialchars($this->input->post('kode_akun')),
                    'nama_akun' => htmlspecialchars($this->input->post('nama_akun')),
                    'kategori' => htmlspecialchars($this->input->post('kategori')),
                    'token' => htmlspecialchars($this->session->userdata('token'))
                ];

                $this->db->insert('tb_akun', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil di Tambahkan! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
            redirect('Akuntansi/Akun');
        } elseif (isset($_POST['ubah_akun'])) {
            $data = [
                'kode_akun' => htmlspecialchars($this->input->post('kode_akun')),
                'nama_akun' => htmlspecialchars($this->input->post('nama_akun')),
                'kategori' => htmlspecialchars($this->input->post('kategori'))
            ];

            $this->db->where('id_akun', $this->input->post('id_akun'));
            $this->db->update('tb_akun', $data);
            $this->session->set_flashdata('message1', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil di Ubah! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Akuntansi/Akun');
        } elseif (isset($_POST['tmbh_jurnal'])) {
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
            redirect('Akuntansi/Jurnal_Umum');
        }
    }

    public function akun()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'AKUN';

        $token = $this->session->userdata('token');
        $this->db->order_by('kode_akun', 'ASC');
        $data['akun'] = $this->db->get_where('tb_akun', ['token' => $token]);

        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/akun', $data);
        $this->load->view('templates/footer');
    }

    public function dt_akun()
    {
        if ($_POST['id_akun']) {
            $kd = $_POST['id_akun'];
            $token = $this->session->userdata('token');

            $data['data'] = $this->db->get_where('tb_akun', ['id_akun' => $kd, 'token' => $token])->row_array();

            $this->load->view('akuntansi/_akun', $data);
        }
    }

    function hps_akun($id)
    {
        $query1 = $this->db->get_where('tb_jurnal', ['id_akun' => $id]);
        $kd1 = $query1->num_rows();
        if ($kd1 > 0) {
            $this->session->set_flashdata('message1', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Akun ini tidak bisa di Hapus, Karena akun ini sudah ada di Jurnal Umum! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $this->db->where('id_akun', $id);
            $this->db->delete('tb_akun');
            $this->session->set_flashdata('message1', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data Berhasil di Hapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        redirect('Akuntansi/Akun');
    }

    public function jurnal_umum()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'JURNAL UMUM';

        $token = $this->session->userdata('token');
        $data['jurnal'] = $this->db->get_where('tb_jurnal', ['token' => $token]);
        $data['akunn'] = $this->db->get_where('tb_akun', ['token' => $token])->result();

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();

        if ($this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
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

            $data['data'] = $this->db->get_where('tb_jurnal', ['no_jurnal' => $kd, 'token' => $token])->result_array();
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
        } elseif ($_POST['filter'] == 2) {
            $data['tgl'] = $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.token='$token' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
        } elseif ($_POST['filter'] == 3) {
            $data['tgl'] = $this->db->query("SELECT * from tb_jurnal, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.token='$token' group by tb_jurnal.no_jurnal order by tb_jurnal_tmp.tgl_jurnal ASC");
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
            $tgl = date('ymd', strtotime($this->input->post('tgl_jurnal')));
            $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);
            $kodetampil = "JU" . $tgl . $batas;

            $data = [
                'no_jurnal' => $kodetampil,
                'tgl_jurnal' => $this->input->post('tgl_jurnal'),
                'keterangan' => $this->input->post('keterangan'),
                'token' => $this->session->userdata('token'),
            ];

            $this->db->insert('tb_jurnal_tmp', $data);

            $no_jurnal = $kodetampil;
            $id_akun = $this->input->post('id_akun');
            $tipe = $this->input->post('tipe');
            $nominal = str_replace(',', '', $this->input->post('nominal'));
            $token = $this->session->userdata('token');
            for ($i = 0; $i < count($id_akun); $i++) {
                $dt = [
                    'no_jurnal' => $no_jurnal,
                    'id_akun' => $id_akun[$i],
                    'nominal' => $nominal[$i],
                    'tipe' => $tipe[$i],
                    'token' => $token
                ];

                $this->db->insert('tb_jurnal', $dt);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Jurnal Umum Berhasil di Tambahkan! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Akuntansi/Jurnal_Umum');
        } elseif (isset($_POST['ubah_jurnall'])) {
            $data = [
                'tgl_jurnal' => $this->input->post('tgl_jurnal'),
                'keterangan' => $this->input->post('keterangan')
            ];

            $this->db->where('id_jurnal_tmp', $this->input->post('id_jurnal_tmp'));
            $this->db->update('tb_jurnal_tmp', $data);

            $no_jurnal = $this->input->post('no_jurnal');
            $id_jurnal = $this->input->post('id_jurnal');
            $id_akun = $this->input->post('id_akun');
            $tipe = $this->input->post('tipe');
            $nominal = str_replace(',', '', $this->input->post('nominal'));
            $token = $this->session->userdata('token');
            for ($ii = 0; $ii < count($id_akun); $ii++) {
                $dtt = [
                    // 'no_jurnal' => $no_jurnal,
                    'id_akun' => $id_akun[$ii],
                    'nominal' => $nominal[$ii],
                    'tipe' => $tipe[$ii]
                ];

                $this->db->where('id_jurnal', $id_jurnal[$ii]);
                $this->db->update('tb_jurnal', $dtt);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Jurnal Umum Berhasil di Ubah! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Akuntansi/Jurnal_Umum');
        }
    }

    function hps_trans($id)
    {
        $this->db->where('no_jurnal', $id);
        $this->db->delete('tb_jurnal');

        $this->db->where('no_jurnal', $id);
        $this->db->delete('tb_jurnal_tmp');
        $this->session->set_flashdata('message1', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Data Berhasil di Hapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Akuntansi/Jurnal_Umum');
    }

    public function buku_besar()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'BUKU BESAR';

        $token = $this->session->userdata('token');
        $data['akun'] = $this->db->query("SELECT *,count(tb_jurnal.id_akun) 'jumlah_akun', tb_akun.id_akun 'idakun' from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun");

        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/buku_besar', $data);
        $this->load->view('templates/footer');
    }

    public function neraca_saldo()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'NERACA SALDO';

        $token = $this->session->userdata('token');
        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();

        if ($this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
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
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun");
        } elseif ($_POST['filter'] == '2') {
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun");
        } elseif ($_POST['filter'] == '3') {
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' group by tb_jurnal.id_akun");
        }

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('akuntansi/cetak_neraca', $data);
    }

    function detail_akun()
    {
        $data['cek_akun'] = $this->db->get_where('tb_akun', ['id_akun' => $_GET['idakun']])->row_array();
        $this->load->view('akuntansi/detail_akun', $data);
    }

    public function laba_rugi()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $data['user']['token'];
        $data['judul'] = 'LABA RUGI';

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();

        if ($this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['data'] = $this->Akuntansi_model->cariLaba();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('akuntansi/laba_rugi', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_laba()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $token = $data['user']['token'];
        $data['judul'] = 'LABA RUGI';

        if ($_POST['filter'] == 'semua') {
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') AND (tb_akun.nama_akun LIKE '%Beban%' OR tb_akun.nama_akun LIKE '%Pendapatan%') group by tb_akun.nama_akun ORDER BY tb_jurnal.id_akun ASC");
        } elseif ($_POST['filter'] == '2') {
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') AND (tb_akun.nama_akun LIKE '%Beban%' OR tb_akun.nama_akun LIKE '%Pendapatan%') group by tb_akun.nama_akun ORDER BY tb_jurnal.id_akun ASC");
        } elseif ($_POST['filter'] == '3') {
            $data['data'] = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') AND (tb_akun.nama_akun LIKE '%Beban%' OR tb_akun.nama_akun LIKE '%Pendapatan%') group by tb_akun.nama_akun ORDER BY tb_jurnal.id_akun ASC");
        }

        $data['tahun'] = $this->db->query("SELECT tgl_jurnal, token FROM tb_jurnal_tmp WHERE token='$token' GROUP BY year(tgl_jurnal)")->result_array();
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('akuntansi/cetak_laba', $data);
    }
}
