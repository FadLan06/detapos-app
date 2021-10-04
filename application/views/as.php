<?php $query = $this->db->get_where('user', ['role_id' => $this->session->userdata('role_id')])->row(); ?>
<?php if ($query->role_id == 1) : ?>
  <div class="navbar-nav">
    <a class="nav-item nav-link text-white ml-4" href="<?= base_url('Dashboard') ?>"><i class="fas fa-home"></i> DASHBOARD <span class="sr-only">(current)</span></a>
    
    <a class="nav-item nav-link text-white ml-4" href="<?= base_url('Menu') ?>"> DATA MENU </a>
    <a class="nav-item nav-link text-white ml-4" href="<?= base_url('Akses') ?>"> USER AKSES </a>

    <a class="nav-item nav-link text-white ml-4 keluar" href="<?= base_url('Login/Logout') ?>"><i class="fas fa-sign-out-alt"></i> KELUAR (<?= $user['nama'] ?>)</a>
  </div>
  <?php elseif ($query->role_id == 2) : ?>
    <div class="navbar-nav">
      <a class="nav-item nav-link text-white ml-4" href="<?= base_url('Home') ?>"><i class="fas fa-home"></i> HOME <span class="sr-only">(current)</span></a>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white ml-4" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          MASTER DATA
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= base_url('Pelanggan') ?>">Data Pelanggan</a>
          <a class="dropdown-item" href="<?= base_url('Supplier') ?>">Data Supplier</a>
          <a class="dropdown-item" href="<?= base_url('Barang/Kategori') ?>">Data Kategori Barang</a>
          <a class="dropdown-item" href="<?= base_url('Barang/Data_Barang') ?>">Data Barang</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white ml-4" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          TRANSAKSI
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?= base_url('Transaksi/Kasir') ?>">KASIR</a>
          <a class="dropdown-item" href="<?= base_url('Transaksi/Penjualan') ?>">Data Transaksi Penjualan</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white ml-4" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          AKUNTANSI
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?= base_url('Akuntansi/Akun') ?>">Akun</a>
          <a class="dropdown-item" href="<?= base_url('Akuntansi/Jurnal_Umum') ?>">Jurnal Umum</a>
          <a class="dropdown-item" href="<?= base_url('Akuntansi/Buku_Besar') ?>">Buku Besar</a>
          <a class="dropdown-item" href="<?= base_url('Akuntansi/Neraca_Saldo') ?>">Neraca Saldo</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white ml-4" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          SETTING
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?= base_url('Setting/Profil') ?>">Profil</a>
          <a class="dropdown-item" href="<?= base_url('Setting/User') ?>">Tambah User</a>
        </div>
      </li>
      <a class="nav-item nav-link text-white ml-4" href="" data-toggle="modal" data-target="#about">ABOUT</a>
      <a class="nav-item nav-link text-white ml-4 keluar" href="<?= base_url('Login/Logout') ?>"><i class="fas fa-sign-out-alt"></i> KELUAR (<?= $user['username'] ?>)</a>
    </div>
    <?php endif; ?>