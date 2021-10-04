<?php
$tgl = date('Y-m-d H-i-s');
header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=$judul $tgl.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
<?php
// date_default_timezone_set("Asia/Makassar");
$tglawal  = $_POST['bulan'];
$tglakhir  = $_POST['tahun'];
?>

<div class="mt-4 ml-4 mr-4 mb-4">
    <center>
        <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
            LAPORAN DATA FINAL REKON
        </h4>
    </center>

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

    <br>

    <div class="row">
        <?php $no = 1;
        foreach ($final->result_array() as $data) : ?>
            <?php $detail = $this->db->get_where('tb_rekon_final', ['token' => $data['token'], 'tgl_final' => $data['tgl_final']]); ?>
            <div class="col-md-6">
                <p><b>FINALISASI DATA REKON <br /> Tanggal</b> : <?= longdate_indo($data['tgl_final']) ?></p>
                <table border="1" width="50%" style="text-align:center;">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Uraian</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
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
                                <td align="left"><?= $dt['uraian'] ?> </td>
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