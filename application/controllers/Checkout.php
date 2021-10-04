<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->model('Akuntansi_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function view($token, $kota, $slug)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Checkout';
        // $slug = decrypt_url($slug);

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('no_wa', 'Nomor HP/Whatsapp', 'required|numeric|min_length[11]|max_length[15]', ['numeric' => 'Field Nomor hanya boleh berisi angka', 'min_length' => 'Field Nomor harus panjangnya minimal 11 karakter', 'max_length' => 'Field Nomor tidak boleh melebihi panjang 15 karakter']);
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('kota', 'Kota/Kabupaten', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('ekspedisi', 'Expedisi', 'required');
        $this->form_validation->set_rules('paket', 'Paket', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('kode_pos', 'Kode POS', 'required|numeric', ['numeric' => 'Field Kode POS hanya boleh berisi angka']);

        if ($this->form_validation->run() == FALSE) {
            $data['barang'] = $this->db->get_where('tb_barang', ['slug' => $slug, 'token' => $token])->row();
            $data['rekening'] = $this->db->get_where('tb_rekening', ['token' => $token])->result_array();
            $data['set'] = $this->db->get_where('setting_app', ['token' => $token])->row();
            $this->db->order_by('kode_barang', 'asc');
            $data['gambar'] = $this->db->get_where('tb_barang_tmp', ['slug' => $slug, 'token' => $token])->result();

            $this->load->view('orders/checkout', $data);
        } else {
            if (isset($_POST['beli'])) {

                date_default_timezone_set('Asia/Jakarta');
                $order_id = htmlspecialchars($this->input->post('order_id'));

                $data = [
                    'order_id'      =>  htmlspecialchars($this->input->post('order_id')),
                    'kode_barang'   =>  htmlspecialchars($this->input->post('kode_barang')),
                    'nama_barang'   =>  htmlspecialchars($this->input->post('nama_barang')),
                    'harga_jual'    =>  htmlspecialchars($this->input->post('harga_jual')),
                    'qty'           =>  htmlspecialchars($this->input->post('qty')),
                    'total'         =>  htmlspecialchars($this->input->post('total')),
                    'kode_unik'     =>  htmlspecialchars($this->input->post('kode_unik')),
                    'nama_lengkap'  =>  htmlspecialchars($this->input->post('nama_lengkap')),
                    'no_wa'         =>  htmlspecialchars($this->input->post('no_wa')),
                    'email'         =>  htmlspecialchars($this->input->post('email')),
                    'provinsi'      =>  htmlspecialchars($this->input->post('provinsi')),
                    'kota'          =>  htmlspecialchars($this->input->post('kota')),
                    'kecamatan'     =>  htmlspecialchars($this->input->post('kecamatan')),
                    'ekspedisi'     =>  htmlspecialchars($this->input->post('ekspedisi')),
                    'paket'         =>  htmlspecialchars($this->input->post('paket')),
                    'ongkir'        =>  htmlspecialchars($this->input->post('ongkir')),
                    'estimasi'      =>  htmlspecialchars($this->input->post('estimasi')),
                    'gran_total'    =>  htmlspecialchars($this->input->post('total_bayar')),
                    'berat'         =>  htmlspecialchars($this->input->post('berat')),
                    'alamat'        =>  htmlspecialchars($this->input->post('alamat')),
                    'kode_pos'      =>  htmlspecialchars($this->input->post('kode_pos')),
                    'status'        =>  1,
                    'waktu'         =>  date('Y-m-d H:i:s'),
                    'token'         =>  htmlspecialchars($this->input->post('token')),
                ];

                $this->_send('verify', $token);
                $this->db->insert('tb_checkout', $data);

                redirect('detail/' . $token . '/' . $order_id);
            }
        }
    }

    public function kirim($token, $kota, $slug)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Checkout';
        // $slug = decrypt_url($slug);

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('no_wa', 'Nomor HP/Whatsapp', 'required|numeric|min_length[11]|max_length[15]', ['numeric' => 'Field Nomor hanya boleh berisi angka', 'min_length' => 'Field Nomor harus panjangnya minimal 11 karakter', 'max_length' => 'Field Nomor tidak boleh melebihi panjang 15 karakter']);
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $data['barang'] = $this->db->get_where('tb_barang', ['slug' => $slug, 'token' => $token])->row();
            $data['rekening'] = $this->db->get_where('tb_rekening', ['token' => $token])->result_array();
            $data['set'] = $this->db->get_where('setting_app', ['token' => $token])->row();
            $this->db->order_by('kode_barang', 'asc');
            $data['gambar'] = $this->db->get_where('tb_barang_tmp', ['slug' => $slug, 'token' => $token])->result();

            $this->load->view('orders/chk', $data);
        } else {
            if (isset($_POST['beli1'])) {

                date_default_timezone_set('Asia/Jakarta');
                $order_id = htmlspecialchars($this->input->post('order_id'));

                $data = [
                    'order_id'      =>  htmlspecialchars($this->input->post('order_id')),
                    'kode_barang'   =>  htmlspecialchars($this->input->post('kode_barang')),
                    'nama_barang'   =>  htmlspecialchars($this->input->post('nama_barang')),
                    'harga_jual'    =>  htmlspecialchars($this->input->post('harga_jual')),
                    'qty'           =>  htmlspecialchars($this->input->post('qty')),
                    'total'         =>  htmlspecialchars($this->input->post('total')),
                    'gran_total'    =>  htmlspecialchars($this->input->post('total')),
                    'kode_unik'     =>  htmlspecialchars($this->input->post('kode_unik')),
                    'nama_lengkap'  =>  htmlspecialchars($this->input->post('nama_lengkap')),
                    'no_wa'         =>  htmlspecialchars($this->input->post('no_wa')),
                    'email'         =>  htmlspecialchars($this->input->post('email')),
                    'id_akun'      =>  htmlspecialchars($this->input->post('id_akun')),
                    'status'        =>  1,
                    'waktu'         =>  date('Y-m-d H:i:s'),
                    'keterangan'      =>  htmlspecialchars($this->input->post('keterangan')),
                    'token'         =>  htmlspecialchars($this->input->post('token')),
                ];

                $this->_sendd('verify', $token);
                $this->db->insert('tb_checkout', $data);

                redirect('detail/' . $token . '/' . $order_id);
            }
        }
    }

    private function _send($type, $token)
    {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'email-smtp.us-east-1.amazonaws.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'AKIA5K3LOZDQ6NLOVIVI';
        $mail->Password = 'BFEN2KI7nEhIffG1Qxt0E1MS4XxPDQKw4Fwl3TcyIvbf';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('admin@detapos.co.id', 'Admin Detapos');

        // Add a recipient
        $mail->addAddress($this->input->post('email'), $this->input->post('nama_lengkap'));

        // Email subject
        $mail->Subject = 'Pesanan anda kami telah terima - #' . $this->input->post('order_id') . '';

        // Set email format to HTML
        $mail->isHTML(true);

        $rek = $this->db->get_where('tb_rekening', ['token' => $token]);
        $dt = $rek->num_rows();

        if ($dt == '1') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        } else if ($dt == '2') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js2') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr2') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an2') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        } else if ($dt == '3') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js2') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr2') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an2') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js3') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr3') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an3') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        } else if ($dt == '4') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js2') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr2') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an2') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js3') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr3') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an3') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js4') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr4') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an4') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        }

        // Email body content
        $mailContent = "
            <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml'>
            
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                <meta name='x-apple-disable-message-reformatting' />
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <meta name='color-scheme' content='light dark' />
                <meta name='supported-color-schemes' content='light dark' />
                <title></title>
                <style type='text/css' rel='stylesheet' media='all'>
                    /* Base ------------------------------ */
            
                    @import url('https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap');
            
                    body {
                        width: 100% !important;
                        height: 100%;
                        margin: 0;
                        -webkit-text-size-adjust: none;
                    }
            
                    a {
                        color: #3869D4;
                    }
            
                    a img {
                        border: none;
                    }
            
                    td {
                        word-break: break-word;
                    }
            
                    .preheader {
                        display: none !important;
                        visibility: hidden;
                        /* mso-hide: all; */
                        font-size: 1px;
                        line-height: 1px;
                        max-height: 0;
                        max-width: 0;
                        opacity: 0;
                        overflow: hidden;
                    }
            
                    /* Type ------------------------------ */
            
                    body,
                    td,
                    th {
                        font-family: 'Nunito Sans', Helvetica, Arial, sans-serif;
                    }
            
                    h1 {
                        margin-top: 0;
                        color: #333333;
                        font-size: 18px;
                        font-weight: bold;
                        text-align: center;
                    }
            
                    h2 {
                        margin-top: 0;
                        color: #333333;
                        font-size: 12px;
                        font-weight: bold;
                        text-align: left;
                    }
            
                    h3 {
                        margin-top: 0;
                        color: #333333;
                        font-size: 10px;
                        font-weight: bold;
                        text-align: left;
                    }
            
                    td,
                    th {
                        font-size: 12px;
                    }
            
                    p,
                    ul,
                    ol,
                    blockquote {
                        margin: .4em 0 1.1875em;
                        font-size: 12px;
                        line-height: 1.625;
                    }
            
                    p.sub {
                        font-size: 10px;
                    }
            
                    /* Utilities ------------------------------ */
            
                    .align-right {
                        text-align: right;
                    }
            
                    .align-left {
                        text-align: left;
                    }
            
                    .align-center {
                        text-align: center;
                    }
            
                    /* Buttons ------------------------------ */
            
                    .button {
                        background-color: #3869D4;
                        border-top: 10px solid #3869D4;
                        border-right: 18px solid #3869D4;
                        border-bottom: 10px solid #3869D4;
                        border-left: 18px solid #3869D4;
                        display: inline-block;
                        color: #FFF;
                        text-decoration: none;
                        border-radius: 3px;
                        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                        -webkit-text-size-adjust: none;
                        box-sizing: border-box;
                    }
            
                    .button--green {
                        background-color: #22BC66;
                        border-top: 10px solid #22BC66;
                        border-right: 18px solid #22BC66;
                        border-bottom: 10px solid #22BC66;
                        border-left: 18px solid #22BC66;
                    }
            
                    .button--red {
                        background-color: #ea323c;
                        border-top: 10px solid #ea323c;
                        border-right: 18px solid #ea323c;
                        border-bottom: 10px solid #ea323c;
                        border-left: 18px solid #ea323c;
                    }
            
                    @media only screen and (max-width: 400px) {
                        .button {
                            width: 100% !important;
                            text-align: center !important;
                        }
                    }
            
                    /* Attribute list ------------------------------ */
            
                    .attributes {
                        margin: 0 0 0px;
                    }
            
                    .attributes_content {
                        background-color: #F4F4F7;
                        padding: 16px;
                    }
            
                    .attributes_item {
                        padding: 0;
                    }
            
                    /* Related Items ------------------------------ */
            
                    .related {
                        width: 100%;
                        margin: 0;
                        padding: 25px 0 0 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    .related_item {
                        padding: 10px 0;
                        color: #CBCCCF;
                        font-size: 12px;
                        line-height: 18px;
                    }
            
                    .related_item-title {
                        display: block;
                        margin: .5em 0 0;
                    }
            
                    .related_item-thumb {
                        display: block;
                        padding-bottom: 10px;
                    }
            
                    .related_heading {
                        border-top: 1px solid #CBCCCF;
                        text-align: center;
                        padding: 25px 0 10px;
                    }
            
                    /* Discount Code ------------------------------ */
            
                    .discount {
                        width: 100%;
                        margin: 0;
                        padding: 24px;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #F4F4F7;
                        border: 2px dashed #CBCCCF;
                    }
            
                    .discount_heading {
                        text-align: center;
                    }
            
                    .discount_body {
                        text-align: center;
                        font-size: 12px;
                    }
            
                    /* Social Icons ------------------------------ */
            
                    .social {
                        width: auto;
                    }
            
                    .social td {
                        padding: 0;
                        width: auto;
                    }
            
                    .social_icon {
                        height: 20px;
                        margin: 0 8px 10px 8px;
                        padding: 0;
                    }
            
                    /* Data table ------------------------------ */
            
                    .purchase {
                        width: 100%;
                        margin: 0;
                        padding: 35px 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    .purchase_content {
                        width: 100%;
                        margin: 0;
                        padding: 5px 0 0 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    .purchase_item {
                        padding: 10px 0;
                        color: #51545E;
                        font-size: 12px;
                        line-height: 18px;
                    }
            
                    .purchase_heading {
                        padding-bottom: 8px;
                        border-bottom: 1px solid #EAEAEC;
                    }
            
                    .purchase_heading p {
                        margin: 0;
                        color: #85878E;
                        font-size: 12px;
                    }
            
                    .purchase_footer {
                        padding-top: 15px;
                        border-top: 1px solid #EAEAEC;
                    }
            
                    .purchase_total {
                        margin: 0;
                        text-align: right;
                        font-weight: bold;
                        color: #333333;
                    }
            
                    .purchase_total--label {
                        padding: 0 15px 0 0;
                    }
            
                    body {
                        background-color: #F4F4F7;
                        color: #51545E;
                    }
            
                    p {
                        color: #51545E;
                    }
            
                    p.sub {
                        color: #6B6E76;
                    }
            
                    .email-wrapper {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #F4F4F7;
                    }
            
                    .email-content {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    /* Body ------------------------------ */
            
                    .email-body {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #FFFFFF;
                    }
            
                    .email-body_inner {
                        width: 570px;
                        margin: 0 auto;
                        padding: 0;
                        -premailer-width: 570px;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #FFFFFF;
                    }
            
                    .body-action {
                        width: 100%;
                        margin: 30px auto;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        text-align: center;
                    }
            
                    .body-sub {
                        margin-top: 25px;
                        padding-top: 25px;
                        border-top: 1px solid #EAEAEC;
                    }
            
                    .content-cell {
                        padding: 0px;
                    }
            
                    /*Media Queries ------------------------------ */
            
                    @media (prefers-color-scheme: dark) {
            
                        body,
                        .email-body,
                        .email-body_inner,
                        .email-content,
                        .email-wrapper,
            
                        p,
                        ul,
                        ol,
                        blockquote,
                        h1,
                        h2,
                        h3 {
                            color: #FFF !important;
                        }
            
                        .attributes_content,
                        .discount {
                            background-color: #222 !important;
                        }
            
                    }
            
                    /* :root {
                        color-scheme: light dark;
                        supported-color-schemes: light dark;
                    } */
                </style>
            </head>
            
            <body>
                <table class='email-wrapper' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                    <tr>
                        <td align='center'>
                            <table class='email-content' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                <!-- Email Body -->
                                <tr>
                                    <td class='email-body' width='100%' cellpadding='0' cellspacing='0'>
                                        <table class='email-body_inner' align='center' width='570' cellpadding='0' cellspacing='0' role='presentation'>
                                            <!-- Body content -->
                                            <tr>
                                                <td class='content-cell'>
                                                    <div class='f-fallback'>
                                                        <h1 align='center'>Terima Kasih Atas Pesanan Anda</h1>
                                                        <table class='attributes' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                            <tr>
                                                                <td class='attributes_content'>
                                                                    <table width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Order ID </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('order_id') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Nama </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('nama_lengkap') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Nomor Hp/WA </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('no_wa') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%' valign='top'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Alamat </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%' valign='top'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('alamat') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Provinsi </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('provinsi') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Kota/Kab </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('kota') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- Action -->
                                                        <table class='purchase' width='100%' cellpadding='0' cellspacing='0'>
                                                            <tr>
                                                                <td colspan='2'>
                                                                    <table class='purchase_content' width='100%' cellpadding='0' cellspacing='0'>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>" . $this->input->post('nama_barang') . "</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>Rp.  " . number_format($this->input->post('harga_jual')) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>QTY</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>" . $this->input->post('qty') . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback purchase_total'>Kode Unik</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback purchase_total'>- Rp. " . number_format($this->input->post('kode_unik')) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Total</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($this->input->post('total')) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Ongkir</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($this->input->post('ongkir')) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Total Bayar</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($this->input->post('total_bayar')) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p align='center'>Untuk menyelesaikan proses pembayaran, silahkan transfer sejumlah </p>
                                                        <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                            <tr>
                                                                <td align='center'>
                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                                                                        <tr>
                                                                            <td align='center'>
                                                                                <a href='' class='f-fallback button button--red'>Rp. " . number_format($this->input->post('total_bayar')) . "</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table> 
                                                        <p align='center'>Ke daftar rekening dibawah ini : </p>
                                                        " . $data . "
                                                        <p align='center'>Konfirmasi pembayaran anda ke : <a href='" . base_url() . "konfirmasi/" . $this->input->post('token') . "/" . $this->input->post('order_id') . "'> Form Konfirmasi Pembayaran </a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
            
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            
            </html>
        ";
        $mail->Body = $mailContent;

        // Send email
        if (!$mail->send()) {
            echo $mail->ErrorInfo;
            die;
        } else {
            return true;
        }
    }

    private function _sendd($type, $token)
    {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'email-smtp.us-east-1.amazonaws.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'AKIA5K3LOZDQ6NLOVIVI';
        $mail->Password = 'BFEN2KI7nEhIffG1Qxt0E1MS4XxPDQKw4Fwl3TcyIvbf';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('admin@detapos.co.id', 'Admin Detapos');

        // Add a recipient
        $mail->addAddress($this->input->post('email'), $this->input->post('nama_lengkap'));

        // Email subject
        $mail->Subject = 'Pesanan anda kami telah terima - #' . $this->input->post('order_id') . '';

        // Set email format to HTML
        $mail->isHTML(true);

        $rek = $this->db->get_where('tb_rekening', ['token' => $token]);
        $dt = $rek->num_rows();

        if ($dt == '1') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        } else if ($dt == '2') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js2') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr2') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an2') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        } else if ($dt == '3') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js2') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr2') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an2') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js3') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr3') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an3') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        } else if ($dt == '4') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js2') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr2') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an2') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js3') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr3') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an3') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js4') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr4') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an4') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        }

        // Email body content
        $mailContent = "
            <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml'>
            
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                <meta name='x-apple-disable-message-reformatting' />
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <meta name='color-scheme' content='light dark' />
                <meta name='supported-color-schemes' content='light dark' />
                <title></title>
                <style type='text/css' rel='stylesheet' media='all'>
                    /* Base ------------------------------ */
            
                    @import url('https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap');
            
                    body {
                        width: 100% !important;
                        height: 100%;
                        margin: 0;
                        -webkit-text-size-adjust: none;
                    }
            
                    a {
                        color: #3869D4;
                    }
            
                    a img {
                        border: none;
                    }
            
                    td {
                        word-break: break-word;
                    }
            
                    .preheader {
                        display: none !important;
                        visibility: hidden;
                        /* mso-hide: all; */
                        font-size: 1px;
                        line-height: 1px;
                        max-height: 0;
                        max-width: 0;
                        opacity: 0;
                        overflow: hidden;
                    }
            
                    /* Type ------------------------------ */
            
                    body,
                    td,
                    th {
                        font-family: 'Nunito Sans', Helvetica, Arial, sans-serif;
                    }
            
                    h1 {
                        margin-top: 0;
                        color: #333333;
                        font-size: 18px;
                        font-weight: bold;
                        text-align: center;
                    }
            
                    h2 {
                        margin-top: 0;
                        color: #333333;
                        font-size: 12px;
                        font-weight: bold;
                        text-align: left;
                    }
            
                    h3 {
                        margin-top: 0;
                        color: #333333;
                        font-size: 10px;
                        font-weight: bold;
                        text-align: left;
                    }
            
                    td,
                    th {
                        font-size: 12px;
                    }
            
                    p,
                    ul,
                    ol,
                    blockquote {
                        margin: .4em 0 1.1875em;
                        font-size: 12px;
                        line-height: 1.625;
                    }
            
                    p.sub {
                        font-size: 10px;
                    }
            
                    /* Utilities ------------------------------ */
            
                    .align-right {
                        text-align: right;
                    }
            
                    .align-left {
                        text-align: left;
                    }
            
                    .align-center {
                        text-align: center;
                    }
            
                    /* Buttons ------------------------------ */
            
                    .button {
                        background-color: #3869D4;
                        border-top: 10px solid #3869D4;
                        border-right: 18px solid #3869D4;
                        border-bottom: 10px solid #3869D4;
                        border-left: 18px solid #3869D4;
                        display: inline-block;
                        color: #FFF;
                        text-decoration: none;
                        border-radius: 3px;
                        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                        -webkit-text-size-adjust: none;
                        box-sizing: border-box;
                    }
            
                    .button--green {
                        background-color: #22BC66;
                        border-top: 10px solid #22BC66;
                        border-right: 18px solid #22BC66;
                        border-bottom: 10px solid #22BC66;
                        border-left: 18px solid #22BC66;
                    }
            
                    .button--red {
                        background-color: #ea323c;
                        border-top: 10px solid #ea323c;
                        border-right: 18px solid #ea323c;
                        border-bottom: 10px solid #ea323c;
                        border-left: 18px solid #ea323c;
                    }
            
                    @media only screen and (max-width: 400px) {
                        .button {
                            width: 100% !important;
                            text-align: center !important;
                        }
                    }
            
                    /* Attribute list ------------------------------ */
            
                    .attributes {
                        margin: 0 0 0px;
                    }
            
                    .attributes_content {
                        background-color: #F4F4F7;
                        padding: 16px;
                    }
            
                    .attributes_item {
                        padding: 0;
                    }
            
                    /* Related Items ------------------------------ */
            
                    .related {
                        width: 100%;
                        margin: 0;
                        padding: 25px 0 0 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    .related_item {
                        padding: 10px 0;
                        color: #CBCCCF;
                        font-size: 12px;
                        line-height: 18px;
                    }
            
                    .related_item-title {
                        display: block;
                        margin: .5em 0 0;
                    }
            
                    .related_item-thumb {
                        display: block;
                        padding-bottom: 10px;
                    }
            
                    .related_heading {
                        border-top: 1px solid #CBCCCF;
                        text-align: center;
                        padding: 25px 0 10px;
                    }
            
                    /* Discount Code ------------------------------ */
            
                    .discount {
                        width: 100%;
                        margin: 0;
                        padding: 24px;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #F4F4F7;
                        border: 2px dashed #CBCCCF;
                    }
            
                    .discount_heading {
                        text-align: center;
                    }
            
                    .discount_body {
                        text-align: center;
                        font-size: 12px;
                    }
            
                    /* Social Icons ------------------------------ */
            
                    .social {
                        width: auto;
                    }
            
                    .social td {
                        padding: 0;
                        width: auto;
                    }
            
                    .social_icon {
                        height: 20px;
                        margin: 0 8px 10px 8px;
                        padding: 0;
                    }
            
                    /* Data table ------------------------------ */
            
                    .purchase {
                        width: 100%;
                        margin: 0;
                        padding: 35px 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    .purchase_content {
                        width: 100%;
                        margin: 0;
                        padding: 5px 0 0 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    .purchase_item {
                        padding: 10px 0;
                        color: #51545E;
                        font-size: 12px;
                        line-height: 18px;
                    }
            
                    .purchase_heading {
                        padding-bottom: 8px;
                        border-bottom: 1px solid #EAEAEC;
                    }
            
                    .purchase_heading p {
                        margin: 0;
                        color: #85878E;
                        font-size: 12px;
                    }
            
                    .purchase_footer {
                        padding-top: 15px;
                        border-top: 1px solid #EAEAEC;
                    }
            
                    .purchase_total {
                        margin: 0;
                        text-align: right;
                        font-weight: bold;
                        color: #333333;
                    }
            
                    .purchase_total--label {
                        padding: 0 15px 0 0;
                    }
            
                    body {
                        background-color: #F4F4F7;
                        color: #51545E;
                    }
            
                    p {
                        color: #51545E;
                    }
            
                    p.sub {
                        color: #6B6E76;
                    }
            
                    .email-wrapper {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #F4F4F7;
                    }
            
                    .email-content {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    /* Body ------------------------------ */
            
                    .email-body {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #FFFFFF;
                    }
            
                    .email-body_inner {
                        width: 570px;
                        margin: 0 auto;
                        padding: 0;
                        -premailer-width: 570px;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #FFFFFF;
                    }
            
                    .body-action {
                        width: 100%;
                        margin: 30px auto;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        text-align: center;
                    }
            
                    .body-sub {
                        margin-top: 25px;
                        padding-top: 25px;
                        border-top: 1px solid #EAEAEC;
                    }
            
                    .content-cell {
                        padding: 0px;
                    }
            
                    /*Media Queries ------------------------------ */
            
                    @media (prefers-color-scheme: dark) {
            
                        body,
                        .email-body,
                        .email-body_inner,
                        .email-content,
                        .email-wrapper,
            
                        p,
                        ul,
                        ol,
                        blockquote,
                        h1,
                        h2,
                        h3 {
                            color: #FFF !important;
                        }
            
                        .attributes_content,
                        .discount {
                            background-color: #222 !important;
                        }
            
                    }
            
                    /* :root {
                        color-scheme: light dark;
                        supported-color-schemes: light dark;
                    } */
                </style>
            </head>
            
            <body>
                <table class='email-wrapper' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                    <tr>
                        <td align='center'>
                            <table class='email-content' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                <!-- Email Body -->
                                <tr>
                                    <td class='email-body' width='100%' cellpadding='0' cellspacing='0'>
                                        <table class='email-body_inner' align='center' width='570' cellpadding='0' cellspacing='0' role='presentation'>
                                            <!-- Body content -->
                                            <tr>
                                                <td class='content-cell'>
                                                    <div class='f-fallback'>
                                                        <h1 align='center'>Terima Kasih Atas Pesanan Anda</h1>
                                                        <table class='attributes' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                            <tr>
                                                                <td class='attributes_content'>
                                                                    <table width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Order ID </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('order_id') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Nama </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('nama_lengkap') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Nomor Hp/WA </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('no_wa') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%' valign='top'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>ID Akun </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%' valign='top'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('id_akun') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Keterangan </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('keterangan') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- Action -->
                                                        <table class='purchase' width='100%' cellpadding='0' cellspacing='0'>
                                                            <tr>
                                                                <td colspan='2'>
                                                                    <table class='purchase_content' width='100%' cellpadding='0' cellspacing='0'>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>" . $this->input->post('nama_barang') . "</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>Rp.  " . number_format($this->input->post('harga_jual')) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>QTY</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>" . $this->input->post('qty') . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback purchase_total'>Kode Unik</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback purchase_total'>Rp. " . number_format($this->input->post('kode_unik')) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Total</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($this->input->post('total')) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p align='center'>Untuk menyelesaikan proses pembayaran, silahkan transfer sejumlah </p>
                                                        <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                            <tr>
                                                                <td align='center'>
                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                                                                        <tr>
                                                                            <td align='center'>
                                                                                <a href='' class='f-fallback button button--red'>Rp. " . number_format($this->input->post('total')) . "</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table> 
                                                        <p align='center'>Ke daftar rekening dibawah ini : </p>
                                                        " . $data . "
                                                        <p align='center'>Konfirmasi pembayaran anda ke : <a href='" . base_url() . "konfirmasi/" . $this->input->post('token') . "/" . $this->input->post('order_id') . "'> Form Konfirmasi Pembayaran </a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
            
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            
            </html>
        ";
        $mail->Body = $mailContent;

        // Send email
        if (!$mail->send()) {
            echo $mail->ErrorInfo;
            die;
        } else {
            return true;
        }
    }

    function proses()
    {
        if (isset($_POST['konfirmasi'])) {
            if ($_FILES['bukti_transfer']['error'] <> 4) {

                $config['upload_path'] = 'assets/upload/konfirmasi';
                $config['allowed_types'] = 'jpg|png|gif|bmp|jpeg|jpe';
                $config['max_size'] = 1000;
                $config['quality'] = '50%';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('bukti_transfer')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $hasil  = $this->upload->data();
                    $totval = $this->input->post('jml_transfer');
                    $data = array(
                        'order_id'          => htmlspecialchars($this->input->post('order_id')),
                        'nama'              => htmlspecialchars($this->input->post('nama')),
                        'transfer_ke'       => htmlspecialchars($this->input->post('transfer_ke')),
                        'tgl_transfer'      => htmlspecialchars($this->input->post('tgl_transfer')),
                        'jml_transfer'      => htmlspecialchars($this->input->post('jml_transfer')),
                        'bukti_transfer'    => $hasil['file_name'],
                        'timee'             => date('Y-m-d H:i:s'),
                        'token'             => htmlspecialchars($this->input->post('token'))
                    );
                    $this->db->insert('tb_checkout_tmp', $data);

                    $this->db->set('status_bayar', '1');
                    $this->db->where('order_id', $this->input->post('order_id'));
                    $this->db->update('tb_checkout');

                    //AKUNTANSI
                    $user = $this->db->get_where('user', ['token' => $this->input->post('token')])->row_array();
                    if ($user['coupon'] == 'new') {
                        $datta = [
                            'no_jurnal' => $this->input->post('no_jurnal'),
                            'tgl_jurnal' => date('Y-m-d'),
                            'keterangan' => 'Pendapatan Penjualan Lewat Link Checkout',
                            'token' => $this->session->userdata('token'),
                        ];

                        $this->db->insert('tb_jurnal_tmp', $datta);

                        $tok = $this->session->userdata('token');
                        $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun BETWEEN 111 AND 411")->result_array();
                        // foreach ($ak as $aku) {
                        //     $ch[] = $aku;
                        // }

                        foreach ($ak as $ro) {
                            if ($ro['kode_akun'] == '111') {
                                // $ka = 'D';
                                $dt1 = [
                                    'no_jurnal' => $this->input->post('no_jurnal'),
                                    'id_akun' => $ro['id_akun'],
                                    'nominal' => $totval,
                                    'tipe' => 'D',
                                    'token' => $this->session->userdata('token'),
                                ];

                                $this->db->insert('tb_jurnal', $dt1);
                            } else if ($ro['kode_akun'] == '411') {
                                // $ka = 'K';
                                $dt1 = [
                                    'no_jurnal' => $this->input->post('no_jurnal'),
                                    'id_akun' => $ro['id_akun'],
                                    'nominal' => $totval,
                                    'tipe' => 'K',
                                    'token' => $this->session->userdata('token'),
                                ];

                                $this->db->insert('tb_jurnal', $dt1);
                            }
                        }
                    }

                    redirect('selesai/' . $this->input->post('token') . '/' . $this->input->post('order_id'));
                }
            } else {
                $totval = $this->input->post('jml_transfer');
                $data = array(
                    'order_id'          => htmlspecialchars($this->input->post('order_id')),
                    'nama'              => htmlspecialchars($this->input->post('nama')),
                    'transfer_ke'       => htmlspecialchars($this->input->post('transfer_ke')),
                    'tgl_transfer'      => htmlspecialchars($this->input->post('tgl_transfer')),
                    'jml_transfer'      => htmlspecialchars($this->input->post('jml_transfer')),
                    'timee'             => date('Y-m-d H:i:s'),
                    'token'             => htmlspecialchars($this->input->post('token'))
                );
                $this->db->insert('tb_checkout_tmp', $data);

                $this->db->set('status', '1');
                $this->db->where('order_id', $this->input->post('order_id'));
                $this->db->update('tb_checkout');

                //AKUNTANSI
                $user = $this->db->get_where('user', ['token' => $this->input->post('token')])->row_array();
                if ($user['coupon'] == 'new') {
                    $datta = [
                        'no_jurnal' => $this->input->post('no_jurnal'),
                        'tgl_jurnal' => date('Y-m-d'),
                        'keterangan' => 'Pendapatan Penjualan Lewat Link Checkout',
                        'token' => $this->session->userdata('token'),
                    ];

                    $this->db->insert('tb_jurnal_tmp', $datta);

                    $tok = $this->session->userdata('token');
                    $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun BETWEEN 111 AND 411")->result_array();
                    // foreach ($ak as $aku) {
                    //     $ch[] = $aku;
                    // }

                    foreach ($ak as $ro) {
                        if ($ro['kode_akun'] == '111') {
                            // $ka = 'D';
                            $dt1 = [
                                'no_jurnal' => $this->input->post('no_jurnal'),
                                'id_akun' => $ro['id_akun'],
                                'nominal' => $totval,
                                'tipe' => 'D',
                                'token' => $this->session->userdata('token'),
                            ];

                            $this->db->insert('tb_jurnal', $dt1);
                        } else if ($ro['kode_akun'] == '411') {
                            // $ka = 'K';
                            $dt1 = [
                                'no_jurnal' => $this->input->post('no_jurnal'),
                                'id_akun' => $ro['id_akun'],
                                'nominal' => $totval,
                                'tipe' => 'K',
                                'token' => $this->session->userdata('token'),
                            ];

                            $this->db->insert('tb_jurnal', $dt1);
                        }
                    }
                }

                redirect('selesai/' . $this->input->post('token') . '/' . $this->input->post('order_id'));
            }
        } elseif (isset($_POST['terima'])) {
            if ($_FILES['bukti_terima']['error'] <> 4) {

                $config['upload_path'] = 'assets/upload/terima';
                $config['allowed_types'] = 'jpg|png|gif|bmp|jpeg|jpe';
                $config['max_size'] = 1000;
                $config['quality'] = '50%';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('bukti_terima')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $hasil  = $this->upload->data();
                    $data = array(
                        'order_id'          => htmlspecialchars($this->input->post('order_id')),
                        'no_resi'           => htmlspecialchars($this->input->post('no_resi')),
                        'ulasan'            => htmlspecialchars($this->input->post('ulasan')),
                        'bukti_terima'      => $hasil['file_name'],
                        'timee'             => date('Y-m-d H:i:s'),
                        'token'             => htmlspecialchars($this->input->post('token'))
                    );
                    $this->db->where('order_id', $this->input->post('order_id'));
                    $this->db->update('tb_checkout_terima', $data);

                    $this->db->set('status', '4');
                    $this->db->where('order_id', $this->input->post('order_id'));
                    $this->db->update('tb_checkout');

                    redirect('finish/' . $this->input->post('token') . '/' . $this->input->post('order_id'));
                }
            } else {
                $data = array(
                    'order_id'          => htmlspecialchars($this->input->post('order_id')),
                    'no_resi'           => htmlspecialchars($this->input->post('no_resi')),
                    'ulasan'            => htmlspecialchars($this->input->post('ulasan')),
                    'timee'             => date('Y-m-d H:i:s'),
                    'token'             => htmlspecialchars($this->input->post('token'))
                );
                $this->db->where('order_id', $this->input->post('order_id'));
                $this->db->update('tb_checkout_terima', $data);

                $this->db->set('status', '4');
                $this->db->where('order_id', $this->input->post('order_id'));
                $this->db->update('tb_checkout');

                redirect('finish/' . $this->input->post('token') . '/' . $this->input->post('order_id'));
            }
        }
    }

    public function detail($token, $order_id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Detail Pemesanan';

        $data['order'] = $this->db->get_where('tb_checkout', ['order_id' => $order_id, 'token' => $token])->row();
        $data['rekening'] = $this->db->get_where('tb_rekening', ['token' => $token])->result_array();

        $this->load->view('orders/detail', $data);
    }

    public function konfirmasi($token, $order_id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Konfirmasi Pembayaran';

        $data['order'] = $this->db->get_where('tb_checkout', ['order_id' => $order_id, 'token' => $token])->row();
        $data['rekening'] = $this->db->get_where('tb_rekening', ['token' => $token])->result_array();
        $data['no_jurnal'] = $this->Akuntansi_model->no_jurnall();

        $this->load->view('orders/konfirmasi', $data);
    }

    public function selesai($token, $order_id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Finish';

        $this->db->join('tb_barang', 'tb_barang.kode_barang = tb_checkout.kode_barang');
        $data['order'] = $this->db->get_where('tb_checkout', ['tb_checkout.order_id' => $order_id, 'tb_checkout.token' => $token])->row();

        $this->db->join('tb_rekening', 'tb_rekening.kd_rekening = tb_checkout_tmp.transfer_ke');
        $data['konf'] = $this->db->get_where('tb_checkout_tmp', ['tb_checkout_tmp.order_id' => $order_id, 'tb_checkout_tmp.token' => $token])->row();

        $data['set'] = $this->db->get_where('setting_app', ['token' => $token])->row();

        $this->load->view('orders/selesai', $data);
    }

    public function terima($token, $order_id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Konfirmasi Penerimaan';

        $data['order'] = $this->db->get_where('tb_checkout', ['order_id' => $order_id, 'token' => $token])->row();
        $data['rekening'] = $this->db->get_where('tb_rekening', ['token' => $token])->result_array();
        $data['no_jurnal'] = $this->Akuntansi_model->no_jurnall();

        $this->load->view('orders/terima', $data);
    }

    public function finish($token, $order_id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Finish';

        $this->load->view('orders/finish', $data);
    }
}
