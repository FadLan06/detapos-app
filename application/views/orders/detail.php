<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Required meta tags -->

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="shortcut icon" href="<?= base_url('assets/') ?>favicon.ico" />

    <title><?= $judul ?> - Detapos</title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>jquery-ui.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
    <style>
        .border-deta {
            border-color: #00aaff;
        }

        .bg-deta {
            background-color: #00aaff;
        }

        .btn-deta {
            background-color: #00aaff;
            border: 1px solid #00aaff;
        }

        .btn-deta:active,
        .btn-deta:focus,
        .btn-deta:hover,
        .btn-deta.active,
        .btn-deta.focus,
        .btn-deta:active,
        .btn-deta:focus,
        .btn-deta:hover,
        .open>.dropdown-toggle.btn-deta,
        .btn-outline-deta.active,
        .btn-outline-deta:active,
        .show>.btn-outline-deta.dropdown-toggle,
        .btn-outline-deta:hover,
        .btn-deta.active,
        .btn-deta:active,
        .show>.btn-deta.dropdown-toggle {
            background-color: #00aaff;
            border: 1px solid #00aaff;
        }
    </style>
</head>

<body style="background-color: #f7f7f7;">

    <div class="container" style="margin-top: 40px; margin-bottom: 30px; text-align:center;">
        <!-- background-color: #891e2b; -->
        <img src="<?= base_url('assets/img/logodeta1.png') ?>" width="100" alt="" class="mb-3">
        <div class="card col-md-10 mx-auto shadow-danger shadow-lg">
            <div class="card-body">
                <h3><b>Terimakasih sudah melakukan order Barang</b></h3>
                <p>Untuk menyelesaikan proses pembayaran, silahkan transfer sejumlah</p>
                <div>
                    <h3><b>Rp. <?= number_format($order->gran_total) ?></b></h3><br>
                    <p id="<?= $order->gran_total ?>" hidden><?= $order->gran_total ?></p>
                </div>
                <button class="btn btn-deta text-white" type="button" onclick="copy_text('#<?= $order->gran_total ?>')"><i class="fas fa-pen"></i> Salin Jumlah</button>
                <p class="mt-2">Pilih salah satu bank berikut ini :</p>
                <div class="row mb-5">
                    <?php $no = 1;
                    foreach ($rekening as $rek) : ?>
                        <?php if ($rek['jenis'] == 'bank-bca') {
                            $gambar = 'bank-bca.png';
                        } elseif ($rek['jenis'] == 'bank-mandiri') {
                            $gambar = 'bank-mandiri.png';
                        } elseif ($rek['jenis'] == 'bank-bni') {
                            $gambar = 'bank-bni.png';
                        } elseif ($rek['jenis'] == 'bank-bri') {
                            $gambar = 'bank-bri.png';
                        } ?>
                        <div class="col-md-5 mr-1 mx-auto mt-3" style="border: 1px dashed #00aaff">
                            <table width="100%">
                                <tr>
                                    <td><img src="<?= base_url('assets/img/') . $gambar ?>" width="45%" alt="" class="mt-2"></td>
                                </tr>
                                <tr>
                                    <td>No. Rekening : <b><?= $rek['no_rekening'] ?></b></td>
                                </tr>
                                <tr>
                                    <td>a.n : <b><?= $rek['atas_nama'] ?></b></td>
                                </tr>
                                <tr>
                                    <p id="<?= $rek['no_rekening'] ?>" hidden><?= $rek['no_rekening'] ?></p>
                                    <td><button class="btn btn-deta text-white btn-sm mt-2 mb-2" type="button" onclick="copy_text1('#<?= $rek['no_rekening'] ?>')"><i class="fas fa-pen"></i> Salin No. Rekening</button></td>
                                </tr>
                            </table>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p>Konfirmasi pembayaran anda di : <a href="<?= base_url('konfirmasi/') . $this->uri->segment(2) . '/' . $this->uri->segment(3); ?>" style="color:#00aaff">Konfirmasi Pembayaran</a></p>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="page-footer font-small text-dark mt-2">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">Powered By :
            <a href="https://gammaadvertisa.co.id/" class="text-danger" target="_blank">Gamma Advertisa</a><br> <small>Copyright ©2020</small>
        </div>
        <!-- Mohammad Fadhlan Zainuddin -->
        <!-- Copyright -->

    </footer>
    <!-- Footer -->

    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
    <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function copy_text(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            alert("Text berhasil dicopy");
        }

        function copy_text1(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            alert("No. Rekening berhasil dicopy");
        }
    </script>

</body>

</html>