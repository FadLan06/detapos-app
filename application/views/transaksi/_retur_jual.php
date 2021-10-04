
<table class="table table-sm" style="font-size: 12px">
	<tr style="border-bottom:1px solid #ccc;">
		<td width="150px">No. Transaksi</td>
		<td width="10px">:</td>
		<td><b><?=$data['no_transaksi']?></b></td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td>Kode / Nama Pelanggan</td>
		<td>:</td>
		<td>
			<b>
				<?php
				if($data['kode_pelanggan'] == NULL){
					echo 'Umum';
				}else{
					echo $data['kode_pelanggan'] .' / '.$data['nama_pel'];
				}
				?>
			</b>
		</td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td>Status</td>
		<td>:</td>
		<td>
			<b>
				<?php 
				if($data['status'] == 'Lunas') {
					echo 'LUNAS';
				}else{
					echo 'HUTANG';
				}
				?>
			</b>
		</td>
	</tr>
</table>
<?php
	$lis = $this->db->query("SELECT *, sum(harga*qty) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$list_pen[no_transaksi]' AND token='$list_pen[token]' AND kd_penjualan='$list_pen[kd_penjualan]' GROUP BY kode_barang")->row();
	$pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$list_pen[kode_barang]' AND token='$list_pen[token]'")->row_array();
?>
<table class="table table-sm mb-2" style="font-size: 12px">
	<tr style="border-bottom:1px solid #ccc;">
		<td width="150px">Nama Barang</td>
		<td width="10px">:</td>
		<td><b><?=$pen['nama_barang']?></b></td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td>Harga Barang</td>
		<td>:</td>
		<td><b>Rp. <?=number_format($lis->harga)?></b></td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td>QTY</td>
		<td>:</td>
		<td><b><?=$lis->kty.' '.$pen['satuan']?></b></td>
	</tr>
	<tr style="border-bottom:1px solid #ccc;">
		<td width="150px">Sub Total</td>
		<td width="10px">:</td>
		<td><b>Rp. <?=number_format($lis->sub_total)?></b></td>
	</tr>
</table>
<form method="post" action="<?=base_url('Penjualan/aksi')?>">
	<input type="hidden" name="no_transaksi" value="<?=$data['no_transaksi']?>">
	<input type="hidden" name="kode_barang" value="<?=$pen['kode_barang']?>">
	<input type="hidden" name="qty" value="<?=$lis->kty?>">
	<input type="hidden" name="harga" value="<?=$lis->harga?>">
	<input type="hidden" name="stok" value="<?=$pen['jml_stok']?>">
	<input type="hidden" name="kd_penjualan" value="<?=$lis->kd_penjualan?>">
	<input type="hidden" name="id" value="<?=$pen['id']?>">
	<input type="hidden" name="kode_pelanggan" value="<?=$data['kode_pelanggan']?>">
	<div class="form-group">
		<label for="">Jumlah Barang Yang Akan Di Retur Oleh Pembeli  :</label><br>
		<input type="text" name="jml_retur" class="form-control" required autocomplete="off">
	</div>
	<button type="submit" class="btn btn-danger float-right" name="retur_jual">Retur Barang</button>
	<button type="button" class="btn btn-warning float-right mr-2" data-dismiss="modal">Keluar</button>
</form>