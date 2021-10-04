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
                        <div class="table-responsive">
                            <h5>User Akses : <b><?= $use['nama']; ?></b> <a href="<?= base_url('Akses') ?>" class="badge badge-deta float-right text-white">Kembali</a></h5>
                            <hr>
                            <?= $this->session->flashdata('message'); ?>
                            <?= $this->session->flashdata('message1'); ?>
                            <?= $this->session->flashdata('message2'); ?>
                            <?= $this->session->flashdata('message3'); ?>
                            <table class="table table-hover table-bordered table-sm" id="example">
                                <thead>
                                    <tr align="center">
                                        <th scope="col" width="5%">#</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Sub Menu</th>
                                        <th scope="col" width="5%">Access</th>
                                        <th scope="col" width="5%">Tambah</th>
                                        <th scope="col" width="5%">Edit</th>
                                        <th scope="col" width="5%">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($menu as $me) : ?>
                                        <tr>
                                            <td align="center"><?= $no++ ?></td>
                                            <td><?= $me['menu'] ?></td>
                                            <td><?= $me['title'] ?></td>
                                            <td align="center">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="form-check-input akses" type="checkbox" <?= check($use['token'], $me['id'], $use['role_id'], $use['id']); ?> data-role="<?= $use['token']; ?>" data-rol="<?= $use['role_id']; ?>" data-menu="<?= $me['id']; ?>" data-user="<?= $use['id']; ?>">
                                                </div>
                                            </td>
                                            <td align="center"><?php if ($me['sub_menu'] != '0') : ?><div class="custom-control custom-checkbox"><input class="form-check-input tambah" <?= tambah($use['token'], $me['id'], $use['role_id'], $use['id']); ?> type="checkbox" data-role1="<?= $use['token']; ?>" data-rol1="<?= $use['role_id']; ?>" data-menu1="<?= $me['id']; ?>" data-user1="<?= $use['id']; ?>"></div><?php endif; ?></td>
                                            <td align="center"><?php if ($me['sub_menu'] != '0') : ?><div class="custom-control custom-checkbox"><input class="form-check-input ubah" <?= ubah($use['token'], $me['id'], $use['role_id'], $use['id']); ?> type="checkbox" data-role2="<?= $use['token']; ?>" data-rol2="<?= $use['role_id']; ?>" data-menu2="<?= $me['id']; ?>" data-user2="<?= $use['id']; ?>"></div><?php endif; ?></td>
                                            <td align="center"><?php if ($me['sub_menu'] != '0') : ?><div class="custom-control custom-checkbox"><input class="form-check-input hapus" <?= hapus($use['token'], $me['id'], $use['role_id'], $use['id']); ?> type="checkbox" data-role3="<?= $use['token']; ?>" data-rol3="<?= $use['role_id']; ?>" data-menu3="<?= $me['id']; ?>" data-user3="<?= $use['id']; ?>"></div><?php endif; ?></td>
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