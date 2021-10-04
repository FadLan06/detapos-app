<div class="page-content-wrapper ">

  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li>
            </ol>
          </div>
          <h4 class="page-title"><?= $judul ?></h4>
        </div>
      </div>
    </div>
    <!-- end page title end breadcrumb -->

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="input-group">
              <form action="" method="post">
                <div class="form-row">
                  <div class="col-auto">
                    <label class="mr-2">Cari Berdasarkan</label>
                    <select name="filter" id="filter" class="form-control-sm" required>
                      <option disabled selected>
                        <-- Pilih -->
                      </option>
                      <option value="semua">Semua Data </option>
                      <option value="1">Tanggal</option>
                      <option value="2">Bulan dan Tahun</option>
                      <option value="3">Tahun</option>
                    </select>
                  </div>
                  <div class="col-auto" id="f-tanggal">
                    <label class="sr-only" for="inlineFormInput">Name</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control-sm">
                  </div>
                  <div class="col-auto" id="f-bulan">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <select class="form-control-sm" id="bulan" name="bulan" autocomplate="off">
                      <option selected>
                        <-- Pilih Bulan -->
                      </option>
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>
                  </div>
                  <div class="col-auto" id="f-tahun">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <select class="form-control-sm" id="tahun" name="tahun" autocomplate="off">
                      <option selected>
                        <-- Pilih Tahun -->
                      </option>
                      <?php foreach ($tahun as $th) : ?>
                        <?php $data = explode('-', $th['tgl_beli']);
                        $tah = $data[0]; ?>
                        <option value="<?= $tah ?>"><?= $tah ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-auto">
                    <button class="mr-1 btn btn-deta btn-sm" type="submit" name="cari"><i class="fas fa-search"></i> Cari</button>
                  </div>
                </div>
              </form>
              <?php if (isset($_POST['cari'])) { ?>
                <form action="<?= base_url('Laporan/Export_Rt_Cus') ?>" method="post">
                  <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                  <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                  <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                  <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                  <button type="submit" class="btn btn-success mr-1 btn-sm"><i class="fas fa-download"></i> Export Data Excel</button>
                </form>
              <?php } ?>
              <?php if (isset($_POST['cari'])) { ?>
                <form action="<?= base_url('Pelanggan/Cetak_Customer') ?>" method="post" target="_blank">
                  <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                  <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                  <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                  <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                  <a href="<?= base_url('Laporan/Retur_Customer') ?>" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
                  <button class="btn btn-danger btn-sm" type="submit" onclick="return valid();"><i class="fas fa-print"></i> Cetak</button>
                </form>
              <?php } ?>
            </div>
            <hr class="bg-deta">
            <?php if (isset($_POST['cari'])) { ?>
              <table width="100%" class="mb-2 mt-0">
                <tr>
                  <td width="13%"><b>Periode</b></td>
                  <td width="2%"><b>:</b></td>
                  <td><b>
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
                        echo $_POST['tanggal'];
                      } else {
                        echo 'Semua Periode';
                      }
                      ?>
                    </b></td>
                </tr>
              </table>
            <?php } ?>
            <div class="table-responsive">
              <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead align="center">
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
                <?php if (isset($_POST['cari'])) { ?>
                  <?php if (!empty($data)) : ?>
                    <tbody>
                      <?php $no = 1; ?>
                      <?php foreach ($cus->result_array() as $sup) : ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= date('d F Y', strtotime($sup['tgl_beli'])) ?></td>
                          <td><?= $sup['no_transaksi'] ?></td>
                          <td><?= $sup['kode_barang'] ?></td>
                          <td><?= $sup['harga'] ?></td>
                          <td>
                            <?php
                            if ($sup['kode_pelanggan'] == NULL) {
                              echo 'Umum';
                            } else {
                              echo $sup['nama_pel'];
                            }
                            ?>
                          </td>
                          <td><?= $sup['jml_retur'] ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  <?php else : ?>
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
                <?php } else { ?>
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
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>