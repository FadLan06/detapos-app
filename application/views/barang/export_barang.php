<?php
$tgl = date('Y-m-d H-i-s');
header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=$judul $tgl.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>

<center>
    <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
        DATA BARANG
    </h4>
</center>
<br>
<table border="1" cellspacing="0" width="70%">
    <?php if (isset($retail['menu_id'])) : ?>
        <thead style="text-align:center; ">
            <tr>
                <th width="5%">#</th>
                <th width="15%">Kode</th>
                <th width="30%">Nama Barang</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th width="10%">Terjual / Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($barang as $br) : ?>
                <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
                <?php
                $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']]);
                $kd = $query->num_rows();
                ?>
                <tr>
                    <td style="vertical-align: middle" align="center"><?= $no++ ?> </td>
                    <td style="vertical-align: middle" align="left">
                        <div class="kodee_brangg"><?= $br['kode'] ?></div>
                    </td>
                    <td style="vertical-align: middle" align="left"><?= $br['nama_barang'] ?></td>
                    <td align="center" style="vertical-align: middle">Rp. <?= number_format($br['harga_beli']) ?></td>
                    <td align="center" style="vertical-align: middle">
                        <li style="display: <?= $br['harga_jual'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual']) ?></li>
                        <li style="display: <?= $br['harga_jual1'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual1']) ?></li>
                        <li style="display: <?= $br['harga_jual2'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual2']) ?></li>
                    </td>
                    <td align="center" style="vertical-align: middle"><?= number_format($stok['qty']) . ' == ' . number_format($br['jml_stok']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php elseif (isset($check['menu_id'])) : ?>
        <thead class="center" style="text-align:center; ">
            <tr>
                <th width="5%">#</th>
                <th width="15%">Kode</th>
                <th width="15%">Nama Barang</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th width="10%">Terjual / Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($barang as $br) : ?>
                <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
                <?php $stok1 = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_checkout t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
                <?php
                $kd = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']])->num_rows();
                $kd1 = $this->db->get_where('tb_checkout', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']])->num_rows();
                ?>
                <tr>
                    <td align="center" style="vertical-align: middle"><?= $no++ ?> </td>
                    <td style="vertical-align: middle" align="left">
                        <div class="kodee_brangg"><?= $br['kode'] ?></div>
                    </td>
                    <td style="vertical-align: middle" align="left"><?= $br['nama_barang'] ?></td>
                    <td align="center" style="vertical-align: middle">Rp. <?= number_format($br['harga_beli']) ?></td>
                    <td align="center" style="vertical-align: middle">
                        <li style="display: <?= $br['harga_jual'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual']) ?></li>
                        <li style="display: <?= $br['harga_jual1'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual1']) ?></li>
                        <li style="display: <?= $br['harga_jual2'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual2']) ?></li>
                    </td>
                    <td align="center" style="vertical-align: middle"><?= number_format($stok['qty'] + $stok1['qty']) . ' == ' . number_format($br['jml_stok']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php else : ?>
        <thead class="center" style="text-align:center; ">
            <tr>
                <th width="5%">#</th>
                <th width="15%">Kode</th>
                <th width="30%">Nama Barang</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th width="10%">Terjual / Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($barang as $br) : ?>
                <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
                <?php
                $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']]);
                $kd = $query->num_rows();
                ?>
                <tr>
                    <td align="center" style="vertical-align: middle"><?= $no++ ?> </td>
                    <td style="vertical-align: middle" align="left"><?= $br['kode'] ?></td>
                    <td style="vertical-align: middle" align="left"><?= $br['nama_barang'] ?></td>
                    <td style="vertical-align: middle" align="center">Rp. <?= number_format($br['harga_beli']) ?></td>
                    <td style="vertical-align: middle" align="center">Rp. <?= number_format($br['harga_jual']) ?></td>
                    <td align="center" style="vertical-align: middle"><?= number_format($stok['qty']) . ' == ' . number_format($br['jml_stok']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>