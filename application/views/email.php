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
            font-size: 22px;
            font-weight: bold;
            text-align: left;
        }

        h2 {
            margin-top: 0;
            color: #333333;
            font-size: 16px;
            font-weight: bold;
            text-align: left;
        }

        h3 {
            margin-top: 0;
            color: #333333;
            font-size: 14px;
            font-weight: bold;
            text-align: left;
        }

        td,
        th {
            font-size: 16px;
        }

        p,
        ul,
        ol,
        blockquote {
            margin: .4em 0 1.1875em;
            font-size: 16px;
            line-height: 1.625;
        }

        p.sub {
            font-size: 13px;
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

        @media only screen and (max-width: 500px) {
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
            padding: 10px;
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
            font-size: 15px;
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
            font-size: 15px;
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
            font-size: 15px;
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
    <span class='preheader'>This is an invoice for your purchase on {{ purchase_date }}. Please submit payment by {{ due_date }}</span>
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
                                            <h1>Terima Kasih Atas Pesanan Anda</h1>
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
                                                                        1024804021
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
                                                                        Mohammad Fadhlan Zainuddin
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
                                                                        082189062042
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
                                                                        Jl. Bali 2, Kelurahan Paguyaman, Kecamatan Kota Tengah, Kota Gorontalo
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
                                                                        Gorontalo
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class='attributes_item' width='30%'>
                                                                    <span class='f-fallback'>
                                                                        <strong>Kota/Kabupaten </strong>
                                                                    </span>
                                                                </td>
                                                                <td class='attributes_item' width='5%'>
                                                                    <span class='f-fallback'>
                                                                        <strong> : </strong>
                                                                    </span>
                                                                </td>
                                                                <td class='attributes_item'>
                                                                    <span class='f-fallback'>
                                                                        Kota Gorontalo
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
                                                                <td width='80%' class='purchase_item'><span class='f-fallback'>Rabbani Hijab Jilbab Kerudung Instan Alma</span></td>
                                                                <td class='align-right' width='20%' class='purchase_item'><span class='f-fallback'>Rp. 250,000</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td width='80%' class='purchase_item'><span class='f-fallback'>QTY</span></td>
                                                                <td class='align-right' width='20%' class='purchase_item'><span class='f-fallback'>1</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td width='80%' class='purchase_item'><span class='f-fallback purchase_total'>Kode Unik</span></td>
                                                                <td class='align-right' width='20%' class='purchase_item'><span class='f-fallback purchase_total'>- Rp. 561</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td width='80%' class='purchase_footer' valign='middle'>
                                                                    <p class='f-fallback purchase_total purchase_total--label'>Total</p>
                                                                </td>
                                                                <td width='20%' class='purchase_footer' valign='middle'>
                                                                    <p class='f-fallback purchase_total'>Rp. 249.440</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width='80%' class='purchase_footer' valign='middle'>
                                                                    <p class='f-fallback purchase_total purchase_total--label'>Ongkir</p>
                                                                </td>
                                                                <td width='20%' class='purchase_footer' valign='middle'>
                                                                    <p class='f-fallback purchase_total'>Rp. 56.000</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width='80%' class='purchase_footer' valign='middle'>
                                                                    <p class='f-fallback purchase_total purchase_total--label'>Total Bayar</p>
                                                                </td>
                                                                <td width='20%' class='purchase_footer' valign='middle'>
                                                                    <p class='f-fallback purchase_total'>Rp. 350.000</p>
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
                                                                    <a href='' class='f-fallback button button--red'>Rp. 350.000</a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <p align='center'>Ke daftar rekening dibawah ini : </p>
                                            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                <tr>
                                                    <td align='center'>
                                                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                                                            <tr>
                                                                <td align='center'>
                                                                    <img src='https://app.detapos.co/assets/img/bank-bca.png' width='50%'>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align='center'>
                                                                    <b>No. Rek : </b> 485657852321328
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align='center'>
                                                                    <b>Atas Nama : </b> Mohammad Fadhlan Zainuddin
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <p align='center'>Konfirmasi pembayaran anda ke : <a href=''> Form Konfirmasi Pembayaran </a></p>
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