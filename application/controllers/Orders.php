<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'ORDERS';

        $this->db->select('*,tb_checkout.token as tok');
        $this->db->join('tb_barang', 'tb_barang.kode_barang = tb_checkout.kode_barang');
        $data['order'] = $this->db->get_where('tb_checkout', ['tb_checkout.token' => $this->session->userdata('token')])->result();
        $data['orderr'] = $this->db->get_where('tb_checkout', ['tb_checkout.token' => $this->session->userdata('token')])->row();
        $data['set'] = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row();
        $data['barang'] = $this->db->get_where('tb_barang', ['token' => $this->session->userdata('token')])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('orders/index', $data);
        $this->load->view('templates/footer');
    }

    function hapus($id)
    {
        $this->db->where('order_id', $id);
        $this->db->delete('tb_checkout');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data Kategori Barang Berhasil di Hapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Orders');
    }

    function vpesanan()
    {
        $this->db->order_by('tb_checkout.waktu', 'DESC');
        $data = $this->db->get_where('tb_checkout', ['tb_checkout.status' => 1, 'tb_checkout.token' => $this->session->userdata('token')])->result();
        echo json_encode($data);
    }

    function vproses()
    {
        $this->db->order_by('tb_checkout.waktu', 'DESC');
        $data = $this->db->get_where('tb_checkout', ['tb_checkout.token' => $this->session->userdata('token'), 'tb_checkout.status' => 2])->result();
        echo json_encode($data);
    }

    function vkirim()
    {
        $this->db->order_by('tb_checkout.waktu', 'DESC');
        $data = $this->db->get_where('tb_checkout', ['tb_checkout.token' => $this->session->userdata('token'), 'tb_checkout.status' => 3])->result();
        echo json_encode($data);
    }

    function vselesai()
    {
        $this->db->order_by('tb_checkout.waktu', 'DESC');
        $this->db->join('tb_checkout_terima', 'tb_checkout_terima.order_id = tb_checkout.order_id');
        $data = $this->db->get_where('tb_checkout', ['tb_checkout.token' => $this->session->userdata('token'), 'tb_checkout.status' => 4])->result();
        echo json_encode($data);
    }

    function proses($id)
    {
        $this->_sendEmail('verify', $id);

        $this->db->set('status', '2');
        $this->db->set('waktu_proses', date('Y-m-d H:i:s'));
        $this->db->where('order_id', $id);
        $this->db->update('tb_checkout');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Pesanan Berhasil Diproses!'); </script>";
        }
        echo "<script>window.location='" . site_url('Orders') . "';</script>";
    }

    function kirim($id, $kd)
    {
        $this->_sendEmail1('verify', $id);

        $this->db->set('status', '3');
        $this->db->set('waktu_kirim', date('Y-m-d H:i:s'));
        $this->db->where('kd_checkout', $id);
        $this->db->update('tb_checkout');

        $data = ['no_resi' => htmlspecialchars($this->input->post('no_resi'))];
        $this->db->where('kd_checkout', $id);
        $this->db->update('tb_checkout', $data);

        $dataa = [
            'order_id' => $kd,
            'no_resi' => htmlspecialchars($this->input->post('no_resi')),
            'timee' => date('Y-m-d H:i:s'),
            'token' => htmlspecialchars($this->session->userdata('token'))
        ];

        $this->db->insert('tb_checkout_terima', $dataa);

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Pesanan Berhasil Dikirim!'); </script>";
        }
        echo "<script>window.location='" . site_url('Orders') . "';</script>";
    }

    function selesai_pesanan($id)
    {
        // $this->_sendEmail('verify', $id);

        $this->db->set('status', '4');
        $this->db->set('waktu_proses', date('Y-m-d H:i:s'));
        $this->db->where('kd_checkout', $id);
        $this->db->update('tb_checkout');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Pesanan Selesai!'); </script>";
        }
        echo "<script>window.location='" . site_url('Orders') . "';</script>";
    }

    private function _sendEmail($type, $id)
    {
        $order = $this->db->get_where('tb_checkout', ['order_id' => $id])->row();
        $toko = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row();

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
        $mail->addAddress($order->email, $order->nama_lengkap);
        $mail->addAddress($toko->email_toko);

        // Email subject
        $mail->Subject = 'Status Pesanan Anda - #' . $order->order_id . '';

        // Set email format to HTML
        $mail->isHTML(true);


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
                        text-align: left;
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
                        padding: 20px 0;
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
                                <tr>
                                    <td class='email-body' width='100%' cellpadding='0' cellspacing='0'>
                                        <table class='email-body_inner' align='center' width='570' cellpadding='0' cellspacing='0' role='presentation'>
                                            <tr>
                                                <td class='content-cell'>
                                                    <div class='f-fallback'>
                                                        <h1>Hallo, " . $order->nama_lengkap . "</h1>
                                                        <p align='center'>Kami Dari Toko " . $toko->nama_toko . " Mengkonfirmasi Status Pesanan Anda</p>
                                                        <!-- Action -->
                                                        <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                            <tr>
                                                                <td align='center'>
                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                                                                        <tr>
                                                                            <td align='center'>
                                                                                <a href='' class='f-fallback button button--red'>Diproses / Dikemas</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p>Berikut detail transaksi pembelian anda :</p>
                                                        <table class='purchase' width='100%' cellpadding='0' cellspacing='0'>
                                                            <tr>
                                                                <td colspan='2'>
                                                                    <table class='purchase_content' width='100%' cellpadding='0' cellspacing='0'>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>" . $order->nama_barang . "</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>Rp.  " . number_format($order->harga_jual) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>QTY</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>" . $order->qty . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback purchase_total'>Kode Unik</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback purchase_total'>- Rp. " . number_format($order->kode_unik) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Total</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($order->total) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Ongkir</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($order->ongkir) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Total Bayar</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($order->gran_total) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p>Terimaksih,
                                                        <br>Salam dari " . $toko->nama_toko . "</p>
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

    private function _sendEmail1($type, $id)
    {
        $order = $this->db->get_where('tb_checkout', ['kd_checkout' => $id])->row();
        $toko = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row();

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
        $mail->addAddress($order->email, $order->nama_lengkap);
        // $mail->addAddress($toko->email_toko);

        // Email subject
        $mail->Subject = 'Status Pesanan Anda - #' . $order->order_id . '';

        // Set email format to HTML
        $mail->isHTML(true);


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
                        text-align: left;
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
                        padding: 25px 0;
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
                                <tr>
                                    <td class='email-body' width='100%' cellpadding='0' cellspacing='0'>
                                        <table class='email-body_inner' align='center' width='570' cellpadding='0' cellspacing='0' role='presentation'>
                                            <tr>
                                                <td class='content-cell'>
                                                    <div class='f-fallback'>
                                                        <h1>Hallo, " . $order->nama_lengkap . "</h1>
                                                        <p align='center'>Kami Dari Toko " . $toko->nama_toko . " Mengkonfirmasi Status Pesanan Anda</p>
                                                        <!-- Action -->
                                                        <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                            <tr>
                                                                <td align='center'>
                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                                                                        <tr>
                                                                            <td align='center'>
                                                                                <a href='' class='f-fallback button button--red'>Dikirim</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p>Berikut detail transaksi pembelian anda :</p>
                                                        <table class='purchase' width='100%' cellpadding='0' cellspacing='0'>
                                                            <tr>
                                                                <td colspan='2'>
                                                                    <table class='purchase_content' width='100%' cellpadding='0' cellspacing='0'>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>" . $order->nama_barang . "</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>Rp.  " . number_format($order->harga_jual) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>QTY</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>" . $order->qty . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback purchase_total'>Kode Unik</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback purchase_total'>- Rp. " . number_format($order->kode_unik) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Total</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($order->total) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Ongkir</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($order->ongkir) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Total Bayar</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($order->gran_total) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p align='center'>Konfirmasi penerimaan barang anda ke : <br> <a href='" . base_url() . "terima/" . $this->session->userdata('token') . "/" . $order->order_id . "'> Form Konfirmasi Penerimaan </a></p>
                                                        <p>Terimaksih,
                                                        <br>Salam dari " . $toko->nama_toko . "</p>
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
}
