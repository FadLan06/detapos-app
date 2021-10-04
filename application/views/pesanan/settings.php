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
            <div class="col-sm-6">

                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="<?= base_url('Pesanan/settings_simpan') ?>" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Display Kategori</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="get_kategori" required>
                                                <option value="" selected>Pilih...</option>
                                                <option value="Aktif" <?= $set['get_kategori'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                                <option value="Tidak Aktif" <?= $set['get_kategori'] == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="bg-deta">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Biaya COD</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="number" name="biaya" min="0" value="<?= $cod['biaya'] ?>" placeholder="1000" id="example-text-input">
                                        </div>
                                        <label class="col-sm-4 col-form-label"></label>
                                        <div class="col-sm-8 mt-2">
                                            <select class="form-control" name="status" required>
                                                <option value="" selected>Pilih...</option>
                                                <option value="1" <?= $cod['status'] == '1' ? 'selected' : '' ?>>Aktif</option>
                                                <option value="0" <?= $cod['status'] == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="bg-deta">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Kode Unik</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="status_bank" required>
                                                <option value="" selected>Pilih...</option>
                                                <option value="1" <?= $setting['status'] == '1' ? 'selected' : '' ?>>Aktif</option>
                                                <option value="0" <?= $setting['status'] == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-4 col-form-label"></label>
                                        <div class="col-sm-8 mt-2">
                                            <select class="form-control" name="kode_unik" required>
                                                <option value="" selected>Pilih...</option>
                                                <option value="Mengurangi" <?= $setting['kode_unik'] == 'Mengurangi' ? 'selected' : '' ?>>Mengurangi (-)</option>
                                                <option value="Menambahkan" <?= $setting['kode_unik'] == 'Menambahkan' ? 'selected' : '' ?>>Menambahkan (+)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="bg-deta">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Ekspedisi Lokal</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="lokal" required>
                                                <option value="" selected>Pilih...</option>
                                                <option value="1" <?= $lokal['status'] == '1' ? 'selected' : '' ?>>Aktif</option>
                                                <option value="0" <?= $lokal['status'] == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-4 col-form-label"></label>
                                        <div class="col-sm-8 mt-2">
                                            <input class="form-control" type="number" name="ongkir" min="0" value="<?= $lokal['ongkir'] ?>" placeholder="1000">
                                        </div>
                                    </div>
                                    <!-- <hr class="bg-deta">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Custom Domain</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="domain" id="domain" value="<?= $setting['dom'] ?>" autocomplete="off">
                                            <small>Contoh : detapos.com</small>
                                        </div>
                                    </div> -->
                                    <hr class="bg-deta">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Fitur Reseller</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="get_kategori" required>
                                                <option value="" selected>Pilih...</option>
                                                <option value="1" <?= $set['reseller'] == '1' ? 'selected' : '' ?>>Aktif</option>
                                                <option value="0" <?= $set['reseller'] == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                                            </select>
                                            <small><span class="text-danger">Lakukan Penginputan Harga Barang Reseller Anda</span></small>
                                        </div>
                                    </div>
                                    <hr class="bg-deta">
                                    <button type="submit" class="btn btn-deta float-right" name="simpan"><i class="fas fa-save"></i> Simpan</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>