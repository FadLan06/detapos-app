<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<title>Cetak Struk - Detapos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="assets/w3.css"> 
	
</head>
<body>
	<?php
	date_default_timezone_set('Asia/Hong_Kong');
	$tgaal    = date('d-m-Y | H:i:s', strtotime($tra['timestmp']));
	?>
	<style>
		@page { size: 58mm 500mm; margin: 10px 10px 0px 10px; }
		/*body { background-color: #999; }*/
	</style>
	<div style="font-size: 9px; ">
		<div class="w3-tinystruk">
			<center>
				<p class="w3-tinystrukhead">
					<?php echo $nm_toko['nama_toko']; ?>
					<br><?php echo $nm_toko['alamat']; ?>
					<br><?php echo $nm_toko['no_telpon']; ?>
				</p>
			</center>
		</div>

		<table cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td colspan="2">
						<a>No. Struk : <?php echo $tra['no_transaksi']; ?></a> /
						<a><?php if($tra['kode_pelanggan'] == NULL){ echo 'Umum';}else{ echo $tra['nama_pel']; } ?></a><br>
						<a><?php echo $tgaal; ?></a>
					</td>
				</tr>
			</tbody>

			<thead></thead>
			<tbody>
				<?php $total_bayar = 0; ?>
				<?php foreach($penjualan as $p): ?>
					<?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
					<tr>
						<td colspan="3">
							<?=$pen['nama_barang']?> <br>
							<?=$p['kty']?> x <?=number_format($p['harga'])?> 
						</td>
						<td style='border-bottom:1px dashed #111;'>
							
							Rp. <?=number_format($p['sub_total'])?>
						</td>
					</tr>
					<?php 
					$total_bayar = $total_bayar+$p['sub_total'];
					$sisa = $tra['bayar'] - $total_bayar;
					?>
				<?php endforeach; ?>
			</tbody>
			<tbody cellspacing="0">
				<tr>
					<td colspan='3'><b>Total</b></td>
					<td><a>Rp. <?php echo number_format($total_bayar); ?></a></td>
				</tr>
				<tr>
					<td colspan='3'><b>Tunai</b></td>
					<td style='border-bottom:1px dashed #000;'><a>Rp. <?php echo number_format($tra['bayar']); ?></a></td>
				</tr>
				<tr>
					<td colspan='3'><b>Kembali</b></td>
					<td><a>Rp. <?php echo number_format($sisa); ?></a></td>
				</tr>
			</tbody>
		</table>

		<div class="w3-tinystruk" style="margin-top: 5px">
			<center>
				<p class="w3-tinystrukhead">
				Terima kasih atas kunjungan anda.
				<br>
				Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.
				<br>
				<br>
				</p>
			</center>
		</div>
	</div>
</body>
</html>