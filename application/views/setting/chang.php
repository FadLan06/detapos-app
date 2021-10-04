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
                    <div class="card-body">
                        <div class="table-responsive">
                            <h5>User Akses : <b><?= $use['nama']; ?></b><br>Posisi : <b><?= $use['posisi']; ?></b> <a href="<?= base_url('User') ?>" class="badge badge-deta text-white float-right">Kembali</a></h5>
                            <hr class="bg-deta">
                            <?= $this->session->flashdata('message'); ?>
                            <?= $this->session->flashdata('message1'); ?>
                            <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead>
                                    <tr align="center">
                                        <th scope="col" width="5%">#</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Sub Menu</th>
                                        <th scope="col" width="10%">Access</th>
                                        <th scope="col" width="10%">Tambah/Cetak</th>
                                        <th scope="col" width="10%">Ubah</th>
                                        <th scope="col" width="10%">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($menu as $me) :
                                        $akses = $this->db->get_where('user_access_menu', ['role_id' => $use['token'], 'menu_id' => $me['id'], 'role' => $use['role_id'], 'user_id' => $use['id']]);
                                    ?>
                                        <tr>
                                            <td align="center"><?= $no++ ?></td>
                                            <td><?= $me['menu'] ?></td>
                                            <td><?= $me['title'] ?></td>
                                            <td align="center">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="form-check-input akses1" type="checkbox" <?= check($use['token'], $me['id'], $use['role_id'],  $use['id']); ?> data-role="<?= $use['token']; ?>" data-roll="<?= $use['role_id']; ?>" data-user="<?= $use['id']; ?>" data-menu="<?= $me['id']; ?>">
                                                </div>
                                            </td>
                                            <td align="center">
                                                <?php if ($me['sub_menu'] != '0') : ?>
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="form-check-input tambah1" <?= $me['id_menu'] == '34' ? 'hidden' : '' ?> <?= $me['id_menu'] == '37' ? 'hidden' : '' ?> <?= $akses->num_rows() < 1 ? 'disabled' : '' ?> <?= tambah($use['token'], $me['id'], $use['role_id'], $use['id']); ?> type="checkbox" data-role4="<?= $use['token']; ?>" data-rol4="<?= $use['role_id']; ?>" data-menu4="<?= $me['id']; ?>" data-user4="<?= $use['id']; ?>">
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td align="center">
                                                <?php if ($me['sub_menu'] != '0') : ?>
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="form-check-input ubah1" <?= $me['id_menu'] == '37' ? 'hidden' : '' ?> <?= $akses->num_rows() < 1 ? 'disabled' : '' ?> <?= ubah($use['token'], $me['id'], $use['role_id'], $use['id']); ?> type="checkbox" data-role5="<?= $use['token']; ?>" data-rol5="<?= $use['role_id']; ?>" data-menu5="<?= $me['id']; ?>" data-user5="<?= $use['id']; ?>">
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td align="center">
                                                <?php if ($me['sub_menu'] != '0') : ?>
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="form-check-input hapus1" <?= $me['id_menu'] == '34' ? 'hidden' : '' ?> <?= $me['id_menu'] == '37' ? 'hidden' : '' ?> <?= $akses->num_rows() < 1 ? 'disabled' : '' ?> <?= hapus($use['token'], $me['id'], $use['role_id'], $use['id']); ?> type="checkbox" data-role6="<?= $use['token']; ?>" data-rol6="<?= $use['role_id']; ?>" data-menu6="<?= $me['id']; ?>" data-user6="<?= $use['id']; ?>">
                                                    </div>
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

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    tampill();

    function tampill() {
        $.ajax({
            type: 'GET',
            url: '<?= base_url('User/Change_User/'); ?>',
            async: true,
            dataType: 'json',
            success: function() {
                reload();
            }
        });
    }
    $('.akses1').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        const roleII = $(this).data('roll');
        const userId = $(this).data('user');

        $.ajax({
            url: "<?= base_url('User/Chang'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId,
                roleII: roleII,
                userId: userId,
            },
            success: function() {
                // document.location.href = "<?= base_url('User/Change_User/'); ?>" + roleId + "/" + userId;
                location.reload();
                tampill();
            }
        });
    });

    $('.tambah1').on('click', function() {
        const menuId4 = $(this).data('menu4');
        const roleId4 = $(this).data('role4');
        const roleI4 = $(this).data('rol4');
        const userId4 = $(this).data('user4');

        $.ajax({
            url: "<?= base_url('User/Chang1'); ?>",
            type: 'post',
            data: {
                menuId4: menuId4,
                roleId4: roleId4,
                roleI4: roleI4,
                userId4: userId4,
            },
            success: function() {
                // document.location.href = "<?= base_url('User/Change_User/'); ?>" + roleId4 + "/" + userId4;
                location.reload();
                tampill();
            }
        });
    });

    $('.ubah1').on('click', function() {
        const menuId5 = $(this).data('menu5');
        const roleId5 = $(this).data('role5');
        const roleI5 = $(this).data('rol5');
        const userId5 = $(this).data('user5');

        $.ajax({
            url: "<?= base_url('User/Chang2'); ?>",
            type: 'post',
            data: {
                menuId5: menuId5,
                roleId5: roleId5,
                roleI5: roleI5,
                userId5: userId5,
            },
            success: function() {
                // document.location.href = "<?= base_url('User/Change_User/'); ?>" + roleId5 + "/" + userId5;
                location.reload();
                tampill();
            }
        });
    });

    $('.hapus1').on('click', function() {
        const menuId6 = $(this).data('menu6');
        const roleId6 = $(this).data('role6');
        const roleI6 = $(this).data('rol6');
        const userId6 = $(this).data('user6');

        $.ajax({
            url: "<?= base_url('User/Chang3'); ?>",
            type: 'post',
            data: {
                menuId6: menuId6,
                roleId6: roleId6,
                roleI6: roleI6,
                userId6: userId6,
            },
            success: function() {
                // document.location.href = "<?= base_url('User/Change_User/'); ?>" + roleId6 + "/" + userId6;
                location.reload();
                tampill();
            }
        });
    });
</script>