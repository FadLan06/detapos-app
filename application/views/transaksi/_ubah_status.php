<table class="table table-sm" style="font-size: 12px">
	<tr style="border-bottom:1px solid #ccc;">
		<td width="150px">No. Transaksi</td>
		<td width="10px">:</td>
		<td><b><?= $data['no_transaksi'] ?></b></td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td>Kode / Nama Pelanggan</td>
		<td>:</td>
		<td>
			<b>
				<?php
				if ($data['kode_pelanggan'] == NULL) {
					echo 'Umum';
				} else {
					echo $data['kode_pelanggan'] . ' / ' . $data['nama_pel'];
				}
				?>
			</b>
		</td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td>Tanggal Transaksi</td>
		<td>:</td>
		<td><b><?= date('d-m-Y | H:i:s', strtotime($data['timestmp'])) ?></b></td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td>Status</td>
		<td>:</td>
		<td>
			<b>
				<?php
				if (($this->session->userdata('token') == 'DPE8DR8MRWKYNHJPV')) {
					if ($data['status'] == 'Lunas') {
						echo 'LUNAS';
					} else {
						echo 'PENDING';
					}
				} else {
					if ($data['status'] == 'Lunas') {
						echo 'LUNAS';
					} else {
						echo 'HUTANG';
					}
				}
				?>
			</b>
		</td>
	</tr>
	<?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) : ?>
		<?php if ($data['status'] == 'Hutang') : ?>
			<tr style="border-bottom:1px solid #ccc;">
				<td>Jatuh Tempo</td>
				<td>:</td>
				<td><b><?= date('d-m-Y', strtotime($data['tempo'])) ?></b></td>
			</tr>
		<?php endif; ?>
	<?php endif; ?>
</table>

<?php if ($data['status'] == 'Hutang') : ?>
	<table class="table table-sm" style="font-size: 12px">
		<tr style="border-bottom:1px solid #ccc;">
			<td width="150px">Total Bayar</td>
			<td width="10px">:</td>
			<td><b>Rp. <?= number_format($total_bayar) ?></b></td>
		</tr>
		<?php if (($this->session->userdata('token') == 'DPE8DR8MRWKYNHJPV')) : ?>
			<tr style="border-bottom:1px solid #ccc;">
				<td width="150px">Uang Muka</td>
				<td width="10px">:</td>
				<td><b>Rp. <?= number_format($uang_muka) ?></b></td>
			</tr>
		<?php endif; ?>
		<tr style="border-bottom:1px solid #ccc;">
			<td width="150px">Sisa Pembayaran</td>
			<td width="10px">:</td>
			<td><b>Rp. <?= number_format($total_bayar - $uang_muka) ?></b></td>
		</tr>
	</table>
<?php endif; ?>

<form method="post" action="<?= base_url('Penjualan/aksi') ?>">
	<?php if ($data['status'] == 'Hutang') : ?>
		<div class="form-group">
			<input type="hidden" name="no_transaksi" value="<?= $data['no_transaksi'] ?>">
		</div>
		<?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) : ?>
			<div class="form-group">
				<label for="">Metode Pembayaran :</label><br>
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="tunai" name="metodePem" class="custom-control-input" value="Tunai" checked>
					<label class="custom-control-label" for="tunai">Tunai</label>
				</div>
				<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" id="transfer" name="metodePem" class="custom-control-input" value="Transfer">
					<label class="custom-control-label" for="transfer">Transfer</label>
				</div>
			</div>
			<div class="form-group">
				<select name="bank" id="bank" class="form-control mb-1" style="display: none;">
					<option value="">Pilih Bank ...</option>
					<?php foreach ($rekening as $data) : ?>
						<option value="<?= strtoupper(substr($data->jenis, 5)) . ' - ' . $data->no_rekening ?>"><?= strtoupper(substr($data->jenis, 5)) . ' - ' . $data->no_rekening ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>
		<div class="form-group">
			<label for="uang">Nominal :</label>
			<input type="text" name="uang" id="uang" onkeypress="return hanyaAngka(event)" class="form-control" autocomplete="off" required>
			<input type="hidden" name="uang_muka" value="<?= $uang_muka ?>" class="form-control">
			<input type="hidden" name="modal" value="<?= $modal ?>" class="form-control">
			<input type="hidden" name="no_jurnal" value="<?= $no_jurnal ?>" class="form-control">
		</div>
		<button type="submit" class="btn btn-danger float-right" name="ubh">Simpan Perubahan</button>
	<?php endif; ?>
	<button type="button" class="btn btn-warning float-right mr-2" data-dismiss="modal">Keluar</button>
</form>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery.number.js"></script>
<script type="text/javascript">
	$(function() {
		$("#uang").number(true);
	});
</script>
<script type="text/javascript">
	function hanyaAngka(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))

			return false;
		return true;
	}
</script>
<script>
	$(document).ready(function() {
		$('#transfer').on('change', function() {
			$("#bank").show();
			$("#bank").prop('required', true);
		});
		$('#tunai').on('change', function() {
			$("#bank").hide();
			$("#bank").prop('required', false);
		});
	});
</script>