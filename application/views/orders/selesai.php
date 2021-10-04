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

    <div class="container" style="margin-top: 40px; margin-bottom: 30px; text-align:left">
        <!-- background-color: #891e2b; -->
        <div align="center">
            <img src="<?= base_url('assets/img/logodeta1.png') ?>" width="100" alt="" class="mb-3">
        </div>
        <div class="card col-md-10 mx-auto shadow-danger shadow-lg">
            <div class="card-body">
                <h4 align="center"><b>Terimakasih Telah Melakukan Pembayaran</b></h4>
                <!-- <p align="center">Pesanan anda sementara kami proses mohon tunggu yaa!!!</p> -->
                <p align="center">Cek email anda untuk mendapatkan info selanjutnya terkait pemesanan anda.</p>
                <p align="center">Berikut detail transaksi pembelian anda :</p>
                <div class="col-md-10 mx-auto">
                    <table class="table" width="100%">
                        <tr>
                            <td width="30%"><b>Order ID</b></td>
                            <td width="2%">:</td>
                            <td><?= $order->order_id ?></td>
                        </tr>
                        <tr>
                            <td width="30%"><b>Nama Barang</b></td>
                            <td width="2%">:</td>
                            <td><?= $order->nama_barang ?></td>
                        </tr>
                        <tr>
                            <td width="30%"><b>Harga</b></td>
                            <td width="2%">:</td>
                            <td>Rp. <?= number_format($order->harga_jual) ?></td>
                        </tr>
                        <tr>
                            <td width="30%"><b>Jumlah</b></td>
                            <td width="2%">:</td>
                            <td><?= $order->qty ?> <?= $order->satuan ?></td>
                        </tr>
                        <tr>
                            <td width="30%"><b>Kode Unik</b></td>
                            <td width="2%">:</td>
                            <td><?php if (($set->kode_unik == 'Mengurangi') || ($set->kode_unik == '')) {
                                    echo '-';
                                } ?> Rp. <?= $order->kode_unik ?></td>
                        </tr>
                        <?php if ($set->token != 'DPVL3N') : ?>
                            <tr>
                                <td width="30%"><b>Ongkir</b></td>
                                <td width="2%">:</td>
                                <td>Rp. <?= number_format($order->ongkir) ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td width="30%"><b>Total</b></td>
                            <td width="2%">:</td>
                            <td>Rp. <?= number_format($order->gran_total) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 mx-auto table-responsive-sm">
                    <table class="table table-bordered table-sm" width="100%">
                        <thead class="bg-deta text-white">
                            <tr align="center">
                                <th width="20%">Atas Nama</th>
                                <th width="35%">Transfer Ke</th>
                                <th>Tanggal Transfer</th>
                                <th>Jumlah Transfer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $konf->nama ?></td>
                                <td align="center"><b>No. Rekening : </b> <?= $konf->no_rekening ?><br /> <b>a.n : </b> <?= $konf->atas_nama ?></td>
                                <td align="center"><?= date('d F Y', strtotime($konf->tgl_transfer)) ?></td>
                                <td>Rp. <?= number_format($konf->jml_transfer) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

</body>

</html>