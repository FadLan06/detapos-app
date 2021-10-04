<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <title>Report Pesanan ONLINE - DETAPOS</title>
</head>

<body>

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
                REPORT PESANAN ONLINE
            </h4>
        </center>

        <br>

        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                    <?php foreach ($dataa->result_array() as $shop) : ?>
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript">
        window.print();
        // window.history.back();
    </script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
</body>

</html>