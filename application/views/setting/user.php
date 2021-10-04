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
                <div class="card m-b-30">
                    <div class="card-body">
                        <a href="<?= base_url('User/Tambah_User') ?>" class="btn btn-deta"><i class="fas fa-plus-circle"></i> Tambah</a>
                        <hr class="bg-deta">
                        <?= $this->session->flashdata('message'); ?>

                        <?php echo validation_errors(); ?>
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="center" style="text-align:center; ">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Nama</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Terakhir Login</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($userr as $us) : ?>
                                        <tr align="center">
                                            <td><?= $no++ ?></td>
                                            <td align="left"><?= $us->nama ?></td>
                                            <td><?= $us->email ?></td>
                                            <td><?= $us->username ?></td>
                                            <td><?= $us->last_login ?></td>
                                            <td>
                                                <a href="<?= base_url('User/Change_User/') . $us->token . '/' . $us->id ?>" class="btn btn-warning btn-sm" title="Akses"><i class="fas fa-search text-dark"></i></a>
                                                <?php if ($us->role_id == '2') : ?>
                                                    <a href="" class="btn btn-deta btn-sm disabled" title="Ubah"><i class="fas fa-edit"></i></a>
                                                    <a href="" class="btn btn-danger btn-sm disabled" title="Hapus"><i class="fas fa-trash text-light"></i></a>
                                                <?php else : ?>
                                                    <a href="<?= base_url('user/Ubah_User/') . $us->id ?>" class="btn btn-deta btn-sm" title="Ubah"><i class="fas fa-edit"></i></a>
                                                    <a href="<?= base_url('User/hps_user/') . $us->id ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-light"></i></a>
                                                <?php endif; ?>
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

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url('User') ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" id="inputEmail4" autocomplete="off">
                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Username</label>
                            <input type="text" name="username" class="form-control" id="inputPassword4" autocomplete="off">
                            <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Email</label>
                        <input type="email" name="email" class="form-control" id="inputAddress" autocomplete="off">
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Password</label>
                            <input type="password" name="password" class="form-control" id="inputCity">
                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputZip">Konfirmasi Password</label>
                            <input type="password" name="password-confirm" class="form-control" id="inputZip">
                            <?= form_error('password-confirm', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger float-right">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="user_Ubh" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ubah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="userUbh"></div>
            </div>
        </div>
    </div>
</div>