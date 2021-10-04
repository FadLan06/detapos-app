<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">

  <title>Cetak Keuntungan - DETAPOS</title>
</head>

<body>
  <?php
  // date_default_timezone_set("Asia/Makassar");
  $tglawal  = $_POST['bulan'];
  $tglakhir  = $_POST['tahun'];
  ?>

  <div class="mt-4 ml-4 mr-4 mb-4">
    <h4><b><?= $toko['nama_toko']; ?></b></h4>

    <div>
      <div class=""><?= $toko['alamat']; ?><br>
        Telp. <?= $toko['no_telpon']; ?><br><br>
        Periode :
        <?php
        if ($_POST['filter'] == '2') {

          if ($_POST['bulan'] == 1) {
            $bulan = 'Januari';
          } elseif ($_POST['bulan'] == 2) {
            $bulan = 'Februari';
          } elseif ($_POST['bulan'] == 3) {
            $bulan = 'Maret';
          } elseif ($_POST['bulan'] == 4) {
            $bulan = 'April';
          } elseif ($_POST['bulan'] == 5) {
            $bulan = 'Mei';
          } elseif ($_POST['bulan'] == 6) {
            $bulan = 'Juni';
          } elseif ($_POST['bulan'] == 7) {
            $bulan = 'Juli';
          } elseif ($_POST['bulan'] == 8) {
            $bulan = 'Agustus';
          } elseif ($_POST['bulan'] == 9) {
            $bulan = 'September';
          } elseif ($_POST['bulan'] == 10) {
            $bulan = 'Oktober';
          } elseif ($_POST['bulan'] == 11) {
            $bulan = 'November';
          } elseif ($_POST['bulan'] == 12) {
            $bulan = 'Desember';
          }
          echo $bulan . ' ' . $_POST['tahun'];
        } elseif ($_POST['filter'] == '3') {
          echo 'Tahun ' . $_POST['tahun'];
        } elseif ($_POST['filter'] == '1') {
          echo 'Tanggal ' . $_POST['tanggal'];
        } elseif ($_POST['filter'] == '4') {
          echo 'Dari ' . $_POST['tgl_awal'] . ' sampai ' . $_POST['tgl_akhir'];
        } else {
          echo 'Semua Periode';
        }
        ?>
      </div>
      <div class="">
        <span class="">
          <br>
        </span>
      </div>
    </div>

    <center>
      <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
        LAPORAN KEUNTUNGAN
      </h4>
    </center>

    <br>

    <table class="table table-striped table-bordered" style="text-align:center; width:100%">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th>KODE BARANG</th>
          <th>NAMA BARANG</th>
          <th>MODAL</th>
          <th>JUAL</th>
          <th width="5%">TERJUAL</th>
          <th>POTONGAN</th>
          <th>KEUNTUNGAN</th>
        </tr>
      </thead>
      <?php if (!empty($dataa)) : ?>
        <tbody>
          <?php $ttl_stok = 0;
          $ttl_terjual = 0;
          $ttl_keuntungan = 0;
          $ttl_pot = 0;
          $no = 1;
          foreach ($dataa->result_array() as $pen) { ?>
            <?php
            $token = $this->session->userdata('token');
            $role = $this->session->userdata('role_id');
            $user_id = $this->session->userdata('id');

            $akses4 = $this->db->get_where('user_access_menu', ['role_id' => $token, 'role' => $role, 'user_id' => $user_id, 'menu_id' => 29])->row_array();
            ?>
            <?php $stok = $this->db->query("SELECT sum(qty) as qty FROM tb_detail_penjualan WHERE kode_barang='$pen[kode_barang]' AND modal='$pen[modal]' AND token='$pen[token]' ")->row_array(); ?>
            <?php if (isset($_POST['cari'])) { ?>
              <?php if ($_POST['filter'] == 'semua') : ?>
                <?php $br = $this->db->query("SELECT kode_barang, nama_barang, harga_beli, harga_jual, token, id_kategori, sub_kategori, warna, ukuran FROM tb_barang WHERE kode_barang='$pen[kode_barang]' AND token='$pen[token]' ")->row_array(); ?>
                <?php $kat = $this->db->get_where('tb_kategori_barang', ['token' => $br['token'], 'kode_kategori' => $br['id_kategori']])->row_array(); ?>
              <?php elseif ($_POST['filter'] == '2') : ?>
                <?php $bulan = $_POST['bulan'];
                $tahun = $_POST['tahun'];
                $br = $this->db->query("SELECT kode_barang, nama_barang, harga_beli, harga_jual, token, id_kategori, sub_kategori, warna, ukuran FROM tb_barang WHERE kode_barang='$pen[kode_barang]' AND token='$pen[token]' ")->row_array(); ?>
                <?php $kat = $this->db->get_where('tb_kategori_barang', ['token' => $br['token'], 'kode_kategori' => $br['id_kategori']])->row_array(); ?>
              <?php elseif ($_POST['filter'] == '3') : ?>
                <?php $tahun = $_POST['tahun'];
                $br = $this->db->query("SELECT kode_barang, nama_barang, harga_beli, harga_jual, token, id_kategori, sub_kategori, warna, ukuran FROM tb_barang WHERE kode_barang='$pen[kode_barang]' AND token='$pen[token]' ")->row_array(); ?>
                <?php $kat = $this->db->get_where('tb_kategori_barang', ['token' => $br['token'], 'kode_kategori' => $br['id_kategori']])->row_array(); ?>
              <?php elseif ($_POST['filter'] == '1') : ?>
                <?php $br = $this->db->query("SELECT kode_barang, nama_barang, harga_beli, harga_jual, token, id_kategori, sub_kategori, warna, ukuran FROM tb_barang WHERE kode_barang='$pen[kode_barang]' AND token='$pen[token]' ")->row_array(); ?>
                <?php $kat = $this->db->get_where('tb_kategori_barang', ['token' => $br['token'], 'kode_kategori' => $br['id_kategori']])->row_array(); ?>
              <?php elseif ($_POST['filter'] == '4') : ?>
                <?php $br = $this->db->query("SELECT kode_barang, nama_barang, harga_beli, harga_jual, token, id_kategori, sub_kategori, warna, ukuran FROM tb_barang WHERE kode_barang='$pen[kode_barang]' AND token='$pen[token]' ")->row_array(); ?>
                <?php $kat = $this->db->get_where('tb_kategori_barang', ['token' => $br['token'], 'kode_kategori' => $br['id_kategori']])->row_array(); ?>
              <?php endif; ?>
            <?php } ?>
            <?php $terjual = $pen['total'] - 0; ?>
            <?php $keuntungan = ($pen['harga'] * $terjual) - ($pen['modal'] * $terjual) - $pen['tot']; ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $br['kode_barang'] ?></td>
              <td>
                <?php if (isset($akses4['menu_id'])) : ?>
                  <?php if (!empty($kat)) : ?>
                    <?= $br['nama_barang'] . ' <br> ' . $kat['nama_kategori'] . ' / ' . $br['sub_kategori'] . ' / ' . $br['warna'] . ' / ' . $br['ukuran'] ?>
                  <?php else : ?>
                    <?= $br['nama_barang'] ?>
                  <?php endif; ?>
                <?php else : ?>
                  <?= $br['nama_barang'] ?>
                <?php endif; ?>
              </td>
              <td>Rp. <?= number_format($pen['modal']) ?></td>
              <td>Rp. <?= number_format($pen['harga']) ?></td>
              <td align="center"><?= $terjual ?></td>
              <td>Rp. <?= number_format($pen['tot']) ?></td>
              <td>Rp. <?= number_format($keuntungan) ?></td>
            </tr>
            <?php $ttl_terjual += $terjual; ?>
            <?php $ttl_pot += $pen['tot']; ?>
            <?php $ttl_keuntungan += $keuntungan; ?>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5"><b>Total</b></td>
            <td align="center"><b><?= $ttl_terjual ?></b></td>
            <td><b>Rp. <?= number_format($ttl_pot) ?></b></td>
            <td><b>Rp. <?= number_format($ttl_keuntungan) ?></b></td>
          </tr>
        </tfoot>
      <?php else : ?>
        <tbody>
          <tr>
            <td colspan='8'>
              <i>
                <center>
                  -----------
                  Tidak Ada Data
                  -----------
                </center>
              </i>
            </td>
          </tr>
        </tbody>
      <?php endif; ?>
      <table>

        <span class="text-danger"><b>Rumus Keuntungan : </b></span> = (jual X terjual) - (modal X terjual) - potongan

  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script type="text/javascript">
    window.print();
    // window.history.back();
  </script>
  <script src="<?= base_url('assets/') ?>bootstrap/js/bootstrap.min.js"></script>
</body>

</html>