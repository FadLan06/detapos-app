<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">

  <title>Cetak Jurnal - DETAPOS</title>
</head>

<body>

  <?php
  date_default_timezone_set("Asia/Makassar");
  ?>
  <div class="mt-4 ml-4 mr-4 mb-4">
    <table class="" cellpadding="0" width="100%">
      <tr>
        <td width="300" style="vertical-align: middle;">
          <!-- <img src="../../assets/images/logolaporan.png" width="90%"> -->
        </td>
        <td style="text-align: right; vertical-align: middle;">
          <h6 class="w3-tinystrukhead">
            <?= $toko['nama_toko']; ?><br>
            <?= $toko['alamat']; ?><br>
            Telp. <?= $toko['no_telpon']; ?>
          </h6>
        </td>
      </tr>
    </table>

    <table class="" cellpadding="0" width="100%">
      <tr>
        <td width="12%">Jenis Laporan</td>
        <td width="2%">:</td>
        <td>Laporan Jurnal Umum</td>
      </tr>
      <tr>
        <td width="12%">Tanggal Cetak</td>
        <td width="2%">:</td>
        <td><?php echo longdate_indo(date('Y-m-d')); ?></td>
      </tr>
      <tr>
        <td width="12%">
          <?php
          if ($_POST['filter'] == '2') {
            echo 'Bulan & Tahun';
          } elseif ($_POST['filter'] == '3') {
            echo 'Tahun';
          } else {
            echo 'Periode';
          }
          ?>
        </td>
        <td width="2%">:</b></td>
        <td>
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
            echo $_POST['tahun'];
          }elseif ($_POST['filter'] == '1') {
            echo longdate_indo($_POST['tanggal']);
          } else {
            echo 'Semua Periode';
          }
          ?>
        </td>
      </tr>
    </table>

    <table class="table table-sm table-bordered mt-4" width="100%">
      <thead align="center">
        <tr>
          <th width="5%" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">NO</th>
          <th width="15%" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Tanggal Transaksi</th>
          <th width="25%" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Keterangan</th>
          <th width="20%" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Akun</th>
          <th style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Debet</th>
          <th style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Kredit</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($tgl->row() > null) : ?>
          <?php
          $no = 1;
          $total_debet =   0;
          $total_kredit    =   0;
          $all_debet       =   0;
          $all_kredit      =   0;
          foreach ($tgl->result_array() as $data) : ?>
            <tr>
              <td align="center" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><?= $no++ ?></td>
              <td colspan="5" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><?= longdate_indo($data['tgl_jurnal']) ?></td>
            </tr>
            <?php $token = $this->session->userdata('token'); ?>
            <?php
            if ($_POST['filter'] == 'semua') {
              $count = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.no_jurnal = '$data[no_jurnal]' ");
            } elseif ($_POST['filter'] == '1') {
                $count = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$_POST[tanggal]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.no_jurnal = '$data[no_jurnal]' ");
            } elseif ($_POST['filter'] == '2') {
              $count = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.no_jurnal = '$data[no_jurnal]' ");
            } elseif ($_POST['filter'] == '3') {
              $count = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.no_jurnal = '$data[no_jurnal]' ");
            }
            ?>
            <?php
            $baris = $count->num_rows();
            ?>
            <tr>
              <td rowspan="<?= $baris ?>" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"></td>
              <td rowspan="<?= $baris ?>" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"></td>
              <td rowspan="<?= $baris ?>" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><?= $data['keterangan'] ?></td>
              <?php foreach ($count->result_array() as $tra) : ?>
                <?php
                $total_debet   =   0;
                $total_kredit  =   0;
                ?>
                <?php if ($tra['tipe'] == 'D') {
                  $akun           =   "<p>$tra[nama_akun]</p>";
                  $kolom_debet    =   $tra['nominal'];
                  $kolom_kredit   =   "0";
                  $total_debet    +=  $kolom_debet;
                } elseif ($tra['tipe'] == 'K') {
                  $akun           =   "<p style='margin-left:50px;'>$tra[nama_akun]</p>";
                  $kolom_kredit   =   $tra['nominal'];
                  $kolom_debet    =   "0";
                  $total_kredit   +=  $kolom_kredit;
                } ?>
                <td style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><?= $akun ?></td>
                <td style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">
                  <p align="right">Rp. <?= number_format($kolom_debet, 0, ",", ".") ?></p>
                </td>
                <td style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">
                  <p align="right">Rp. <?= number_format($kolom_kredit, 0, ",", ".") ?></p>
                </td>
            </tr>
            <?php
                $all_debet   +=  $total_debet;
                $all_kredit +=   $total_kredit;
            ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
        <tr>
          <td colspan='4' align='center' style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><b>TOTAL</b></td>
          <td align='center' style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><b>Rp. <?= number_format($all_debet, 0, ",", ".") ?></b></td>
          <td align='center' style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><b>Rp. <?= number_format($all_kredit, 0, ",", ".") ?></b></td>
        </tr>
      <?php else : ?>
        <tr align="center">
          <td colspan="6" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><i>Tidak Ada Data Jurnal Umum</i></td>
        </tr>
      <?php endif; ?>
      </tbody>
    </table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript">
      window.print();
      // window.history.back();
    </script>
    <script src="<?= base_url('assets/') ?>bootstrap/js/bootstrap.min.js"></script>
</body>

</html>