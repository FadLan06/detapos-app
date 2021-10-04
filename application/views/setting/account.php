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
                <?= $this->session->flashdata('message') ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body m-b-30 table-responsive">
                            <h5>Data Account</h5>
                            <hr class="bg-deta">
                            <table cellspacing="0" cellpadding="10" width="100%">
                                <tr>
                                    <td width="30%">Nama Lengkap</td>
                                    <td width="5%" align="center">:</td>
                                    <td><?= $setting['nama'] ?></td>
                                </tr>
                                <tr>
                                    <td width="30%">Email</td>
                                    <td width="5%" align="center">:</td>
                                    <td><?= $setting['email'] ?></td>
                                </tr>
                                <tr>
                                    <td width="30%" valign="top">Username</td>
                                    <td width="5%" align="center" valign="top">:</td>
                                    <td><?= $setting['username'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body m-b-30">
                            <h5>Edit Account</h5>
                            <hr class="bg-deta">
                            <?= $this->session->flashdata('message1') ?>
                            <nav class="mb-3">
                                <div class="nav nav-tabs border-deta" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" style="color: #008FD4" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Account</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" style="color: #008FD4" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Change Password</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <form method="POST" action="<?= base_url('Account/Aksi') ?>">
                                        <div class="form-group">
                                            <label for="inputAddress">Nama Lengkap</label>
                                            <input type="text" name="nama" class="form-control border-deta" id="inputAddress" autocomplete="off" value="<?= $setting['nama'] ?>">
                                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-7">
                                                <label for="inputEmail4">Email</label>
                                                <input type="email" name="email" class="form-control border-deta" id="inputEmail4" autocomplete="off" value="<?= $setting['email'] ?>">
                                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label for="inputPassword4">Username</label>
                                                <input type="text" name="username" class="form-control border-deta" id="inputPassword4" autocomplete="off" value="<?= $setting['username'] ?>">
                                                <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                                            </div>
                                        </div>
                                        <button type="submit" name="ubh" class="btn btn-deta float-right">Simpan</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <form method="POST" action="<?= base_url('Account') ?>">
                                        <div class="form-group">
                                            <label for="inputAddress">Password Lama</label>
                                            <input type="text" name="lama" class="form-control border-deta" id="inputAddress" autocomplete="off">
                                            <?= form_error('lama', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Password Baru</label>
                                            <input type="password" name="password" class="form-control border-deta" id="inputAddress" autocomplete="off">
                                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Konfirmasi Password Baru</label>
                                            <input type="password" name="password1" class="form-control border-deta" id="inputAddress" autocomplete="off">
                                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <button type="submit" class="btn btn-deta float-right">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>