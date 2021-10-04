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
                    <select name="filter" id="filter" class="form-control-sm">
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
                        <?php $data = explode('-', $th['tgl_penjualan']);
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
                <form action="<?= base_url('Laporan/Export_Uang') ?>" method="post">
                  <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                  <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                  <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                  <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                  <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                  <button type="submit" class="btn btn-success mr-1 btn-sm"><i class="fas fa-download"></i> Export Data Excel</button>
                </form>
              <?php } ?>
              <?php if (isset($_POST['cari'])) { ?>
                <form action="<?= base_url('Penjualan/Cetak_Keuntungan') ?>" method="post" target="_blank">
                  <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                  <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                  <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                  <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                  <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                  <a href="<?= base_url('Laporan/Keuntungan') ?>" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
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
            <?php } ?>
            <div class="table-responsive">
              <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead align="center">
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
                <?php if (isset($_POST['cari'])) { ?>
                  <?php if (!empty($data)) : ?>
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
                <?php } else { ?>
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
                <?php } ?>
              </table>
            </div>
            <?php if (isset($_POST['cari'])) { ?>
              <span style="color: #008FD4"><b>Rumus Keuntungan : </b></span> = (jual X terjual) - (modal X terjual) - potongan
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>