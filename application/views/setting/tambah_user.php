<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Data User</a></li>
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
                    <div class="card-body col-md-8 mx-auto">
                        <form method="POST" action="<?= base_url('User/Tambah_User') ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control border-deta" id="inputEmail4" autocomplete="off" value="<?= set_value('nama') ?>">
                                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Username</label>
                                    <input type="text" name="username" class="form-control border-deta" id="inputPassword4" autocomplete="off" value="<?= set_value('username') ?>">
                                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="inputAddress">Email</label>
                                    <input type="email" name="email" class="form-control border-deta" id="inputAddress" autocomplete="off" value="<?= set_value('email') ?>">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Posisi</label>
                                    <select name="posisi" id="posisi" class="form-control border-deta" required autocomplete="off">
                                        <option disbled selected>
                                            <-- Pilih Posisi -->
                                        </option>
                                        <option value="Admin">Admin</option>
                                        <option value="Kepala Gudang">Kepala Gudang</option>
                                        <option value="Keuangan">Keuangan</option>
                                        <option value="Kasir">Kasir</option>
                                    </select>
                                    <?= form_error('posisi', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">Password</label>
                                    <input type="password" name="password" class="form-control border-deta" id="inputCity">
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputZip">Konfirmasi Password</label>
                                    <input type="password" name="password-confirm" class="form-control border-deta" id="inputZip">
                                    <?= form_error('password-confirm', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-deta float-right">Tambah</button>
                            <a class="btn btn-warning float-right mr-3" href="<?= base_url('User') ?>">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>