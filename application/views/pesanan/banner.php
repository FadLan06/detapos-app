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

        <div class="card m-b-30">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Tambah Data</h5>
                        <hr class="bg-deta">
                        <form method="post" action="<?= base_url('Banner/Aksi') ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">NAMA FILE GAMBAR</label>
                                    <input type="text" class="form-control border-deta" name="nama_produk" autocomplete="off" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputCity">GAMBAR</label>
                                    <input type="file" class="form-control border-deta" onchange="previeww(this);" name="gambar" autocomplete="off" required>
                                    <small>Size = 1200 x 400 pixel</small>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputCity">PREVIEW GAMBAR</label><br>
                                    <img src="<?= base_url('assets/images/no-image.png') ?>" width="150px" alt="" id="preview_produk">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-deta" name="simpan" <?= $rows >= '5' ? 'disabled' : '' ?>><i class="fas fa-plus-circle"></i> Tambah</button>
                        </form>

                    </div>
                    <div class="col-md-8">
                        <h5>List Data</h5>
                        <hr class="bg-deta">
                        <table class="table table-sm table-bordered" width="100%">
                            <thead>
                                <tr align="center">
                                    <th width="3%">#</th>
                                    <th width="25%">Nama File</th>
                                    <th>Gambar</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($banner as $data) : ?>
                                    <tr align="center">
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['nama_produk'] ?></td>
                                        <td> <img src="<?= base_url('assets/upload/banner/') . $data['produk'] ?>" width="50%" alt=""></td>
                                        <td><a href="<?= base_url('Banner/hapus/') . $data['id_shop_banner'] ?>" class="badge badge-danger"><i class="fas fa-trash"></i> hapus</a></td>
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

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    window.previeww = function(input) {
        if (input.files && input.files[0]) {
            $(input.files).each(function() {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function(e) {
                    $("#preview_produk").attr('src', e.target.result);
                }
            });
        }
    }
</script>