<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<title>Cetak Laporan Data Barang - Detapos</title>
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
	<?php date_default_timezone_set($nm_toko['zona']); ?>
	<div style="margin-top: 15px; margin-bottom: 15px; margin-left: 35px; margin-right: 40px">
		<div class="w3-tinystruk1">
	    <table class="" cellpadding="0" width="100%">
	      <tr>
	        <td width="300" style="vertical-align: middle;">
	            <?php if($nm_toko['logo'] == null): ?>
                  <img src="<?= base_url() ?>assets/img/LOGO.webp" width="110"  height="35" class="d-inline-block align-top" alt="">
                <?php else: ?>
                  <img src="<?= base_url() ?>assets/upload/<?=$nm_toko['logo']?>" width="110"  height="35" class="d-inline-block align-top" alt="">
                <?php endif; ?>
	        </td>
	        <td style="text-align: right; vertical-align: middle;">
	          <h6 class="w3-tinystrukhead1">
	            <?=$nm_toko['nama_toko'];?><br>
	            <?=$nm_toko['alamat'];?><br>
	            Telp. <?=$nm_toko['no_telpon'];?><br>
	            <?=date('d-m-Y | H:i:s')?>
	          </h6>
	        </td>
	      </tr>
	    </table>
		</div>
  	</div>

  	<div style="margin-top: 15px; margin-bottom: 15px; margin-left: 35px; margin-right: 40px">
		<div class="w3-tinystruk1">
			<table class="w3-table-all w3-small">
			    <thead class="center" style="text-align:center; ">
			        <tr>
			            <th width="5%" style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">#</th>
			            <th width="25%" style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Nama Barang</th>
			            <th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Harga Modal</th>
			            <th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Harga Jual</th>
			            <th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Sisa Stok</th>
			            <th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Jml Modal</th>
			            <th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Jml Jual</th>
			            <th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Keuntungan</th>
			        </tr>
			    </thead>
			    <tbody>
			        <?php $no = 1; $ttl_beli = 0; $ttl_jual = 0; $ttl_sisa = 0; $ttl_modal = 0; $ttl_juall = 0; $ttl_untung = 0;?>
			        <?php foreach ($barang as $br) : ?>
			        <?php $stok = $this->db->query("SELECT *, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
			        <?php 
			            $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang'=>$br['kode_barang'], 'token'=>$br['token']]);
			            $kd = $query->num_rows();
			            $sisa = $br['jml_stok']; 
			            $modal = $sisa * $br['harga_beli']; 
			            $jual = $sisa * $br['harga_jual']; 
			            $untung = $jual-$modal; 
			        ?>
			            <tr>
			                <td style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;"><?=$no++?></td>
			                <td style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;"><?= $br['nama_barang'] ?></td>
			                <td style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?= number_format($br['harga_beli']) ?></td>
			                <td style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?= number_format($br['harga_jual']) ?></td>
			                <td style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;"><?=number_format($sisa)?></td>
			                <td style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?=number_format($modal)?></td>
			                <td style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?=number_format($jual)?></td>
			                <td style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?=number_format($untung)?></td>
			            </tr>
			        <?php
			        	$ttl_beli += $br['harga_beli'];
			        	$ttl_jual += $br['harga_jual'];
			        	$ttl_sisa += $sisa;
			        	$ttl_modal += $modal;
			        	$ttl_juall += $jual;
			        	$ttl_untung += $untung;
			        ?>
			        <?php endforeach; ?>
			    </tbody>
			    <tfoot>
			    	<tr align="center">
			    		<th colspan="2" style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">TOTAL</th>
			    		<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?=number_format($ttl_beli)?></th>
			    		<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?=number_format($ttl_jual)?></th>
			    		<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;"><?=number_format($ttl_sisa)?></th>
			    		<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?=number_format($ttl_modal)?></th>
			    		<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?=number_format($ttl_juall)?></th>
			    		<th style="border-bottom:1px solid #000; border-top:1px solid #000; vertical-align: center;">Rp. <?=number_format($ttl_untung)?></th>
			    	</tr>
			    </tfoot>
			<table>
		</div>
  	</div>
  	
	<script type="text/javascript">
		window.print();
		// window.history.back();
	</script>
</body>
</html>