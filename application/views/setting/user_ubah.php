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
                        <?= $this->session->flashdata('message'); ?>
                        <form method="POST" action="<?= base_url('User/Ubah') ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Nama Lengkap</label>
                                    <input type="text" name="nama_user" class="form-control border-deta" id="inputEmail4" autocomplete="off" value="<?= $data->nama ?>">
                                    <input type="hidden" name="id" class="form-control" id="inputEmail4" autocomplete="off" value="<?= $data->id ?>">
                                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Username</label>
                                    <input type="text" name="username_user" class="form-control border-deta" id="inputPassword4" autocomplete="off" value="<?= $data->username ?>">
                                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="inputAddress">Email</label>
                                    <input type="email" name="email_user" class="form-control border-deta" id="inputAddress" autocomplete="off" value="<?= $data->email ?>">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Posisi</label>
                                    <select name="posisi" id="posisi" class="form-control border-deta" autocomplete="off">
                                        <option value="Admin" <?= $data->posisi == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="Kepala Gudang" <?= $data->posisi == 'Kepala Gudang' ? 'selected' : '' ?>>Kepala Gudang</option>
                                        <option value="Keuangan" <?= $data->posisi == 'Keuangan' ? 'selected' : '' ?>>Keuangan</option>
                                        <option value="Kasir" <?= $data->posisi == 'Kasir' ? 'selected' : '' ?>>Kasir</option>
                                    </select>
                                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">Password Baru</label>
                                    <input type="password" name="password_user" class="form-control border-deta" id="inputCity" placeholder="Password baru diisi jika perlu diganti">
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputZip">Konfirmasi Password</label>
                                    <input type="password" name="password-confirm-user" class="form-control border-deta" id="inputZip" placeholde="Samakan password baru jika ingin diganti">
                                    <?= form_error('password-confirm', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <button type="submit" name="ubh_user" class="btn btn-deta float-right">Simpan Perubahan</button>
                            <a class="btn btn-warning float-right mr-3" href="<?= base_url('User') ?>">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>