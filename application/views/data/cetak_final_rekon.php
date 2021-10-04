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
                LAPORAN DATA FINAL REKON
            </h4>
        </center>

        <br>

        <div class="row">
            <?php $no = 1;
            foreach ($final->result_array() as $data) : ?>
                <?php $detail = $this->db->get_where('tb_rekon_final', ['token' => $data['token'], 'tgl_final' => $data['tgl_final']]); ?>
                <div class="col-md-6">
                    <p><b>FINALISASI DATA REKON <br /> Tanggal</b> : <?= longdate_indo($data['tgl_final']) ?></p>
                    <table class="table table-bordered" width="100%" style="text-align:center;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Uraian</th>
                                <th width="15%">Debet</th>
                                <th width="15%">Kredit</th>
                                <th width="15%">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ang = 1;
                            $saldo = 0;
                            foreach ($detail->result_array() as $dt) : ?>
                                <?php if ($dt['tipe'] == 'D') {
                                    $uraian           =   $dt['uraian'];
                                    $kolom_debet    =   $dt['nominal'];
                                    $kolom_kredit   =   "0";
                                    $saldo = $saldo + $kolom_debet - $kolom_kredit;
                                } elseif ($dt['tipe'] == 'K') {
                                    $uraian           =   $dt['uraian'];
                                    $kolom_kredit   =   $dt['nominal'];
                                    $kolom_debet    =   "0";
                                    $saldo = $saldo - $kolom_kredit;
                                } ?>
                                <tr>
                                    <td><?= $ang++ ?></td>
                                    <td align="left"><?= $dt['uraian'] ?></td>
                                    <td><?= number_format($kolom_debet) ?></td>
                                    <td><?= number_format($kolom_kredit) ?></td>
                                    <td><?= number_format($saldo) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
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