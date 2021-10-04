<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Cetak Struk - Detapos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url() ?>assets/w3.css">
    <!-- <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css"> -->
    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0mm;
        }
    </style>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }

        hr {
            height: 0;
            border: 0;
            border-top: 5px solid #f4e30d;
            margin: 20px 0;
        }

        .w3-table td,
        .w3-table th,
        .w3-table-all td,
        .w3-table-all th {
            padding: 5px 8px;
            display: table-cell;
            text-align: left;
            vertical-align: top;
        }
    </style>
</head>

<body>
    <?php
    date_default_timezone_set($nm_toko['zona']);
    $tgaal    = date('d-m-Y | H:i:s', strtotime($tra['timestmp']));
    ?>
    <?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $tra['token'], 'nama_pel' => $tra['kode_pelanggan']])->row(); ?>

    <div style="margin-bottom: 15px; margin-left: 35px; margin-right: 40px">
        <table widht="100%" style="margin-top: 50px;">
            <tr>
                <td width="30%"></td>
                <td align="center" style="background-color: #f4e30d;"><img src="<?= base_url('assets/upload/logo_vamos_hitam.png') ?>" width="280px" height="70px" style="padding: 10px 0px;"></td>
                <td width="30%"></td>
            </tr>
        </table>

        <table widht="100%" style="margin-top: 10px;">
            <tr>
                <td width="20%"></td>
                <td align="center">
                    <?= $nm_toko['alamat']; ?><br>
                    <?= $nm_toko['no_telpon']; ?><br>
                    <?= $nm_toko['email_toko']; ?>
                </td>
                <td width="20%"></td>
            </tr>
        </table>

        <table class="" style="margin-top: 40px;" cellpadding="0" width="100%">
            <tr>
                <td width="55%">
                    <?php if ($tra['kode_pelanggan'] == NULL) {
                        echo '<b>Umum</b>';
                    } else {
                        echo '<b>' . $pel->nama_pel . '</b><br>';
                        echo '' . $pel->alamat . '<br>';
                        echo '' . $pel->no_hp . '<br>';
                        echo '' . $pel->email . '<br>';
                    } ?>
                </td>
                <td width="10%"></td>
                <td width="35%" style="vertical-align: top;">
                    <b><?php echo $tra['no_transaksi']; ?></b><br>
                    <?= $tgaal ?>
                </td>
            </tr>
        </table>

        <hr style="color: #f4e30d;">

        <table class="w3-table w3-small" width="100%">
            <thead>
                <th align="left">
                    NAMA BARANG
                </th>
                <th>
                    <center>QTY</center>
                </th>
                <th>
                    <center>HARGA</center>
                </th>
                <th>
                    <center>POTONGAN</center>
                </th>
                <th>
                    <center>SUB TOTAL HARGA</center>
                </th>
            </thead>
            <tbody>
                <?php $total_bayar = 0;
                $no = 1; ?>
                <?php foreach ($penjualan as $p) : ?>
                    <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
                    <tr>
                        <td width="35%">
                            <?= $pen['nama_barang'] ?>
                        </td>
                        <td>
                            <center><?= $p['kty'] ?></center>
                        </td>
                        <td>
                            <center>Rp. <?= number_format($p['harga']) ?></center>
                        </td>
                        <td>
                            <center>Rp. <?= number_format($p['potongan']) ?></center>
                        </td>
                        <td>
                            <center>Rp. <?= number_format($p['sub_total']) ?></center>
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
                    <td colspan="4" style=" text-align:right;"><b>Sub Total :</b></td>
                    <td style="">
                        <center><b>Rp <?php echo number_format($total_bayar); ?></b></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style=" text-align:right;"><b>Diskon :</b></td>
                    <td style="">
                        <center><b>Rp <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></b></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style=" text-align:right;"><b>Total Bayar :</b></td>
                    <td style="">
                        <center><b>Rp <?php echo number_format($diskon); ?></b></center>
                    </td>
                </tr>
                <tr>
                    <?php if (($this->session->userdata('token') == 'DPE8DR8MRWKYNHJPV')) : ?>
                        <?php if ($tra['status'] == "Hutang") : ?>
                            <td colspan="4" style="text-align:right;"><b>Uang Muka :</b></td>
                        <?php else : ?>
                            <td colspan="4" style="text-align:right;"><b>Tunai :</b></td>
                        <?php endif; ?>
                    <?php else : ?>
                        <td colspan="4" style="text-align:right;"><b>Tunai :</b></td>
                    <?php endif; ?>
                    <td>
                        <center><b>Rp <?php echo number_format($tra['bayar']); ?></b></center>
                    </td>
                </tr>
                <tr>
                    <?php if (($this->session->userdata('token') == 'DPE8DR8MRWKYNHJPV')) : ?>
                        <?php if ($tra['status'] == "Hutang") : ?>
                            <td colspan="4" style="text-align:right;"><b>Sisa Pembayaran :</b></td>
                        <?php else : ?>
                            <td colspan="4" style="text-align:right;"><b>Kembali :</b></td>
                        <?php endif; ?>
                    <?php else : ?>
                        <td colspan="4" style="text-align:right;"><b>Kembali :</b></td>
                    <?php endif; ?>
                    <td style="">
                        <center><b>Rp <?php echo number_format($sisa); ?></b></center>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr style="color: #f4e30d;">

        <table class="" cellpadding="0" width="100%">
            <tr>
                <td width="55%">
                    <b>PAYMENT INFORMATION</b><br>
                    Nur Muhammad Azmi <br>
                    Account Number : BCA 0662778816
                </td>
                <td width="10%"></td>
                <td width="35%" style="vertical-align: top; text-align:right">
                    <img src="<?= base_url('assets/upload/thanks.png') ?>" width="50%"><br>
                    www.vamos-sportapparel.com
                </td>
            </tr>
        </table>
    </div>
</body>

</html>