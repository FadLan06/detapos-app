<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Cetak Struk - Detapos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url() ?>assets/w3.css">
    <style>
        @media print {
            @page {
                size: auto;
                margin: 0mm;
            }
        }
    </style>
</head>

<body>
    <?php
    date_default_timezone_set($nm_toko['zona']);
    $tgaal    = date('d-m-Y | H:i:s', strtotime($tra['timestmp']));
    ?>

    <table cellspacing="0" cellpadding="0" style="font-size: 9px; margin: 0mm; margin-top: 10px" width="100%">
        <tr align="center">
            <td><img src="<?= base_url('assets/upload/') . $nm_toko['logo']; ?>" width="50px"></td>
        </tr>
    </table>
    <table cellspacing="0" cellpadding="0" style="font-size: 9px; margin: 0mm; margin-top: 10px" width="100%">
        <tr align="center">
            <td><?php echo $nm_toko['nama_toko']; ?></td>
        </tr>
        <tr align="center">
            <td><?php echo $nm_toko['alamat']; ?></td>
        </tr>
        <tr align="center">
            <td><?php echo $nm_toko['no_telpon']; ?></td>
        </tr>
    </table>
    <table cellspacing="0" cellpadding="0" style="font-size: 9px; margin: 0mm; margin-top: 10px" width="100%">

        <?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $tra['token'], 'kode_pel' => $tra['kode_pelanggan']])->row(); ?>
        <tr>
            <td colspan="3">
                <a>No. Struk : <?php echo $tra['no_transaksi']; ?></a> /
                <a><?php if ($tra['kode_pelanggan'] == NULL) {
                        echo 'Umum';
                    } else {
                        echo $pel->nama_pel;
                    } ?></a><br>
                <a> <?php echo $tgaal; ?></a>
            </td>
        </tr>
    </table>
    <table cellspacing="0" cellpadding="2" style="font-size: 9px; margin: 0mm; margin-top: 10px" width="100%">
        <?php if (isset($akses1['menu_id'])) : ?>
            <?php $total_bayar = 0; ?>
            <?php foreach ($penjualan as $p) : ?>
                <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
                <tr>
                    <td>
                        <?= $pen['nama_barang'] ?> <br>
                        <?= $p['kty'] ?> x <?= number_format($p['harga']) ?>
                    </td>
                    <td colspan='2' style='border-bottom:1px dashed #111; text-align:right'>
                        &nbsp&nbsp<br>
                        Rp. <?= number_format($p['sub_total']) ?>
                    </td>
                </tr>
                <?php
                $total_bayar = $total_bayar + $p['sub_total'];
                $diskon = $total_bayar - (($total_bayar * $tra['diskon']) / 100);
                $total = $total_bayar - $diskon;
                $sisa = $tra['bayar'] - $diskon;
                ?>
            <?php endforeach; ?>
            <tr>
                <td colspan='2'><b>Diskon</b></td>
                <td align="right"><a>Rp. <?php echo number_format($total) . ' (' . $tra['diskon'] . '%)'; ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Total</b></td>
                <td align="right"><a>Rp. <?php echo number_format($diskon); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Tunai</b></td>
                <td align="right" style='border-bottom:1px dashed #000;'><a>Rp. <?php echo number_format($tra['bayar']); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Kembali</b></td>
                <td align="right"><a>Rp. <?php echo number_format($sisa); ?></a></td>
            </tr>
        <?php elseif (isset($akses2['menu_id'])) : ?>
            <?php $total_bayar = 0; ?>
            <?php foreach ($penjualan as $p) : ?>
                <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
                <tr>
                    <td>
                        <?= $pen['nama_barang'] ?> <br>
                        <?= $p['kty'] ?> x <?= number_format($p['harga']) ?> (<?= number_format($p['potongan']) ?>)
                    </td>
                    <td colspan='2' style='border-bottom:1px dashed #111; text-align: right;'>
                        &nbsp&nbsp<br>
                        Rp. <?= number_format($p['sub_total']) ?>
                    </td>
                </tr>
                <?php
                $total_bayar = $total_bayar + $p['sub_total'];
                $diskon = $total_bayar - (($total_bayar * $tra['disc']) / 100);
                $total = $total_bayar - $diskon;
                $sisa = $tra['bayar'] - $diskon;
                ?>
            <?php endforeach; ?>
            <tr>
                <td colspan='2'><b>Sub Total</b></td>
                <td align="right"><a>Rp. <?php echo number_format($total_bayar); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Diskon</b></td>
                <td align="right"><a>Rp. <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Total Bayar</b></td>
                <td align="right"><a>Rp. <?php echo number_format($diskon) ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Tunai</b></td>
                <td align="right" style='border-bottom:1px dashed #000;'><a>Rp. <?php echo number_format($tra['bayar']); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Kembali</b></td>
                <td align="right"><a>Rp. <?php echo number_format($sisa); ?></a></td>
            </tr>
        <?php elseif (isset($akses['menu_id'])) : ?>
            <?php $total_bayar = 0; ?>
            <?php foreach ($penjualan as $p) : ?>
                <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
                <tr>
                    <td>
                        <?= $pen['nama_barang'] ?> <br>
                        <?= $p['kty'] ?> x <?= number_format($p['harga']) ?> (<?= number_format($p['potongan']) ?>)
                    </td>
                    <td colspan='2' style='border-bottom:1px dashed #111; text-align:right'>
                        &nbsp&nbsp<br>
                        Rp. <?= number_format($p['sub_total']) ?>
                    </td>
                </tr>
                <?php
                $total_bayar = $total_bayar + $p['sub_total'];
                $diskon = $total_bayar - (($total_bayar * $tra['disc']) / 100);
                $total = $total_bayar - $diskon;
                $sisa = $tra['bayar'] - $diskon;
                ?>
            <?php endforeach; ?>
            <tr>
                <td colspan='2'><b>Sub Total</b></td>
                <td align="right"><a>Rp. <?php echo number_format($total_bayar); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Diskon</b></td>
                <td align="right"><a>Rp. <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Total Bayar</b></td>
                <td align="right"><a>Rp. <?php echo number_format($diskon) ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Tunai</b></td>
                <td align="right" style='border-bottom:1px dashed #000;'><a>Rp. <?php echo number_format($tra['bayar']); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Kembali</b></td>
                <td align="right"><a>Rp. <?php echo number_format($sisa); ?></a></td>
            </tr>
        <?php elseif (isset($akses3['menu_id'])) : ?>
            <?php $total_bayar = 0; ?>
            <?php foreach ($penjualan as $p) : ?>
                <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
                <tr>
                    <td>
                        <?= $pen['nama_barang'] ?> <br>
                        <?= $p['kty'] ?> x <?= number_format($p['harga']) ?> (<?= number_format($p['potongan']) ?>)
                    </td>
                    <td colspan='2' style='border-bottom:1px dashed #111; text-align:right'>
                        &nbsp&nbsp<br>
                        Rp. <?= number_format($p['sub_total']) ?>
                    </td>
                </tr>
                <?php
                $total_bayar = $total_bayar + $p['sub_total'];
                $diskon = $total_bayar - (($total_bayar * $tra['disc']) / 100);
                $total = $total_bayar - $diskon;
                $sisa = $tra['bayar'] - $diskon;
                ?>
            <?php endforeach; ?>
            <tr>
                <td colspan='2'><b>Sub Total</b></td>
                <td align="right"><a>Rp. <?php echo number_format($total_bayar); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Diskon</b></td>
                <td align="right"><a>Rp. <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Total Bayar</b></td>
                <td align="right"><a>Rp. <?php echo number_format($diskon) ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Tunai</b></td>
                <td align="right" style='border-bottom:1px dashed #000;'><a>Rp. <?php echo number_format($tra['bayar']); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Kembali</b></td>
                <td align="right"><a>Rp. <?php echo number_format($sisa); ?></a></td>
            </tr>
        <?php elseif (isset($akses4['menu_id'])) : ?>
            <?php $total_bayar = 0; ?>
            <?php foreach ($penjualan as $p) : ?>
                <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
                <tr>
                    <td>
                        <?= $pen['nama_barang'] . '/' . $pen['warna'] . '/' . $pen['ukuran'] ?> <br>
                        <?= $p['kty'] ?> x <?= number_format($p['harga']) ?> (<?= number_format($p['potongan']) ?>)
                    </td>
                    <td colspan='2' style='border-bottom:1px dashed #111; text-align: right;'>
                        &nbsp&nbsp<br>
                        Rp. <?= number_format($p['sub_total']) ?>
                    </td>
                </tr>
                <?php
                $total_bayar = $total_bayar + $p['sub_total'];
                $diskon = $total_bayar - (($total_bayar * $tra['disc']) / 100);
                $total = $total_bayar - $diskon;
                $sisa = $tra['bayar'] - $diskon;
                ?>
            <?php endforeach; ?>
            <tr>
                <td colspan='2'><b>Sub Total</b></td>
                <td align="right"><a>Rp. <?php echo number_format($total_bayar); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Diskon</b></td>
                <td align="right"><a>Rp. <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Total Bayar</b></td>
                <td align="right"><a>Rp. <?php echo number_format($diskon) ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Tunai</b></td>
                <td align="right" style='border-bottom:1px dashed #000;'><a>Rp. <?php echo number_format($tra['bayar']); ?></a></td>
            </tr>
            <tr>
                <td colspan='2'><b>Kembali</b></td>
                <td align="right"><a>Rp. <?php echo number_format($sisa); ?></a></td>
            </tr>
        <?php endif; ?>
    </table>
    <table cellspacing="0" cellpadding="2" style="font-size: 9px; margin: 0mm; margin-top: 5px" width="100%">
        <tr align="center">
            <td>
                Terima kasih atas kunjungan anda. <br>
                Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.
            </td>
        </tr>
        <tr>
            <td>
                -<br><br>
            </td>
        </tr>
    </table>

    <script type="text/javascript">
        window.print();
        // window.history.back();
    </script>
</body>

</html>