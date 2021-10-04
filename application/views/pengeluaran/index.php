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
                    <div class="card-header"><a href="" data-toggle="modal" data-target="#addPembelian" class="btn btn-deta btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-plus-circle"></i> Tambah</a></div>
                    <div class="card-body">
                        <?= $this->session->flashdata('message') ?>
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="center" style="text-align:center; ">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">No. Seri</th>
                                        <th width="25%">Uraian</th>
                                        <th width="15%">Tanggal</th>
                                        <th width="10%">Petugas</th>
                                        <th width="10%">Total</th>
                                        <th width="5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($pengeluaran as $data) : ?>
                                        <tr>
                                            <td align="center"><?= $no++ ?></td>
                                            <td align="center"><?= $data['no_seri'] ?></td>
                                            <td><?= $data['uraian'] ?></td>
                                            <td align="center"><?= date('d F Y', strtotime($data['tanggal'])); ?></td>
                                            <td><?= $data['petugas'] ?></td>
                                            <td>Rp. <?= number_format($data['nominal']) ?></td>
                                            <td><a href="<?= base_url('pengeluaran/hapus/') . $data['no_seri'] ?>" class="btn <?= $akses->hapus != 1 ? 'disabled' : '' ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-danger"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="addPembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Pengeluaran</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url('Pengeluaran/simpan') ?>">
                    <div class="form-group">
                        <label for="inputAddress">Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tanggal" id="inputAddress" value="<?php echo date("Y-m-d"); ?>" required>
                        <input type="hidden" name="no_seri" id="no_seri" value="<?= $no_seri ?>">
                        <input type="hidden" name="no_jurnal" id="no_jurnal" value="<?= $no_jurnal ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Uraian</label>
                        <textarea class="form-control" name="uraian" id="uraian" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputCity">Nominal</label>
                        <input type="text" class="form-control" id="nominal" name="nominal" autocomplete="off" required>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-deta float-right">Simpan</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</div>