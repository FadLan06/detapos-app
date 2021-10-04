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

		body {
			width: 80mm;
		}

		.view {
			margin-top: 10px;
			font-size: 14px;
			margin-bottom: 10px;
		}

		@media (max-width: 576px) {
			body {
				width: 80mm;
			}

			.view {
				margin-top: 10px;
				font-size: 14px;
				margin-bottom: 10px;
			}
		}

		@media (max-width: 768px) {
			body {
				width: 80mm;
			}

			.view {
				margin-top: 10px;
				font-size: 18px;
				margin-bottom: 10px;
			}
		}

		@media (min-width: 992px) {
			body {
				width: 80mm;
			}

			.view {
				margin-top: 10px;
				font-size: 14px;
				margin-bottom: 10px;
			}
		}
	</style>
</head>

<body>
	<?php
	date_default_timezone_set($nm_toko['zona']);
	$tgaal    = date('d-m-Y | H:i:s', strtotime($tra['timestmp']));
	?>

	<div class="view" style="text-align: center;">
		<img src="<?= base_url('assets/upload/') . $nm_toko['logo']; ?>" width="80px">
	</div>

	<div style="text-align: center;">
		<div class="view">
			<table>
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
		</div>
	</div>

	<div style="text-align: left;">
		<div class="view">
			<table>
				<tr>
					<td>
						<a>No. Struk : <?php echo $tra['no_transaksi']; ?></a> <br>
						<a> <?php echo $tgaal; ?></a>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<?php $total_bayar = 0; ?>
	<?php foreach ($penjualan as $p) : ?>
		<?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
		<div class="view">
			<table style='border-bottom: 2px dashed #111;'>
				<tr>
					<td colspan="2">
						<?= $pen['nama_barang'] . '/' . $pen['warna'] . '/' . $pen['ukuran'] ?> <br>
					</td>
				</tr>
				<tr>
					<td>
						<?= $p['kty'] ?> x <?= number_format($p['harga']) ?>
					</td>
					<td align="right">
						Rp. <?= number_format($p['sub_total']) ?>
					</td>
				</tr>
			</table>

			<?php
			$total_bayar = $total_bayar + $p['sub_total'];
			$diskon = $total_bayar - (($total_bayar * $tra['disc']) / 100);
			$total = $total_bayar - $diskon;
			$sisa = $tra['bayar'] - $diskon;
			?>
		</div>
	<?php endforeach; ?>
	<div class="view">
		<table style='border-bottom: 2px dashed #111;'>
			<tr>
				<td colspan='2'>Sub Total</td>
				<td align="right"><a>Rp. <?php echo number_format($total_bayar); ?></a></td>
			</tr>
			<tr>
				<td colspan='2'>Diskon</td>
				<td align="right"><a>Rp. <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></a></td>
			</tr>
			<tr>
				<td colspan='2'>Total Bayar</td>
				<td align="right"><a>Rp. <?php echo number_format($diskon) ?></a></td>
			</tr>
			<tr>
				<td colspan='2'>Tunai</td>
				<td align="right"><a>Rp. <?php echo number_format($tra['bayar']); ?></a></td>
			</tr>
			<tr>
				<td colspan='2'>Kembali</td>
				<td align="right"><a>Rp. <?php echo number_format($sisa); ?></a></td>
			</tr>
		</table>
	</div>

	<div class="view" style="text-align: center;">
		<span>Barang yang dibeli tidak dapat ditukar atau dikembalikan.</span><br>
		<span>Terima Kasih.</span>
	</div>

	<script type="text/javascript">
		window.print();
		// window.history.back();
	</script>
</body>

</html>