<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>Cetak Struk - Detapos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?= base_url() ?>assets/w3.css">
	<!-- <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">  -->
	<style type="text/css" media="print">
		@page {
			size: auto;
			margin: 0mm;
		}
	</style>
</head>

<body>
	<?php
	date_default_timezone_set($nm_toko['zona']);
	$tgaal    = date('d-m-Y | H:i:s', strtotime($tra['timestmp']));
	?>
	<div style="margin-top: 15px; margin-bottom: 15px; margin-left: 35px; margin-right: 40px">
		<div class="w3-tinystruk1" style="letter-spacing: 4px;">
			<table class="" cellpadding="0" width="100%">
				<tr>
					<td width="300" style="vertical-align: middle;">
						<img src="<?= base_url('assets/upload/') . $nm_toko['logo']; ?>" width="100px">
					</td>
					<td style="text-align: right; vertical-align: middle;">
						<h6 class="w3-tinystrukhead1">
							<?= $nm_toko['nama_toko']; ?><br>
							<?= $nm_toko['alamat']; ?><br>
							Telp. <?= $nm_toko['no_telpon']; ?>
						</h6>
					</td>
				</tr>
			</table>
		</div>

		<?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $tra['token'], 'kode_pel' => $tra['kode_pelanggan']])->row(); ?>
		<div class="w3-responsive" style="letter-spacing: 4px;">
			<table class="w3-table w3-tinystruk1 tbl" cellpadding="0">
				<tr>
					<td width="10"><b>No. Struk</b></td>
					<td width="2"><b>:</b></td>
					<td><?php echo $tra['no_transaksi']; ?></td>
				</tr>
				<tr>
					<td width="10"><b>Pelanggan</b></td>
					<td width="2"><b>:</b></td>
					<td><?php if ($tra['kode_pelanggan'] == NULL) {
							echo 'Umum';
						} else {
							echo $pel->nama_pel;
						} ?> </td>
				</tr>
				<tr>
					<td width="10"><b>Tanggal</td>
					<td width="2"><b>:</b></td>
					<td><?= $tgaal ?></td>
				</tr>
			</table>
		</div>

		<br>
		<table class="w3-table-all w3-small" style="letter-spacing: 4px;">
			<!-- <table class="w3-small" style="letter-spacing: 4px;"> -->

			<?php if (isset($akses1['menu_id'])) : ?>
				<thead>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>NO</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>KODE BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>NAMA BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>QTY</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>HARGA</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>SUB TOTAL HARGA</center>
					</th>
				</thead>
				<tbody>
					<?php $total_harga = 0;
					$no = 1; ?>
					<?php foreach ($penjualan as $p) : ?>
						<?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
						<tr>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $no++ ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $pen['kode_barang'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<?= $pen['nama_barang'] ?>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $p['kty'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['harga']) ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['sub_total']) ?></center>
							</td>
						</tr>
						<?php
						$total_harga = $total_harga + $p['sub_total'];
						$total = $total_harga - (($total_harga * $tra['diskon']) / 100);
						$diskon = $total_harga - $total;
						$total_bayar = $total_harga - $diskon;
						$sisa = $tra['bayar'] - $total_bayar;
						?>
					<?php endforeach; ?>
					<tr>
						<td colspan="5" style="border-top:1px solid #000; text-align:right;"><b>Total Harga :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total_harga); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="5" style="border-top:1px solid #000; text-align:right;"><b>Diskon :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?= number_format($diskon) . ' (' . $tra['diskon'] . '%)'; ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="5" style="border-top:1px solid #000; text-align:right;"><b>Total Bayar :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total_bayar); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="5" style="text-align:right;"><b>Tunai :</b></td>
						<td>
							<center><b>Rp <?php echo number_format($tra['bayar']); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="5" style="text-align:right;border-bottom:1px solid #000;"><b>Kembali :</b></td>
						<td style="border-bottom:1px solid #000;">
							<center><b>Rp <?php echo number_format($sisa); ?></b></center>
						</td>
					</tr>
				</tbody>
			<?php elseif (isset($akses2['menu_id'])) : ?>
				<thead>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>NO</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>KODE BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>NAMA BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>QTY</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>HARGA</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>POTONGAN</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>SUB TOTAL HARGA</center>
					</th>
				</thead>
				<tbody>
					<?php $total_bayar = 0;
					$no = 1; ?>
					<?php foreach ($penjualan as $p) : ?>
						<?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
						<tr>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $no++ ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $pen['kode_barang'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<?= $pen['nama_barang'] ?>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $p['kty'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['harga']) ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['potongan']) ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
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
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Sub Total :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total_bayar); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Diskon :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Total Bayar :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($diskon); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;"><b>Tunai :</b></td>
						<td>
							<center><b>Rp <?php echo number_format($tra['bayar']); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;border-bottom:1px solid #000;"><b>Kembali :</b></td>
						<td style="border-bottom:1px solid #000;">
							<center><b>Rp <?php echo number_format($sisa); ?></b></center>
						</td>
					</tr>
				</tbody>
			<?php elseif (isset($akses['menu_id'])) : ?>
				<thead>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>NO</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>KODE BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>NAMA BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>QTY</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>HARGA</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>POTONGAN</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>SUB TOTAL HARGA</center>
					</th>
				</thead>
				<tbody>
					<?php $total_bayar = 0;
					$no = 1; ?>
					<?php foreach ($penjualan as $p) : ?>
						<?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
						<tr>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $no++ ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $pen['kode_barang'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<?= $pen['nama_barang'] ?>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $p['kty'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['harga']) ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['potongan']) ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
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
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Sub Total :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total_bayar); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Diskon :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Total Bayar :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($diskon); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;"><b>Tunai :</b></td>
						<td>
							<center><b>Rp <?php echo number_format($tra['bayar']); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;border-bottom:1px solid #000;"><b>Kembali :</b></td>
						<td style="border-bottom:1px solid #000;">
							<center><b>Rp <?php echo number_format($sisa); ?></b></center>
						</td>
					</tr>
				</tbody>
			<?php elseif (isset($akses3['menu_id'])) : ?>
				<thead>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>NO</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>KODE BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>NAMA BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>QTY</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>HARGA</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>POTONGAN</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>SUB TOTAL HARGA</center>
					</th>
				</thead>
				<tbody>
					<?php $total_bayar = 0;
					$no = 1; ?>
					<?php foreach ($penjualan as $p) : ?>
						<?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
						<tr>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $no++ ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $pen['kode_barang'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<?= $pen['nama_barang'] ?>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $p['kty'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['harga']) ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['potongan']) ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
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
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Sub Total :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total_bayar); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Diskon :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Total Bayar :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($diskon); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;"><b>Tunai :</b></td>
						<td>
							<center><b>Rp <?php echo number_format($tra['bayar']); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;border-bottom:1px solid #000;"><b>Kembali :</b></td>
						<td style="border-bottom:1px solid #000;">
							<center><b>Rp <?php echo number_format($sisa); ?></b></center>
						</td>
					</tr>
				</tbody>
			<?php elseif (isset($akses4['menu_id'])) : ?>
				<thead>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>NO</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>KODE BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>NAMA BARANG</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>QTY</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>HARGA</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">
						<center>POTONGAN</center>
					</th>
					<th style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>SUB TOTAL HARGA</center>
					</th>
				</thead>
				<tbody>
					<?php $total_bayar = 0;
					$no = 1; ?>
					<?php foreach ($penjualan as $p) : ?>
						<?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
						<tr>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $no++ ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $pen['kode_barang'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<?= $pen['nama_barang'] . ' / ' . $pen['warna'] . ' / ' . $pen['ukuran'] ?>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center><?= $p['kty'] ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['harga']) ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
								<center>Rp. <?= number_format($p['potongan']) ?></center>
							</td>
							<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
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
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Sub Total :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total_bayar); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Diskon :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($total) . ' (' . number_format($tra['disc']) . '%)'; ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="border-top:1px solid #000; text-align:right;"><b>Total Bayar :</b></td>
						<td style="border-top:1px solid #000;">
							<center><b>Rp <?php echo number_format($diskon); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;"><b>Tunai :</b></td>
						<td>
							<center><b>Rp <?php echo number_format($tra['bayar']); ?></b></center>
						</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;border-bottom:1px solid #000;"><b>Kembali :</b></td>
						<td style="border-bottom:1px solid #000;">
							<center><b>Rp <?php echo number_format($sisa); ?></b></center>
						</td>
					</tr>
				</tbody>
			<?php endif; ?>
		</table>
		<br>

		<div class="w3-row-padding w3-tinystruk" style="letter-spacing: 4px;">
			<center>Terima kasih atas kunjungan anda.<br>
				Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.
				<br>
				<br>
			</center>
		</div>
	</div>
	<script type="text/javascript">
		// window.print();
		// window.history.back();
	</script>
</body>

</html>