<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Data Pelanggan</a></li>
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
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('Pelanggan/Aksi') ?>">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Kode Pelanggan</label>
                                    <input type="text" name="kode_pel" class="form-control border-deta" id="inputEmail4" value="<?= $pelanggan->kode_pel ?>" autocomplete="off" readonly>
                                    <input type="hidden" name="kd_pelanggan" class="form-control" id="inputEmail4" value="<?= $pelanggan->kd_pelanggan ?>" autocomplete="off" readonly>
                                    <?= form_error('kode_pel', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR') || ($this->session->userdata('token') == 'DPQTT39LS7ETWKXE')) : ?>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Nama Pelanggan</label>
                                        <input type="text" name="nama_pel" class="form-control border-deta" id="inputPassword4" autocomplete="off" value="<?= $pelanggan->nama_pel ?>">
                                        <?= form_error('nama_pel', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputPassword4">Nominal perPoint</label>
                                        <input type="number" min="0" name="point" class="form-control border-deta" id="inputPassword4" autocomplete="off" value="<?= $pelanggan->point ?>">
                                        <?= form_error('point', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                <?php else : ?>
                                    <div class="form-group col-md-8">
                                        <label for="inputPassword4">Nama Pelanggan</label>
                                        <input type="text" name="nama_pel" class="form-control border-deta" id="inputPassword4" autocomplete="off" value="<?= $pelanggan->nama_pel ?>">
                                        <?= form_error('nama_pel', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="inputAddress">Email</label>
                                    <input type="email" name="email" class="form-control border-deta" id="inputAddress" autocomplete="off" value="<?= $pelanggan->email ?>">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="inputAddress">Nomor Telpon/Hp</label>
                                    <input type="text" name="no_hp" class="form-control border-deta" id="inputAddress" autocomplete="off" value="<?= $pelanggan->no_hp ?>">
                                    <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="diskonn">Diskon</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control border-deta" id="diskonn" name="diskonn" autocomplete="off" value="<?= $pelanggan->diskon ?>">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control border-deta"><?= $pelanggan->alamat ?></textarea>
                                <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <button type="submit" name="ubah" class="btn btn-deta float-right">Simpan Perubahan</button>
                            <a class="btn btn-warning float-right mr-3" href="<?= base_url('Pelanggan') ?>">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>