<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">

  <title>Cetak Neraca Saldo - DETAPOS</title>
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
        <td>Laporan Neraca Saldo</td>
      </tr>
      <tr>
        <td width="12%">Tanggal Cetak</td>
        <td width="2%">:</td>
        <td><?php echo longdate_indo(date('Y-m-d')); ?></td>
      </tr>
      <tr>
        <td width="20%">
          <?php
          if ($_POST['filter'] == '1') {
            echo 'Tanggal';
          } elseif ($_POST['filter'] == '2') {
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
          } elseif ($_POST['filter'] == '1') {
            echo longdate_indo($_POST['tanggal']);
          } else {
            echo 'Semua Data';
          }
          ?>
        </td>
      </tr>
    </table>

    <table class="table table-bordered table-sm mt-4" cellspacing="0" width="100%">
      <thead align="center">
        <tr>
          <th width="5%" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">NO</th>
          <th width="15%" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Kode Akun</th>
          <th width="35%" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Nama Akun</th>
          <th style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Debet</th>
          <th style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Kredit</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($data->row() > null) : ?>
          <?php $no = 1;
          $ts_debet = "0";
          $ts_kredit = "0";
          foreach ($data->result_array() as $d) : ?>
            <?php $total_debet = "0";
            $total_kredit = "0";
            $saldo_debet = "0";
            $saldo_kredit = "0"; ?>

            <?php $token = $this->session->userdata('token'); ?>
            <?php
            if ($_POST['filter'] == 'semua') {
              $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.id_akun='$d[idakun]' ");
            } elseif ($_POST['filter'] == '1') {
              $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$_POST[tanggal]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.id_akun='$d[idakun]' ");
            } elseif ($_POST['filter'] == '2') {
              $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.id_akun='$d[idakun]' ");
            } elseif ($_POST['filter'] == '3') {
              $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.id_akun='$d[idakun]' ");
            }
            ?>
            <?php foreach ($neraca->result_array() as $n) : ?>
              <?php
              if ($n['tipe'] == 'D') {
                $debet = $n['nominal'];
                $kredit = "0";
              } elseif ($n['tipe'] == 'K') {
                $kredit = $n['nominal'];
                $debet = "0";
              }
              $total_debet += $debet;
              $total_kredit += $kredit;

              if ($n['kategori'] == 'HL') {
                $saldo_debet = $total_debet - $total_kredit;
                $posisi = "Debet";
              } elseif ($n['kategori'] == 'HT') {
                $saldo_kredit = $total_kredit - $total_debet;
                $posisi = "Kredit";
              }
              ?>
            <?php endforeach; ?>
            <?php $ts_kredit += $saldo_kredit;
            $ts_debet += $saldo_debet; ?>

            <tr align="center">
              <td style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><?= $no++ ?></td>
              <td style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><?= $d['kode_akun'] ?></td>
              <td style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><?= $d['nama_akun'] ?></td>
              <td style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align='right'>Rp. <?= number_format($saldo_debet, 0, ",", ".") ?></td>
              <td style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align='right'>Rp. <?= number_format($saldo_kredit, 0, ",", ".") ?></td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td colspan='3' align='center' style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><b>Total</b></td>
            <td align='center' style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Rp. <?php echo number_format($ts_debet, 0, ",", "."); ?></td>
            <td align='center' style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">Rp. <?php echo number_format($ts_kredit, 0, ",", "."); ?></td>
          </tr>
        <?php else : ?>
          <tr align="center">
            <td colspan="5" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"><i>Tidak Ada Data Neraca Saldo</i></td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
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