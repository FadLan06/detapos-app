<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Supplier extends CI_Controller
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
        $data['judul'] = 'Data Supplier';
        $token = $data['user']['token'];
        $data['supplier'] = $this->db->get_where('tb_supplier', ['token' => $token])->result();

        $query = $this->db->get_where('user_menu', ['menu' => $this->uri->segment(1)])->row_array();
        $menu_id = $query['id'];
        $data['akses'] = $this->db->get_where('user_access_menu', ['role_id' => $this->session->userdata('token'), 'role' => $this->session->userdata('role_id'), 'user_id' => $this->session->userdata('id'), 'menu_id' => $menu_id])->row();

        $this->load->view('templates/header', $data);
        $this->load->view('supplier/index', $data);
        $this->load->view('templates/footer');
    }

    function aksi()
    {
        if (isset($_POST['smpn'])) {
            $kode_sup = htmlspecialchars($this->input->post('kode_sup'));
            $token = $this->session->userdata('token');

            $query = $this->db->get_where('tb_supplier', ['token' => $token, 'kode_sup' => $kode_sup])->num_rows();
            $query1 = $this->db->get_where('tb_supplier', ['token' => $token, 'kode_sup' => $kode_sup])->row();

            if (($query > 0) and ($kode_sup == $query1->kode_sup)) {
                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Gagal tambah data supplier, Kode Supplier sudah tersedia!'); </script>";
                }
                echo "<script>window.location='" . site_url('Supplier/Tambah_Supplier') . "';</script>";
            } else {
                $data = [
                    'kode_sup' => htmlspecialchars($this->input->post('kode_sup')),
                    'nama_toko' => htmlspecialchars($this->input->post('nama_toko')),
                    'alamat' => htmlspecialchars($this->input->post('alamat')),
                    'telpon' => htmlspecialchars($this->input->post('telpon')),
                    'email' => htmlspecialchars($this->input->post('email')),
                    'provinsi' => htmlspecialchars($this->input->post('provinsi')),
                    'kota' => htmlspecialchars($this->input->post('kota')),
                    'token' => htmlspecialchars($this->session->userdata('token'))
                ];

                $this->db->insert('tb_supplier', $data);

                if ($this->db->affected_rows() > 0) {
                    echo "<script>alert('Data Supplier Berhasil di Tambahkan!'); </script>";
                }
                echo "<script>window.location='" . site_url('Supplier') . "';</script>";
            }
        } elseif (isset($_POST['ubah'])) {
            $data = [
                'nama_toko' => htmlspecialchars($this->input->post('nama_toko')),
                'alamat' => htmlspecialchars($this->input->post('alamat')),
                'telpon' => htmlspecialchars($this->input->post('telpon')),
                'email' => htmlspecialchars($this->input->post('email')),
                'provinsi' => htmlspecialchars($this->input->post('provinsi')),
                'kota' => htmlspecialchars($this->input->post('kota')),
            ];

            $this->db->where('kd_supplier', htmlspecialchars($this->input->post('kd_supplier')));
            $this->db->update('tb_supplier', $data);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Supplier Berhasil di Ubah!'); </script>";
            }
            echo "<script>window.location='" . site_url('Supplier') . "';</script>";
        }
    }

    public function ubah_supplier($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Ubah Data Supplier';
        $token = $this->session->userdata('token');
        $data['data'] = $this->db->get_where('tb_supplier', ['kd_supplier' => $id, 'token' => $token])->row();

        $this->db->where('id_prov!=', 0);
        $this->db->order_by('nama', 'ASC');
        $data['provinsi'] = $this->db->get_where('tb_provinsi')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('supplier/ubah_supplier', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_supplier()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Tambah Data Supplier';
        $token = $this->session->userdata('token');

        $this->db->where('id_prov!=', 0);
        $this->db->order_by('nama', 'ASC');
        $data['provinsi'] = $this->db->get_where('tb_provinsi')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('supplier/tambah_supplier', $data);
        $this->load->view('templates/footer');
    }


    function hapus($id)
    {
        $this->db->where('kd_supplier', $id);
        $this->db->delete('tb_supplier');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Data Supplier Berhasil di Hapus!'); </script>";
        }
        echo "<script>window.location='" . site_url('Supplier') . "';</script>";
    }

    public function cetak_supplier()
    {
        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tanggal') || $this->input->post('bulan') || $this->input->post('tahun') || $this->input->post('filter')) {
            $data['supp'] = $this->Laporan_model->cariSupplier();
        }

        $this->load->view('supplier/cetak_supplier', $data);
    }

    function ambil_kota()
    {
        $modul = $this->input->post('modul');
        $id = $this->input->post('id');

        if ($modul == "kabupaten") {
            echo $this->Data_model->kabupaten($id);
        }
    }

    public function export()
    {
        // Panggil class PHPExcel nya
        $excel = new Spreadsheet;

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('MFZ')
            ->setLastModifiedBy('Detapos Lite')
            ->setTitle("Data Supplier")
            ->setSubject("Supplier")
            ->setDescription("Report Supplier")
            ->setKeywords("Supplier");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT DATA SUPPLIER");
        $excel->getActiveSheet()->mergeCells('A1:G1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "KODE SUPPLIER");
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "NAMA SUPPLIER");
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "EMAIL");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "NOMOR TELPON");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "ALAMAT");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "COUNT");

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
        $hari = $this->db->get_where('tb_supplier', ['token' => $token]);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        $tot = 0;
        if ($hari->num_rows() > 0) {
            foreach ($hari->result() as $data) { // Lakukan looping pada variabel siswa
                $coun = $this->db->query("SELECT COUNT(kd_supplier) as pem FROM tb_pembelian WHERE kd_supplier='$data->kode_sup'")->row();

                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->kode_sup);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_toko);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->email);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->telpon);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->alamat);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $coun->pem . ' Kali');

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

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(35); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(10); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Report Data Supplier");
        $excel->setActiveSheetIndex(0);

        $writer = new Xlsx($excel);

        $title = 'Report Data Supplier';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
