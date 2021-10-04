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
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-body">
                            <h4>Input Data Warna</h4>
                            <hr class="bg-deta">
                            <form method="post" action="<?= base_url('Warna/Aksi') ?>">
                                <div class="form-group">
                                    <label for="inputEmail4">Kode Warna</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="text" name="kode_warna" class="form-control border-deta" id="kode_warna" autocomplete="off" autofocus required>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-deta" onclick="kode()" type="button">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Nama Warna</label>
                                    <input type="text" name="nama_warna" class="form-control border-deta" autocomplete="off" required>
                                </div>
                                <button type="submit" name="smpn_war" class="btn btnn btn-deta float-right " <?= $akses->tambah != 1 ? 'disabled' : '' ?>>Tambah</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-body m-b-30">
                            <h4>Data Warna Barang</h4>
                            <hr class="bg-deta">

                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead style="text-align:center; ">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Kode</th>
                                            <th>Warna</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($warna as $war) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $war->kode_warna ?></td>
                                                <td><?= $war->nama_warna ?></td>
                                                <td align="center">
                                                    <a href="" <?= $akses->ubah != 1 ? 'hidden' : '' ?> data-target="#editWar<?= $war->id_warna_barang ?>" data-toggle="modal"><i class="fas fa-edit"></i></a>
                                                    <a href="<?= base_url('Warna/hapus/') . $war->id_warna_barang ?>" <?= $akses->hapus != 1 ? 'hidden' : '' ?> onclick="return confirm('Yakin hapus data ?')"><i class="fas fa-trash text-danger"></i></a>
                                                </td>
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
</div>

<!-- MODAL ADD -->
<?php foreach ($warna as $war) : ?>
    <div class="modal fade" id="editWar<?= $war->id_warna_barang ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header bg-deta text-white">
                    <h5 class="modal-title" id="exampleModalCenterTitle"><b>Ubah Warna Barang</b></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url('Warna/Aksi') ?>">
                        <div class="form-group">
                            <label for="inputEmail4">Kode Warna</label>
                            <input type="hidden" name="id_warna" class="form-control" autocomplete="off" autofocus value="<?= $war->id_warna_barang ?>">
                            <input type="text" name="kode_warna" class="form-control border-deta" autocomplete="off" autofocus value="<?= $war->kode_warna ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Nama Warna</label>
                            <input type="text" name="nama_warna" class="form-control border-deta" autocomplete="off" value="<?= $war->nama_warna ?>">
                        </div>
                        <button type="submit" name="ubah_war" class="btn btn-deta float-right">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    function kode() {
        var as = Math.ceil(Math.random() * 50000);
        $('#kode_warna').val(as);
    }
</script>