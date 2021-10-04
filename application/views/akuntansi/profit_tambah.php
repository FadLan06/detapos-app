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
            <div class="col-md-3 mt-2">
                <div class="card card-body m-b-30">
                    <h5><b>Tambah</b></h5>
                    <hr class="bg-deta">
                    <?= $this->session->flashdata('message') ?>
                    <form method="POST" action="<?= base_url('Profit/Aksi') ?>">
                        <div class="form-group">
                            <label for="keterangan">Gross Profit</label>
                            <input type="text" name="keterangan" class="form-control border-deta" id="keterangan" autocomplete="off" required>
                            <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="persentase">Persentase</label>
                            <input type="text" name="persentase" class="form-control border-deta" id="persentase" autocomplete="off" required>
                            <?= form_error('persentase', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="" class="form-control border-deta">
                                <option value="1">Utama</option>
                                <option value="0">Biasa</option>
                            </select>
                            <?= form_error('status', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <button type="submit" name="tmbh" class="btn btn-deta float-right" <?= $akses->tambah != 1 ? 'disabled' : '' ?>>Tambah</button>
                        <a href="<?= base_url('Profit') ?>" class="btn btn-warning">Kembali</a>
                    </form>
                </div>
            </div>
            <div class="col-md-9 mt-2">
                <div class="card card-body m-b-30">
                    <h5><b>DAFTAR</b></h5>
                    <hr class="bg-deta">
                    <?= $this->session->flashdata('message1') ?>
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead align="center" class="bg-deta text-white">
                                <tr>
                                    <th width="5%">NO</th>
                                    <th width="35%">Gross Profit</th>
                                    <th>Persentase</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($profit->row() > null) : ?>
                                    <?php $no = 1;
                                    foreach ($profit->result() as $ak) : ?>
                                        <tr align="center">
                                            <td><?= $no++ ?></td>
                                            <td align="left"><?= $ak->keterangan ?></td>
                                            <td><?= $ak->persentase ?>%</td>
                                            <td><?= $ak->status == '1' ? '<span class="badge badge-primary">Utama</span>' : '<span class="badge badge-warning">Biasa</span>' ?></td>
                                            <td>
                                                <a class="btn btn-deta btn-sm <?= $akses->ubah != 1 ? 'disabled' : '' ?>" href="" data-target="#UbahGross<?= $ak->id_jurnal_profit ?>" data-toggle="modal"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger btn-sm <?= $akses->hapus != 1 ? 'disabled' : '' ?>" href="<?= base_url('Profit/hapus/') . $ak->id_jurnal_profit ?>" onclick="return confirm('Yakin anda ?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr align="center">
                                        <td colspan="5"><i>Tidak Ada Data Gross Profit</i></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach ($profit->result() as $ak) :  ?>
    <div class="modal fade" id="UbahGross<?= $ak->id_jurnal_profit ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-deta text-white">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Ubah Akun</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?= base_url('Profit/Aksi') ?>">
                        <div class="form-group">
                            <label for="keterangan">Gross Profit</label>
                            <input type="hidden" name="id_jurnal_profit" class="form-control border-deta" value="<?= $ak->id_jurnal_profit ?>" autocomplete="off" required>
                            <input type="text" name="keterangan" class="form-control border-deta" value="<?= $ak->keterangan ?>" id="keterangan" autocomplete="off" required>
                            <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="persentase">Persentase</label>
                            <input type="text" name="persentase" class="form-control border-deta" value="<?= $ak->persentase ?>" id="persentase" autocomplete="off" required>
                            <?= form_error('persentase', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="" class="form-control border-deta">
                                <option value="1" <?= $ak->status == '1' ? 'selected' : '' ?>>Utama</option>
                                <option value="0" <?= $ak->status == '0' ? 'selected' : '' ?>>Biasa</option>
                            </select>
                            <?= form_error('status', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <button type="submit" name="ubah" class="btn btn-deta float-right" <?= $akses->ubah != 1 ? 'disabled' : '' ?>>Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>