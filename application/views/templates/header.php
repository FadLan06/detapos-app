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

  <!-- DataTables -->
  <link href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url() ?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="<?= base_url() ?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome/css/all.min.css">
  <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url() ?>assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style type="text/css">
    .pesanan {
      height: 450px;
      overflow-y: scroll;
    }

    .anyClass {
      height: 250px;
      overflow-y: scroll;
    }

    .anyClass1 {
      height: 200px;
      overflow-y: scroll;
    }

    .anyClass2 {
      height: 500px;
      overflow-y: scroll;
    }

    .anyClass3 {
      height: 200px;
      overflow-y: scroll;
    }

    .kirim {
      /*visibility: visible;*/
      margin-top: 0mm;
      font-size: 18px;
    }

    .short {
      display: none;
    }

    .modal-xl {
      max-width: 800px;
    }

    @media (min-width: 768px) {
      .kirim {
        /*visibility: hidden;*/
        margin-top: 5mm;
        font-size: 18px;
      }

      .short {
        display: block;
      }

      .modal-xl {
        max-width: 999px
      }
    }

    @media (min-width: 1200px) {
      .kirim {
        /*visibility: hidden;*/
        margin-top: 5mm;
        font-size: 18px;
      }

      .short {
        display: block;
      }

      .modal-xl {
        max-width: 1200px
      }
    }
  </style>
</head>


