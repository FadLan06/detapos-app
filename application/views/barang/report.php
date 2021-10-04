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
                      <option value="semua" selected>Semua Data </option>
                      <option value="1">Bulan dan Tahun</option>
                      <option value="3">Tahun</option>
                      <option value="2">Range Periode</option>
                    </select>
                  </div>
                  <div class="col-auto" id="ff-barang">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <input type="text" class="form-control-sm" id="barang" name="barang" autocomplete="off" placeholder="Kode Barang/Nama Barang">
                  </div>
                  <div class="col-auto" id="ff-bulan">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <select class="form-control-sm" id="bulan" name="bulan" autocomplate="off" required>
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
                  <div class="col-auto" id="ff-bulan1">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <select class="form-control-sm" id="bulan" name="bulan1" autocomplate="off" required>
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
                  <div class="col-auto" id="ff-tahun">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <select class="form-control-sm" id="tahun" name="tahun" autocomplate="off">
                      <option selected>
                        <-- Pilih Tahun -->
                      </option>
                      <?php foreach ($tahun as $th) : ?>
                        <?php $data = explode('-', $th['tgl_penjualan']);
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
                <form action="<?= base_url('Report/Export') ?>" method="post">
                  <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                  <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                  <input type="hidden" name="bulan1" id="bulan" class="form-control" value="<?= $_POST['bulan1'] ?>">
                  <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                  <input type="hidden" name="barang" id="barang" class="form-control" value="<?= $_POST['barang'] ?>">
                  <button type="submit" class="btn btn-success mr-1 btn-sm"><i class="fas fa-download"></i> Export Data Excel</button>
                </form>
              <?php } ?>
              <?php if (isset($_POST['cari'])) { ?>
                <form action="<?= base_url('Report/Cetak') ?>" method="post" target="_blank">
                  <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                  <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                  <input type="hidden" name="bulan1" id="bulan" class="form-control" value="<?= $_POST['bulan1'] ?>">
                  <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                  <input type="hidden" name="barang" id="barang" class="form-control" value="<?= $_POST['barang'] ?>">
                  <a href="<?= base_url('Report') ?>" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
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
                    </b></td>
                </tr>
              </table>
            <?php } ?>
            <div class="table-responsive">
              <?php if (isset($_POST['cari'])) { ?>
                <table id="datatable" class="table table-striped table-bordered table-sm" style="text-align: center;" cellspacing="0" width="100%">
                  <?php if ($_POST['filter'] != 2) { ?>
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
                          <?php $ttl3 += $br['sub_total']; ?>
                          <?php $ttl4 += $br['jml_stok']; ?>
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
                  <?php } else { ?>
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
                  <?php } ?>
                </table>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script src="<?= base_url() ?>assets/js/popper.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $('#barang').autocomplete({
      source: "<?php echo site_url('Report/barang'); ?>",

      select: function(event, ui) {
        $('[name="barang"]').val(ui.item.label);
      }
    });

  });
</script>