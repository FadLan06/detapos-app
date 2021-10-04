<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Laporan_model');
        $zona = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row_array();
        date_default_timezone_set($zona['zona']);
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Pesanan ONLINE';

        $token = $this->session->userdata('token');
        $data['shop'] = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='1' AND d.token='$token' GROUP BY d.token, d.order_id ORDER BY tgl_order DESC")->result();
        $data['proses'] = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='2' AND d.token='$token' GROUP BY d.token, d.order_id ORDER BY waktu_proses DESC")->result();
        $data['kirim'] = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='3' AND d.token='$token' GROUP BY d.token, d.order_id ORDER BY waktu_kirim DESC")->result();

        $this->load->view('templates/header', $data);
        $this->load->view('pesanan/index', $data);
        $this->load->view('templates/footer');
    }

    function proses($id)
    {
        $shop = $this->db->get_where('tb_shop', ['order_id' => $id])->row();

        if ($shop->metodePem == 'transfer') {
            // $this->_sendEmail('verify', $id);
        }

        $this->db->set('status', '2');
        $this->db->set('waktu_proses', date('Y-m-d H:i:s'));
        $this->db->where('order_id', $id);
        $this->db->update('tb_shop');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Pesanan Berhasil Diproses!'); </script>";
        }
        echo "<script>window.location='" . site_url('Pesanan') . "';</script>";
    }

    function kirim($id, $kd)
    {
        $shop = $this->db->get_where('tb_shop', ['order_id' => $id])->row();

        if ($shop->metodePem == 'transfer') {
            // $this->_sendEmail1('verify', $id);
        }

        $this->db->set('status', '3');
        $this->db->set('no_resi', htmlspecialchars($this->input->post('no_resi')));
        $this->db->set('waktu_kirim', date('Y-m-d H:i:s'));

        $this->db->where('order_id', $id);
        $this->db->update('tb_shop');

        $dataa = [
            'order_id' => $id,
            'no_resi' => htmlspecialchars($this->input->post('no_resi')),
            'timee' => date('Y-m-d H:i:s'),
            'token' => htmlspecialchars($kd)
        ];

        $this->db->insert('tb_shop_terima', $dataa);

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Pesanan Berhasil Dikirim!'); </script>";
        }
        echo "<script>window.location='" . site_url('Pesanan') . "';</script>";
    }

    function semua()
    {
        $token = $this->session->userdata('token');
        $shop = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='1' AND d.token='$token' GROUP BY d.token, d.order_id ORDER BY tgl_order DESC")->result();

        $no = 1;
        foreach ($shop as $data) {
            echo '<tr>
                    <td align="center">' . $no++ . ' </td>
                    <td align="center">' . $data->order_id . ' </td>
                    <td align="center">' . longdate_indo($data->tgl_order) . ' </td>
                    <td><b>' . strtoupper($data->expedisi) . ' </b><br>
                        Paket : ' . $data->paket . ' <br>
                        Ongkir : Rp. ' . number_format($data->ongkir) . '</td>
                    <td align="center">
                        Rp. ' . number_format($data->totbar) . '
                    </td>
                    <td align="center">
                        ';
            if ($data->metodePem == 'cod') {
                echo '<span class="badge badge-primary badge-pill">COD</span>';
            } else {
                if ($data->tusbar == 0) {
                    echo '<span class="badge badge-primary badge-pill">Transfer Bank</span><br>
                    <span class="badge badge-warning badge-pill">belum bayar</span>';
                } else {
                    echo '<span class="badge badge-success badge-pill">sudah bayar</span><br>
                            <span class="badge badge-deta text-white badge-pill">menunggu konfirmasi</span>';
                }
            }
            echo '
                    </td>
                    <td align="center">';
            if ($data->metodePem == 'cod') {
                echo '<a href="' . base_url('Pesanan/Proses/') . $data->order_id . '" class="btn btn-sm btn-danger">Proses</a><br>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#verifikasicod' . $data->order_id . ' " class="btn btn-sm btn-deta mt-2">Verfikasi</a>';
            } else {
                if ($data->tusbar == 1) {
                    echo '<a href="' . base_url('Pesanan/Proses/') . $data->order_id . '" class="btn btn-sm btn-danger">Proses</a><br>
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#verifikasi' . $data->order_id . ' " class="btn btn-sm btn-deta mt-2">Verfikasi</a>';
                }
            }
            echo '</td>
                </tr>';
        }
    }

    function diproses()
    {
        $token = $this->session->userdata('token');
        $proses = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='2' AND d.token='$token' GROUP BY d.token, d.order_id ORDER BY waktu_proses DESC")->result();

        $no = 1;
        foreach ($proses as $data) {
            echo '<tr>
                    <td align="center" width="3%">' . $no++ . '</td>
                    <td align="center" width="10%">';
            if ($data->metodePem == 'cod') {
                echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#verifikasicod' . $data->order_id . '" class="btn btn-sm btn-deta mt-2">' . $data->order_id . '</a>';
            } else {
                echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#verifikasi' . $data->order_id . '" class="btn btn-sm btn-deta mt-2">' . $data->order_id . '</a>';
            }
            echo '</td>
                    <td align="center" width="20%">' . $data->waktu_proses . '</td>
                    <td>
                        <b>' . strtoupper($data->expedisi) . ' </b>';
            if ($data->metodePem == 'cod') {
                echo '- COD';
            } else {
                echo '- TRANSFER';
            }
            echo '<br>
                        Paket : ' . $data->paket . ' <br>
                        Ongkir : Rp. ' . number_format($data->ongkir) . '
                    </td>
                    <td align="center" width="15%">
                        Rp. ' . number_format($data->totbar) . '
                    </td>
                    <td align="center" width="15%">
                        <span class="badge badge-deta text-white badge-pill">Diproses / Dikemas</span>
                    </td>
                    <td align="center">';
            if ($data->metodePem == 'cod') {
                echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#kirim' . $data->order_id . '" class="btn btn-sm btn-danger mt-2">Kirim</a>';
            } else {
                if ($data->tusbar == 1) :
                    echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#kirim' . $data->order_id . '" class="btn btn-sm btn-danger mt-2">Kirim</a>';
                endif;
            }
            echo '</td>
                </tr>';
        }
    }

    function dikirim()
    {
        $token = $this->session->userdata('token');
        $kirim = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='3' AND d.token='$token' GROUP BY d.token, d.order_id ORDER BY waktu_kirim DESC")->result();

        $no = 1;
        foreach ($kirim as $data) :
            echo '
                <tr>
                    <td align="center">' . $no++ . '</td>
                    <td align="center">' . $data->order_id . '</td>
                    <td align="center">' . $data->waktu_kirim . '</td>
                    <td>
                        <b>' . strtoupper($data->expedisi) . ' </b>';
            if ($data->metodePem == 'cod') {
                echo '- COD';
            } else {
                echo '- TRANSFER';
            }
            echo '<br>
                        Paket : ' . $data->paket . ' <br>
                        Ongkir : Rp. ' . number_format($data->ongkir) . '
                    </td>
                    <td align="center">
                        Rp. ' . number_format($data->totbar) . '
                    </td>
                    <td align="center">' . $data->no_resi . '</td>
                    <td align="center">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#lacak' . $data->order_id . '" class="badge badge-deta text-white badge-pill">Lacak</a>
                    </td>
                </tr>
                ';

        // $waktu = date('Y-m-d H:i:s');
        // $this->db->query("UPDATE tb_shop SET status='4', waktu_selesai='$waktu' WHERE DATEDIFF(CURDATE(), waktu_kirim) >= 3 AND order_id = '$data->order_id' AND status='3' ");
        endforeach;
    }

    function selesai()
    {
        $token = $this->session->userdata('token');
        $selesai = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='4' AND d.token='$token' GROUP BY d.token, d.order_id ORDER BY waktu_selesai DESC")->result();

        $no = 1;
        foreach ($selesai as $data) :
            echo '<tr>
                    <td align="center">' . $no++ . '</td>
                    <td align="center">' . $data->order_id . '</td>
                    <td align="center">' . longdate_indo($data->tgl_order) . '</td>
                    <td>
                        <b>' . strtoupper($data->expedisi) . ' </b>';
            if ($data->metodePem == 'cod') {
                echo '- COD';
            } else {
                echo '- TRANSFER';
            }
            echo '<br>
                        Paket : ' . $data->paket . ' <br>
                        Ongkir : Rp. ' . number_format($data->ongkir) . '
                    </td>
                    <td align="center">
                        Rp. ' . number_format($data->totbar) . '
                    </td>
                    <td align="center">
                        <span class="badge badge-deta text-white badge-pill">Selesai</span>
                    </td>
                    <td align="center">' . $data->no_resi . '</td>
                </tr>';
        endforeach;
    }

    function jumlah()
    {
        $token = $this->session->userdata('token');
        $data = $this->db->query("SELECT s.status, s.order_id, d.token, d.order_id, d.status_bayar FROM tb_shop_detail d LEFT JOIN tb_shop s ON s.order_id=d.order_id WHERE d.token='$token' AND d.status_bayar='1' AND s.status='1' GROUP BY d.order_id");

        echo $data->num_rows();
    }

    private function _sendEmail($type, $id)
    {
        $order = $this->db->get_where('tb_shop', ['order_id' => $id])->row();
        $pel = $this->db->get_where('tb_shop_pel', ['id_shop_pel' => $order->id_shop_pel])->row();
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
        $mail->addAddress($pel->email, $pel->nama_pel);
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
                        margin: 10px auto;
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
                                                        <h1>Hallo, " . $pel->nama_pel . "</h1>
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
                                                        <p>Terimaksih, Salam dari " . $toko->nama_toko . "</p>
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
        $order = $this->db->get_where('tb_shop', ['order_id' => $id])->row();
        $pel = $this->db->get_where('tb_shop_pel', ['id_shop_pel' => $order->id_shop_pel])->row();
        $toko = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row();
        $nmtoko = strtolower(str_replace(' ', '-', $toko->nama_toko));

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
        $mail->addAddress($pel->email, $pel->nama_pel);
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
                                                        <h1>Hallo, " . $pel->nama_pel . "</h1>
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
                                                        <p align='center'>Konfirmasi penerimaan barang anda ke : <br> <a href='http://localhost:84/shop_detapos/" . $nmtoko . "/pesanan'> Form Konfirmasi Penerimaan </a></p>
                                                        <p>Terimaksih, Salam dari " . $toko->nama_toko . "</p>
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

    public function report()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Report Pesanan ONLINE';

        $token = $this->session->userdata('token');
        $data['tahun'] = $this->db->query("SELECT tgl_penjualan, token FROM tb_detail_penjualan WHERE token='$token' GROUP BY year(tgl_penjualan)")->result_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('report')) {
            $data['dataa'] = $this->Laporan_model->cariReport();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('pesanan/report', $data);
        $this->load->view('templates/footer');
    }

    function report_cetak()
    {
        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);
        $report = $this->input->post('report', true);

        $token = $this->session->userdata('token');

        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($_POST['report'] == 'harian') {
            $this->db->select('*, sum(qty) as kkty');
            $this->db->where('tgl_order_detail', $tanggal);
            $this->db->where('status_bayar', 1);
            $this->db->where('token', $token);
            $this->db->group_by('id_barang');
            $data['dataa'] = $this->db->get('tb_shop_detail');
        } elseif ($_POST['report'] == 'minggu') {
            $data['dataa'] = $this->db->query("SELECT *, sum(qty) as kkty FROM tb_shop_detail WHERE token='$token' AND status_bayar='1' AND tgl_order_detail BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY id_barang");
        }

        $this->load->view('pesanan/report_cetak', $data);
    }

    function report_export()
    {
        $data['judul'] = 'Report Pesanan ONLINE';

        $tgl_akhir = $this->input->post('tgl_akhir', true);
        $tgl_awal = $this->input->post('tgl_awal', true);
        $tanggal = $this->input->post('tanggal', true);
        $report = $this->input->post('report', true);

        $token = $this->session->userdata('token');

        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($_POST['report'] == 'harian') {
            $this->db->select('*, sum(qty) as kkty');
            $this->db->where('tgl_order_detail', $tanggal);
            $this->db->where('status_bayar', 1);
            $this->db->where('token', $token);
            $this->db->group_by('id_barang');
            $data['dataa'] = $this->db->get('tb_shop_detail');
        } elseif ($_POST['report'] == 'minggu') {
            $data['dataa'] = $this->db->query("SELECT *, sum(qty) as kkty FROM tb_shop_detail WHERE token='$token' AND status_bayar='1' AND tgl_order_detail BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY id_barang");
        }

        $this->load->view('pesanan/report_export', $data);
    }

    public function customer()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Customer Pesanan ONLINE';

        $token = $this->session->userdata('token');
        $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $link = strtolower(str_replace(' ', '-', $set['nama_toko']));
        $data['cus'] = $this->db->get_where('tb_shop_pel', ['link' => $link, 'reseller' => 0])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('pesanan/customer', $data);
        $this->load->view('templates/footer');
    }

    function customer_export()
    {
        $data['judul'] = 'Customer Pesanan ONLINE';

        $token = $this->session->userdata('token');
        $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $link = strtolower(str_replace(' ', '-', $set['nama_toko']));
        $data['cus'] = $this->db->get_where('tb_shop_pel', ['link' => $link, 'reseller' => 0])->result_array();

        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('pesanan/customer_export', $data);
    }

    function customer_cetak()
    {
        $data['judul'] = 'Customer Pesanan ONLINE';

        $token = $this->session->userdata('token');
        $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $link = strtolower(str_replace(' ', '-', $set['nama_toko']));
        $data['cus'] = $this->db->get_where('tb_shop_pel', ['link' => $link, 'reseller' => 0])->result_array();

        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('pesanan/customer_cetak', $data);
    }

    public function customer_view()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Customer Pesanan ONLINE';

        $token = $this->session->userdata('token');
        $data['tahun'] = $this->db->query("SELECT tgl_penjualan, token FROM tb_detail_penjualan WHERE token='$token' GROUP BY year(tgl_penjualan)")->result_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('report') || $this->input->post('id_shop_pel')) {
            $data['dataa'] = $this->Laporan_model->cariCusView();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('pesanan/customer_view', $data);
        $this->load->view('templates/footer');
    }

    public function customer_view_cetak()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Customer Pesanan ONLINE';

        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('report') || $this->input->post('id_shop_pel')) {
            $data['dataa'] = $this->Laporan_model->cariCusView();
        }

        $this->load->view('pesanan/customer_view_cetak', $data);
    }

    public function customer_view_export()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Report-Customer-Pesanan-ONLINE';

        $token = $this->session->userdata('token');
        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        if ($this->input->post('tgl_awal') || $this->input->post('tgl_akhir') || $this->input->post('tanggal') || $this->input->post('report') || $this->input->post('id_shop_pel')) {
            $data['dataa'] = $this->Laporan_model->cariCusView();
        }

        $this->load->view('pesanan/customer_view_export', $data);
    }

    public function settings()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Settings';

        $token = $this->session->userdata('token');
        $data['set'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $data['cod'] = $this->db->get_where('tb_cod', ['token' => $token])->row_array();
        $data['setting'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $data['lokal'] = $this->db->get_where('tb_shop_lokal', ['token' => $token])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('pesanan/settings', $data);
        $this->load->view('templates/footer');
    }

    function settings_simpan()
    {
        if (isset($_POST['simpan'])) {
            $this->db->set('get_kategori', htmlspecialchars($this->input->post('get_kategori')));
            $this->db->where('token', $this->session->userdata('token'));
            $this->db->update('setting_app');

            $data = [
                'biaya' => htmlspecialchars($this->input->post('biaya')),
                'status' => htmlspecialchars($this->input->post('status'))
            ];

            $this->db->where('token', $this->session->userdata('token'));
            $this->db->update('tb_cod', $data);

            $dataa = [
                'kode_unik' => htmlspecialchars($this->input->post('kode_unik')),
                'status' => htmlspecialchars($this->input->post('status_bank'))
            ];

            $this->db->where('token', $this->session->userdata('token'));
            $this->db->update('setting_app', $dataa);

            // $domain = 'https://' . htmlspecialchars($this->input->post('domain')) . '/';
            // $this->db->set('domain', $domain);
            // $this->db->set('dom', htmlspecialchars($this->input->post('domain')));
            // $this->db->where('token', $this->session->userdata('token'));
            // $this->db->update('setting_app');

            $dataaa = [
                'deskripsi' => htmlspecialchars('LCL'),
                'ongkir' => htmlspecialchars($this->input->post('ongkir')),
                'estimasi' => htmlspecialchars('1 Hari'),
                'status' => htmlspecialchars($this->input->post('status'))
            ];

            $this->db->where('token', $this->session->userdata('token'));
            $this->db->update('tb_shop_lokal', $dataaa);

            if ($this->db->affected_rows() > 0) {
                echo "<script>alert('Data Berhasil di Simpan!'); </script>";
            }
            echo "<script>window.location='" . site_url('Pesanan/Settings') . "';</script>";
        }
    }

    function cetak_label()
    {
        $token = $this->session->userdata('token');
        $data['logo'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('pesanan/cetak_label', $data);
    }

    public function reseller()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Data Reseller';

        $token = $this->session->userdata('token');
        $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $link = strtolower(str_replace(' ', '-', $set['nama_toko']));
        $data['res'] = $this->db->get_where('tb_shop_pel', ['link' => $link, 'reseller' => 1])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('pesanan/reseller', $data);
        $this->load->view('templates/footer');
    }

    function reseller_aksi($is, $id)
    {
        $this->db->set('is_active', $is);
        $this->db->where('id_shop_pel', $id);
        $this->db->update('tb_shop_pel');

        if ($this->db->affected_rows() > 0) {
            echo "<script>alert('Status Berhasil di Update!'); </script>";
        }
        echo "<script>window.location='" . site_url('Pesanan/Reseller') . "';</script>";
    }

    function reseller_export()
    {
        $data['judul'] = 'Data Reseller';

        $token = $this->session->userdata('token');
        $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $link = strtolower(str_replace(' ', '-', $set['nama_toko']));
        $data['res'] = $this->db->get_where('tb_shop_pel', ['link' => $link, 'reseller' => 1])->result_array();

        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('pesanan/reseller_export', $data);
    }

    function reseller_cetak()
    {
        $data['judul'] = 'Data Reseller';

        $token = $this->session->userdata('token');
        $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();
        $link = strtolower(str_replace(' ', '-', $set['nama_toko']));
        $data['res'] = $this->db->get_where('tb_shop_pel', ['link' => $link, 'reseller' => 1])->result_array();

        $data['toko'] = $this->db->get_where('setting_app', ['token' => $token])->row_array();

        $this->load->view('pesanan/reseller_cetak', $data);
    }
}