<body class="fixed-left">

  <!-- Begin page -->
  <div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
      <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
      </button>

      <!-- LOGO -->
      <div class="topbar-left">
        <div class="text-center">
          <?php $token = $this->session->userdata('token'); ?>
          <?php $logo = $this->db->get_where('setting_app', ['token' => $token])->row_array(); ?>
          <?php if (($token == '15812917') || ($logo['logo'] == null)) : ?>
            <a href="index.html" class="logo"><img src="<?= base_url() ?>assets/img/LOGO.webp" height="60" alt="logo"></a>
          <?php else : ?>
            <a href="index.html" class="logo"><img src="<?= base_url() ?>assets/upload/<?= $logo['logo'] ?>" alt="logo"></a>
          <?php endif; ?>
        </div>
      </div>

      <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
          <ul>
            <li class="menu-title">Main</li>
            <?php $acc = $this->db->get_where('setting_app', ['token' => $this->session->userdata('token')])->row(); ?>
            <?php
            $token = $this->session->userdata('token');
            $role = $this->session->userdata('role_id');
            $user_id = $this->session->userdata('id');

            $akses = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 27])->row_array();
            $akses1 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 38])->row_array();
            $akses2 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 40])->row_array();
            $akses3 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 39])->row_array();
            $akses4 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();
            $akses5 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 30])->row_array();
            $akses6 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 31])->row_array();

            ?>

            <?php if ($role = $this->session->userdata('role_id') == 1) : ?>
              <li>
                <a href="<?= base_url('Dashboard') ?>" class="waves-effect">
                  <i class="fas fa-home"></i>
                  <span> Dashboard </span>
                </a>
              </li>
              <li>
                <a href="<?= base_url('Menu') ?>" class="waves-effect">
                  <i class="fas fa-bars"></i>
                  <span> Data Menu </span>
                </a>
              </li>
              <li>
                <a href="<?= base_url('Akses') ?>" class="waves-effect">
                  <i class="fas fa-universal-access"></i>
                  <span> User Akses </span>
                </a>
              </li>
              <li>
                <a href="<?= base_url('Alert') ?>" class="waves-effect">
                  <i class="fas fa-exclamation-triangle"></i>
                  <span> ALERT </span>
                </a>
              </li>
              <li>
                <a href="<?= base_url('DB_Backup') ?>" class="waves-effect">
                  <i class="fas fa-database"></i>
                  <span> Backup Database </span>
                </a>
              </li>
            <?php elseif ($role = $this->session->userdata('role_id') == 2) : ?>
              <li>
                <a href="<?= base_url('Home') ?>" class="waves-effect">
                  <i class="fas fa-home"></i>
                  <span> Home </span>
                </a>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-copy"></i> <span>
                    Data Master </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Pelanggan') ?>">Pelanggan</a></li>
                  <li><a href="<?= base_url('Supplier') ?>">Supplier</a></li>
                  <li><a href="<?= base_url('Penjualan') ?>">Penjualan</a></li>
                  <li><a href="<?= base_url('Pembelian') ?>">Pembelian</a></li>
                  <li><a href="<?= base_url('Pengeluaran') ?>">Pengeluaran</a></li>
                  <?php if ($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR') : ?>
                    <li><a href="<?= base_url('Penjualan/Piutang') ?>">Piutang</a></li>
                  <?php endif; ?>
                </ul>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-clipboard"></i> <span>
                    Data Barang </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Ket_barang') ?>">Kategori</a></li>
                  <li><a href="<?= base_url('Barang') ?>">Barang</a></li>
                  <?php if (isset($akses4['menu_id'])) : ?>
                    <!-- <li><a href="<?= base_url('Harga') ?>">Harga Produk</a></li> -->
                    <li><a href="<?= base_url('Produk') ?>">Gambar Produk</a></li>
                    <li><a href="<?= base_url('Warna') ?>">Warna</a></li>
                    <li><a href="<?= base_url('Ukuran') ?>">Ukuran</a></li>
                  <?php endif; ?>
                </ul>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-chart-pie"></i> <span>
                    Akuntansi </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Akun') ?>">Akun</a></li>
                  <li><a href="<?= base_url('Jurnal_umum') ?>">Jurnal Umum</a></li>
                  <li><a href="<?= base_url('Buku_besar') ?>">Buku Besar</a></li>
                  <li><a href="<?= base_url('Neraca_saldo') ?>">Neraca Saldo</a></li>
                  <li><a href="<?= base_url('Laba_rugi') ?>">Laba Rugi</a></li>
                  <?php if ($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR') : ?>
                    <li><a href="<?= base_url('Profit') ?>">Sharing Profit</a></li>
                    <li><a href="<?= base_url('Kas_Bank') ?>">Bank & Kas</a></li>
                  <?php endif; ?>
                </ul>
              </li>
              <?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR') || (($this->session->userdata('token') == 'DPHNJ3FMWEHPNUG1'))) : ?>
                <li class="has_sub">
                  <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-clipboard"></i> <span>
                      Data </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                  <ul class="list-unstyled">
                    <li><a href="<?= base_url('Data_rekon') ?>">Data Rekon</a></li>
                    <li><a href="<?= base_url('Data_setoran') ?>">Data Setoran</a></li>
                  </ul>
                </li>
              <?php endif; ?>
              <li>
                <?php
                if (isset($akses['menu_id'])) {
                  echo '<a href="' . base_url('Kasir') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses1['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Diskon') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses2['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Retail') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses3['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Checkout') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses4['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Butik') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses5['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Warkop') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses6['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Electronik') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                }
                ?>
              </li>
              <?php if (isset($akses4['menu_id'])) : ?>
                <?php $toko = strtolower(str_replace(' ', '-', $logo['nama_toko'])) ?>
                <li class="has_sub">
                  <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-shopping-cart"></i> <span>
                      E-Commerce </span> <span class="badge badge-pill badge-light text-deta float-right" id="jumm">0</span></a>
                  <ul class="list-unstyled">
                    <li><a href="<?= base_url('Banner') ?>">Banner </a></li>
                    <li><a href="http://localhost:84/detashop/<?= $toko ?>" target="_blank">Toko Saya </a></li>
                    <li><a href="<?= base_url('Pesanan') ?>">Pesanan <span class="badge badge-pill badge-light text-deta float-right" id="jum">0</span></a></li>
                    <li><a href="<?= base_url('Pesanan/Report') ?>">Report </a></li>
                    <li><a href="<?= base_url('Pesanan/Customer') ?>">Customer </a></li>
                    <li><a href="<?= base_url('Pesanan/Reseller') ?>">Reseller </a></li>
                    <li><a href="<?= base_url('Pesanan/Settings') ?>">Settings </a></li>
                  </ul>
                </li>
              <?php endif; ?>
              <?php if ($this->session->userdata('token') == '0137216208-AJCV7-N8Z6X-ZOEHQ-WE9W4') : ?>
                <li>
                  <a href="<?= base_url('Report') ?>" class="waves-effect">
                    <i class="fas fa-file"></i>
                    <span> Report Barang </span>
                  </a>
                </li>
                <li>
                  <a href="<?= base_url('Notif') ?>" class="waves-effect">
                    <i class="fas fa fa-sticky-note"></i>
                    <span> Notif Stok </span>
                  </a>
                </li>
                <li>
                  <a href="<?= base_url('Tempo') ?>" class="waves-effect">
                    <i class="fas fa-server"></i>
                    <span> Jatuh Tempo </span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if (isset($akses3['menu_id'])) : ?>
                <li>
                  <a href="<?= base_url('Orders') ?>" class="waves-effect">
                    <i class="fas fa-shopping-cart"></i>
                    <span> Orders </span>
                  </a>
                </li>
              <?php endif; ?>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-archive"></i> <span>
                    Laporan </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Laporan/Harian') ?>">Penjualan Harian</a></li>
                  <li><a href="<?= base_url('Laporan/Minggu_Bulan') ?>">Penjualan Minggu Bulan</a></li>
                  <li><a href="<?= base_url('Laporan/Keuntungan') ?>">Keuntungan</a></li>
                  <li><a href="<?= base_url('Laporan/Retur_Supplier') ?>">Retur Supplier</a></li>
                  <li><a href="<?= base_url('Laporan/Retur_Customer') ?>">Retur Customer</a></li>
                  <li><a href="<?= base_url('Laporan/Pembelian') ?>">Pembelian Barang</a></li>
                </ul>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-edit"></i> <span>
                    Pengaturan </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Profil') ?>">Profil</a></li>
                  <li><a href="<?= base_url('User') ?>">User</a></li>
                  <li><a href="<?= base_url('Account') ?>">Account</a></li>
                  <?php if (isset($akses3['menu_id']) || isset($akses4['menu_id'])) : ?>
                    <li><a href="<?= base_url('No_rekening') ?>">No. Rekening</a></li>
                  <?php endif; ?>
                </ul>
              </li>
            <?php elseif ($role = $this->session->userdata('role_id') == 3) : ?>
              <li>
                <a href="<?= base_url('Beranda') ?>" class="waves-effect">
                  <i class="fas fa-home"></i>
                  <span> Beranda </span>
                </a>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-copy"></i> <span>
                    Data Master </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Pelanggan') ?>">Pelanggan</a></li>
                  <li><a href="<?= base_url('Supplier') ?>">Supplier</a></li>
                  <li><a href="<?= base_url('Penjualan') ?>">Penjualan</a></li>
                  <li><a href="<?= base_url('Pembelian') ?>">Pembelian</a></li>
                </ul>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-clipboard"></i> <span>
                    Data Barang </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Ket_barang') ?>">Kategori</a></li>
                  <li><a href="<?= base_url('Barang') ?>">Barang</a></li>
                  <?php if (isset($akses4['menu_id'])) : ?>
                    <li><a href="<?= base_url('Produk') ?>">Gambar Produk</a></li>
                    <li><a href="<?= base_url('Warna') ?>">Warna</a></li>
                    <li><a href="<?= base_url('Ukuran') ?>">Ukuran</a></li>
                  <?php endif; ?>
                </ul>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-chart-pie"></i> <span>
                    Akuntansi </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Akun') ?>">Akun</a></li>
                  <li><a href="<?= base_url('Jurnal_umum') ?>">Jurnal Umum</a></li>
                  <li><a href="<?= base_url('Buku_besar') ?>">Buku Besar</a></li>
                  <li><a href="<?= base_url('Neraca_saldo') ?>">Neraca Saldo</a></li>
                  <li><a href="<?= base_url('Laba_rugi') ?>">Laba Rugi</a></li>
                </ul>
              </li>
              <?php if (($this->session->userdata('token') == '0137242275-MQ07B-NAJWN-7VPXY-VYXZH') || (($this->session->userdata('token') == 'DPHNJ3FMWEHPNUG1'))) : ?>
                <li class="has_sub">
                  <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-clipboard"></i> <span>
                      Data </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                  <ul class="list-unstyled">
                    <li><a href="<?= base_url('Data_rekon') ?>">Data Rekon</a></li>
                    <li><a href="<?= base_url('Data_setoran') ?>">Data Setoran</a></li>
                  </ul>
                </li>
              <?php endif; ?>
              <li>
                <?php
                if (isset($akses['menu_id'])) {
                  echo '<a href="' . base_url('Kasir') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses1['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Diskon') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses2['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Retail') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses3['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Checkout') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses4['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Butik') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                } else if (isset($akses5['menu_id'])) {
                  echo '<a href="' . base_url('Kasir_Warkop') . '" class="waves-effect">
                    <i class="fas fa-vote-yea"></i>
                    <span> Kasir </span>
                  </a>';
                }
                ?>
              </li>
              <?php if ($this->session->userdata('token') == '0137216208-AJCV7-N8Z6X-ZOEHQ-WE9W4') : ?>
                <li>
                  <a href="<?= base_url('Report') ?>" class="waves-effect">
                    <i class="fas fa-file"></i>
                    <span> Report Barang </span>
                  </a>
                </li>
                <li>
                  <a href="<?= base_url('Notif') ?>" class="waves-effect">
                    <i class="fas fa fa-sticky-note"></i>
                    <span> Notif Stok </span>
                  </a>
                </li>
                <li>
                  <a href="<?= base_url('Tempo') ?>" class="waves-effect">
                    <i class="fas fa-server"></i>
                    <span> Jatuh Tempo </span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if (isset($akses3['menu_id'])) : ?>
                <li>
                  <a href="<?= base_url('Orders') ?>" class="waves-effect">
                    <i class="fas fa-shopping-cart"></i>
                    <span> Orders </span>
                  </a>
                </li>
              <?php endif; ?>
              <li hidden>
                <a href="<?= base_url('DB_Backup') ?>" class="waves-effect">
                  <i class="fas fa-database"></i>
                  <span> Backup Database </span>
                </a>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-archive"></i> <span>
                    Laporan </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Laporan/Harian') ?>">Penjualan Harian</a></li>
                  <li><a href="<?= base_url('Laporan/Minggu_Bulan') ?>">Penjualan Minggu Bulan</a></li>
                  <li><a href="<?= base_url('Laporan/Keuntungan') ?>">Keuntungan</a></li>
                  <li><a href="<?= base_url('Laporan/Retur_Supplier') ?>">Retur Supplier</a></li>
                  <li><a href="<?= base_url('Laporan/Retur_Customer') ?>">Retur Customer</a></li>
                  <li><a href="<?= base_url('Laporan/Pembelian') ?>">Pembelian Barang</a></li>
                </ul>
              </li>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-edit"></i> <span>
                    Pengaturan </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="<?= base_url('Profil') ?>">Profil</a></li>
                  <li><a href="<?= base_url('User') ?>">User</a></li>
                  <li><a href="<?= base_url('Account') ?>">Account</a></li>
                  <?php if (isset($akses3['menu_id']) || isset($akses4['menu_id'])) : ?>
                    <li><a href="<?= base_url('No_rekening') ?>">No. Rekening</a></li>
                  <?php endif; ?>
                </ul>
              </li>
            <?php endif; ?>
            <li>
              <a href="#" class="waves-effect" data-toggle="modal" data-target="#about">
                <i class="fas fa-info"></i>
                <span> ABOUT </span>
              </a>
            </li>
          </ul>
        </div>
        <div class="clearfix"></div>
      </div> <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->
    <!-- MODAL ABOUT -->
    <div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">About (Tentang Detapos Lite)</h5>
          </div>

          <div class="modal-body">
            <label>Nama Aplikasi :</label><br>
            <label><a target="_blank" href="https://detapos.co.id" style="color: #00aaff"><b>Detapos Lite v.03.02</b></a></label>

            <br>

            <label>Developed By :</label><br>
            <label><a target="_blank" href="https://www.gammaadvertisa.co.id" style="color: #00aaff"><b>Gamma Advertisa</b></a></label>

            <br>

            <label>Alamat Kantor :</label><br>
            <label>
              <a target="_blank" href="https://www.google.co.id/maps/place/Gamma+Advertisa/@0.55818,123.0512529,21z/data=!4m12!1m6!3m5!1s0x32792b4df6e4158b:0x9a9c6975e5bd74e!2sGamma+Advertisa!8m2!3d0.5582405!4d123.0512177!3m4!1s0x32792b4df6e4158b:0x9a9c6975e5bd74e!8m2!3d0.5582405!4d123.0512177" style="color: #00aaff">
                <b>Jl. Makassar, Dulalowo Tim, Kota Tengah, Kota Gorontalo, Gorontalo 96138</b>
              </a>
            </label>

            <br>
            <label>Kontak Support :</label><br>
            <label>
              <a target="_blank" href="//web.whatsapp.com/send?phone=628114324445&amp;text=Halo, Saya Mau Tanya Tentang Aplikasi *Detapos ini*" style="color: #00aaff">
                <b>0811-4324-445</b>
              </a>
            </label>

            <br>
            <label>Butuh Tambah/Custom Fitur :</label><br>
            <a class="btn btn-deta" style="background-color: #00aaff; border-color: #00aaff" target="_blank" href="//web.whatsapp.com/send?phone=628114324445&amp;text=Halo Admin, Saya Mau Request Tambah/Custom Fitur Aplikasi *Detapos*, Caranya Bagaimana yaa ?">
              <span class="badge badge-light"><i class="fas fa-plus"></i></span> Request Fitur
            </a>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!-- END MODAL ABOUT -->
    <!-- Start right Content here -->

    <div class="content-page">
      <!-- Start content -->
      <div class="content">

        <!-- Top Bar Start -->
        <div class="topbar">

          <nav class="navbar-custom">

            <ul class="list-inline float-right mb-0">

              <li class="list-inline-item dropdown notification-list">
                <a class="nav-link text-dark dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                  <?= $user['nama'] ?> <img src="<?= base_url() ?>assets/img/default.png" alt="user" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                  <a class="dropdown-item" href="<?= base_url('Login/Logout') ?>"><i class="mdi mdi-logout m-r-5 text-muted"></i>
                    Keluar</a>
                </div>
              </li>

            </ul>

            <ul class="list-inline menu-left mb-0">
              <li class="float-left">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                  <i class="mdi mdi-menu"></i>
                </button>
              </li>
            </ul>

            <div class="clearfix"></div>

          </nav>

        </div>
        <!-- Top Bar End -->