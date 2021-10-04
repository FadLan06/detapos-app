<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">

    <title><?= $judul ?> - DETAPOS</title>
</head>

<body>
    <?php
    // date_default_timezone_set("Asia/Makassar");
    $tglawal  = $_POST['bulan'];
    $tglakhir  = $_POST['tahun'];
    ?>

    <div class="mt-4 ml-4 mr-4 mb-4">
        <h4><b><?= $toko['nama_toko']; ?></b></h4>

        <div>
            <div class=""><?= $toko['alamat']; ?><br>
                Telp. <?= $toko['no_telpon']; ?><br><br>
                Periode :
                <?php
                if ($_POST['filter'] == '2') {

                    if ($_POST['bulan'] == 1) {
                        $bulan = 'Januari';
                    } elseif ($_POST['bulan'] == 2) {
                        $bulan = 'Februari';
                    } elseif ($_POST['bulan'] == 3) {
                        $bulan = 'Maret';
                    } elseif ($_POST['bulan'] == 4) {
                        $bulan = 'April';
                    } elseif ($_POST['bulan'] == 5) {
                        $bulan = 'Mei';
                    } elseif ($_POST['bulan'] == 6) {
                        $bulan = 'Juni';
                    } elseif ($_POST['bulan'] == 7) {
                        $bulan = 'Juli';
                    } elseif ($_POST['bulan'] == 8) {
                        $bulan = 'Agustus';
                    } elseif ($_POST['bulan'] == 9) {
                        $bulan = 'September';
                    } elseif ($_POST['bulan'] == 10) {
                        $bulan = 'Oktober';
                    } elseif ($_POST['bulan'] == 11) {
                        $bulan = 'November';
                    } elseif ($_POST['bulan'] == 12) {
                        $bulan = 'Desember';
                    }
                    echo 'Bulan ' . $bulan . ' Tahun ' . $_POST['tahun'];
                } elseif ($_POST['filter'] == '3') {
                    echo 'Tahun ' . $_POST['tahun'];
                } elseif ($_POST['filter'] == '1') {
                    echo 'Tanggal ' . $_POST['tanggal'];
                } elseif ($_POST['filter'] == '4') {
                    echo 'Dari ' . $_POST['tgl_awal'] . ' sampai ' . $_POST['tgl_akhir'];
                } else {
                    echo 'Semua Periode';
                }
                ?>
            </div>
            <div class="">
                <span class="">
                    <br>
                </span>
            </div>
        </div>

        <center>
            <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
                LAPORAN DATA REKON
            </h4>
        </center>

        <br>

        <div class="table-responsive">
            <table class="table table-bordered" style="text-align:center; width:100%">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">TANGGAL</th>
                        <th width="25%">URAIAN</th>
                        <th width="15%">DEBET</th>
                        <th width="15%">KREDIT</th>
                        <th width="15%">SALDO</th>
                        <th width="15%">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $saldo  =   0;
                    $ttl = 0;
                    $ttl1 = 0;
                    foreach ($rekon->result_array() as $data) : ?>
                        <?php
                        $total_debet   =   0;
                        $total_kredit  =   0;
                        ?>
                        <?php if ($data['tipe'] == 'D') {
                            $uraian           =   $data['uraian'];
                            $kolom_debet    =   $data['nominal'];
                            $kolom_kredit   =   "0";
                            $ttl   +=   $kolom_debet;
                            $saldo = $saldo + $kolom_debet - $kolom_kredit;
                        } elseif ($data['tipe'] == 'K') {
                            $uraian           =   $data['uraian'];
                            $kolom_kredit   =   $data['nominal'];
                            $kolom_debet    =   "0";
                            $ttl1   +=   $kolom_kredit;
                            $saldo = $saldo - $kolom_kredit;
                        } ?>
                        <td align="center"><?= $no++ ?></td>
                        <td><?= longdate_indo($data['tgl_rekon_tmp']) ?></td>
                        <td align="left"><?= $uraian ?></td>
                        <td>Rp. <?= number_format($kolom_debet) ?></td>
                        <td>Rp. <?= number_format($kolom_kredit) ?></td>
                        <td>Rp. <?= number_format($saldo) ?></td>
                        <td><?= $data['keterangan'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td> <b>Rp. <?= number_format($ttl) ?></b></td>
                        <td> <b>Rp. <?= number_format($ttl1) ?></b></td>
                        <td> <b>Rp. <?= number_format($saldo) ?></b></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                <table>
        </div>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript">
        window.print();
        // window.history.back();
    </script>
    <script src="<?= base_url('assets/') ?>bootstrap/js/bootstrap.min.js"></script>
</body>

</html>