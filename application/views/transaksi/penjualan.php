<div class="page-content-wrapper ">

	<div class="container-fluid">

		<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box">
					<div class="btn-group float-right">
						<ol class="breadcrumb hide-phone p-0 m-0">
							<li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li>
						</ol>
					</div>
					<h4 class="page-title"><?= $judul ?></h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->

		<div class="row">
			<div class="col-12">
				<div class="card m-b-30">
					<div class="card-body">
						<?php if ($user['role_id'] == 3) : ?>
							<button class="btn btn-info btn-sm mt-1" data-toggle="modal" data-target="#lpharian"><i class="fas fa-print"></i> Cetak Laporan Harian</button>
							<button href="" class="btn btn-success btn-sm mt-1" data-toggle="modal" data-target="#lpbulan"><i class="fas fa-print"></i> Cetak Laporan Minggu/Bulan</button>
							<hr class="bg-deta">
						<?php endif; ?>

						<?= $this->session->flashdata('message') ?>
						<div class="table-responsive b-0" data-pattern="priority-columns">
							<table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
								<thead class="center" style="text-align:center; ">
									<tr>
										<th width="2%">#</th>
										<th width="15%">No. Transaksi</th>
										<th width="10%">Pelanggan</th>
										<th width="20%">Tanggal</th>
										<th width="10%">Petugas</th>
										<th width="15%">Total</th>
										<?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) : ?>
											<th width="10%">MetodePem</th>
										<?php endif; ?>
										<th width="10%">Status</th>
										<th width="5%">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1; ?>
									<?php if ($user['role_id'] == 2) : ?>
										<?php foreach ($penjualan as $pen) : ?>
											<?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $pen->token, 'nama_pel' => $pen->kode_pelanggan])->row(); ?>
											<?php $total = $pen->total - (($pen->total * $pen->diskon) / 100); ?>
											<tr>
												<!-- <td align="center"><input type='checkbox' class='check-item' name='pen[]' value='<?= $pen->no_transaksi ?>'></td> -->
												<td align="center"><?= $no++ ?></td>
												<td align="center"><button class="btn btn-outline-deta" onclick="location.href='<?= base_url('Penjualan/Dtl_penjualan/') . $pen->no_transaksi ?>'"><?= $pen->no_transaksi ?></button></td>
												<td>
													<?php
													if ($pen->kode_pelanggan == NULL) {
														echo 'Umum';
													} else {
														echo $pel->nama_pel;
													}
													?>
												</td>
												<td><?= date('d F Y | H:i:s', strtotime($pen->timestmp)) ?></td>
												<td><?= $pen->petugas ?></td>
												<td>Rp. <?= number_format($total) ?></td>
												<?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) : ?>
													<td align="center"><?= $pen->metodePem ?></td>
												<?php endif; ?>
												<td align="center">
													<?php
													if (($this->session->userdata('token') == 'DPE8DR8MRWKYNHJPV')) {
														if ($pen->status == 'Lunas') {
															$cl = "btn btn-outline-success";
															$status = $pen->status;
														} else {
															$cl = "btn btn-outline-danger";
															$status = "Pending";
														}
													} else {
														if ($pen->status == 'Lunas') {
															$cl = "btn btn-outline-success";
														} else {
															$cl = "btn btn-outline-danger";
														}
														$status = $pen->status;
													}
													?>
													<?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) : ?>
														<?php if ($pen->status == 'Lunas') { ?>
															<a href="" class="<?= $cl ?> btn-sm" data-target="#ubhstatus" data-toggle="modal" data-id="<?= $pen->no_transaksi ?>"><?= $status ?></a>
														<?php } else { ?>
															<a href="" class="<?= $cl ?> btn-sm" onclick="return false"><?= $status ?></a>
														<?php } ?>
													<?php else : ?>
														<a href="" class="<?= $cl ?> btn-sm" data-target="#ubhstatus" data-toggle="modal" data-id="<?= $pen->no_transaksi ?>"><?= $status ?></a>
													<?php endif; ?>
												</td>
												<td align="center">
													<a href="<?= base_url('Penjualan/hps_pen/') . $pen->no_transaksi ?>" class="btn <?= $akses->hapus != 1 ? 'disabled' : '' ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-danger"></i></a>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php elseif ($user['role_id'] == 3) : ?>
										<?php foreach ($penjualan2 as $pen) : ?>
											<?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $pen->token, 'kode_pel' => $pen->kode_pelanggan])->row(); ?>

											<tr>
												<td><?= $no++ ?></td>
												<td><button class="btn btn-outline-deta" onclick="location.href='<?= base_url('Penjualan/Dtl_penjualan/') . $pen->no_transaksi ?>'"><?= $pen->no_transaksi ?></button></td>
												<td>
													<?php
													if ($pen->kode_pelanggan == NULL) {
														echo 'Umum';
													} else {
														echo $pel->nama_pel;
													}
													?>
												</td>
												<td><?= date('d F Y | H:i:s', strtotime($pen->timestmp)) ?></td>
												<td><?= $pen->petugas ?></td>
												<td>Rp. <?= number_format($pen->total) ?></td>
												<td align="center">
													<?php
													if (($this->session->userdata('token') == 'DPE8DR8MRWKYNHJPV')) {
														if ($pen->status == 'Lunas') {
															$cl = "btn btn-outline-success";
															$status = $pen->status;
														} else {
															$cl = "btn btn-outline-danger";
															$status = "Pending";
														}
													} else {
														if ($pen->status == 'Lunas') {
															$cl = "btn btn-outline-success";
														} else {
															$cl = "btn btn-outline-danger";
														}
														$status = $pen->status;
													}
													?>
													<a href="" class="<?= $cl ?> btn-sm" data-target="#ubhstatus" data-toggle="modal" data-id="<?= $pen->no_transaksi ?>"><?= $status ?></a>
												</td>
												<td align="center">
													<a href="<?= base_url('Penjualan/hps_pen/') . $pen->no_transaksi ?>" class="btn <?= $akses->hapus != 1 ? 'disabled' : '' ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-danger"></i></a>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="lpharian" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-deta text-white">
				<h5 class="modal-title" id="exampleModalCenterTitle">Cetak Laporan Harian</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php if ($this->session->userdata('role_id') == 2) : ?>
				<form method="post" action="<?= base_url('Penjualan/Cetak_Harian') ?>">
				<?php elseif ($this->session->userdata('role_id') == 3) : ?>
					<form method="post" action="<?= base_url('Penjualan/Cetak_Harian_User') ?>">
					<?php endif; ?>
					<div class="modal-body">
						<div class="form-group">
							<label class="form-control-label">Tanggal Laporan Penjualan</label>
							<input type="date" name="tgl_akhir" placeholder="Tanggal" class="form-control">
						</div>
						<?php if ($this->session->userdata('role_id') == 2) : ?>
							<div class="form-group">
								<label class="form-control-label">Pilih Petugas</label>
								<select class="form-control" name="petugas" id="petugas" autocomplate="off">
									<option value="Semua" selected>Semua Petugas</option>
									<?php foreach ($petugas as $p) : ?>
										<option value="<?= $p['username'] ?>"><?= $p['nama'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						<?php endif; ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-danger" onclick="return valid();">Cetak</button>
					</div>
					</form>
		</div>
	</div>
</div>

<div class="modal fade" id="lpbulan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-deta text-white">
				<h5 class="modal-title" id="exampleModalCenterTitle">Cetak Laporan Minggu/Bulan</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php if ($this->session->userdata('role_id') == 2) : ?>
				<form method="post" action="<?= base_url('Penjualan/Cetak_Bulan') ?>">
				<?php elseif ($this->session->userdata('role_id') == 3) : ?>
					<form method="post" action="<?= base_url('Penjualan/Cetak_Bulan_User') ?>">
					<?php endif; ?>
					<div class="modal-body">
						<div class='form-group'>
							<label class='form-control-label'>Tanggal awal</label>
							<input type='date' name='tgl_awal' placeholder='tanggal input' class='form-control'>
						</div>

						<div class='form-group'>
							<label class='form-control-label'>Tanggal Akhir</label>
							<input type='date' name='tgl_akhir' placeholder='tanggal input' class='form-control'>
						</div>
						<?php if ($this->session->userdata('role_id') == 2) : ?>
							<div class="form-group">
								<label class="form-control-label">Pilih Petugas</label>
								<select class="form-control" name="petugas" id="petugas" autocomplate="off">
									<option value="Semua" selected>Semua Petugas</option>
									<?php foreach ($petugas as $p) : ?>
										<option value="<?= $p['username'] ?>"><?= $p['nama'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						<?php endif; ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-danger" onclick="return valid();">Cetak</button>
					</div>
					</form>
		</div>
	</div>
</div>

<div class="modal fade" id="lpuntung" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-deta text-white">
				<h5 class="modal-title" id="exampleModalCenterTitle">Cetak Laporan Keuntungan</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="<?= base_url('Penjualan/Cetak_Keuntungan') ?>">
				<div class="modal-body">
					<div class='form-group'>
						<label class='form-control-label'>Tanggal awal</label>
						<input type='date' name='tgl_awal' placeholder='tanggal input' class='form-control w3-input dp'>
					</div>

					<div class='form-group'>
						<label class='form-control-label'>Tanggal Akhir</label>
						<input type='date' name='tgl_akhir' placeholder='tanggal input' class='form-control w3-input dp'>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger" onclick="return valid();">Cetak</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="ubhstatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-deta text-white">
				<h5 class="modal-title" id="exampleModalCenterTitle">Ubah Status</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="ubh_status"></div>
			</div>
		</div>
	</div>
</div>


<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#ubhstatus').on('show.bs.modal', function(e) {
			var kd = $(e.relatedTarget).data('id');
			//menggunakan fungsi ajax untuk pengambilan data
			$.ajax({
				type: 'post',
				url: '<?= base_url('Penjualan/ubh_status') ?>',
				data: 'no_transaksi=' + kd,
				success: function(data) {
					$('.ubh_status').html(data); //menampilkan data ke dalam modal
				}
			});
		});
	});
</script>