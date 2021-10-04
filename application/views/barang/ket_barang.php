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
                <?php if ($set->usaha == 'Butik') : ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h6>Input Data Kategori</h6>
                                    <hr class="bg-deta">
                                    <form method="post" action="<?= base_url('Ket_barang/Aksi') ?>" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="inputEmail4">Kode Kategori</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="text" name="kd_kat" class="form-control border-deta" id="kd_kat" autocomplete="off" autofocus required>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-deta" onclick="kode()" type="button">Generate</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Nama Kategori</label>
                                            <input type="text" name="nama_kategori" class="form-control border-deta" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Icon</label>
                                            <input type="file" name="icon" accept="image/*" class="form-control border-deta" autocomplete="off" required>
                                            <small>format file : 217 x 217 pixels ukuran maksimal 100 kb</small>
                                        </div>
                                        <button type="submit" name="smpn_ket" class="btn btnn btn-deta float-right " <?= $akses->tambah != 1 ? 'disabled' : '' ?>>Tambah</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h6>Input Data Sub Kategori</h6>
                                    <hr class="bg-deta">
                                    <form method="post" action="<?= base_url('Ket_barang/Aksi') ?>">
                                        <div class="form-group">
                                            <label for="inputAddress">Kategori</label>
                                            <select name="kode_kategori" id="kode_kategori" class="form-control" required>
                                                <option selected disabled>
                                                    <-- Pilih Kategori -->
                                                </option>
                                                <?php foreach ($kat as $ket) : ?>
                                                    <option value="<?= $ket->kode_kategori ?>"><?= $ket->nama_kategori ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail4">Kode Sub Kategori</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="text" name="kode_sub_kategori" class="form-control border-deta" id="kode_sub_kategori" autocomplete="off" autofocus required>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-deta" onclick="kode1()" type="button">Generate</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Nama Sub Kategori</label>
                                            <input type="text" name="nama_sub_kategori" class="form-control border-deta" autocomplete="off" required>
                                        </div>
                                        <button type="submit" name="smpn_sub_ket" class="btn btnn btn-deta float-right " <?= $akses->tambah != 1 ? 'disabled' : '' ?>>Tambah</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h4>Data Kategori Barang</h4>
                                    <hr class="bg-deta">

                                    <div class="table-responsive b-0" data-pattern="priority-columns">
                                        <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                            <thead style="text-align:center; ">
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="12%">Kode Kategori</th>
                                                    <th>Kategori</th>
                                                    <th width="5%">Icon</th>
                                                    <th>Sub Kategori</th>
                                                    <th width="10%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($kat as $ket) : ?>
                                                    <?php $sub = $this->db->get_where('tb_sub_kategori_barang', ['kode_kategori' => $ket->kode_kategori])->result(); ?>
                                                    <?php $ico = $this->db->query("SELECT * FROM tb_kategori_barang WHERE token='$ket->token' AND kode_kategori='$ket->kode_kategori' AND icon LIKE 'fa %'")->row(); ?>
                                                    <tr>
                                                        <td align="center"><?= $no++ ?></td>
                                                        <td><?= $ket->kode_kategori ?></td>
                                                        <td><?= $ket->nama_kategori ?></td>
                                                        <td align="center">
                                                            <?php if (!empty($ket->icon)) : ?>
                                                                <?php if ($ket->icon == $ico->icon) : ?>
                                                                    <i class="<?= $ket->icon ?>"></i>
                                                                <?php else : ?>
                                                                    <img src="<?= base_url('assets/upload/kategori/') . $ket->icon ?>" style="width: 50px; border-radius:30%" alt="">
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                <img src="<?= base_url('assets/upload/kategori/') . $ket->icon ?>" style="width: 50px; border-radius:30%" alt="">
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php foreach ($sub as $subb) : ?>
                                                                <li style="list-style-type: none"><a href="" data-target="#editSubKet<?= $subb->id_sub_kategori ?>" data-toggle="modal"><?= $subb->nama_sub_kategori ?></a></li>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <td align="center">
                                                            <a href="" <?= $akses->ubah != 1 ? 'hidden' : '' ?> data-target="#editKet<?= $ket->id_kategori ?>" data-toggle="modal"><i class="fas fa-edit"></i></a>
                                                            <a href="<?= base_url('Ket_barang/hapus_ket/') . $ket->id_kategori ?>" <?= $akses->hapus != 1 ? 'hidden' : '' ?> onclick="return confirm('Yakin hapus data ?')"><i class="fas fa-trash text-danger"></i></a>
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
                <?php else : ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-body">
                                <h4>Input Data Kategori</h4>
                                <hr class="bg-deta">
                                <form method="post" action="<?= base_url('Ket_barang/Aksi') ?>">
                                    <div class="form-group">
                                        <label for="inputEmail4">Kode Kategori</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="text" name="kd_kat" class="form-control border-deta" id="kd_kat" autocomplete="off" autofocus required>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-deta" onclick="kode()" type="button">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Nama Kategori</label>
                                        <input type="text" name="nama_kategori" class="form-control border-deta" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Icon</label>
                                        <input type="text" name="icon" class="form-control border-deta" autocomplete="off">
                                    </div>
                                    <button type="submit" name="smpn_ket" class="btn btnn btn-deta float-right " <?= $akses->tambah != 1 ? 'disabled' : '' ?>>Tambah</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card card-body">
                                <h4>Data Kategori Barang</h4>
                                <hr class="bg-deta">

                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead style="text-align:center; ">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th>Kode</th>
                                                <th>Kategori</th>
                                                <th>Icon</th>
                                                <th width="15%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($kat as $ket) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $ket->kode_kategori ?></td>
                                                    <td><?= $ket->nama_kategori ?></td>
                                                    <td><i class="fas <?= $ket->icon ?>" style="font-size:24px"></i></td>
                                                    <td align="center">
                                                        <a href="" <?= $akses->ubah != 1 ? 'hidden' : '' ?> data-target="#editKet<?= $ket->id_kategori ?>" data-toggle="modal"><i class="fas fa-edit"></i></a>
                                                        <a href="<?= base_url('Ket_barang/hapus_ket/') . $ket->id_kategori ?>" <?= $akses->hapus != 1 ? 'hidden' : '' ?> onclick="return confirm('Yakin hapus data ?')"><i class="fas fa-trash text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD -->
