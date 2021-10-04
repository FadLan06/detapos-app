<table class="table table-sm" style="font-size: 12px">
	<tr style="border-bottom:1px solid #ccc;">
		<td width="150px">Kode Barang</td>
		<td width="10px">:</td>
		<td><b><?= $data['kode_barang'] ?></b></td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td>Nama Barang</td>
		<td>:</td>
		<td><b><?= $data['nama_barang'] ?></b></td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td>Stok Tersedia</td>
		<td>:</td>
		<td><b><?= $data['jml_stok'] ?></b></td>
	</tr>
</table>
<form method="post" action="<?= base_url('Barang/aksi_retur') ?>">
	<input type="hidden" name="id" value="<?= $data['id'] ?>">
	<input type="hidden" name="kode_barang" value="<?= $data['kode_barang'] ?>">
	<div class="form-group">
		<label for="formGroupExampleInput">Supplier</label>
		<select name="kode_supplier" id="kode_supplier" class="form-control">
			<?php foreach ($sup as $data) : ?>
				<option value="<?= $data['kode_sup'] ?>"><?= $data['kode_sup'] ?> / <?= $data['nama_toko'] ?></option>
			<?php endforeach; ?>
		</select>
	</div>
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