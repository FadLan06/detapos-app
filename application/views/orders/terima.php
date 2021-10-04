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
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dataTables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dataTables/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>jquery-ui.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
</head>

<body style="background-color: #f7f7f7;">

    <div class="container" style="margin-top: 40px; margin-bottom: 30px; text-align:left">
        <!-- background-color: #891e2b; -->
        <div align="center">
            <img src="<?= base_url('assets/img/logodeta1.png') ?>" width="100" alt="" class="mb-3">
        </div>
        <div class="card col-md-6 mx-auto shadow-danger shadow-lg">
            <div class="card-body">
                <h4 align="center"><b>Konfirmasi Penerimaan</b></h4><br>
                <?= form_open_multipart('Checkout/Proses') ?>
                <div class="form-group">
                    <label><b>Order ID <span class="text-danger">*</span></b></label>
                    <input type="hidden" value="<?= $this->uri->segment(2); ?>" name="token">
                    <input type="text" name="order_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Order ID" autocomplete="off" value="<?= $order->order_id ?>" readonly>
                    <?= form_error('order_id', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label><b>Nomor Resi <span class="text-danger">*</span></b></label>
                    <input type="text" name="no_resi" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Order ID" autocomplete="off" value="<?= $order->no_resi ?>" readonly>
                    <?= form_error('no_resi', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label><b>Bukti Penerimaan<span class="text-danger">*</span></b></label>
                    <input type="file" name="bukti_terima" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Bukti Penerimaan" autocomplete="off" required>
                    <?= form_error('bukti_terima', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label><b>Ulasan <span class="text-danger">*</span></b></label>
                    <textarea name="ulasan" id="ulasan" cols="30" rows="10" required class="form-control"></textarea>
                    <?= form_error('nama', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block text-white bg-danger btn-outline-light mt-3 mb-2 shadow" name="terima"><b>K I R I M </b> <i class="fas fa-paper-plane"></i></button>
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

    <script src="<?= base_url('assets/') ?>jquery-3.4.1.js"></script>
    <script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
    <script src="<?= base_url('assets/') ?>popper.min.js"></script>
    <script src="<?= base_url('assets/') ?>bootstrap/js/bootstrap.min.js"></script>

</body>

</html>