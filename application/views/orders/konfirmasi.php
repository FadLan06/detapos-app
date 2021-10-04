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
        <div class="card col-md-6 mx-auto shadow-danger shadow-lg">
            <div class="card-body">
                <h4 align="center"><b>Konfirmasi Pembayaran</b></h4><br>
                <?= form_open_multipart('Checkout/Proses') ?>
                <div class="form-group">
                    <label><b>Order ID <span class="text-danger">*</span></b></label>
                    <input type="hidden" value="<?= $this->uri->segment(2); ?>" name="token">
                    <input type="hidden" name="no_jurnal" class="form-control" id="no_jurnal" autocomplete="off" value="<?= $no_jurnal ?>" readonly>
                    <input type="text" name="order_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Order ID" autocomplete="off" value="<?= $order->order_id ?>" readonly>
                    <?= form_error('order_id', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label><b>Atas Nama Rekening <span class="text-danger">*</span></b></label>
                    <input type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Atas Nama Rekening" autocomplete="off" autofocus required>
                    <?= form_error('nama', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label><b>Transfer Ke <span class="text-danger">*</span></b></label>
                    <select name="transfer_ke" id="transfer_ke" class="form-control" required>
                        <option disabled selected>
                            <-- Pilih Jenis Rekekning -->
                        </option>
                        <?php foreach ($rekening as $rek) : ?>
                            <option value="<?= $rek['kd_rekening'] ?>"><?php if ($rek['jenis'] == 'bank-bca') {
                                                                            echo 'Bank Central Asia (BCA)';
                                                                        } elseif ($rek['jenis'] == 'bank-mandiri') {
                                                                            echo 'Bank Mandiri';
                                                                        } elseif ($rek['jenis'] == 'bank-bni') {
                                                                            echo 'Bank Negara Indonesia (BNI)';
                                                                        } elseif ($rek['jenis'] == 'bank-bri') {
                                                                            echo 'Bank Rakyat Indonesia (BRI)';
                                                                        } ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('transfer_ke', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label><b>Tanggal Transfer <span class="text-danger">*</span></b></label>
                    <input type="date" name="tgl_transfer" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tanggal Transfer" autocomplete="off" required>
                    <?= form_error('tgl_transfer', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label><b>Jumlah Transfer <span class="text-danger">*</span></b></label>
                    <input type="number" name="jml_transfer" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Jumlah Transfer" autocomplete="off" required>
                    <?= form_error('jml_transfer', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label><b>Bukti Transfer<span class="text-danger">*</span></b></label>
                    <input type="file" name="bukti_transfer" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Bukti Transfer" autocomplete="off" required>
                    <?= form_error('bukti_transfer', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block text-white btn-deta mt-3 mb-2 shadow" name="konfirmasi"><b>K I R I M </b> <i class="fas fa-paper-plane"></i></button>
                </div>
                </form>
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