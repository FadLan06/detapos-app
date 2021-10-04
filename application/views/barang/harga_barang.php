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
                            <h4>Input Data Ukuran</h4>
                            <hr class="bg-deta">
                            <form method="post" action="<?= base_url('Harga/Aksi') ?>">
                                <div class="form-group">
                                    <label for="inputAddress">Nama Harga Tingkatan</label>
                                    <input type="text" name="harga" class="form-control border-deta" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Keterangan</label>
                                    <textarea name="keterangan" class="form-control"></textarea>
                                </div>
                                <button type="submit" name="smpn" class="btn btnn btn-deta float-right " <?= $akses->tambah != 1 ? 'disabled' : '' ?>>Tambah</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-body m-b-30">
                            <h4>Data Ukuran Barang</h4>
                            <hr class="bg-deta">

                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead style="text-align:center; ">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Nama Harga Tingkatan</th>
                                            <th width="25%">Keterangan</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($harga as $data) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $data['harga'] ?></td>
                                                <td><?= $data['keterangan'] ?></td>
                                                <td></td>
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
<!-- <?php foreach ($ha as $kur) : ?>
    <div class="modal fade" id="editkur<?= $kur->id_ukuran_barang ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header bg-deta text-white">
                    <h5 class="modal-title" id="exampleModalCenterTitle"><b>Ubah Ukuran Barang</b></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url('Ukuran/Aksi') ?>">
                        <div class="form-group">
                            <label for="inputEmail4">Kode Ukuran</label>
                            <input type="hidden" name="id_ukuran" class="form-control" autocomplete="off" autofocus value="<?= $kur->id_ukuran_barang ?>">
                            <input type="text" name="kode_ukuran" class="form-control border-deta" autocomplete="off" autofocus value="<?= $kur->kode_ukuran ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Nama Ukuran</label>
                            <input type="text" name="nama_ukuran" class="form-control border-deta" autocomplete="off" value="<?= $kur->nama_ukuran ?>">
                        </div>
                        <button type="submit" name="ubah_kur" class="btn btn-deta float-right">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?> -->

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    function kode() {
        var as = Math.ceil(Math.random() * 50000);
        $('#kode_ukuran').val(as);
    }
</script>