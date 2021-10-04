<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pelanggan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Data_model');
        $this->load->model('Laporan_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Pelanggan';

        $token = $data['user']['token'];
        $data['pelanggan'] = $this->db->get_where('tb_pelanggan', ['token' => $token])->result();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('pelanggan/index', $data);
        $this->load->view('templates/footer');
    }

    function aksi()
    {
        if (isset($_POST['smpn'])) {
            $kode_pel = htmlspecialchars($this->input->post('kode_pel'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_pelanggan', ['token' => $token, 'kode_pel' => $kode_pel])->num_rows();
            $query1 = $this->db->get_where('tb_pelanggan', ['token' => $token, 'kode_pel' => $kode_pel])->row();

            if (($query > 0) and ($kode_pel == $query1->kode_pel)) {

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data pelanggan, Kode Pelanggan sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Pelanggan/Tambah_Pelanggan') . "';</script>";
            } else {
                $data = [
                    'kode_pel' => htmlspecialchars($this->input->post('kode_pel')),
                    'nama_pel' => htmlspecialchars($this->input->post('nama_pel')),
                    'no_hp' => htmlspecialchars($this->input->post('no_hp')),
                    'email' => htmlspecialchars($this->input->post('email')),
                    'alamat' => htmlspecialchars($this->input->post('alamat')),
                    'diskon' => htmlspecialchars($this->input->post('diskonn')),
                    'point' => htmlspecialchars($this->input->post('point')),
                    'token' => htmlspecialchars($this->session->userdata('token'))
                ];

                $this->db->insert('tb_pelanggan', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Pelanggan Berhasil di Tambahkan!'); </script>";
                }
                echo "<script>window.location='" . site_url('Pelanggan') . "';</script>";
            }
        } elseif (isset($_POST['ubah'])) {
            $data = [
                'kode_pel' => htmlspecialchars($this->input->post('kode_pel')),
                'nama_pel' => htmlspecialchars($this->input->post('nama_pel')),
                'no_hp' => htmlspecialchars($this->input->post('no_hp')),
                'email' => htmlspecialchars($this->input->post('email')),
                'alamat' => htmlspecialchars($this->input->post('alamat')),
                'diskon' => htmlspecialchars($this->input->post('diskonn')),
                'point' => htmlspecialchars($this->input->post('point')),
            ];

            $this->db->where('kd_pelanggan', htmlspecialchars($this->input->post('kd_pelanggan')));
            $this->db->update('tb_pelanggan', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Pelanggan Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Pelanggan') . "';</script>";
        }
    }

    public function tambah_pelanggan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Tambah Data Pelanggan';

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('pelanggan/tambah_pelanggan', $data);
        $this->load->view('templates/footer');
    }

    public function ubah_pelanggan($kd)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Ubah Data Pelanggan';

        $token = $this->session->userdata('token');

        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
        $data['pelanggan'] = $this->db->get_where('tb_pelanggan', ['kd_pelanggan' => $kd, 'token' => $token])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('pelanggan/ubah_pelanggan', $data);
        $this->load->view('templates/footer');
    }

    public function view($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Detail Data Pelanggan';

        $token = $this->session->userdata('token');
        $data['pelanggan'] = $this->db->get_where('tb_pelanggan', ['kd_pelanggan' => $id, 'token' => $token])->row();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('report') || $this->input->post('kd_pelanggan')) {
            $data['data'] = $this->Laporan_model->rpel();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('pelanggan/lihat_pelanggan', $data);
        $this->load->view('templates/footer');
    }

    public function detail()
    {
        if ($_POST['kd_pelanggan']) {
            $kd = $_POST['kd_pelanggan'];
            $data['data'] = $this->db->get_where('tb_pelanggan', ['kd_pelanggan' => $kd])->row();

            $this->load->view('Pelanggan/_ubah', $data);
        }
    }

    function hapus($id)
    {
        $this->db->where('kd_pelanggan', $id);
        $this->db->delete('tb_pelanggan');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Pelanggan Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Pelanggan') . "';</script>";
    }

    public function cetak_customer()
    {
        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['cus'] = $this->Laporan_model->cariCustomer();
        }

        $this->load->view('pelanggan/cetak_customer', $data);
    }

    public function export()
    {
        // Panggil class PHPExcel nya
        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('MFZ')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Data Pelanggan")
            ->setSubject("Pelanggan")
            ->setDescription("Report Pelanggan")
            ->setKeywords("Pelanggan");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('borderStyle'  =>  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT DATA PELANGGAN");
        $excel->getActiveSheet()->mergeCells('A1:H1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "KODE PELANGGAN");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "NAMA PELANGGAN");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "EMAIL");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "NOMOR TELPON");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "ALAMAT");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "DISKON");
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "COUNT");
        if (($this->session->userdata('token') == 'DPE3DPU354ZB4A7YZ') || ($this->session->userdata('token') == 'DPQTT39LS7ETWKXE')) {
            $excel->setActiveSheetIndex(0)->setCellValue('I4', "TOTAL");
            $excel->setActiveSheetIndex(0)->setCellValue('J4', "POINT");
        }

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        if (($this->session->userdata('token') == 'DPE3DPU354ZB4A7YZ') || ($this->session->userdata('token') == 'DPQTT39LS7ETWKXE')) {
            $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
        }

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $token = $this->session->userdata('token');
        $hari = $this->db->get_where('tb_pelanggan', ['token' => $token]);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        $tot = 0;
        if ($hari->num_rows() > 0) {
            foreach ($hari->result() as $data) { // Lakukan looping pada variabel siswa
                $coun = $this->db->query("SELECT COUNT(kode_pelanggan) as pen FROM tb_penjualan WHERE kode_pelanggan='$data->kode_pel'")->row();
                $tot = $this->db->query("SELECT sum(total) as tot FROM tb_penjualan WHERE kode_pelanggan='$data->nama_pel' AND token='$data->token'")->row();
                $disk = $this->db->query("SELECT sum(pot) as pot FROM tb_penjualan WHERE kode_pelanggan='$data->nama_pel' AND token='$data->token'")->row();
                $total = $tot->tot - $disk->pot;
                $sisaBagi =  fmod($total, $data->point);
                $hasilbagi = ($total - $sisaBagi) / $data->point;

                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->kode_pel);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_pel);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->email);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->no_hp);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->alamat);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->diskon . '%');
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $coun->pen . ' Kali');
                if (($this->session->userdata('token') == 'DPE3DPU354ZB4A7YZ') || ($this->session->userdata('token') == 'DPQTT39LS7ETWKXE')) {
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, 'Rp. ' . number_format($total));
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->point != '0' ? $hasilbagi : 0);
                }

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
                if (($this->session->userdata('token') == 'DPE3DPU354ZB4A7YZ') || ($this->session->userdata('token') == 'DPQTT39LS7ETWKXE')) {
                    $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
                }
                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
            }
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A5', "----------- Tidak Ada Data -----------");
            $excel->getActiveSheet()->mergeCells('A5:H5');
            $excel->getActiveSheet()->getStyle('A5')->getFont()->setItalic(TRUE);
            $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_row);
            if (($this->session->userdata('token') == 'DPE3DPU354ZB4A7YZ') || ($this->session->userdata('token') == 'DPQTT39LS7ETWKXE')) {
                $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(35); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(10); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(10); // Set width kolom E
        if (($this->session->userdata('token') == 'DPE3DPU354ZB4A7YZ') || ($this->session->userdata('token') == 'DPQTT39LS7ETWKXE')) {
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(25); // Set width kolom E
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        } // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Report Data Pelanggan");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Report Data Pelanggan';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    function range_cetak()
    {
        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('report') || $this->input->post('kd_pelanggan')) {
            $data['data'] = $this->Laporan_model->rpel();
        }
        $this->load->view('pelanggan/cetak', $data);
    }

    function range_export()
    {
        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('report') || $this->input->post('kd_pelanggan')) {
            $data['data'] = $this->Laporan_model->rpel();
        }
        $this->load->view('pelanggan/export', $data);
    }
}
