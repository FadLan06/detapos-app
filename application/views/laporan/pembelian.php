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
                      <option value="1">Tanggal</option>
                      <option value="2">Bulan dan Tahun</option>
                      <option value="3">Tahun</option>
                      <option value="4">Range Periode</option>
                    </select>
                  </div>
                  <div class="col-auto" id="f-tanggal">
                    <label class="sr-only" for="inlineFormInput">Name</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control-sm">
                  </div>
                  <div class="col-auto" id="f-bulan">
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
                  <div class="col-auto" id="f-tahun">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <select class="form-control-sm" id="tahun" name="tahun" autocomplate="off">
                      <option selected>
                        <-- Pilih Tahun -->
                      </option>
                      <?php foreach ($tahun as $th) : ?>
                        <?php $data = explode('-', $th['timee']);
                        $tah = $data[0]; ?>
                        <option value="<?= $tah ?>"><?= $tah ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-row" id="f-range">
                    <div class="col-auto">
                      <label class="sr-only" for="inlineFormInput">Name</label>
                      <input type="date" name="tgl_awal" id="tgl_awal" class="form-control-sm">
                    </div>
                    <div class="col-auto">
                      <label class="sr-only" for="inlineFormInput">Name</label>
                      <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control-sm">
                    </div>
                  </div>
                  <div class="col-auto">
                    <button class="mr-1 btn btn-deta btn-sm" type="submit" name="cari"><i class="fas fa-search"></i> Cari</button>
                  </div>
                </div>
              </form>
              <?php if (isset($_POST['cari'])) { ?>
                <form action="<?= base_url('Pembelian/Export') ?>" method="post">
                  <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                  <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                  <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                  <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                  <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                  <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                  <button type="submit" class="btn btn-success mr-1 btn-sm"><i class="fas fa-download"></i> Export Data Excel</button>
                </form>
              <?php } ?>
              <?php if (isset($_POST['cari'])) { ?>
                <form action="<?= base_url('Pembelian/Cetak') ?>" method="post" target="_blank">
                  <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                  <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                  <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                  <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                  <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                  <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                  <a href="<?= base_url('Laporan/Pembelian') ?>" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
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
                        echo 'Bulan ' . $bulan . ' Tahun ' . $_POST['tahun'];
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
                    </b></td>
                </tr>
              </table>

              <div class="table-responsive">
                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead align="center">
                    <tr>
                      <th width="5%">#</th>
                      <th>SUPPLIER</th>
                      <th>KODE BARANG</th>
                      <th>NAMA BARANG</th>
                      <th width="5%">ITEM</th>
                      <th>HARGA</th>
                      <th>SUB TOTAL</th>
                    </tr>
                  </thead>
                  <?php if ($pembelian->num_rows() > 0) : ?>
                    <tbody>
                      <?php $no = 1;
                      $ttl2 = 0;
                      foreach ($pembelian->result_array() as $pem) : ?>
                        <?php $sup = $this->db->get_where('tb_supplier', ['kode_sup' => $pem['kd_supplier'], 'token' => $pem['token']])->row_array(); ?>
                        <tr style="border-top: 2px solid #00aaff">
                          <td class="bg-light"><?= $no++ ?></td>
                          <td colspan="8" align="left" class="bg-light">
                            <?php if ($pem['kd_supplier'] == '') : ?>
                              <?= '' ?>
                              <?php $kd = ''; ?>
                            <?php else : ?>
                              <b><?= $sup['kode_sup'] ?> - <?= $sup['nama_toko'] ?></b>
                              <?php $kd = $sup['kode_sup']; ?>
                            <?php endif; ?>
                          </td>
                        </tr>

                        <?php
                        $sub = $this->db->query("SELECT *, sum(harga_beli*jumlah-potongan) as sub_total, sum(jumlah) as kty FROM tb_detail_pembelian WHERE no_faktur='$pem[id_pembelian]' AND token='$pem[token]' GROUP BY kode_barang");
                        $count = $sub->num_rows() + 1;
                        ?>
                        <tr>
                          <td rowspan="<?= $count ?>"></td>
                          <td rowspan="<?= $count ?>"></td>
                          <?php $ttl1 = 0;
                          foreach ($sub->result_array() as $data) : ?>
                            <?php $sub_total = $data['harga_beli'] * $data['jumlah']; ?>
                        <tr align="left">
                          <td><?= $data['kode_barang'] ?></td>
                          <td><?= $data['nama_barang'] ?></td>
                          <td align="center"><?= $data['jumlah'] ?></td>
                          <td>Rp. <?= number_format($data['harga_beli']) ?></td>
                          <td>Rp. <?= number_format($sub_total) ?></td>
                        </tr>
                        <?php $ttl1 += $sub_total ?>
                      <?php endforeach; ?>
                      </tr>
                      <tr>
                        <td colspan="6" align="right"><b>TOTAL PEMBELIAN</b></td>
                        <td><b>Rp. <?= number_format($ttl1) ?></b></td>
                      </tr>
                      <?php $ttl2 += $ttl1 ?>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr style="border-top: 2px solid #00aaff">
                        <td colspan="6"><b>TOTAL</b></td>
                        <td><b>Rp. <?= number_format($ttl2) ?></b></td>
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
                </table>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>