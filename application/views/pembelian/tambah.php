<div class="page-content-wrapper ">

	<div class="container-fluid">

		<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box">
					<div class="btn-group float-right">
						<ol class="breadcrumb hide-phone p-0 m-0">
							<li class="breadcrumb-item"><a href="#">Data Pembelian</a></li>
							<li class="breadcrumb-item active"><?= $judul ?></li>
						</ol>
					</div>
					<h4 class="page-title"><?= $judul ?></h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->

		<div class="row">
			<div class="col-12">

				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header bg-white border-deta"><b>Transaksi Pembelian
									<button class="btn btn-outline-deta btn-sm float-right" type="button" onclick="location.href='<?= base_url('') . 'Pembelian' ?>'"><i class="fas fa-return"></i> Kembali</button></b></div>
							<div class="card-body">
								<form method="post">
									<div class="form-row">
										<div class="form-group col-md">
											<label for="kd_brng">Kode Barang</label>
											<div class="input-group">
												<div class="custom-file">
													<input type="text" class="form-control border-deta" id="kd_brng" name="kd_brng" autocomplete="off" required autofocus>
												</div>
												<div class="input-group-append">
													<button class="btn btn-outline-deta" onclick="myFunction()" type="button">Generate</button>
												</div>
											</div>
										</div>
										<div class="form-group col-md">
											<label for="nm_brng">Nama Barang</label>
											<input type="text" class="form-control" id="nm_brng" name="nm_brng" autocomplete="off" required>
										</div>
										<div class="form-group col-md">
											<label for="hrga_pk">Harga</label>
											<input type="text" class="form-control" id="hrga_pk" name="hrga_pk" autocomplete="off" required>
										</div>
										<div class="form-group col-md">
											<label for="hrga_pk">Satuan</label>
											<input type="text" class="form-control" id="satuan" name="satuan" autocomplete="off" required>
										</div>
										<div class="form-group col-md-2">
											<label for="potongan">Potongan (Rp.)</label>
											<input type="text" class="form-control" id="potongan" name="potongan" autocomplete="off">
										</div>
										<div class="form-group col-md-1">
											<label for="jumlah">Jumlah</label>
											<input type="text" class="form-control" id="jumlah" name="jumlah" autocomplete="off" required>
										</div>
									</div>
									<button type="submit" name="kirim" id="kirim" class="btn btn-deta float-right btn-sm">Kirim</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-12 mt-3">
						<div class="card m-b-30">
							<div class="card-header bg-white border-deta"><b>Data Pembelian</b></div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped table-sm" style="width: 100%; font-size: 12px" id="mydatabrng">
										<thead>
											<tr style="border-bottom:1px solid #ccc;">
												<th width="5%">#</th>
												<th>Barang</th>
												<th>Harga</th>
												<th>Item</th>
												<th width="10%">Satuan</th>
												<th>Potongan</th>
												<th colspan="2">Sub Total</th>
												<!-- <th></th> -->
											</tr>
										</thead>
										<tbody id="listbrng">

										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer border-deta bg-white">
								<form action="<?= base_url('Pembelian/smpn_pem') ?>" method="post">
									<div class="row">
										<div class="col-md" align="center"><b>Jumlah Barang </b><br /> <label id="jml_brng"></label></div>
										<div class="col-md" align="center"><b>Jumlah Item </b><br /> <label id="jml_item"></label> item</div>
										<div class="col-md" align="center"><b>Total Pembelian </b><br /> <label id="total_bl"></label></div>
										<!-- <div class="col-md" align="center"> -->
										<form action="" method="post">
											<div class="col-md"><input type="text" class="form-control border-deta" id="diskon" name="diskon" placeholder="Diskon(%)"></div>
											<input type="hidden" name="total_bl" id="total_bli">
											<input type="hidden" name="total_bl1" id="total_bli1">
											<input type="hidden" name="no_faktur" value="<?= $no_faktur ?>">
											<div class="col-md"><input type="text" class="form-control border-deta" id="kd_sup" name="kd_sup" placeholder="Kode Supplier"></div>
											<div class="col-md" align="center">
												<button type="submit" name="simpan" id="simpan" class="btn btn-outline-success  btn-sm"><i class="fas fa-save"></i> Simpan</button>
												<!-- <button type="submit" name="cetak" id="cetak" class="btn btn-outline-deta  btn-sm"><i class="fas fa-print"></i> Cetak</button> -->
											</div>

										</form>
										<!-- </div> -->
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script>
	$(document).ready(function() {

		$('#kd_sup').autocomplete({
			source: "<?php echo site_url('Pembelian/Auto_Sup'); ?>",

			select: function(event, ui) {
				$('[name="kd_sup"]').val(ui.item.label);
			}
		});

	});

	$(document).ready(function() {

		$('#kd_brng').autocomplete({
			source: "<?php echo site_url('Pembelian/Auto_Barang_Butik'); ?>",

			select: function(event, ui) {
				$('[name="kd_brng"]').val(ui.item.label);
				$('[name="nm_brng"]').val(ui.item.nm_brng);
				$('[name="hrga_pk"]').val(ui.item.hrga_pk);
				$('[name="satuan"]').val(ui.item.satuan);
			}
		});

	});

	tampil_barang(); //pemanggilan fungsi tampil barang.

	$('#mydatabrng');

	//tampil barang
	function tampil_barang() {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url() ?>Pembelian/data_barang',
			async: true,
			dataType: 'json',
			success: function(data) {
				var html = '';
				var i;
				var tot = 0;
				var item = 0;
				var nomor = 0;
				var no = 1;
				for (i = 0; i < data.length; i++) {
					html += '<tr>' +
						'<td width="5%">' + no++ + '</td>' +
						'<td width="25%">' + data[i].nama_barang + '</td>' +
						'<td width="20%">' + to_rupiah1(data[i].harga_beli) + '</td>' +
						'<td width="10%">' + data[i].kty + '</td>' +
						'<td width="10%">' + data[i].satuan + '</td>' +
						'<td width="15%">' + to_rupiah1(data[i].potongan) + '</td>' +
						'<td width="20%">' + to_rupiah1(data[i].sub_total) + '</td>' +
						'<td style="text-align:center; width:20%">' +
						'<a href="" class="badge badge-danger hapus" id="' + data[i].kode_barang + '">Hapus</a>' +
						'</td>' +
						'</tr>';
					tot = parseInt(tot) + parseInt(data[i].sub_total);
					item += parseInt(data[i].kty);
					if (parseInt(data[i].beli)) {
						nomor += parseInt(data[i].beli);
					} else {
						nomor += 0;
					}
				}
				$("#total_bl").text(to_rupiah1(tot));
				$("#total_bli").val(tot);
				$("#jml_brng").text(nomor);
				$("#jml_item").text(item);
				$('#listbrng').html(html);

				if (tot == 0) {
					$('#simpan').prop("disabled", true);
					$('#cetak').prop("disabled", true);
				} else {
					$('#simpan').prop("disabled", false);
					$('#cetak').prop("disabled", false);
				}
			}
		});
	};

	//Simpan Barang
	$('#kirim').on('click', function() {
		var valid = this.form.checkValidity();
		if (valid) {
			event.preventDefault();
			var kd_brng = $('#kd_brng').val();
			var nm_brng = $('#nm_brng').val();
			var potongan = $('#potongan').val();
			var hrga_pk = $('#hrga_pk').val();
			var satuan = $('#satuan').val();
			var petugas = $('#petugas').val();
			var jumlah = $('#jumlah').val();
			var kd_sup = $('#kd_sup').val();
			var token = $('#token').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('Pembelian/simpan_barang') ?>",
				dataType: "JSON",
				data: {
					kd_brng: kd_brng,
					nm_brng: nm_brng,
					potongan: potongan,
					hrga_pk: hrga_pk,
					satuan: satuan,
					petugas: petugas,
					jumlah: jumlah,
					kd_sup: kd_sup,
					token: token
				},
				success: function(data) {
					$('[name="kd_brng"]').val('').focus();
					$('[name="nm_brng"]').val('');
					$('[name="potongan"]').val('');
					$('[name="hrga_pk"]').val('');
					$('[name="satuan"]').val('');
					$('[name="petugas"]').val('');
					$('[name="jumlah"]').val('');
					$('[name="kd_sup"]').val('');
					$('[name="token"]').val('');
					tampil_barang();
				}
			});
			return false;
		}
	});

	// Hapus Barang
	$(document).on('click', '.hapus', function() {
		var id = $(this).attr("id");
		$.ajax({
			url: "<?php echo base_url(); ?>Pembelian/hapus",
			type: "POST",
			data: {
				id: id
			},
			success: function(data) {
				$('[name="kd_brng"]').focus();
				tampil_barang();
			}
		});
		return false;
	});

	function to_rupiah1(angka) {
		var rev = parseInt(angka, 10).toString().split('').reverse().join('');
		var rev2 = '';
		for (var i = 0; i < rev.length; i++) {
			rev2 += rev[i];
			if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
				rev2 += '.';
			}
		}
		return 'Rp. ' + rev2.split('').reverse().join('');
	}
</script>