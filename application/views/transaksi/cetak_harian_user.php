<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!-- Required meta tags -->

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">

  <title>Cetak Harian - DETAPOS</title>
</head>

<body>
  <?php
  // date_default_timezone_set("Asia/Makassar");
  $tglakhir  = $_POST['tgl_akhir'];
  ?>

  <div class="mt-4 ml-4 mr-4 mb-4">
    <h4><b><?= $toko['nama_toko']; ?></b></h4>

    <div>
      <div class=""><?= $toko['alamat']; ?><br>
        Telp. <?= $toko['no_telpon']; ?><br><br>
        Periode : <?= date('d F Y', strtotime($tglakhir)); ?><br>
        Petugas : <?= $this->session->userdata('username') ?>
      </div>
      <div class="">
        <span class="">
          <br>
        </span>
      </div>
    </div>

    <center>
      <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
        LAPORAN PENJUALAN
      </h4>
    </center>

    <br>
    <table class="table table-sm table-hover" style="border-bottom: 1px solid #d3d3d3 ">
      <thead>
        <tr>
          <th>NO</th>
          <th>NO. TRANSAKSI</th>
          <th>PELANGGAN</th>
          <th>TANGGAL PENJUALAN</th>
          <th>PETUGAS</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($penjua)) : ?>
          <?php $total = 0;
          $no = 1;
          foreach ($penjua as $pen) { ?>
            <?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $pen['token'], 'kode_pel' => $pen['kode_pelanggan']])->row(); ?>
            <tr class="bg-light">
              <td><?= $no++ ?></td>
              <td><?= $pen['no_transaksi'] ?></td>
              <td>
                <?php
                if ($pen['kode_pelanggan'] == NULL) {
                  echo 'Umum';
                } else {
                  echo $pel->nama_pel;
                }
                ?>
              </td>
              <td><?= date('d F Y', strtotime($pen['tgl_transaksi'])); ?></td>
              <td><?= $pen['petugas'] ?></td>
              <td></td>
            </tr>
            <?php $total += $pen['total'] ?>
            <tr align="center">
              <th></th>
              <th>NAMA BARANG</th>
              <th>QTY</th>
              <th>HARGA</th>
              <th>POTONGAN</th>
              <th>SUB TOTAL</th>
            </tr>
            <?php
            $sub = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$pen[no_transaksi]' AND token='$pen[token]' GROUP BY harga, kode_barang ORDER BY kode_barang");
            $count = $sub->num_rows() + 1;
            ?>
            <tr>
              <td rowspan="<?= $count ?>"></td>
              <?php $ttl_ju = 0;
              foreach ($sub->result() as $data) : ?>
                <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$data->kode_barang' AND token='$data->token'")->row(); ?>
            <tr align="center">
              <td><?= $pen->nama_barang ?></td>
              <td><?= $data->kty ?></td>
              <td>RP. <?= number_format($data->harga) ?></td>
              <td>Rp. <?= number_format($data->potongan) ?></td>
              <td>Rp. <?= number_format($data->sub_total) ?></td>
            </tr>
            <?php $ttl_ju += $data->sub_total; ?>
          <?php endforeach; ?>
          <tr>
            <td colspan="5" align="right"><b>TOTAL PENJUALAN</b></td>
            <td align="center"><b>Rp. <?= number_format($ttl_ju) ?></b></td>
          </tr>
          </tr>
        <?php } ?>
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
      <?php if (!empty($penjua)) : ?>
        <tfoot>
          <tr>
            <td colspan="5"><b>Total</b></td>
            <td><b>Rp. <?= number_format($total) ?></b></td>
          </tr>
        </tfoot>
      <?php endif; ?>
    </table>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script type="text/javascript">
    // window.print();
    // window.history.back();
  </script>
  <script src="<?= base_url('assets/') ?>bootstrap/js/bootstrap.min.js"></script>
</body>

</html>