<?php foreach ($kat as $ket) : ?>
    <div class="modal fade" id="editKet<?= $ket->id_kategori ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header bg-deta text-white">
                    <h5 class="modal-title" id="exampleModalCenterTitle"><b>Ubah Kategori Barang</b></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url('Ket_barang/Aksi') ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputEmail4">Kode Kategori</label>
                            <input type="hidden" name="id_kat" class="form-control" autocomplete="off" autofocus value="<?= $ket->id_kategori ?>">
                            <input type="text" name="kd_kat" class="form-control border-deta" autocomplete="off" autofocus value="<?= $ket->kode_kategori ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control border-deta" autocomplete="off" value="<?= $ket->nama_kategori ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Icon</label>
                            <input type="file" name="icon" accept="image/*" class="form-control border-deta" autocomplete="off" required>
                            <small>format file : 217 x 217 pixels ukuran maksimal 100 kb</small>
                        </div>
                        <button type="submit" name="ubah_ket" class="btn btn-deta float-right">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($kat as $ket) : ?>
    <?php $sub = $this->db->get_where('tb_sub_kategori_barang', ['kode_kategori' => $ket->kode_kategori])->result(); ?>
    <?php foreach ($sub as $subb) : ?>
        <div class="modal fade" id="editSubKet<?= $subb->id_sub_kategori ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header bg-deta text-white">
                        <h5 class="modal-title" id="exampleModalCenterTitle"><b>Ubah Sub Kategori Barang</b></h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?= base_url('Ket_barang/Aksi') ?>">
                            <input type="hidden" name="id_sub_kategori" id="id_sub_kategori" value="<?= $subb->id_sub_kategori ?>">
                            <div class="form-group">
                                <label for="inputAddress">Kategori</label>
                                <select name="kode_kategori" id="kode_kategori" class="form-control" required>
                                    <option selected disabled>
                                        <-- Pilih Kategori -->
                                    </option>
                                    <?php foreach ($kat as $ket) : ?>
                                        <option value="<?= $ket->kode_kategori ?>" <?= $ket->kode_kategori == $subb->kode_kategori ? 'selected' : '' ?>><?= $ket->nama_kategori ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Nama Sub Kategori</label>
                                <input type="text" name="nama_sub_kategori" value="<?= $subb->nama_sub_kategori ?>" class="form-control border-deta" autocomplete="off">
                            </div>
                            <button type="submit" name="ubah_sub_ket" class="btn btn-deta float-right">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    function kode() {
        var as = Math.ceil(Math.random() * 50000);
        $('#kd_kat').val(as);
    }


    function kode1() {
        var as = Math.ceil(Math.random() * 50000);
        $('#kode_sub_kategori').val(as);
    }
</script>