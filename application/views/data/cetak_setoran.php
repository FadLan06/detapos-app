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
                    echo $bulan . ' ' . $_POST['tahun'];
                } elseif ($_POST['filter'] == '3') {
                    echo $_POST['tahun'];
                } elseif ($_POST['filter'] == '1') {
                    echo $_POST['tanggal'];
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
                LAPORAN DATA SETORAN
            </h4>
        </center>

        <br>

        <div class="table-responsive">
            <table class="table table-bordered table-sm" style="text-align:center; width:100%" id="example">
                <thead>
                    <tr>
                        <th width="5%" rowspan="2" style="vertical-align: middle;">#</th>
                        <th width="15%" rowspan="2" style="vertical-align: middle;">TANGGAL</th>
                        <th width="40%" rowspan="2" style="vertical-align: middle;">URAIAN</th>
                        <th colspan="2">EXPEDISI</th>
                    </tr>
                    <tr>
                        <th>BANK</th>
                        <th>TUNAI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $all = 0;
                    $all1 = 0;
                    foreach ($setoran->result_array() as $data) : ?>
                        <?php $tmp = $this->db->get_where('tb_setoran_tmp', ['token' => $data['token'], 'no_setoran' => $data['no_setoran']])->result();
                        $ttl = 0;
                        $ttl1 = 0;
                        ?>
                        <?php foreach ($tmp as $dt) : ?>
                            <?php if ($dt->expedisi == 'T') {
                                $tunai = $dt->nominal;
                                $bank = 0;
                                $ttl += $tunai;
                                $id = $dt->id_setoran_tmp;
                            } else {
                                $bank = $dt->nominal;
                                $tunai = 0;
                                $ttl1 += $bank;
                                $id = $dt->id_setoran_tmp;
                            } ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d F Y', strtotime($data['tgl_setoran'])) ?></td>
                                <td align="left"><?= $data['uraian'] ?></td>
                                <td>
                                    Rp. <?= number_format($bank) ?>
                                </td>
                                <td>
                                    Rp. <?= number_format($tunai) ?>
                                </td>
                            </tr>
                            <?php
                            $all   +=  $ttl;
                            $all1 +=   $ttl1;
                            ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><b>TOTAL</b></td>
                        <td><b>Rp. <?= number_format($all1) ?></b></td>
                        <td><b>Rp. <?= number_format($all) ?></b></td>
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