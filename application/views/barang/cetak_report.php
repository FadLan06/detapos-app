<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">

  <title>Cetak Report Barang - DETAPOS</title>
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
          if ($_POST['bulan1'] == 1) {
            $bulan1 = 'Januari';
          } elseif ($_POST['bulan1'] == 2) {
            $bulan1 = 'Februari';
          } elseif ($_POST['bulan1'] == 3) {
            $bulan1 = 'Maret';
          } elseif ($_POST['bulan1'] == 4) {
            $bulan1 = 'April';
          } elseif ($_POST['bulan1'] == 5) {
            $bulan1 = 'Mei';
          } elseif ($_POST['bulan1'] == 6) {
            $bulan1 = 'Juni';
          } elseif ($_POST['bulan1'] == 7) {
            $bulan1 = 'Juli';
          } elseif ($_POST['bulan1'] == 8) {
            $bulan1 = 'Agustus';
          } elseif ($_POST['bulan1'] == 9) {
            $bulan1 = 'September';
          } elseif ($_POST['bulan1'] == 10) {
            $bulan1 = 'Oktober';
          } elseif ($_POST['bulan1'] == 11) {
            $bulan1 = 'November';
          } elseif ($_POST['bulan1'] == 12) {
            $bulan1 = 'Desember';
          }
          echo $bulan . ' sampai ' . $bulan1 . ' ' . $_POST['tahun'];
        } elseif ($_POST['filter'] == '3') {
          echo $_POST['tahun'];
        } elseif ($_POST['filter'] == '1') {

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
        LAPORAN REPORT BARANG
      </h4>
    </center>

    <br>

    <?php if ($_POST['filter'] == '2') { ?>
      <table class="table table-striped table-bordered" id="example" style="text-align:center; width:100%">
        <thead>
          <tr>
            <th width="5%">#</th>
            <th>BULAN / TAHUN</th>
            <th>KODE / NAMA BARANG</th>
            <th>TERJUAL</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($barang->num_rows() >= 1) : ?>
            <?php $no = 1;
            $tttl = 0;
            foreach ($barang->result_array() as $br) : ?>
              <?php if ($br['bulan'] == 1) {
                $bulan = 'Januari';
              } elseif ($br['bulan'] == 2) {
                $bulan = 'Februari';
              } elseif ($br['bulan'] == 3) {
                $bulan = 'Maret';
              } elseif ($br['bulan'] == 4) {
                $bulan = 'April';
              } elseif ($br['bulan'] == 5) {
                $bulan = 'Mei';
              } elseif ($br['bulan'] == 6) {
                $bulan = 'Juni';
              } elseif ($br['bulan'] == 7) {
                $bulan = 'Juli';
              } elseif ($br['bulan'] == 8) {
                $bulan = 'Agustus';
              } elseif ($br['bulan'] == 9) {
                $bulan = 'September';
              } elseif ($br['bulan'] == 10) {
                $bulan = 'Oktober';
              } elseif ($br['bulan'] == 11) {
                $bulan = 'November';
              } elseif ($br['bulan'] == 12) {
                $bulan = 'Desember';
              } ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $bulan . ' ' . $br['tahun'] ?></td>
                <td><?= $br['kode'] . ' / ' . $br['nama_barang'] ?></td>
                <td><?= number_format($br['kty']) ?></td>
              </tr>
              <?php $tttl += $br['kty'] ?>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan='4'>
                <i>
                  <center>
                    -----------
                    Tidak Ada Data
                    -----------
                  </center>
                </i>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"><b>TOTAL</b></td>
            <td><b><?= number_format($tttl) ?></b></td>
          </tr>
        </tfoot>
        <table>
        <?php } else { ?>
          <table class="table table-striped table-bordered" style="text-align:center; width:100%">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th>KODE BARANG</th>
                <th>NAMA BARANG</th>
                <th width="20%">HARGA JUAL</th>
                <th width="5%">TERJUAL</th>
                <th width="15%">SISA STOK</th>
                <th>SUB TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php $ttl1 = 0; ?>
              <?php $ttl2 = 0; ?>
              <?php $ttl3 = 0; ?>
              <?php $ttl4 = 0; ?>
              <?php if ($barang->num_rows() >= 1) : ?>
                <?php foreach ($barang->result_array() as $br) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $br['kode'] ?></td>
                    <td><?= $br['nama_barang'] ?></td>
                    <td>Rp. <?= number_format($br['harga_jual']) ?></td>
                    <td><?= number_format($br['kty']) ?></td>
                    <td><?= number_format($br['jml_stok']) ?></td>
                    <td>Rp. <?= number_format($br['sub_total']) ?></td>
                  </tr>
                  <?php $ttl1 += $br['harga_jual']; ?>
                  <?php $ttl2 += $br['kty']; ?>
                  <?php $ttl4 += $br['jml_stok']; ?>
                  <?php $ttl3 += $br['sub_total']; ?>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan='6'>
                    <i>
                      <center>
                        -----------
                        Tidak Ada Data
                        -----------
                      </center>
                    </i>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3"><b>TOTAL</b></td>
                <td><b>Rp. <?= number_format($ttl1) ?></b></td>
                <td><b><?= number_format($ttl2) ?></b></td>
                <td><b><?= number_format($ttl4) ?></b></td>
                <td><b>Rp. <?= number_format($ttl3) ?></b></td>
              </tr>
            </tfoot>
            <table>
            <?php } ?>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script type="text/javascript">
    // window.print();
    // window.history.back();
  </script>
</body>

</html>