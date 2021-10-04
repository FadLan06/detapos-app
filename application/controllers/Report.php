<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        $this->load->model('Report_model');
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Report Barang';

        $token = $this->session->userdata('token');
        $data['tahun'] = $this->db->query("SELECT tgl_penjualan, token FROM tb_detail_penjualan WHERE token='$token' GROUP BY year(tgl_penjualan)")->result_array();

        if ($this->input->post('bulan') || $this->input->post('bulan1') || $this->input->post('tahun') || $this->input->post('filter') || $this->input->post('barang')) {
            $data['barang'] = $this->Report_model->cari();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('barang/report', $data);
        $this->load->view('templates/footer');
    }

    function barang()
    {
        if (isset($_GET['term'])) {
            $result = $this->Report_model->getAuto($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label'  => $row->kode_barang . ' / ' . $row->nama_barang,
                        'value'  => $row->kode_barang,
                    );
                echo json_encode($arr_result);
            }
        }
    }

    public function cetak()
    {
        $token = $this->session->userdata('token');
        $role = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id');
        $bulan = $this->input->post('bulan');
        $bulan1 = $this->input->post('bulan1');
        $tahun = $this->input->post('tahun');
        $barang = $this->input->post('barang');

        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($_POST['filter'] == 'semua') {
            $data['barang'] = $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' GROUP BY b.kode_barang, b.harga_jual ORDER BY kty DESC");
        } elseif ($_POST['filter'] == 2) {
            $data['barang'] = $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty, MONTH(p.timee) as bulan, YEAR(p.timee) as tahun FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' AND MONTH(p.timee) BETWEEN '$bulan' AND '$bulan1' AND YEAR(p.timee)='$tahun' AND b.kode_barang='$barang' GROUP BY b.kode_barang, b.harga_jual, MONTH(p.timee) ORDER BY kty DESC");
        } elseif ($_POST['filter'] == 1) {
            $data['barang'] = $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' AND MONTH(p.timee)='$bulan' AND YEAR(p.timee)='$tahun' GROUP BY b.kode_barang, b.harga_jual ORDER BY kty DESC");
        } elseif ($_POST['filter'] == 3) {
            $data['barang'] = $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' AND YEAR(p.timee)='$tahun' GROUP BY b.kode_barang, b.harga_jual ORDER BY kty DESC");
        }
        $this->load->view('barang/cetak_report', $data);
    }

    public function export()
    {

        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('MFZ')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Report Barang")
            ->setSubject("Report")
            ->setDescription("Laporan Report Barang")
            ->setKeywords("Report Barang");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN REPORT BARANG");
        $excel->getActiveSheet()->mergeCells('A1:K1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "PERIODE");
        $excel->getActiveSheet()->mergeCells('A3:B3');
        $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $bulan = $this->input->post('bulan');
        $bulan1 = $this->input->post('bulan1');
        $tahun = $this->input->post('tahun');
        $filter = $this->input->post('filter');
        $barang = $this->input->post('barang');

        if ($filter == 'semua') {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', 'Semua Data Periode');
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 1) {
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
            if ($bulan1 == 1) {
                $bul1 = 'Januari';
            } elseif ($bulan1 == 2) {
                $bul1 = 'Februari';
            } elseif ($bulan1 == 3) {
                $bul1 = 'Maret';
            } elseif ($bulan1 == 4) {
                $bul1 = 'April';
            } elseif ($bulan1 == 5) {
                $bul1 = 'Mei';
            } elseif ($bulan1 == 6) {
                $bul1 = 'Juni';
            } elseif ($bulan1 == 7) {
                $bul1 = 'Juli';
            } elseif ($bulan1 == 8) {
                $bul1 = 'Agustus';
            } elseif ($bulan1 == 9) {
                $bul1 = 'September';
            } elseif ($bulan1 == 10) {
                $bul1 = 'Oktober';
            } elseif ($bulan1 == 11) {
                $bul1 = 'November';
            } elseif ($bulan1 == 12) {
                $bul1 = 'Desember';
            }
            $excel->setActiveSheetIndex(0)->setCellValue('C3', $bul . ' sampai ' . $bul1 . ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        } elseif ($filter == 3) {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', ' ' . $tahun);
            $excel->getActiveSheet()->mergeCells('C3:E3');
        }


        if ($filter == 2) {
            // Buat header tabel nya pada baris ke 4
            $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('B4', "BULAN / TAHUN");
            $excel->setActiveSheetIndex(0)->setCellValue('C4', "KODE / NAMA BARANG");
            $excel->setActiveSheetIndex(0)->setCellValue('D4', "TERJUAL");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        } else {
            // Buat header tabel nya pada baris ke 4
            $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('B4', "KODE BARANG");
            $excel->setActiveSheetIndex(0)->setCellValue('C4', "NAMA BARANG");
            $excel->setActiveSheetIndex(0)->setCellValue('D4', "HARGA JUAL");
            $excel->setActiveSheetIndex(0)->setCellValue('E4', "TERJUAL");
            $excel->setActiveSheetIndex(0)->setCellValue('F4', "SISA STOK");
            $excel->setActiveSheetIndex(0)->setCellValue('G4', "SUB TOTAL");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        }

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $token = $this->session->userdata('token');
        if ($filter == '3') {
            $ken = $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' AND YEAR(p.timee)='$tahun' GROUP BY b.kode_barang, b.harga_jual ORDER BY kty DESC");
        } elseif ($filter == '2') {
            $ken = $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty, MONTH(p.timee) as bulan, YEAR(p.timee) as tahun FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' AND MONTH(p.timee) BETWEEN '$bulan' AND '$bulan1' AND YEAR(p.timee)='$tahun' AND b.kode_barang='$barang' GROUP BY b.kode_barang, b.harga_jual, MONTH(p.timee) ORDER BY kty DESC");
        } elseif ($filter == '1') {
            $ken = $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' AND MONTH(p.timee)='$bulan' AND YEAR(p.timee)='$tahun' GROUP BY b.kode_barang, b.harga_jual ORDER BY kty DESC");
        } elseif ($filter == 'semua') {
            $ken = $this->db->query("SELECT *, b.kode_barang as kode, SUM(p.qty*b.harga_jual) as sub_total, SUM(p.qty) as kty FROM tb_barang b LEFT JOIN tb_detail_penjualan p ON p.kode_barang = b.kode_barang WHERE b.token='$token' GROUP BY b.kode_barang, b.harga_jual ORDER BY kty DESC");
        }

        if ($filter != 2) {
            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
            $ttl_terjual = 0;
            $ttl_keuntungan = 0;
            $ttl_pot = 0;
            if ($ken->num_rows() > 0) {
                foreach ($ken->result() as $data) { // Lakukan looping pada variabel siswa

                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->kode);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_barang);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->harga_jual);
                    if ($data->kty == '') {
                        $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, '0');
                    } else {
                        $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->kty);
                    }
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->jml_stok);
                    if ($data->sub_total == '') {
                        $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, '0');
                    } else {
                        $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->sub_total);
                    }

                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->getNumberFormat()->setFormatCode('_("Rp."* #,##0_);_("Rp."* \(#,##0\);_("Rp."* "-"??_);_(@_)');
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->getNumberFormat()->setFormatCode('_("Rp."* #,##0_);_("Rp."* \(#,##0\);_("Rp."* "-"??_);_(@_)');

                    $no++; // Tambah 1 setiap kali looping
                    $numrow++; // Tambah 1 setiap kali looping
                    $ttl_terjual += $data->harga_jual;
                    $ttl_pot += $data->kty;
                    $ttl_keuntungan += $data->sub_total;
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

            $excel->setActiveSheetIndex(0)->setCellValue('I4', "TOTAL JUAL");
            $excel->setActiveSheetIndex(0)->setCellValue('J4', "TOTAL TERJUAL");
            $excel->setActiveSheetIndex(0)->setCellValue('K4', "TOTAL KEUNTUNGAN");
            $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
            $excel->setActiveSheetIndex(0)->setCellValue('I5', $ttl_terjual);
            $excel->getActiveSheet()->getStyle('I5')->getNumberFormat()->setFormatCode('_("Rp."* #,##0_);_("Rp."* \(#,##0\);_("Rp."* "-"??_);_(@_)');
            $excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $excel->setActiveSheetIndex(0)->setCellValue('J5', $ttl_pot);
            $excel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $excel->setActiveSheetIndex(0)->setCellValue('K5', $ttl_keuntungan);
            $excel->getActiveSheet()->getStyle('K5')->getNumberFormat()->setFormatCode('_("Rp."* #,##0_);_("Rp."* \(#,##0\);_("Rp."* "-"??_);_(@_)');
            $excel->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()->mergeCells('I5:I6');
            $excel->getActiveSheet()->mergeCells('J5:J6');
            $excel->getActiveSheet()->mergeCells('K5:K6');
            $excel->getActiveSheet()->getStyle('I5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I6')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J6')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K6')->applyFromArray($style_row);

            // Set width kolom
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // Set width kolom E
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom F
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom G
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(10); // Set width kolom G
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom G
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20); // Set width kolom G
            $excel->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom G
        } else {
            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
            $ttl = 0;
            if ($ken->num_rows() > 0) {
                foreach ($ken->result() as $data) { // Lakukan looping pada variabel siswa
                    if ($data->bulan == 1) {
                        $bul = 'Januari';
                    } elseif ($data->bulan == 2) {
                        $bul = 'Februari';
                    } elseif ($data->bulan == 3) {
                        $bul = 'Maret';
                    } elseif ($data->bulan == 4) {
                        $bul = 'April';
                    } elseif ($data->bulan == 5) {
                        $bul = 'Mei';
                    } elseif ($data->bulan == 6) {
                        $bul = 'Juni';
                    } elseif ($data->bulan == 7) {
                        $bul = 'Juli';
                    } elseif ($data->bulan == 8) {
                        $bul = 'Agustus';
                    } elseif ($data->bulan == 9) {
                        $bul = 'September';
                    } elseif ($data->bulan == 10) {
                        $bul = 'Oktober';
                    } elseif ($data->bulan == 11) {
                        $bul = 'November';
                    } elseif ($data->bulan == 12) {
                        $bul = 'Desember';
                    }
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $bul . ' ' . $data->tahun);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->kode_barang . ' / ' . $data->nama_barang);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    if ($data->kty == '') {
                        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, '0');
                    } else {
                        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->kty);
                    }

                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);

                    $no++; // Tambah 1 setiap kali looping
                    $numrow++; // Tambah 1 setiap kali looping
                    $ttl += $data->kty;
                }
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('A5', "----------- Tidak Ada Data -----------");
                $excel->getActiveSheet()->mergeCells('A5:D5');
                $excel->getActiveSheet()->getStyle('A5')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_row);
            }

            $excel->setActiveSheetIndex(0)->setCellValue('F4', "TOTAL JUAL");
            $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
            $excel->setActiveSheetIndex(0)->setCellValue('F5', $ttl);
            $excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()->mergeCells('F5:F6');
            $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F6')->applyFromArray($style_row);

            // Set width kolom
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // Set width kolom E
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom F
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Report Barang");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Laporan Report Barang';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
