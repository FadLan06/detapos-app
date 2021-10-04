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
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="text-center mt-0 m-b-15">
                            <a href="" class="logo logo-admin"><img src="<?= base_url('') ?>assets/img/logodeta1.webp" height="80" alt="logo"></a>
                        </h3>
                        <form class="form-horizontal m-t-20" action="<?= base_url('Shop/Registrasi') ?>" method="POST">
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="text" name="nama_pel" placeholder="Nama Lengkap" autocomplete="off">
                                    <?= form_error('nama_pel', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="text" name="no_hp" placeholder="Nomor HP/WA" autocomplete="off">
                                    <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <select name="provinsi" id="provinsi" class="form-control">
                                        <option selected disabled>
                                            <-- Pilih Provinsi -->
                                        </option>
                                    </select>
                                    <?= form_error('provinsi', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <select name="kota" id="kota" class="form-control">
                                        <option selected disabled>
                                            <-- Pilih Kota -->
                                        </option>
                                    </select>
                                    <?= form_error('kota', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Alamat"></textarea>
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="off">
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input type="password" name="password1" class="form-control border-deta" id="password1" autocomplete="off" placeholder="Confirm Password">
                                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>

                            <div class="form-group text-center row">
                                <div class="col-12">
                                    <button class="btn btn-deta btn-block waves-effect waves-light" type="submit"><b>R E G I S T R A S I</b></button>
                                    <small>Sudah punya akun ? <a href="<?= base_url('Shop/Login') ?>">Login</a></small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script>
    $.ajax({
        type: "POST",
        url: "<?= base_url('Raja_ongkir/Provinsi') ?>",
        success: function(hasil_provinsi) {
            $('select[name="provinsi"]').html(hasil_provinsi);
        }
    });

    $('select[name="provinsi"]').on("change", function() {
        var id_provinsi = $('option:selected', this).attr('id_provinsi');
        $.ajax({
            type: "POST",
            url: "<?= base_url('Raja_ongkir/Kota') ?>",
            data: 'id_provinsi=' + id_provinsi,
            success: function(hasil_kota) {
                $('select[name="kota"]').html(hasil_kota);
            }
        });
    });
</script>