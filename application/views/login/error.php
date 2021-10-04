<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('assets/')?>favicon.ico">
    <title><?=$judul?> - Detapos</title>
	<!-- <link rel="canonical" href="https://www.wrappixel.com/templates/xtremeadmin/" /> -->
    <link href="<?=base_url('assets/')?>style.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="error-title text-danger">404</h1>
                <h3 class="text-uppercase error-subtitle">PAGE NOT FOUND !</h3>
                <p class="text-muted mt-4 mb-4">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
                <button onclick="window.history.back()" class="btn btn-danger btn-rounded waves-effect waves-light mb-5">Back to home</button> </div>
        </div>
    </div>
    <script src="<?= base_url('assets/') ?>jquery-3.4.1.js"></script>
    <script src="<?= base_url('assets/') ?>popper.min.js"></script>
    <script src="<?= base_url('assets/') ?>bootstrap/js/bootstrap.min.js"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
    </script>
</body>

</html>