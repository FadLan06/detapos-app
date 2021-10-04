<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<title>Cetak Barcode - Detapos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=base_url()?>assets/w3.css"> 
	<style>
		@media print {
			@page {
				margin: 0mm;
			}
		}
	</style>
</head>
<body onLoad="javascrip:window:print()">
	<?php 
		$kolom   = 3;  
		$copy    = $_POST['jumlah'];
		$counter = 1;
	?>
	<table cellspacing="0" cellpadding="0" style="font-size: 8px; margin: 0mm; margin-top: 0mm">
	<?php	
		for ($ucopy=1; $ucopy<=$copy; $ucopy++) {
			if (($counter-1) % $kolom == '0'){
				?>
				<tr>
				<?php } ?>

				<td class='merk' style="padding: 0mm 0mm 0mm 0mm">
					<center>
						<?php $kode= $barcode['kode_barang']; ?>
						<font style="font-size: 15;" ><?php echo substr($barcode['nama_barang'],0,20).""; ?></font>
						<br/>
						<img src="<?php echo site_url('Barang/barcode/').$kode?>" style="height: 15.3mm;">
					</center>
				</td>

				<?php
				if ($counter % $kolom == '0') { echo "</tr>"; }
				$counter++;
			}
			echo "</table>";
			?>

</body>
</html>