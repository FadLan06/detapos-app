<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<title>Cetak Invoice - Detapos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=base_url()?>assets/w3.css">
    <!-- <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">  -->
	<style type="text/css" media="print">
	@page{
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
		<div class="w3-tinystruk1">
	    <table class="" cellpadding="0" width="100%">
	      <tr>
	        <td width="300" style="vertical-align: middle;">
	          <img src="<?=base_url('')?>assets/img/<?=$nm_toko['logo']?>" width="50%" height="50%">
	        </td>
	        <td style="text-align: right; vertical-align: middle;">
	          <h6>
	            <?=$nm_toko['nama_toko'];?><br>
	            <?=$nm_toko['alamat'];?><br>
	            Telp. <?=$nm_toko['no_telpon'];?>
	          </h6>
	        </td>
	      </tr>
	    </table>
  	</div>
  	<?php $sup = $this->db->get_where('tb_supplier',['kode_sup' => $tra['kd_supplier'], 'token' => $tra['token']])->row_array(); ?>
		<div class="w3-responsive">
			<table class="w3-table w3-tinystruk1" cellpadding="0">
				<tr>
					<td width="12%"><b>No. Invoice</b></td>
					<td width="2%"><b>:</b></td>
					<td><?php echo $tra['no_faktur']; ?></td>
				</tr>
				<tr>
					<td width="12%"><b>Supplier</b></td>
					<td width="2%"><b>:</b></td>
					<td>
						<?php if($tra['kd_supplier'] == ''): ?>
			                <?=''?>
			            <?php else : ?>
							<?php echo $sup['kode_sup'] .' / '. $sup['nama_toko']; ?>
			            <?php endif; ?>
					</td>
				</tr>
				<tr>
					<td width="12%"><b>Tanggal</td>
					<td width="2%"><b>:</b></td>
					<td><?=$tgaal?></td>
				</tr>
			</table>
		</div>

		<br>
		<table class="w3-table-all w3-small">
		<!-- <table class="w3-small"> -->
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
				<?php $total_harga = 0; $no=1;?>
					<?php foreach($pembelian as $p): ?>
					<?php $pen = $this->db->query("SELECT *, kode_barang as kode FROM tb_barang WHERE kode_barang='$p[kode_barang]' AND token='$p[token]'")->row_array(); ?>
				<tr>
					<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center><?=$no++?></center>
					</td>
					<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center><?=$pen['kode']?></center>
					</td>
					<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<?=$pen['nama_barang']?>
					</td>
					<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center><?=$p['kty']?></center>
					</td>
					<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>Rp. <?=number_format($p['harga_beli'])?></center>
					</td>
					<td style="border-bottom:1px solid #000; border-top:1px solid #000;">
						<center>Rp. <?=number_format($p['sub_total'])?></center>
					</td>
				</tr>
				<?php 
					$total_harga = $total_harga+$p['sub_total'];
				?>
				<?php endforeach; ?>

				<tr>
					<td colspan="5" style="border-top:1px solid #000; text-align:right;"><b>Total Harga :</b></td>
					<td style="border-top:1px solid #000;"><center><b>Rp <?=number_format($total_harga)?></b></center></td>
				</tr>
			</tbody>
		</table>
		<br>

		<div class="w3-row-padding w3-tinystruk">
			<center>Terima kasih atas kunjungan anda.<br>
				Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.
				<br>
				<br>
			</center>
		</div>	
	</div>
	<script type="text/javascript">
		window.print();
		// window.history.back();
	</script>
</body>
</html>