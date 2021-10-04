<?php $sup = $this->db->get_where('tb_supplier', ['kode_sup' => $data['kd_supplier'], 'token' => $data['token']])->row_array(); ?>
<table class="table table-sm" style="font-size: 12px">
    <tr style="border-bottom:1px solid #ccc;">
        <td width="150px">No. Invoice</td>
        <td width="10px">:</td>
        <td><b><?= $data['no_faktur'] ?></b></td>
    </tr>
    <tr style="border-bottom:1px solid #ccc;">
        <td>Kode / Nama Supplier</td>
        <td>:</td>
        <td>
            <b>
                <?php if ($data['kd_supplier'] == '') : ?>
                    <?= $supp = '' ?>
                <?php else : ?>
                    <?php echo $sup['kode_sup'] . ' / ' . $sup['nama_toko']; ?>
                    <?php $supp =  $sup['kode_sup']; ?>
                <?php endif; ?>
            </b>
        </td>
    </tr>
    <tr style="border-bottom:1px solid #ccc;">
        <td>Tanggal Transaksi</td>
        <td>:</td>
        <td><b><?= date('d-m-Y | H:i:s', strtotime($data['timestmp'])) ?></b></td>
    </tr>
</table>

<?php $dt = $this->db->query("SELECT *, sum(jumlah) as jumlah FROM tb_detail_pembelian WHERE token='$pem[token]' AND kode_barang='$pem[kode_barang]' AND no_faktur='$pem[no_faktur]'")->row_array(); ?>
<table class="table table-sm mb-2" style="font-size: 12px">
    <tr style="border-bottom:1px solid #ccc;">
        <td width="150px">Kode Barang</td>
        <td width="10px">:</td>
        <td><b><?= $dt['kode_barang'] ?></b></td>
    </tr>
    <tr style="border-bottom:1px solid #ccc;">
        <td width="150px">Nama Barang</td>
        <td width="10px">:</td>
        <td><b><?= $dt['nama_barang'] ?></b></td>
    </tr>
    <tr style="border-bottom:1px solid #ccc;">
        <td>Item</td>
        <td>:</td>
        <td><b><?= $dt['jumlah'] ?></b></td>
    </tr>
    <tr style="border-bottom:1px solid #ccc;">
        <td>Harga</td>
        <td>:</td>
        <td><b>Rp. <?= number_format($dt['harga_beli']) ?></b></td>
    </tr>
</table>
<form method="post" action="<?= base_url('Pembelian/aksi_retur') ?>">
    <input type="hidden" name="kode_barang" value="<?= $dt['kode_barang'] ?>">
    <input type="hidden" name="no_faktur" value="<?= $data['no_faktur'] ?>">
    <input type="hidden" name="kode_supplier" value="<?= $supp ?>">
    <input type="hidden" name="id_pembelian" value="<?= $data['id_pembelian'] ?>">
    <div class="form-group">
        <label for="formGroupExampleInput">Jumlah Barang</label>
        <input type="number" class="form-control" name="jumlah_barang" id="formGroupExampleInput" required autocomplete="off">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Alasan</label>
        <textarea class="form-control" id="formGroupExampleInput2" name="alasan" required autocomplete="off"></textarea>
    </div>
    <button type="submit" class="btn btn-danger float-right" name="smpn_beli">Retur Barang</button>
    <button type="button" class="btn btn-warning float-right mr-2" data-dismiss="modal">Keluar</button>
</form>