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
                <div class="form-row align-items-center">
                  <div class="col-auto">
                    <label class="sr-only" for="inlineFormInput">Name</label>
                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control-sm" required>
                  </div>
                  <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <select class="form-control-sm" id="petugas" name="petugas" autocomplate="off" required>
                      <option disabled selected>
                        <-- Pilih Petugas -->
                      </option>
                      <option value="Semua">Semua Petugas</option>
                      <?php foreach ($petugas as $p) : ?>
                        <option value="<?= $p['username'] ?>"><?= $p['nama'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-auto">
                    <button class="mr-1 btn-sm btn btn-deta" type="submit" name="cari"><i class="fas fa-search"></i> Cari</button>
                  </div>
                </div>
              </form>
              <?php if (isset($_POST['cari'])) { ?>
                <form action="<?= base_url('Laporan/Export_Harian_Tgl') ?>" method="post">
                  <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                  <input type="hidden" name="petugas" id="petugas" class="form-control" value="<?= $_POST['petugas'] ?>">
                  <button type="submit" class="btn btn-success btn-sm mr-1"><i class="fas fa-download"></i> Export Data Excel</button>
                </form>
              <?php } else { ?>
                <a href="<?= base_url('Laporan/Export_Harian') ?>" class="btn btn-success btn-sm"><i class="fas fa-download"></i> Export Data Excel</a>
              <?php } ?>
              <?php if (isset($_POST['cari'])) { ?>
                <form action="<?= base_url('Penjualan/Cetak_Harian') ?>" method="post" target="_blank">
                  <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                  <input type="hidden" name="petugas" id="petugas" class="form-control" value="<?= $_POST['petugas'] ?>">
                  <a href="<?= base_url('Laporan/Harian') ?>" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
                  <button class="btn btn-danger btn-sm" type="submit" onclick="return valid();"><i class="fas fa-print"></i> Cetak</button>
                </form>
              <?php } ?>
            </div>
            <hr class="bg-deta">
            <?php if (isset($_POST['cari'])) { ?>
              <div class="table-responsive">
                <table width="100%" class="mb-2 mt-0">
                  <tr>
                    <td width="15%"><b>Tanggal</b></td>
                    <td width="2%"><b>:</b></td>
                    <td><b><?= $_POST['tgl_akhir'] ?></b></td>
                    <td align="right"><b>Petugas</b></td>
                    <td width="2%" align="center"><b>:</b></td>
                    <td width="13%" align="center"><b><?= $_POST['petugas'] ?></b></td>
                  </tr>
                </table>
              </div>
            <?php } else { ?>
              <div class="table-responsive">
                <table width="100%" class="mb-2 mt-0">
                  <tr>
                    <td width="15%"><b>Tanggal</b></td>
                    <td width="2%"><b>:</b></td>
                    <td><b><?= date('d F Y') ?></b></td>
                  </tr>
                </table>
              </div>
            <?php } ?>
            <div class="table-responsive">
              <table class="table table-bordered table-sm" cellspacing="0" width="100%">
                <thead align="center">
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
                  <?php if (!empty($data)) : ?>
                    <?php $total = 0;
                    $poto = 0;
                    $no = 1;
                    foreach ($data as $pen) { ?>
                      <?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $pen['token'], 'nama_pel' => $pen['kode_pelanggan']])->row(); ?>

                      <tr class="bg-light">
                        <td align="center"><?= $no++ ?></td>
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
                        <td>
                          <?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) : ?>
                            <?= $pen['metodePem'] ?>
                          <?php endif; ?>
                        </td>
                      </tr>
                      <?php $total += $pen['total'] ?>
                      <?php $poto = $poto + $pen['pot']  ?>
                      <?php $potto = $pen['pot']  ?>
                      <?php $per = $pen['diskon']  ?>
                      <tr align="center">
                        <th></th>
                        <th>NAMA BARANG</th>
                        <th>QTY</th>
                        <th>HARGA</th>
                        <th>POTONGAN</th>
                        <th>SUB TOTAL</th>
                      </tr>
                      <?php
                      $sub = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$pen[no_transaksi]' AND token='$pen[token]' GROUP BY harga, kode_barang, varian, ukuran ORDER BY kode_barang");
                      $count = $sub->num_rows() + 1;
                      ?>
                      <tr>
                        <td rowspan="<?= $count ?>"></td>
                        <?php $ttl_ju = 0;
                        foreach ($sub->result() as $data) : ?>
                          <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$data->kode_barang' AND token='$data->token'")->row(); ?>
                      <tr align="center">
                        <td><?= $pen->nama_barang ?><?= $data->ukuran != '0' ? ' - ' . $data->ukuran : '' ?><?= $data->varian != '0' ? '/' . $data->varian : '' ?></td>
                        <td><?= $data->kty ?></td>
                        <td>RP. <?= number_format($data->harga) ?></td>
                        <td>Rp. <?= number_format($data->potongan) ?></td>
                        <td>Rp. <?= number_format($data->sub_total) ?></td>
                      </tr>
                      <?php $ttl_ju += $data->sub_total; ?>
                    <?php endforeach; ?>
                    <?php if ($potto > 0) : ?>
                      <tr>
                        <td colspan="5" align="right"><b>SUB TOTAL</b></td>
                        <td align="center"><b>Rp. <?= number_format($ttl_ju) ?></b></td>
                      </tr>
                      <tr>
                        <td colspan="5" align="right"><b>DISKON</b></td>
                        <td align="center"><b>Rp. <?= number_format($potto) . ' (' . number_format($per) . '%)' ?></b></td>
                      </tr>
                    <?php endif; ?>
                    <tr>
                      <td colspan="5" align="right"><b>TOTAL PENJUALAN</b></td>
                      <td align="center"><b>Rp. <?= number_format($ttl_ju - $potto) ?></b></td>
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
                <?php if (!empty($data)) : ?>
                  <tfoot>
                    <tr>
                      <td colspan="5"><b>Total Pendapatan</b></td>
                      <td><b>Rp. <?= number_format($total - $poto) ?></b></td>
                    </tr>
                  </tfoot>
                <?php endif; ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>