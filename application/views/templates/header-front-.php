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

    <link rel="shortcut icon" href="<?= base_url() ?>assets/logodetanew.ico">

    <!-- Magnific popup -->
    <link href="<?= base_url() ?>assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome/css/all.min.css">
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/') ?>toastr.min.css" rel="stylesheet">

    <style>
        .imglogo {
            margin-top: 10px;
            /* margin-left: 30px; */
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto
        }

        .teks {
            font-size: 10px;
        }

        .harga {
            font-size: 28px;
        }

        .dtscroll {
            height: auto;
            width: auto;
            overflow: auto;
        }

        @media (min-width:576px) {
            .container {
                max-width: 576px
            }

            .teks {
                font-size: 12px;
            }

            .harga {
                font-size: 48px;
            }
        }

        @media (min-width:768px) {
            .container {
                max-width: 768px
            }

            .teks {
                font-size: 14px;
            }

            .harga {
                font-size: 48px;
            }
        }

        @media (min-width:992px) {
            .container {
                max-width: 992px
            }

            .teks {
                font-size: 14px;
            }

            .harga {
                font-size: 48px;
            }
        }

        @media (min-width:1200px) {
            .container {
                max-width: 1140px
            }

            .teks {
                font-size: 14px;
            }

            .alink:hover {
                border-bottom: 4px solid #00aaff;
                border-radius: 5px;
            }

            .harga {
                font-size: 48px;
            }
        }
    </style>
</head>


<!-- <body class="fixed-left"> -->

<body class="fixed-left" oncontextmenu="return false">

    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div> -->

    <!-- Begin page -->
    <div id="wrapper" class="enlarged">
        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <!-- Top Bar Start -->
                <div class="topbar">

                    <nav class="navbar-custom">
                        <div class="container">
                            <ul class="list-inline float-right mb-0">

                                <?php if ($this->session->userdata('email') != '') : ?>
                                    <?php $jml = 0;
                                    $total = 0; ?>
                                    <?php $use = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array(); ?>
                                    <?php $kr = $this->db->query("SELECT *, sum(qty) as qty, sum(qty * harga) as subtotal FROM tb_keranjang_tmp WHERE id_pel='$use[id_pel_shop]' GROUP BY id_barang")->result_array(); ?>
                                    <?php foreach ($kr as $items) {
                                        $jml = $jml + $items['qty'];
                                        $total = $total + $items['subtotal'];
                                    } ?>
                                    <li class="list-inline-item dropdown notification-list">
                                        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="fas fa-shopping-cart noti-icon"></i>
                                            <span class="badge badge-deta text-dark noti-icon-badge"><?= $jml ?></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                                            <!-- item-->
                                            <?php if ($this->session->userdata('email') != '') : ?>
                                                <?php if (empty($kr)) : ?>
                                                    <div class="dropdown-item noti-title">
                                                        <h5><span class="badge badge-deta text-dark float-right"><?= $jml ?></span>Keranjang Belanjaan</h5>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="dropdown-item noti-title">
                                                        <h5><span class="badge badge-deta text-dark float-right"><?= $jml ?></span>Keranjang Belanja</h5>
                                                    </div>
                                                    <?php foreach ($kr as $items) : ?>
                                                        <?php $barang = $this->db->get_where('tb_barang', ['gambar !=' => null, 'id' => $items['id_barang']])->row_array(); ?>
                                                        <!-- item-->
                                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                            <div class="notify-icon"><img src="<?= base_url() ?>assets/upload/barang/<?= $barang['gambar'] ?>" alt="user-img" class="img-fluid" /> </div>
                                                            <p class="notify-details"><b><?= $items['nama_barang'] ?></b><small class="text-muted"><?= $items['qty'] ?> x <?= number_format($items['harga']) ?> = Rp. <?= number_format($items['subtotal']) ?></small></p>
                                                        </a>
                                                    <?php endforeach; ?>

                                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                        <b>Total : </b> Rp. <?= number_format($total) ?>
                                                    </a>

                                                    <!-- All-->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <button type="button" onclick="location.href='<?= base_url('Shop/Keranjang') ?>'" class="btn btn-block btn-sm btn-warning" style="width:85%; margin:auto">
                                                                View Cart
                                                            </button></div>
                                                        <div class="col-md-6">
                                                            <a href="javascript:void(0);" onclick="location.href='<?= base_url('Shop/Checkout') ?>'" class="btn btn-block btn-sm btn-deta" style="width:85%; margin:auto">
                                                                Checkout
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <div class="dropdown-item noti-title">
                                                    <h5><span class="badge badge-deta text-dark float-right"><?= $jml ?></span>Keranjang Belanjaan</h5>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <li class="list-inline-item dropdown notification-list">
                                    <?php if ($this->session->userdata('email') == '') { ?>
                                        <a class="nav-link dropdown-toggle arrow-none text-dark waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <img src="<?= base_url() ?>assets/img/default.png" alt="user" class="rounded-circle">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right profile-dropdown dropdown-menu-lg">
                                            <div class="dropdown-item noti-title">
                                                Login
                                            </div>
                                            <!-- item-->
                                            <a class="dropdown-item" href="<?= base_url('Shop/Login') ?>"><i class="mdi mdi-login m-r-5 text-muted"></i> Masuk</a>
                                        </div>
                                    <?php } else { ?>
                                        <a class="nav-link dropdown-toggle arrow-none text-dark waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <img src="<?= base_url() ?>assets/img/<?= $this->session->userdata('image') ?>" alt="user" class="rounded-circle">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right profile-dropdown dropdown-menu-lg">
                                            <div class="dropdown-item noti-title">
                                                <?= $this->session->userdata('nama_pel') ?>
                                            </div>
                                            <!-- item-->
                                            <a class="dropdown-item" href="<?= base_url('Shop/Profil') ?>"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profil</a>
                                            <a class="dropdown-item" href="<?= base_url('Shop/Pesanan') ?>"><i class="mdi mdi-wallet m-r-5 text-muted"></i> Pesanan Saya</a>
                                            <a class="dropdown-item" href="<?= base_url('Shop/Keluar') ?>"><i class="mdi mdi-logout m-r-5 text-muted"></i> Keluar</a>
                                        </div>
                                    <?php } ?>
                                </li>

                            </ul>

                            <ul class="list-inline menu-left mb-0">
                                <li class="float-left">
                                    <?php
                                    $toko = ucwords(str_replace('-', ' ', $this->uri->segment(2)));
                                    $set = $this->db->get_where('setting_app', ['nama_toko' => $toko])->row_array();

                                    if ($set['logo'] == null) : ?>
                                        <a href="<?= base_url('Olshop/') . $this->uri->segment(2) ?>"><img src="<?= base_url() ?>assets/img/LOGOBIRU.webp" class="imglogo" height="50" alt="logo"></a>
                                    <?php else : ?>
                                        <a href="<?= base_url('Olshop/') . $this->uri->segment(2) ?>"><img src="<?= base_url() ?>assets/upload/<?= $set['logo'] ?>" class="imglogo" height="50" alt="logo"></a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>

                    </nav>

                </div>
                <!-- Top Bar End -->