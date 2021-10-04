<div class="page-content-wrapper ">

    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <!-- <li class="breadcrumb-item"><a href="#">Annex</a></li> -->
                            <li class="breadcrumb-item"><a href="<?= base_url('Shop') ?>">Home</a></li>
                            <li class="breadcrumb-item active"><?= $judul ?></li>
                        </ol>
                    </div>
                    <h4><?= $judul ?></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mt-0 m-b-15">
                            <a href="" class="logo logo-admin"><img src="<?= base_url('') ?>assets/img/logodeta1.webp" height="150" alt="logo"></a>
                        </h3>
                        <?= $this->session->flashdata('message'); ?>
                        <form class="form-horizontal m-t-20" action="<?= base_url('Shop/Login') ?>" method="POST">

                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="off">
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>

                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-deta btn-block waves-effect waves-light" type="submit"><b>M A S U K</b></button>
                                    <small>Belum punya akun ? <a href="<?= base_url('Shop/Registrasi') ?>">Registrasi</a></small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->