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

        <div class="row">
            <div class="col-md-4 mt-2">
                <div class="card m-b-30">
                    <div class="card-body">
                        <a href="" class="btn btn-sm" style="background-color: #008FD4; border-color: #008FD4; color: white" data-toggle="modal" data-target="#tmbh_menu"><i class="fas fa-plus-circle"></i> Tambah</a>
                        <h5 class="float-right"><b>MENU</b></h5>
                        <hr>
                        <?= $this->session->flashdata('message') ?>
                        <table class="table table-striped table-bordered table-sm" id="datatable-menu">
                            <thead align="center">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Menu</th>
                                    <th width="35%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($menu1 as $m) : ?>
                                    <tr>
                                        <td align="center"><?= $no++ ?></td>
                                        <td><?= $m->menu ?></td>
                                        <td align="center">
                                            <a href="" data-target="#ubh_menu" data-toggle="modal" data-id="<?= $m->id ?>" class="badge badge-info shadow">Ubah</a>
                                            <a href="<?= base_url('Menu/hapus_menu/') . $m->id ?>" onclick="return confirm('Yakin anda ?')" class="badge badge-danger shadow">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-2">
                <div class="card m-b-30">
                    <div class="card-body">
                        <a href="" class="btn btn-sm" style="background-color: #008FD4; border-color: #008FD4; color: white" data-toggle="modal" data-target="#tmbh_sub"><i class="fas fa-plus-circle"></i> Tambah</a>
                        <h5 class="float-right"><b>SUB MENU</b></h5>
                        <hr>
                        <?= $this->session->flashdata('message1') ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm" id="datatable" cellspacing="0">
                                <thead>
                                    <tr align="center">
                                        <th width="5%">#</th>
                                        <th width="25%">Title</th>
                                        <th width="15%">Menu</th>
                                        <th>Link</th>
                                        <th width="20%">Submenu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($submenu as $sm) :
                                        $submenu = $sm['sub_menu'] == 0 ? 'Menu Utama' : chek($sm['sub_menu']);
                                    ?>
                                        <tr>
                                            <td scope="row" align="center"><?= $no++ ?></td>
                                            <td>
                                                <?php if ($sm['is_active'] == 1) : ?>
                                                    <span class="text-success"><b><?= $sm['title'] ?></b></span>
                                                <?php else : ?>
                                                    <span class="text-danger"><b><?= $sm['title'] ?></b></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $sm['menu'] ?></td>
                                            <td><?= $sm['url'] ?></td>
                                            <td><?= $submenu ?></td>
                                            <td style="text-align:center;">
                                                <a href="" data-target="#ubh_sub" data-toggle="modal" data-id="<?= $sm['id'] ?>" class="badge badge-info shadow">Ubah</a>
                                                <a href="<?= base_url('Menu/hapus_sub/') . $sm['id'] ?>" onclick="return confirm('Yakin anda ?')" class="badge badge-danger shadow">Hapus</a>
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

<!-- Modal Menu-->
<div class="modal fade" id="tmbh_menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url('Menu/Aksi') ?>">
                    <div class="form-group">
                        <label for="menu">Nama Menu</label>
                        <input type="text" name="menu" class="form-control" id="menu" autocomplete="off">
                        <?= form_error('menu', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <button type="submit" name="smpn_menu" class="btn float-right" style="background-color: #008FD4; border-color: #008FD4; color: white">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ubh_menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ubah Data Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="ubh_menu"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sub Menu-->
<div class="modal fade" id="tmbh_sub" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url('Menu/Aksi') ?>">
                    <div class="form-group">
                        <label for="">Nama Menu</label>
                        <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">User Menu</label>
                        <select name="menu_id" id="menu_id" class="form-control" autocomplete="off">
                            <option value="">Pilih Menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Link Menu</label>
                        <input type="text" class="form-control" id="url" name="url" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Icon Menu</label>
                        <input type="text" class="form-control" id="icon" name="icon" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Sub Menu</label>
                        <select name="sub_menu" id="sub_menu" class="form-control" autocomplete="off">
                            <option value="0">Menu Utama</option>
                            <?php foreach ($sub_menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="smpn_sub" class="btn float-right" style="background-color: #008FD4; border-color: #008FD4; color: white">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ubh_sub" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ubah Data Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="ubh_sub"></div>
            </div>
        </div>
    </div>
</div>