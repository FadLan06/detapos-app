<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Cetak Struk - Detapos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @media print {
            @page {
                size: auto;
                margin: 0mm;
            }
        }

        body {
            width: 100mm;
            height: 150mm;
        }
    </style>
</head>

<body>
    <table width="100%" style="border: 1px solid #111; font-size: 10px; margin-bottom: 8px; height: 150mm">
        <tr height="10%">
            <td colspan="2"><img src="<?= base_url() ?>assets/upload/<?= $logo['logo'] ?>" style="margin: 5px 0px 5px 8px" height="40px"></td>
            <td colspan="2"></td>
        </tr>
        <tr height="1%">
            <td colspan="4" style="border-bottom: 1px solid #111;"></td>
        </tr>
        <tr height="10%">
            <td width="25%" align="center"><img src="http://localhost:84/detashop/assets/img/expedisi/jne.png" width="50px"></td>
            <td width="25%">JNE <br> Regular</td>
            <td colspan="2" width="50%">||||||||||||||||||||||||</td>
        </tr>
        <tr height="10%">
            <td width="25%">Berat : <br> 12 Gr</td>
            <td width="25%">Ongkir :<br> Rp. 7.000</td>
            <td colspan="2" width="50%" align="center"><b style="font-size: 12px;">79865432100</b> <br> <i>Kode ini bukan No Resi Pengiriman</i></td>
        </tr>
        <tr height="1%">
            <td colspan="4" style="border-bottom: 1px solid #111;"></td>
        </tr>
        <tr height="10%">
            <td colspan="2">Kepada : <br> <b>qwerty</b> <br> jl. qwerty <br>0821</td>
            <td colspan="2">Dari : <br> <b>ytrewq</b> <br> jl. qwerty <br> 0821</td>
        </tr>
        <tr height="10%">
            <td colspan="4" style="border-bottom: 1px dashed #111;"></td>
        </tr>
        <tr height="10%">
            <td colspan="3">Produk : <br> 1. aaaaaaaaaaaaaaaaaaaaaa</td>
            <td width="10%">jumlah : <br> 2 pcs</td>
        </tr>
    </table>

    <script type="text/javascript">
        window.print();
        // window.history.back();
    </script>
</body>

</html>