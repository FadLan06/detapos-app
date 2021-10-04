<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <title>Cetak Penjualan Pelanggan - DETAPOS</title>
</head>

<body>
    <?php
    // date_default_timezone_set("Asia/Makassar");
    $tglawal  = $_POST['tgl_awal'];
    $tglakhir  = $_POST['tgl_akhir'];
    ?>

    <?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $_POST['token'], 'kd_pelanggan' => $_POST['kd_pelanggan']])->row(); ?>

    <div class="mt-4 ml-4 mr-4 mb-4">
        <h4><b><?= $toko['nama_toko']; ?></b></h4>

        <div>
            <div class=""><?= $toko['alamat']; ?><br>
                Telp. <?= $toko['no_telpon']; ?><br>
            </div>
            <div class="">
                <span class="">
                    <br>
                </span>
            </div>
        </div>

        <table width="100%" class="mb-2 mt-0">
            <tr>
                <td width="8%"><b>Range :</b></td>
                <td colspan="3">
                    <b>
                        <?php if ($_POST['report'] == 'harian') {
                            echo 'Harian (' . $_POST['tanggal'] . ')';
                        } elseif ($_POST['report'] == 'minggu') {
                            echo 'Minggu/Bulan (' . $_POST['tgl_awal'] . ' sampai ' . $_POST['tgl_akhir'] . ')';
                        } elseif ($_POST['report'] == 'terlaris') {
                            echo 'Terlaris';
                        } ?>
                    </b>
                </td>
            </tr>
        </table>

        <center>
            <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
                LAPORAN PENJUALAN PELANGGAN
            </h4>
        </center>

        <br>
        <table class="table table-sm table-hover" style="border-bottom: 1px solid #d3d3d3" id="">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO. TRANSAKSI</th>
                    <th>NAMA PELANGGAN</th>
                    <th>TGL. TRANSAKSI</th>
                    <th>PETUGAS</th>
                    <th></th>
                </tr>
            </thead>
            <?php if (!empty($data)) : ?>
                <tbody>
                    <?php $total = 0;
                    $poto = 0;
                    $no = 1;
                    foreach ($data as $pen) { ?>
                        <?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $pen['token'], 'nama_pel' => $pen['kode_pelanggan']])->row(); ?>
                        <tr class="bg-light">
                            <td><?= $no++ ?></td>
                            <td><?= $pen['no_transaksi'] ?></td>
                            <td>
                                <?php if ($pen['kode_pelanggan'] == NULL) {
                                    echo 'UMUM';
                                } else {
                                    echo $pel->nama_pel;
                                } ?>
                            </td>
                            <td><?= date('d F Y', strtotime($pen['timestmp'])) ?></td>
                            <td><?= $pen['petugas'] ?></td>
                            <td></td>
                        </tr>
                        <?php $total += $pen['total'] ?>
                        <?php $poto = $poto + $pen['pot']  ?>
                        <?php $potto = $pen['pot']  ?>
                        <?php $per = $pen['diskon']  ?>
                        <tr align="center">
                            <th></th>
                            <th>NAMA BARANG</th>
                            <th>QTY</th>
                            <th>HARGA</th>
                            <th>POTONGAN</th>
                            <th>SUB TOTAL</th>
                        </tr>
                        <?php
                        $sub = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$pen[no_transaksi]' AND token='$pen[token]' GROUP BY harga, kode_barang ORDER BY kode_barang");
                        $count = $sub->num_rows() + 1;
                        ?>
                        <tr>
                            <td rowspan="<?= $count ?>"></td>
                            <?php $ttl_ju = 0;
                            foreach ($sub->result() as $data) : ?>
                                <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$data->kode_barang' AND token='$data->token'")->row(); ?>
                        <tr align="center">
                            <td><?= $pen->nama_barang ?></td>
                            <td><?= $data->kty ?></td>
                            <td>RP. <?= number_format($data->harga) ?></td>
                            <td>Rp. <?= number_format($data->potongan) ?></td>
                            <td>Rp. <?= number_format($data->sub_total) ?></td>
                        </tr>
                        <?php $ttl_ju += $data->sub_total; ?>
                    <?php endforeach; ?>
                    <?php if ($potto > 0) : ?>
                        <tr>
                            <td colspan="5" align="right"><b>SUB TOTAL</b></td>
                            <td align="center"><b>Rp. <?= number_format($ttl_ju) ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right"><b>DISKON</b></td>
                            <td align="center"><b>Rp. <?= number_format($potto) . ' (' . number_format($per) . '%)' ?></b></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="5" align="right"><b>TOTAL PENJUALAN</b></td>
                        <td align="center"><b>Rp. <?= number_format($ttl_ju - $potto) ?></b></td>
                    </tr>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5"><b>Total Pendapatan</b></td>
                        <td><b>Rp. <?= number_format($total - $poto) ?></b></td>
                    </tr>
                </tfoot>
            <?php else : ?>
                <tbody>
                    <tr>
                        <td colspan='6'>
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
        // window.print();
        // window.history.back();
    </script>
    <script src="<?= base_url('assets/') ?>bootstrap/js/bootstrap.min.js"></script>
</body>

</html>