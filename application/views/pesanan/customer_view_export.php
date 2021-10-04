<?php
$tgl = date('Y-m-d H-i-s');
header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=$judul $tgl.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
<div class="mt-4 ml-4 mr-4 mb-4">
    <h4><b><?= $toko['nama_toko']; ?></b></h4>

    <div>
        <div class=""><?= $toko['alamat']; ?><br>
            Telp. <?= $toko['no_telpon']; ?><br><br>
            Report :
            <?php if ($_POST['report'] == 'harian') {
                echo 'Harian (' . $_POST['tanggal'] . ')';
            } elseif ($_POST['report'] == 'minggu') {
                echo 'Minggu/Bulan (' . $_POST['tgl_awal'] . ' sampai ' . $_POST['tgl_akhir'] . ')';
            } elseif ($_POST['report'] == 'terlaris') {
                echo 'Terlaris';
            } ?>
        </div>
        <div class="">
            <span class="">
                <br>
            </span>
        </div>
    </div>

    <center>
        <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
            REPORT CUSTOMER PESANAN ONLINE
        </h4>
    </center>

    <br>

    <table class="table table-striped table-bordered table-sm" border="1" cellspacing="0" width="70%">
        <thead align="center">
            <tr>
                <th width="5%">#</th>
                <th>KODE BARANG</th>
                <th>NAMA BARANG</th>
                <th>MODAL</th>
                <th>JUAL</th>
                <th width="5%">TERJUAL</th>
                <th>KEUNTUNGAN</th>
            </tr>
        </thead>
        <?php if (!empty($dataa)) : ?>
            <tbody>
                <?php $no = 1;
                $tt = 0;
                $ttl = 0; ?>
                <?php foreach ($dataa as $shop) : ?>
                    <?php if ($_POST['report'] == 'harian') : ?>
                        <?php $dt = $this->db->query("SELECT a.kode_barang, a.nama_barang, a.token, a.harga_beli, b.id_barang, SUM(b.qty) as kty, b.status_bayar, c.id_barang as kd_hg, c.harga_jual FROM tb_shop_detail b LEFT JOIN tb_barang a ON a.kode_barang=b.id_barang LEFT JOIN tb_barang_harga c ON c.id_barang=a.kode_barang WHERE b.token='$shop[token]' AND b.tgl_order_detail='$_POST[tanggal]' AND b.status_bayar='1' AND b.id_barang='$shop[id_barang]' GROUP BY b.id_barang")->row_array(); ?>
                    <?php else : ?>
                        <?php $dt = $this->db->query("SELECT a.kode_barang, a.nama_barang, a.token, a.harga_beli, b.id_barang, SUM(b.qty) as kty, b.status_bayar, c.id_barang as kd_hg, c.harga_jual FROM tb_shop_detail b LEFT JOIN tb_barang a ON a.kode_barang=b.id_barang LEFT JOIN tb_barang_harga c ON c.id_barang=a.kode_barang WHERE b.token='$shop[token]' AND b.tgl_order_detail BETWEEN '$_POST[tgl_awal]' AND '$_POST[tgl_akhir]' AND b.status_bayar='1' AND b.id_barang='$shop[id_barang]' GROUP BY b.id_barang")->row_array(); ?>
                    <?php endif; ?>
                    <?php $ken = ($dt['harga_jual'] * $shop['kkty']) - ($dt['harga_beli'] * $shop['kkty']); ?>
                    <tr>
                        <td align="center"><?= $no++ ?></td>
                        <td><?= $dt['id_barang'] ?></td>
                        <td><?= $dt['nama_barang'] ?></td>
                        <td>Rp. <span class="float-right"><?= number_format($dt['harga_beli']) ?></span></td>
                        <td>Rp. <span class="float-right"><?= number_format($dt['harga_jual']) ?></span></td>
                        <td align="center"><?= $shop['kkty'] ?></td>
                        <td>Rp. <span class="float-right"><?= number_format($ken) ?></span></td>
                    </tr>
                    <?php $tt += $shop['kkty']; ?>
                    <?php $ttl += $ken; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" align="center"><b>TOTAL</b></td>
                    <td align="center"><b><?= $tt ?></b></td>
                    <td>Rp. <b class="float-right"><?= number_format($ttl) ?></b></td>
                </tr>
            </tfoot>
        <?php else : ?>
            <tbody>
                <tr>
                    <td colspan='7'>
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
    </table>
</div>