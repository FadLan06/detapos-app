<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">

  <title>Cetak Laba Rugi - DETAPOS</title>
</head>

<body>

  <?php
  date_default_timezone_set("Asia/Makassar");

  $tanggal = $_POST['tanggal'];
  $bulan = $_POST['bulan'];
  $tahun = $_POST['tahun'];
  $filter = $_POST['filter'];
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
        <td>Laporan Laba Rugi</td>
      </tr>
      <tr>
        <td width="12%">Tanggal Cetak</td>
        <td width="2%">:</td>
        <td><?php echo longdate_indo(date('Y-m-d')); ?></td>
      </tr>
      <tr>
        <td width="12%">
          <?php
          if ($filter == '1') {
            echo 'Tanggal';
          } elseif ($filter == '2') {
            echo 'Bulan & Tahun';
          } elseif ($filter == '3') {
            echo 'Tahun';
          } else {
            echo 'Periode';
          }
          ?>
        </td>
        <td width="2%">:</b></td>
        <td>
          <?php
          if ($filter == '2') {

            if ($bulan == 1) {
              $bulan = 'Januari';
            } elseif ($bulan == 2) {
              $bulan = 'Februari';
            } elseif ($bulan == 3) {
              $bulan = 'Maret';
            } elseif ($bulan == 4) {
              $bulan = 'April';
            } elseif ($bulan == 5) {
              $bulan = 'Mei';
            } elseif ($bulan == 6) {
              $bulan = 'Juni';
            } elseif ($bulan == 7) {
              $bulan = 'Juli';
            } elseif ($bulan == 8) {
              $bulan = 'Agustus';
            } elseif ($bulan == 9) {
              $bulan = 'September';
            } elseif ($bulan == 10) {
              $bulan = 'Oktober';
            } elseif ($bulan == 11) {
              $bulan = 'November';
            } elseif ($bulan == 12) {
              $bulan = 'Desember';
            }
            echo $bulan . ' ' . $tahun;
          } elseif ($filter == '3') {
            echo $tahun;
          } elseif ($filter == '1') {
            echo longdate_indo($tanggal);
          } else {
            echo 'Semua Data';
          }
          ?>
        </td>
      </tr>
    </table>

    <table class="table table-striped table-bordered table-sm" border="1" cellspacing="0" width="100%">
      <thead align="center" class="bg-deta text-white">
        <tr>
          <th width="5%">NO</th>
          <th width="10%">Kode Akun</th>
          <th width="40%">Nama Akun</th>
          <th width="20%" colspan="2">Nominal</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($data->row() > null) : ?>
          <?php $no = 1;
          $ts_debet = "0";
          $ts_kredit = "0";
          foreach ($data->result_array() as $k) : ?>
            <?php if ($k['tipe'] == 'K') : ?>
              <?php $total_kredit = "0";
              $saldo_kredit = "0"; ?>
              <?php
              $token = $this->session->userdata('token');
              if ($filter == 'semua') {
                $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun as idakun from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$k[nama_akun]'");
              } elseif ($filter == '1') {
                $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE t.tgl_jurnal='$tanggal' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");
              } elseif ($filter == '2') {
                $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE YEAR(t.tgl_jurnal)='$tahun' AND MONTH(t.tgl_jurnal)='$_POST[bulan]' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");
              } elseif ($filter == '3') {
                $neraca = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$k[kode_akun]'");
              }
              ?>
              <?php foreach ($neraca->result_array() as $n) : ?>
                <?php
                if ($n['tipe'] == 'K') {
                  $kredit = $n['nominal'];
                  $debet = "0";
                }
                $total_kredit += $kredit;

                if ($n['kategori'] == 'HT') {
                  $saldo_kredit = $total_kredit;
                  $posisi = "Kredit";
                }
                ?>
              <?php endforeach; ?>
              <tr>
                <td align="center"><?= $no++ ?></td>
                <td align="center"><?= $k['kode_akun'] ?></td>
                <td><?= $k['nama_akun'] ?></td>
                <td width="3%" align="center">Rp. </td>
                <td align="right"><?= number_format($saldo_kredit, 0, ",", ".") ?></td>
              </tr>
              <?php $ts_kredit = abs($saldo_kredit - $ts_kredit); ?>
            <?php endif; ?>
          <?php endforeach; ?>
          <tr>
            <td colspan="3" align="Center"><b>Laba Kotor </b></td>
            <td align="center" width="3%">Rp.</td>
            <td align="right"><b><?= number_format($ts_kredit, 0, ",", ".") ?></b></td>
          </tr>
          <?php foreach ($data->result_array() as $d) : ?>
            <?php if ($d['tipe'] == 'D') : ?>
              <?php $total_debet = "0";
              $saldo_debet = "0"; ?>
              <?php
              $token = $this->session->userdata('token');
              if ($filter == 'semua') {
                $neraca1 = $this->db->query("SELECT *, tb_jurnal.id_akun as idakun from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
              } elseif ($filter == '1') {
                $neraca1 = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE t.tgl_jurnal='$tanggal' AND j.token='$token' AND a.kode_akun='$d[kode_akun]'");
              } elseif ($filter == '2') {
                $neraca1 = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE MONTH(t.tgl_jurnal)='$_POST[bulan]' AND YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$d[kode_akun]'");
              } elseif ($filter == '3') {
                $neraca1 = $this->db->query("SELECT j.tipe, j.id_akun, j.nominal, j.no_jurnal, j.token, a.id_akun, a.kode_akun, a.nama_akun, a.kategori, t.no_jurnal, t.tgl_jurnal FROM tb_jurnal j LEFT JOIN tb_akun a ON a.id_akun=j.id_akun LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal WHERE YEAR(t.tgl_jurnal)='$tahun' AND j.token='$token' AND a.kode_akun='$d[kode_akun]'");
              }
              ?>
              <?php foreach ($neraca1->result_array() as $nn) : ?>
                <?php
                if ($nn['tipe'] == 'D') {
                  $debet = $nn['nominal'];
                  $kredit = "0";
                }
                $total_debet += $debet;

                if ($nn['kategori'] == 'HL') {
                  $saldo_debet = $total_debet;
                  $posisi = "Debet";
                }
                ?>
              <?php endforeach; ?>
              <tr>
                <td align="center"><?= $no++ ?></td>
                <td align="center"><?= $d['kode_akun'] ?></td>
                <td><?= $d['nama_akun'] ?></td>
                <td width="3%" align="center">Rp. </td>
                <td align="right"><?= number_format($saldo_debet, 0, ",", ".") ?></td>
              </tr>
              <?php $ts_debet += $saldo_debet ?>
            <?php endif; ?>
            <?php $bersih = $ts_kredit - $ts_debet ?>
          <?php endforeach; ?>
          <tr>
            <td colspan="3" align="Center"><b>Beban Operasional </b></td>
            <td align="center" width="3%">Rp.</td>
            <td align="right"><b><?= number_format($ts_debet, 0, ",", ".") ?></b></td>
          </tr>
          <tr>
            <td colspan="3" align="Center">
              <?php if ($ts_kredit > $ts_debet) : ?>
                <b style="color: green">Laba Bersih</b>
              <?php elseif ($ts_kredit < $ts_debet) : ?>
                <b style="color: red">Rugi</b>
              <?php else : ?>
                <b>BALANCE</b>
              <?php endif; ?>
            </td>
            <td align="center" width="3%">Rp.</td>
            <td align="right"><b><?= number_format($bersih, 0, ",", ".") ?></b></td>
          </tr>
        <?php else : ?>
          <tr>
            <td colspan="5">
              <i>
                <center>
                  -----------
                  Tidak Ada Data Laba Rugi
                  -----------
                </center>
              </i>
            </td>
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