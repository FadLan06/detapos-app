<?php
$tgl = date('Y-m-d H-i-s');
header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=$judul $tgl.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>

<center>
    <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
        LAPORAN PEMBELIAN BARANG
    </h4>
</center>

<div>
    <div class="">
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

<br>

<table class="table table-bordered" border="1" style="text-align:center; width:100">
    <thead>
        <tr>
            <th width="15%">#</th>
            <th>SUPPLIER</th>
            <th>KODE BARANG</th>
            <th>NAMA BARANG</th>
            <th width="5%">ITEM</th>
            <th>HARGA</th>
            <th>SUB TOTAL</th>
        </tr>
    </thead>
    <?php if ($pembelian->num_rows() > 0) : ?>
        <tbody>
            <?php $no = 1;
            $ttl2 = 0;
            foreach ($pembelian->result_array() as $pem) : ?>
                <?php $sup = $this->db->get_where('tb_supplier', ['kode_sup' => $pem['kd_supplier'], 'token' => $pem['token']])->row_array(); ?>
                <tr style="border-top: 2px solid #00aaff">
                    <td class="bg-light" style="width: 10;"><?= $no++ ?></td>
                    <td colspan="6" align="left" class="bg-light">
                        <?php if ($pem['kd_supplier'] == '') : ?>
                            <?= '' ?>
                            <?php $kd = ''; ?>
                        <?php else : ?>
                            <b><?= $sup['kode_sup'] ?> - <?= $sup['nama_toko'] ?></b>
                            <?php $kd = $sup['kode_sup']; ?>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php
                $sub = $this->db->query("SELECT *, sum(harga_beli*jumlah-potongan) as sub_total, sum(jumlah) as kty FROM tb_detail_pembelian WHERE no_faktur='$pem[id_pembelian]' AND token='$pem[token]' GROUP BY kode_barang");
                $count = $sub->num_rows() + 1;
                ?>
                <?php $ttl1 = 0;
                foreach ($sub->result_array() as $data) : ?>
                    <?php $sub_total = $data['harga_beli'] * $data['jumlah']; ?>
                    <tr align="left">
                        <td colspan="2"></td>
                        <td><?= $data['kode_barang'] ?></td>
                        <td><?= $data['nama_barang'] ?></td>
                        <td align="center"><?= $data['jumlah'] ?></td>
                        <td>Rp. <?= number_format($data['harga_beli']) ?></td>
                        <td>Rp. <?= number_format($sub_total) ?></td>
                    </tr>
                    <?php $ttl1 += $sub_total ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="6" align="right"><b>TOTAL PEMBELIAN</b></td>
                    <td><b>Rp. <?= number_format($ttl1) ?></b></td>
                </tr>
                <?php $ttl2 += $ttl1 ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="border-top: 2px solid #00aaff">
                <td colspan="6"><b>TOTAL</b></td>
                <td><b>Rp. <?= number_format($ttl2) ?></b></td>
            </tr>
        </tfoot>
    <?php else : ?>
        <tbody>
            <tr>
                <td colspan='8'>
                    <i>
                        <center>
                            -----------
                            Tidak Ada Data
                            -----------
                        </center>
                    </i>
                </td>
            </tr>
        </tbody>
    <?php endif; ?>
    <table>