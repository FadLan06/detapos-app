<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">

    <title>Cetak Laporan Retur Customer - DETAPOS</title>
  </head>
  <body>
    <?php
    // date_default_timezone_set("Asia/Makassar");
    $tglawal  = $_POST['bulan'];
    $tglakhir  = $_POST['tahun'];
    ?>

    <div class="mt-4 ml-4 mr-4 mb-4">
     <h4><b><?=$toko['nama_toko'];?></b></h4>

     <div>
      <div class=""><?=$toko['alamat'];?><br>
        Telp. <?=$toko['no_telpon'];?><br><br>
        Periode : 
        <?php
          if($_POST['filter'] == '2'){

            if($_POST['bulan'] == 1){
              $bulan = 'Januari';
            }elseif($_POST['bulan'] == 2){
              $bulan = 'Februari';
            }elseif($_POST['bulan'] == 3){
              $bulan = 'Maret';
            }elseif($_POST['bulan'] == 4){
              $bulan = 'April';
            }elseif($_POST['bulan'] == 5){
              $bulan = 'Mei';
            }elseif($_POST['bulan'] == 6){
              $bulan = 'Juni';
            }elseif($_POST['bulan'] == 7){
              $bulan = 'Juli';
            }elseif($_POST['bulan'] == 8){
              $bulan = 'Agustus';
            }elseif($_POST['bulan'] == 9){
              $bulan = 'September';
            }elseif($_POST['bulan'] == 10){
              $bulan = 'Oktober';
            }elseif($_POST['bulan'] == 11){
              $bulan = 'November';
            }elseif($_POST['bulan'] == 12){
              $bulan = 'Desember';
            }
            echo $bulan.' '.$_POST['tahun'];
          }elseif($_POST['filter'] == '3'){
            echo $_POST['tahun'];
          }elseif($_POST['filter'] == '1'){
            echo $_POST['tanggal'];
          }else{
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
        LAPORAN RETUR CUSTOMER
      </h4>
    </center>

    <br>

    <table class="table table-striped table-bordered" id="example" style="text-align:center; width:100%">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th>TANGGAL RETUR</th>
          <th>NO TRANSAKSI</th>
          <th>KODE BARANG</th>
          <th>HARGA</th>
          <th>NAMA PELANGGAN</th>
          <th>JUMLAH RETUR</th>
        </tr>
      </thead>
      <?php if(! empty($cus)): ?>
        <tbody>
          <?php $no = 1; ?>
          <?php foreach($cus->result_array() as $sup): ?>
            <tr>
              <td><?=$no++?></td>
              <td><?=date('d F Y', strtotime($sup['tgl_beli']))?></td>
              <td><?=$sup['no_transaksi']?></td>
              <td><?=$sup['kode_barang']?></td>
              <td><?=$sup['harga']?></td>
              <td>
                <?php
                  if($sup['kode_pelanggan'] == NULL){
                    echo 'Umum';
                  }else{
                    echo $sup['nama_pel'];
                  }
                ?>
              </td>
              <td><?=$sup['jml_retur']?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      <?php else: ?>
        <tbody>
          <tr>
            <td colspan='7'>
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