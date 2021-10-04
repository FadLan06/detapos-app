<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?= $judul ?> | Detapos</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?= base_url('') ?>assets/logodetanew.ico">

    <link href="<?= base_url('') ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('') ?>assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('') ?>assets/css/style.css" rel="stylesheet" type="text/css">

</head>

<!-- <body class="fixed-left"> -->

<body class="fixed-left" oncontextmenu="return true">

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">

        <div class="card">
            <div class="card-body">

                <h3 class="text-center mt-0 m-b-15">
                    <a href="" class="logo logo-admin"><img src="<?= base_url('') ?>assets/img/logodeta1.webp" height="100" alt="logo"></a>
                </h3>

                <div class="p-3"><?= $this->session->flashdata('message'); ?>
                    <form class="form-horizontal" method="POST" action="<?= base_url('Login/Registrasi') ?>">

                        <div class="form-group row">
                            <div class="col-12">
                                <input type="text" name="token" class="form-control border-deta" id="token" onBlur='cekToken()' aria-describedby="emailHelp" placeholder="License Key" autocomplete="off" autofocus required>
                                <input type="hidden" name="token2" class="form-control border-deta" id="token2" onBlur='cekToken()' aria-describedby="emailHelp" placeholder="License Key" autocomplete="off" autofocus>
                                <input type="hidden" name="produk" class="form-control border-deta" id="produk" onBlur='cekToken()' aria-describedby="emailHelp" placeholder="License Key" autocomplete="off" autofocus>
                                <img src='<?= base_url('assets/icon/') ?>loader.gif' id='IconToken' style='display:none' /><span id='token-status'></span>
                                <?= form_error('token', '<span class="text-danger pl-3">', '</span>') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input type="text" name="nama" class="form-control border-deta" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Lengkap" autocomplete="off" required>
                                <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input type="text" name="username" class="form-control border-deta" id="inputPassword4" placeholder="Username" autocomplete="off" required>
                                <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input type="number" name="no_hp" class="form-control border-deta" id="inputPassword4" placeholder="No. Hp/WA" autocomplete="off" required>
                                <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input type="email" name="email" class="form-control border-deta" id="email" autocomplete="off" placeholder="Email" required>
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <select class="form-control" autocomplete="off" name="usaha" id="usaha" required>
                                    <option disabled selected>
                                        Jenis Usaha...
                                    </option>
                                    <option value="Butik">Pemilik Butik</option>
                                </select>
                                <?= form_error('usaha', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input type="password" name="password" class="form-control border-deta" id="password" placeholder="Password" autocomplete="off" required>
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input type="password" name="password1" class="form-control border-deta" id="password1" autocomplete="off" placeholder="Confirm Password" required>
                                <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="hidden" name="license_expires" class="form-control border-deta" id="license_expires" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-deta btn-block waves-effect waves-light" disabled id="register" type="submit">Register</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- jQuery  -->
    <script src="<?= base_url('') ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url('') ?>assets/js/bootstrap.min.js"></script>

    <script>
        function cekToken() {
            var token = $('#token').val();
            $("#IconToken").show();
            $.ajax({
                url: "<?= base_url('Login/Cek_Token') ?>",
                data: 'token=' + $('#token').val(),
                type: "POST",
                dataType: 'json',
                success: function(hasil) {
                    // console.log(hasil);
                    if ((hasil.message == 'License Key not found') || (hasil.message == 'Empty License Key submitted')) {
                        $("#token-status").html('<img src="<?= base_url('assets/icon/') ?>close.png" width="20px" align="absmiddle"> <font color="#">Tidak Tersedia </font>');
                        $("#IconToken").hide();
                        $("#register").prop('disabled', true);
                        $("#token2").val(hasil);
                        $('#license_expires').val(' ');
                    } else {
                        $("#token-status").html('<img src="<?= base_url('assets/icon/') ?>check.png" width="20px" align="absmiddle"> <font color="#"> Tersedia </font>  ');
                        $("#IconToken").hide();
                        $("#register").prop('disabled', false);
                        $("#token2").val(hasil);

                        // var exp = $(this).attr('exp');
                        $('#license_expires').val(hasil.license_expires);

                        $.ajax({
                            url: "<?= base_url('Login/Cek_Produk') ?>",
                            data: 'token=' + token,
                            type: "POST",

                            success: function(produk) {
                                if ((produk == '') || (produk == '0')) {
                                    $('#produk').val(produk);
                                } else {
                                    $('#produk').val(produk);
                                }
                            }
                        })
                    }
                }

            });
        }
    </script>

</body>

</html>