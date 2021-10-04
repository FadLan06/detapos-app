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
            Telp. <?= $toko['no_telpon']; ?>
        </div>
        <div class="">
            <span class="">
                <br>
            </span>
        </div>
    </div>

    <center>
        <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
            DATA RESELLER
        </h4>
    </center>

    <br>

    <table class="table table-striped table-bordered table-sm" border="1" cellspacing="0" width="70%">
        <thead align="center">
            <tr>
                <th width="5%">#</th>
                <th>NAMA</th>
                <th>EMAIL</th>
                <th>NO. TELPON</th>
                <th>ALAMAT</th>
                <th width="6%">COUNT</th>
                <th width="15%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($res as $data) : ?>
                <?php $coun = $this->db->query("SELECT COUNT(s.id_shop_pel) as pel FROM tb_shop s WHERE s.id_shop_pel='$data[id_shop_pel]' AND s.status_bayar='1'")->row(); ?>
                <?php $total = $this->db->query("SELECT SUM(total) as tot FROM tb_shop s WHERE s.id_shop_pel='$data[id_shop_pel]' AND s.status_bayar='1'")->row(); ?>
                <?php if ($data['is_active'] == 1) {
                    $b = 'success';
                    $n = 'Aktif';
                    $a = 0;
                } else {
                    $b = 'danger';
                    $n = 'Non Aktif';
                    $a = 1;
                } ?>
                <tr>
                    <td align="center"><?= $no++ ?></td>
                    <td><?= $data['nama_pel'] ?></td>
                    <td><?= $data['email'] ?></td>
                    <td><?= $data['no_hp'] ?></td>
                    <td><?= $data['alamat'] ?></td>
                    <td align="center"><?= $coun->pel ?> Kali</td>
                    <td align="center">Rp. <?= number_format($total->tot) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>