<?php $this->load->view('akses/css'); ?>
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
                    <div class="card-body table-responsive">
                        <h5><b>Management User Akses</b></h5>
                        <hr class="bg-deta">
                        <?= $this->session->flashdata('message'); ?>
                        <table class="table table-striped table-bordered table-sm" id="datatable" cellspacing="0" width="100%">
                            <thead align="center" class="bg-deta text-white">
                                <tr>
                                    <th width="25%" style="vertical-align: middle;">TOKEN</th>
                                    <th width="30%" style="vertical-align: middle;">Nama Lengkap</th>
                                    <th width="25%" style="vertical-align: middle;">Email</th>
                                    <th width="10%" style="vertical-align: middle;">Perpanjang</th>
                                    <th style="vertical-align: middle;">Status</th>
                                    <th width="10%" style="vertical-align: middle;">Verifikasi</th>
                                    <th width="10%">Reset Password</th>
                                    <th width="10%" style="vertical-align: middle;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kuser as $ku) : ?>
                                    <tr>
                                        <td><button class="btn text-danger" data-toggle="modal" data-target="#viewakses" data-id="<?= $ku['id'] ?>"><?= $ku['token'] ?></button></td>
                                        <td><?= $ku['nama'] ?></td>
                                        <td><?= $ku['email'] ?></td>
                                        <td align="center">
                                            <button type="submit" class="btn btn-primary btn-sm shadow" onclick="location.href='<?= base_url('Akses/Perpanjang/') . $ku['id'] . '/' . $ku['username'] ?>'">Perpanjang</button>
                                        </td>
                                        <td align="center">
                                            <?php if ($ku['is_active'] == '1') {
                                                echo '<span class="badge badge-success">Aktif</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">Non Aktif</span>';
                                            } ?>
                                        </td>
                                        <td align="center">
                                            <div class="onoffswitch" id="<?php echo $ku['token']; ?>">
                                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox status " id="myonoffswitch<?php echo $ku['token']; ?>" value="<?php echo $ku['is_active']; ?>" <?php echo $ku['is_active'] == "1" ? 'checked' : '' ?> />
                                                <label class="onoffswitch-label" for="myonoffswitch<?php echo $ku['token']; ?>">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td align="center">
                                            <button type="submit" class="btn btn-info btn-sm shadow" onclick="location.href='<?= base_url('Akses/Reset/') . $ku['id'] . '/' . $ku['username'] ?>'">Reset</button>
                                        </td>
                                        <td align="center">
                                            <a href="<?= base_url('Akses/Change_Member/') . $ku['token'] ?>" class="badge badge-warning shadow">Akses</a>
                                            <a href="<?= base_url('Akses/hapus_akses/') . $ku['token'] ?>" onclick="return confirm('Yakin anda ?')" class="badge badge-danger shadow">Hapus</a>
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

<div class="modal fade" id="viewakses" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-xl">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalCenterTitle">View User Akses</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="view_akses"></div>
            </div>
        </div>
    </div>
</div>