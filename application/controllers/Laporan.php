<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Laporan_model');
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    public function harian()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Laporan Harian';

        $token = $data['user']['token'];
        $data['petugas'] = $this->db->get_where('user', ['token' => $token])->result_array();
        $tgl = date('Y-m-d');
        $data['data'] = $this->db->query("SELECT * FROM tb_penjualan p where p.token='$token' AND p.tgl_transaksi='$tgl' ORDER BY p.timestmp DESC")->result_array();

        if ($this->input->post('petugas') && $this->input->post('tgl_akhir')) {
            $data['data'] = $this->Laporan_model->cariData();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/harian', $data);
        $this->load->view('templates/footer');
    }

    public function export_harian()
    {
        // Panggil class PHPExcel nya
        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('MFZ')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Data Penjualan Harian")
            ->setSubject("Penjualan")
            ->setDescription("Laporan Penjualan Harian")
            ->setKeywords("Penjualan Harian");

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

        $tgll = date('j F Y');
        $tgl = date('Y-m-d');

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PENJUALAN HARIAN");
        $excel->getActiveSheet()->mergeCells('A1:E1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "PERIODE");
        $excel->getActiveSheet()->mergeCells('A3:B3');
        $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('C3', ':  ' . $tgll);
        $excel->getActiveSheet()->mergeCells('C3:E3');


        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "NO. TRANSAKSI");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "TANGGAL PENJUALAN");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "PETUGAS");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "PENDAPATAN TOKO");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $token = $this->session->userdata('token');
        $hari = $this->db->get_where('tb_penjualan', ['token' => $token, 'tgl_transaksi' => $tgl]);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        $tot = 0;
        if ($hari->num_rows() > 0) {
            foreach ($hari->result() as $data) { // Lakukan looping pada variabel siswa
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->no_transaksi);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, date('j F Y', strtotime($data->tgl_transaksi)));
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->petugas);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->total);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
                $tot += $data->total;
            }
            $excel->setActiveSheetIndex(0)->setCellValue('G4', "TOTAL PENDAPATAN");
            $excel->getActiveSheet()->mergeCells('G5:G6');
            $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
            $excel->setActiveSheetIndex(0)->setCellValue('G5', $tot);
            $excel->getActiveSheet()->getStyle('G5')->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
            $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G6')->applyFromArray($style_row);
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A5', "----------- Tidak Ada Data -----------");
            $excel->getActiveSheet()->mergeCells('A5:E5');
            $excel->getActiveSheet()->getStyle('A5')->getFont()->setItalic(TRUE);
            $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_row);
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Penjualan Harian");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Laporan Penjualan Harian';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function export_harian_tgl()
    {

        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('MFZ')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Data Penjualan Harian")
            ->setSubject("Penjualan")
            ->setDescription("Laporan Penjualan Harian")
            ->setKeywords("Penjualan Harian");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PENJUALAN HARIAN");
        $excel->getActiveSheet()->mergeCells('A1:E1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "PERIODE");
        $excel->getActiveSheet()->mergeCells('A3:B3');
        $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $tgl_akhir = $this->input->post('tgl_akhir');
        $excel->setActiveSheetIndex(0)->setCellValue('C3', $tgl_akhir);
        $excel->getActiveSheet()->mergeCells('C3:E3');


        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "NO. TRANSAKSI");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "TANGGAL PENJUALAN");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "PETUGAS");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "PENDAPATAN TOKO");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $token = $this->session->userdata('token');
        $petugas = $this->input->post('petugas');
        if ($petugas == "Semua") {
            $hari = $this->db->get_where('tb_penjualan', ['token' => $token, 'tgl_transaksi' => $tgl_akhir]);
        } else {
            $hari = $this->db->get_where('tb_penjualan', ['token' => $token, 'tgl_transaksi' => $tgl_akhir, 'petugas' => $petugas]);
        }

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        $tot = 0;
        if ($hari->num_rows() > 0) {
            foreach ($hari->result() as $data) { // Lakukan looping pada variabel siswa
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->no_transaksi);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->tgl_transaksi);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->petugas);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->total);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
                $tot += $data->total;
            }
            $excel->setActiveSheetIndex(0)->setCellValue('G4', "TOTAL PENDAPATAN");
            $excel->getActiveSheet()->mergeCells('G5:G6');
            $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
            $excel->setActiveSheetIndex(0)->setCellValue('G5', $tot);
            $excel->getActiveSheet()->getStyle('G5')->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
            $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G6')->applyFromArray($style_row);
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A5', "----------- Tidak Ada Data -----------");
            $excel->getActiveSheet()->mergeCells('A5:E5');
            $excel->getActiveSheet()->getStyle('A5')->getFont()->setItalic(TRUE);
            $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_row);
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Penjualan Harian");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Laporan Penjualan Harian';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function minggu_bulan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Laporan Minggu/Bulan';

        $token = $this->session->userdata('token');
        $data['petugas'] = $this->db->get_where('user', ['token' => $token])->result_array();
        if ($this->input->post('petugas') && $this->input->post('tgl_akhir') && $this->input->post('tgl_awal')) {
            $data['data'] = $this->Laporan_model->minggu();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/minggu_bulan', $data);
        $this->load->view('templates/footer');
    }

    public function export_minggu()
    {
        // Load plugin PHPExcel nya
        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Gamma Advertisa')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Data Penjualan Minggu/Bulan")
            ->setSubject("Penjualan")
            ->setDescription("Laporan Penjualan Minggu/Bulan")
            ->setKeywords("Penjualan Minggu/Bulan");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PENJUALAN MINGGU/BULAN");
        $excel->getActiveSheet()->mergeCells('A1:F1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "PERIODE");
        $excel->getActiveSheet()->mergeCells('A3:B3');
        $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $excel->setActiveSheetIndex(0)->setCellValue('C3', $tgl_awal . ' Sampai ' . $tgl_akhir);
        $excel->getActiveSheet()->mergeCells('C3:E3');


        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "NO. TRANSAKSI");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "NAMA PELANGGAN");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "TGL. TRANSAKSI");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "PETUGAS");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "TOTAL");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $token = $this->session->userdata('token');
        $petugas = $this->input->post('petugas');
        if ($petugas == 'Semua') {
            $ming = $this->db->query("SELECT * FROM tb_penjualan LEFT JOIN tb_pelanggan ON tb_pelanggan.kode_pel = tb_penjualan.kode_pelanggan WHERE tb_penjualan.token='$token' AND tgl_transaksi BETWEEN '$tgl_awal' and '$tgl_akhir'");
        } else {
            $ming = $this->db->query("SELECT * FROM tb_penjualan LEFT JOIN tb_pelanggan ON tb_pelanggan.kode_pel = tb_penjualan.kode_pelanggan WHERE tb_penjualan.token='$token' AND petugas='$petugas' AND tgl_transaksi BETWEEN '$tgl_awal' and '$tgl_akhir'");
        }

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        $tot = 0;
        if ($ming->num_rows() > 0) {
            foreach ($ming->result() as $data) { // Lakukan looping pada variabel siswa
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->getActiveSheet()->getStyle('A' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->no_transaksi);
                if ($data->kode_pelanggan == '') {
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, 'Umum');
                } else {
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_pel);
                }
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->timestmp);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->petugas);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->total);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
                $tot += $data->total;
            }
            $excel->setActiveSheetIndex(0)->setCellValue('H4', "TOTAL PENDAPATAN");
            $excel->getActiveSheet()->mergeCells('H5:H6');
            $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
            $excel->setActiveSheetIndex(0)->setCellValue('H5', $tot);
            $excel->getActiveSheet()->getStyle('H5')->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
            $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H6')->applyFromArray($style_row);
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A5', "----------- Tidak Ada Data -----------");
            $excel->getActiveSheet()->mergeCells('A5:F5');
            $excel->getActiveSheet()->getStyle('A5')->getFont()->setItalic(TRUE);
            $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_row);
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25); // Set width kolom F

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Penjualan Minggu_Bulan");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Laporan Penjualan Minggu_Bulan';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function keuntungan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Laporan Keuntungan';

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
        $data['tahun'] = $this->db->query("SELECT tgl_penjualan, token FROM tb_detail_penjualan WHERE token='$token' GROUP BY year(tgl_penjualan)")->result_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['dataa'] = $this->Laporan_model->cariBulan();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/keuntungan', $data);
        $this->load->view('templates/footer');
    }

    public function export_uang()
    {

        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('MFZ')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Data Penjualan Keuntungan")
            ->setSubject("Penjualan")
            ->setDescription("Laporan Penjualan Keuntungan")
            ->setKeywords("Penjualan Keuntungan");

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

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $akses = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN KEUNTUNGAN");
        $excel->getActiveSheet()->mergeCells('A1:J1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "PERIODE");
        $excel->getActiveSheet()->mergeCells('A3:B3');
        $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $filter = $this->input->post('filter');
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);

        if ($filter == 'semua') {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', 'Semua Data Periode');
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 2) {
            if ($bulan == 1) {
                $bul = 'Januari';
            } elseif ($bulan == 2) {
                $bul = 'Februari';
            } elseif ($bulan == 3) {
                $bul = 'Maret';
            } elseif ($bulan == 4) {
                $bul = 'April';
            } elseif ($bulan == 5) {
                $bul = 'Mei';
            } elseif ($bulan == 6) {
                $bul = 'Juni';
            } elseif ($bulan == 7) {
                $bul = 'Juli';
            } elseif ($bulan == 8) {
                $bul = 'Agustus';
            } elseif ($bulan == 9) {
                $bul = 'September';
            } elseif ($bulan == 10) {
                $bul = 'Oktober';
            } elseif ($bulan == 11) {
                $bul = 'November';
            } elseif ($bulan == 12) {
                $bul = 'Desember';
            }
            $excel->setActiveSheetIndex(0)->setCellValue('C3', $bul . ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 3) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 1) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tanggal);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 4) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tgl_awal . ' sampai ', $tgl_akhir);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        }


        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "KODE BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "NAMA BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "MODAL");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "JUAL");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "TERJUAL");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "POTONGAN");
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "KEUNTUNGAN");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $token = $this->session->userdata('token');
        if ($filter == '3') {
            $ken = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.total) as tot FROM tb_detail_penjualan a WHERE a.token='$token' AND YEAR(a.timee)='$tahun' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($filter == '2') {
            $ken = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.total) as tot FROM tb_detail_penjualan a WHERE a.token='$token' AND MONTH(a.timee)='$bulan' AND YEAR(a.timee)='$tahun' GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($filter == 'semua') {
            $ken = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.total) as tot FROM tb_detail_penjualan a WHERE a.token='$token'GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($filter == '1') {
            $ken = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.total) as tot FROM tb_detail_penjualan a WHERE a.token='$token'GROUP BY a.kode_barang, a.modal, a.harga");
        } elseif ($filter == '4') {
            $ken = $this->db->query("SELECT a.qty, a.kode_barang, a.modal, a.token, a.harga, sum(a.qty) as total, sum(a.total) as tot FROM tb_detail_penjualan a WHERE a.token='$token'GROUP BY a.kode_barang, a.modal, a.harga");
        }

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        $ttl_terjual = 0;
        $ttl_keuntungan = 0;
        $ttl_pot = 0;
        if ($ken->num_rows() > 0) {
            foreach ($ken->result() as $data) { // Lakukan looping pada variabel siswa
                if ($filter == 'semua') {
                    $br = $this->db->query("SELECT kode_barang, nama_barang, harga_beli, harga_jual FROM tb_barang WHERE kode_barang='$data->kode_barang' AND token='$data->token' ")->row();
                } elseif ($filter == 2) {
                    $br = $this->db->query("SELECT kode_barang, nama_barang, harga_beli, harga_jual FROM tb_barang WHERE kode_barang='$data->kode_barang' AND token='$data->token' ")->row();
                } elseif ($filter == 3) {
                    $br = $this->db->query("SELECT kode_barang, nama_barang, harga_beli, harga_jual FROM tb_barang WHERE kode_barang='$data->kode_barang' AND token='$data->token' ")->row();
                }
                $terjual = $data->total - 0;
                $keuntungan = ($data->harga * $terjual) - ($data->modal * $terjual) - $data->tot;

                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->getActiveSheet()->getStyle('A' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $br->kode_barang);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $br->nama_barang);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->modal);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->harga);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $terjual);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->tot);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $keuntungan);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
                $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
                $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
                $ttl_terjual += $terjual;
                $ttl_pot += $data->tot;
                $ttl_keuntungan += $keuntungan;
            }
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A5', "----------- Tidak Ada Data -----------");
            $excel->getActiveSheet()->mergeCells('A5:G5');
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
        }

        $excel->setActiveSheetIndex(0)->setCellValue('J4', "TOTAL TERJUAL");
        $excel->setActiveSheetIndex(0)->setCellValue('J8', "TOTAL POTONGAN");
        $excel->setActiveSheetIndex(0)->setCellValue('J12', "TOTAL KEUNTUNGAN");
        $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J12')->applyFromArray($style_col);
        $excel->setActiveSheetIndex(0)->setCellValue('J5', $ttl_terjual);
        $excel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $excel->setActiveSheetIndex(0)->setCellValue('J9', $ttl_pot);
        $excel->getActiveSheet()->getStyle('J9')->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
        $excel->getActiveSheet()->getStyle('J9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $excel->setActiveSheetIndex(0)->setCellValue('J13', $ttl_keuntungan);
        $excel->getActiveSheet()->getStyle('J13')->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
        $excel->getActiveSheet()->getStyle('J13')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->mergeCells('J5:J6');
        $excel->getActiveSheet()->mergeCells('J9:J10');
        $excel->getActiveSheet()->mergeCells('J13:J14');
        $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('J6')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('J9')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('J10')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('J13')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('J14')->applyFromArray($style_row);

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(10); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); // Set width kolom G
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25); // Set width kolom G
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20); // Set width kolom G

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Penjualan Keuntungan");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Laporan Penjualan Keuntungan';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function retur_supplier()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Laporan Retur Supplier';

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
        $data['tahun'] = $this->db->query("SELECT tgl_pem, token FROM tb_retur_pembelian WHERE token='$token' GROUP BY year(tgl_pem)")->result_array();

        if ($this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['supp'] = $this->Laporan_model->cariSupplier();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/retur_supplier', $data);
        $this->load->view('templates/footer');
    }

    public function export_rt_sup()
    {
        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('MFZ')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Data Retur Supplier")
            ->setSubject("Retur")
            ->setDescription("Laporan Retur Supplier")
            ->setKeywords("Retur Supplier");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN RETUR SUPPLIER");
        $excel->getActiveSheet()->mergeCells('A1:H1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "PERIODE");
        $excel->getActiveSheet()->mergeCells('A3:B3');
        $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $token = $this->session->userdata('token');
        $tanggal = $this->input->post('tanggal');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $filter = $this->input->post('filter');

        if ($filter == 'semua') {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', 'Semua Data Periode');
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 2) {
            if ($bulan == 1) {
                $bul = 'Januari';
            } elseif ($bulan == 2) {
                $bul = 'Februari';
            } elseif ($bulan == 3) {
                $bul = 'Maret';
            } elseif ($bulan == 4) {
                $bul = 'April';
            } elseif ($bulan == 5) {
                $bul = 'Mei';
            } elseif ($bulan == 6) {
                $bul = 'Juni';
            } elseif ($bulan == 7) {
                $bul = 'Juli';
            } elseif ($bulan == 8) {
                $bul = 'Agustus';
            } elseif ($bulan == 9) {
                $bul = 'September';
            } elseif ($bulan == 10) {
                $bul = 'Oktober';
            } elseif ($bulan == 11) {
                $bul = 'November';
            } elseif ($bulan == 12) {
                $bul = 'Desember';
            }
            $excel->setActiveSheetIndex(0)->setCellValue('C3', $bul . ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 3) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 1) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tanggal);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        }


        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "KODE BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "NAMA SUPPLIER");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "JUMLAH RETUR");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "KETERANGAN");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "TANGGAL RETUR");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya

        if ($filter == '3') {
            $retur = $this->db->query("SELECT * FROM tb_retur_pembelian r WHERE r.token='$token' AND YEAR(r.tgl_pem)='$tahun' ORDER BY r.id_retur_pembelian");
        } elseif ($filter == '2') {
            $retur = $this->db->query("SELECT * FROM tb_retur_pembelian r WHERE r.token='$token' AND MONTH(r.tgl_pem)='$bulan' AND YEAR(r.tgl_pem)='$tahun' ORDER BY r.id_retur_pembelian");
        } elseif ($filter == '1') {
            $retur = $this->db->query("SELECT * FROM tb_retur_pembelian r WHERE r.token='$token' AND r.tgl_pem='$tanggal' ORDER BY r.id_retur_pembelian");
        } elseif ($filter == 'semua') {
            $retur = $this->db->query("SELECT * FROM tb_retur_pembelian r WHERE r.token='$token'");
        }

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        $tot = 0;
        if ($retur->num_rows() > 0) {
            foreach ($retur->result() as $data) { // Lakukan looping pada variabel siswa
                $sup = $this->db->get_where('tb_supplier', ['kode_sup' => $data->kode_supplier, 'token' => $data->token])->row();
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->kode_barang);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $sup->nama_toko);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->jumlah_barang);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->alasan);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->tgl_pem);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
                $tot += $data->jumlah_barang;
            }
            $excel->setActiveSheetIndex(0)->setCellValue('H4', "TOTAL RETUR");
            $excel->getActiveSheet()->mergeCells('H5:H6');
            $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
            $excel->setActiveSheetIndex(0)->setCellValue('H5', $tot);
            $excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H6')->applyFromArray($style_row);
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A5', "----------- Tidak Ada Data -----------");
            $excel->getActiveSheet()->mergeCells('A5:E5');
            $excel->getActiveSheet()->getStyle('A5')->getFont()->setItalic(TRUE);
            $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_row);
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Retur Supplier");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Laporan Retur Supplier';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function retur_customer()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Laporan Retur Customer';

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
        $data['tahun'] = $this->db->query("SELECT tgl_beli, token FROM tb_retur_penjualan WHERE token='$token' GROUP BY year(tgl_beli)")->result_array();

        if ($this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['cus'] = $this->Laporan_model->cariCustomer();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/retur_customer', $data);
        $this->load->view('templates/footer');
    }

    public function export_rt_cus()
    {
        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('MFZ')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Data Retur Customer")
            ->setSubject("Retur")
            ->setDescription("Laporan Retur Customer")
            ->setKeywords("Retur Customer");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN RETUR CUSTOMER");
        $excel->getActiveSheet()->mergeCells('A1:I1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "PERIODE");
        $excel->getActiveSheet()->mergeCells('A3:B3');
        $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $token = $this->session->userdata('token');
        $tanggal = $this->input->post('tanggal');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $filter = $this->input->post('filter');

        if ($filter == 'semua') {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', 'Semua Data Periode');
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 2) {
            if ($bulan == 1) {
                $bul = 'Januari';
            } elseif ($bulan == 2) {
                $bul = 'Februari';
            } elseif ($bulan == 3) {
                $bul = 'Maret';
            } elseif ($bulan == 4) {
                $bul = 'April';
            } elseif ($bulan == 5) {
                $bul = 'Mei';
            } elseif ($bulan == 6) {
                $bul = 'Juni';
            } elseif ($bulan == 7) {
                $bul = 'Juli';
            } elseif ($bulan == 8) {
                $bul = 'Agustus';
            } elseif ($bulan == 9) {
                $bul = 'September';
            } elseif ($bulan == 10) {
                $bul = 'Oktober';
            } elseif ($bulan == 11) {
                $bul = 'November';
            } elseif ($bulan == 12) {
                $bul = 'Desember';
            }
            $excel->setActiveSheetIndex(0)->setCellValue('C3', $bul . ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 3) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 1) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tanggal);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        }


        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "NO TRANSAKSI");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "KODE BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "HARGA");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "NAMA PELANGGAN");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "JUMLAH RETUR");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "TANGGAL RETUR");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya

        if ($filter == '3') {
            $retur = $this->db->query("SELECT r.*, p.kode_pel, p.nama_pel FROM tb_retur_penjualan r LEFT JOIN tb_pelanggan p ON p.kode_pel = r.kode_pelanggan WHERE r.token='$token' AND YEAR(r.tgl_beli)='$tahun' ORDER BY r.id_retur_penjualan DESC");
        } elseif ($filter == '2') {
            $retur = $this->db->query("SELECT r.*, p.kode_pel, p.nama_pel FROM tb_retur_penjualan r LEFT JOIN tb_pelanggan p ON p.kode_pel = r.kode_pelanggan WHERE r.token='$token' AND MONTH(r.tgl_beli)='$bulan' AND YEAR(r.tgl_beli)='$tahun' ORDER BY r.id_retur_penjualan");
        } elseif ($filter == '1') {
            $retur = $this->db->query("SELECT r.*, p.kode_pel, p.nama_pel FROM tb_retur_penjualan r LEFT JOIN tb_pelanggan p ON p.kode_pel = r.kode_pelanggan WHERE r.token='$token' AND r.tgl_beli='$tanggal' ORDER BY r.id_retur_penjualan");
        } elseif ($filter == 'semua') {
            $retur = $this->db->query("SELECT r.*, p.kode_pel, p.nama_pel FROM tb_retur_penjualan r LEFT JOIN tb_pelanggan p ON p.kode_pel = r.kode_pelanggan WHERE r.token='$token'");
        }

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        $tot = 0;
        if ($retur->num_rows() > 0) {
            foreach ($retur->result() as $data) { // Lakukan looping pada variabel siswa

                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->no_transaksi);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->kode_barang);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->harga);
                if ($data->kode_pelanggan == NULL) {
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, 'Umum');
                } else {
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nama_pel);
                }
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->jml_retur);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->tgl_beli);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
                $tot += $data->jml_retur;
            }
            $excel->setActiveSheetIndex(0)->setCellValue('I4', "TOTAL RETUR");
            $excel->getActiveSheet()->mergeCells('I5:I6');
            $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
            $excel->setActiveSheetIndex(0)->setCellValue('I5', $tot);
            $excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I6')->applyFromArray($style_row);
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A5', "----------- Tidak Ada Data -----------");
            $excel->getActiveSheet()->mergeCells('A5:G5');
            $excel->getActiveSheet()->getStyle('A5')->getFont()->setItalic(TRUE);
            $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_row);
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(25); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Retur Customer");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Laporan Retur Customer';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function pembelian()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Laporan Keuntungan';

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
        $data['tahun'] = $this->db->query("SELECT timee, token FROM tb_detail_pembelian WHERE token='$token' GROUP BY year(timee)")->result_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['pembelian'] = $this->Laporan_model->cariPembelian();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/pembelian', $data);
        $this->load->view('templates/footer');
    }

    public function export_pembelian()
    {

        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('MFZ')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Data Pembelian Barang")
            ->setSubject("Pembelian")
            ->setDescription("Laporan Pembelian Barang")
            ->setKeywords("Pembelian Barang");

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

        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');

        $akses = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PEMBELIAN BARANG");
        $excel->getActiveSheet()->mergeCells('A1:J1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "PERIODE");
        $excel->getActiveSheet()->mergeCells('A3:B3');
        $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $filter = $this->input->post('filter');
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);

        if ($filter == 'semua') {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', 'Semua Data Periode');
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 2) {
            if ($bulan == 1) {
                $bul = 'Januari';
            } elseif ($bulan == 2) {
                $bul = 'Februari';
            } elseif ($bulan == 3) {
                $bul = 'Maret';
            } elseif ($bulan == 4) {
                $bul = 'April';
            } elseif ($bulan == 5) {
                $bul = 'Mei';
            } elseif ($bulan == 6) {
                $bul = 'Juni';
            } elseif ($bulan == 7) {
                $bul = 'Juli';
            } elseif ($bulan == 8) {
                $bul = 'Agustus';
            } elseif ($bulan == 9) {
                $bul = 'September';
            } elseif ($bulan == 10) {
                $bul = 'Oktober';
            } elseif ($bulan == 11) {
                $bul = 'November';
            } elseif ($bulan == 12) {
                $bul = 'Desember';
            }
            $excel->setActiveSheetIndex(0)->setCellValue('C3', $bul . ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 3) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 1) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tanggal);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 4) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tgl_awal . ' sampai ', $tgl_akhir);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        }


        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "SUPPLIER");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "KODE BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "NAMA BARANG");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "ITEM");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "HARGA");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "SUB TOTAL");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $token = $this->session->userdata('token');
        if ($filter == '3') {
            $pembelian = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND YEAR(p.timestmp)='$tahun' ORDER BY p.timestmp DESC");
        } elseif ($filter == '2') {
            $pembelian = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND MONTH(p.timestmp)='$bulan' AND YEAR(p.timestmp)='$tahun'  ORDER BY p.timestmp DESC");
        } elseif ($filter == 'semua') {
            $pembelian = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' ORDER BY p.timestmp DESC");
        } elseif ($filter == '1') {
            $pembelian = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND p.tgl_transaksi='$tanggal' ORDER BY p.timestmp DESC");
        } elseif ($filter == '4') {
            $pembelian = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, p.token FROM tb_pembelian p WHERE p.token = '$token' AND p.tgl_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY p.timestmp DESC");
        }

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        $ttl2 = 0;
        if ($pembelian->num_rows() > 0) {
            foreach ($pembelian->result() as $pem) { // Lakukan looping pada variabel siswa
                $sup = $this->db->get_where('tb_supplier', ['kode_sup' => $pem->kd_supplier, 'token' => $pem->token])->row();

                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->getActiveSheet()->getStyle('A' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $sup->kode_sup . ' - ' . $sup->nama_toko);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                // $excel->getActiveSheet()->mergeCells('C'.$numrow.':G'.$numrow);

                $sub = $this->db->query("SELECT p.kd_supplier, p.id_pembelian, d.no_faktur, d.kode_barang, d.harga_beli, d.jumlah, b.nama_barang, b.kode_barang as kode FROM tb_pembelian p INNER JOIN tb_detail_pembelian d ON d.no_faktur=p.id_pembelian INNER JOIN tb_barang b ON b.kode_barang=d.kode_barang WHERE p.kd_supplier='$sup->kode_sup' AND d.no_faktur='$pem->id_pembelian' ORDER BY d.timee DESC");
                $count = $sub->num_rows() + $numrow;

                $ttl1 = 0;
                foreach ($sub->result() as $data) {
                    $dsa = $numrow;
                    $sub_total = $data->harga_beli * $data->jumlah;
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $dsa, $data->kode_barang);
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $dsa, $data->nama_barang);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $dsa, $data->jumlah);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $dsa, $data->harga_beli);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $dsa, $sub_total);

                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

                    $numrow++; // Tambah 1 setiap kali looping
                    $ttl1 += $sub_total;
                }

                $excel->getActiveSheet()->mergeCells('A' . $numrow . ':D' . $numrow);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, 'TOTAL PEMBELIAN');
                $excel->getActiveSheet()->mergeCells('E' . $numrow . ':F' . $numrow);
                $excel->getActiveSheet()->getStyle('E' . $numrow . ':F' . $numrow)->getFont()->setBold(TRUE);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $ttl1);
                $excel->getActiveSheet()->getStyle('G' . $numrow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
                $excel->getActiveSheet()->getStyle('G' . $numrow)->getFont()->setBold(TRUE);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
                $ttl2 += $ttl1;
            }
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A5', "----------- Tidak Ada Data -----------");
            $excel->getActiveSheet()->mergeCells('A5:G5');
            $excel->getActiveSheet()->getStyle('A5')->getFont()->setItalic(TRUE);
            $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_row);
        }

        $excel->setActiveSheetIndex(0)->setCellValue('I4', "TOTAL");
        $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
        $excel->setActiveSheetIndex(0)->setCellValue('I5', $ttl2);
        $excel->getActiveSheet()->getStyle('I5')->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
        $excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->mergeCells('I5:I6');
        $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('I6')->applyFromArray($style_row);

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(35); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(35); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); // Set width kolom G
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom G

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Pembelian Barang");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Laporan Pembelian Barang';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
