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
    <link rel="manifest" href="manifest2.json">
</head>

<body class="fixed-left" oncontextmenu="return true">

    <div class="accountbg"></div>
    <div class="wrapper-page">

        <div class="card">
            <div class="card-body">

                <h3 class="text-center mt-0 m-b-15">
                    <a href="" class="logo logo-admin"><img src="<?= base_url('') ?>assets/img/logodeta1.webp" height="150" alt="logo"></a>
                </h3>

                <div class="p-3">
                    <?= $this->session->flashdata('message'); ?>
                    <form class="form-horizontal m-t-20" action="<?= base_url('Login') ?>" method="POST">

                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" type="text" id="username" name="username" placeholder="Username">
                                <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember me</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-deta btn-block waves-effect waves-light" id="masuk" type="submit"><b>M A S U K</b></button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= base_url('') ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
    <script src="<?= base_url('') ?>assets/js/bootstrap.min.js"></script>
    <!-- <script>
        $('#masuk').on('click', function() {
            var valid = this.form.checkValidity();
            if (valid) {
                event.preventDefault();
                var username = $('#username').val();
                var password = $('#password').val();
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url() ?>Login/api_login',
                    dataType: "JSON",
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
                return false;
            }
        });
    </script> -->


</body>

</html>

<!-- <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="img/128.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Fredoka One', cursive;
        }

        html,
        .fullscreen {
            display: flex;
            height: 100%;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .con {
            margin: auto;
            text-align: center;
        }

        .title {
            font-size: 5rem;
        }
    </style>

    <title>Maintenance Server</title>
</head>

<body class="fullscreen">
    <div class="con">
        <img src="<?= base_url('') ?>assets/img/logodeta1.webp" height="200" alt="logo"><br>
        <h1 class="title">Maintenance Server</h1>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html> -->