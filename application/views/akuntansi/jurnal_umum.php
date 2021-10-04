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
                  </div>
                  <div class="col-auto">
                    <select name="filter" id="filter" class="form-control-sm" required>
                      <option value="semua" selected>Semua Data </option>
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
                    <select class="form-control-sm" id="tahun" name="tahun" autocomplate="off">
                      <option selected>
                        <-- Pilih Tahun -->
                      </option>
                      <?php foreach ($tahun as $th) : ?>
                        <?php $dataa = explode('-', $th['tgl_jurnal']);
                        $tah = $dataa[0]; ?>
                        <option value="<?= $tah ?>"><?= $tah ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-auto">
                    <button class="mr-1 btn btn-danger btn-sm" type="submit" name="cari"><i class="fas fa-search"></i> View</button>
                    <button class="btn btn-deta btn-sm mr-1" type="button" data-target="#tmbhjurnal" data-toggle="modal" <?= $akses->tambah != 1 ? 'disabled' : '' ?>><i class="fas fa-plus-circle"></i> Tambah</button>
                  </div>
                </div>
              </form>
              <?php if (isset($_POST['cari'])) { ?>
                <form action="<?= base_url('Jurnal_umum/Cetak_Jurnal') ?>" method="post" target="_blank">
                  <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                  <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                  <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                  <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                  <a href="<?= base_url('Jurnal_umum') ?>" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
                  <button class="btn btn-primary btn-sm" type="submit" onclick="return valid();" <?= $akses->tambah != 1 ? 'disabled' : '' ?>><i class="fas fa-print"></i> Cetak</button>
                </form>
              <?php } ?>
            </div>
            <hr class="bg-deta">
            <?= $this->session->flashdata('message') ?>
            <?= $this->session->flashdata('message1') ?>
            <?php if (isset($_POST['cari'])) : ?>
              <div class="table-responsive">
                <table width="100%" class="mb-2 mt-0">
                  <tr>
                    <td width="7%"><b>Data</b></td>
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
                          echo longdate_indo($_POST['tanggal']);
                        } else {
                          echo 'Semua Data';
                        }
                        ?>
                      </b></td>
                  </tr>
                </table>
                <table class="table table-hover table-bordered table-sm" width="100%">
                  <thead align="center" class="bg-deta text-white">
                    <tr>
                      <th width="5%">NO</th>
                      <th width="15%">Tanggal Transaksi</th>
                      <th width="25%">Keterangan</th>
                      <th width="20%">Akun</th>
                      <th>Debet</th>
                      <th>Kredit</th>
                      <th>Aksi</th>
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
                        <?php $no_trans = $this->db->get_where('tb_penjualan', ['token' => $data['token'], 'no_transaksi' => $data['no_transaksi']])->row(); ?>
                        <?php $no_inv = $this->db->get_where('tb_pembelian', ['token' => $data['token'], 'no_faktur' => $data['invoice']])->row(); ?>
                        <?php $order_id = $this->db->get_where('tb_shop_detail', ['token' => $data['token'], 'id_shop_detail' => $data['order_id']])->row(); ?>
                        <?php $no_seri = $this->db->get_where('tb_pengeluaran', ['token' => $data['token'], 'no_seri' => $data['no_seri']])->row(); ?>
                        <?php
                        if ($data['no_transaksi'] != null) {
                          $trans = $no_trans->no_transaksi == $data['no_transaksi'] ? 'disabled' : '';
                          $inv = "";
                          $order = "";
                          $seri = "";
                        } elseif ($data['order_id'] != '0') {
                          $trans = "";
                          $inv = "";
                          $order = $order_id->id_shop_detail == $data['order_id']  ? 'disabled' : '';
                          $seri = "";
                        } elseif ($data['invoice'] != null) {
                          $trans = "";
                          $inv = $no_inv->no_faktur == $data['invoice'] ? 'disabled' : '';
                          $order = "";
                          $seri = "";
                        } elseif ($data['no_seri'] != null) {
                          $trans = "";
                          $inv = $no_seri->no_seri == $data['no_seri'] ? 'disabled' : '';
                          $order = "";
                          $seri = "";
                        } else {
                          $trans = '';
                          $inv = "";
                          $order = '';
                          $seri = "";
                        }
                        ?>
                        <tr style="border-bottom: 2px solid #008FD4; border-top: 2px solid #008FD4">
                          <td align="center"><?= $no++ ?></td>
                          <td colspan="5"><?= longdate_indo($data['tgl_jurnal']) ?></td>
                          <td align="center">
                            <a href="" class="btn btn-deta btn-sm <?= $akses->ubah != 1 ? 'disabled' : '' ?> <?= $trans ?> <?= $inv ?> <?= $order ?>" data-target="#ubahJurnal" data-toggle="modal" data-id="<?= $data['no_jurnal'] ?>"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-danger btn-sm <?= $akses->hapus != 1 ? 'disabled' : '' ?> <?= $trans ?> <?= $inv ?> <?= $order ?>" href="<?= base_url('Jurnal_umum/hps_trans/') . $data['no_jurnal'] ?>" onclick="return confirm('Yakin anda ?');"><i class="fas fa-trash text-white"></i></a>
                          </td>
                        </tr>
                        <?php $token = $this->session->userdata('token'); ?>
                        <?php
                        if ($_POST['filter'] == 'semua') {
                          $count = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.no_jurnal = '$data[no_jurnal]' ORDER BY tb_jurnal.tipe ASC");
                        } elseif ($_POST['filter'] == '1') {
                          $count = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$_POST[tanggal]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.no_jurnal = '$data[no_jurnal]' ORDER BY tb_jurnal.tipe ASC");
                        } elseif ($_POST['filter'] == '2') {
                          $count = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.no_jurnal = '$data[no_jurnal]' ORDER BY tb_jurnal.tipe ASC");
                        } elseif ($_POST['filter'] == '3') {
                          $count = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND tb_jurnal.token='$token' and tb_jurnal.no_jurnal = '$data[no_jurnal]' ORDER BY tb_jurnal.tipe ASC");
                        }
                        ?>
                        <?php
                        $baris = $count->num_rows();
                        ?>
                        <tr>
                          <td rowspan="<?= $baris ?>"></td>
                          <td rowspan="<?= $baris ?>"></td>
                          <td rowspan="<?= $baris ?>"><?= $data['keterangan'] ?></td>
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
                            <td><?= $akun ?></td>
                            <td>
                              <p align="right">Rp. <?= number_format($kolom_debet, 0, ",", ".") ?></p>
                            </td>
                            <td>
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
                      <td colspan='4' align='center'><b>TOTAL</b></td>
                      <td align='center'><b>Rp. <?= number_format($all_debet, 0, ",", ".") ?></b></td>
                      <td align='center'><b>Rp. <?= number_format($all_kredit, 0, ",", ".") ?></b></td>
                    </tr>
                  <?php else : ?>
                    <tr>
                      <td colspan="7">
                        <i>
                          <center>
                            -----------
                            Tidak Ada Data Jurnal Umum
                            -----------
                          </center>
                        </i>
                      </td>
                    </tr>
                  <?php endif; ?>
                  </tbody>
                </table>
              </div>
            <?php else : ?>
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm" width="100%">
                  <thead align="center" class="bg-deta text-white">
                    <tr>
                      <th width="5%">NO</th>
                      <th width="15%">Tanggal Transaksi</th>
                      <th width="25%">Keterangan</th>
                      <th width="20%">Akun</th>
                      <th>Debet</th>
                      <th>Kredit</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="7">
                        <i>
                          <center>
                            -----------
                            Tidak Ada Data Jurnal Umum
                            -----------
                          </center>
                        </i>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Menu-->
<div class="modal fade" id="tmbhjurnal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Jurnal Umum</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?= base_url('Jurnal_umum/Act_Jurnal') ?>">
          <div class="form-group">
            <label for="tgl_jurnal">Tanggal Transaksi</label>
            <input type="date" name="tgl_jurnal" class="form-control border-deta" id="tgl_jurnal" autocomplete="off" value="<?php echo date("Y-m-d"); ?>">
            <?= form_error('tgl_jurnal', '<small class="text-danger pl-3">', '</small>') ?>
          </div>
          <div class="row">
            <div class="form-group col-md-3">
              <label for="id_akun">Nama Akun</label>
              <select name="id_akunD[]" id="id_akunD" class="form-control border-deta" required>
                <option value="">Pilih Akun</option>
                <?php foreach ($akunn as $ak) : ?>
                  <option value="<?= $ak->id_akun ?>"><?= $ak->nama_akun ?></option>
                <?php endforeach; ?>
              </select>
              <?= form_error('id_akun', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <!-- <div class="form-group col-md-3">
              <label for="id_akun">Kredit</label>
              <select name="id_akunK[]" id="id_akunK" class="form-control border-deta" required>
                <option>Pilih Akun</option>
                <?php foreach ($akunn as $ak) : ?>
                  <option value="<?= $ak->id_akun ?>"><?= $ak->nama_akun ?></option>
                <?php endforeach; ?>
              </select>
              <?= form_error('id_akun', '<small class="text-danger pl-3">', '</small>') ?>
            </div> -->
            <div class="form-group col-md-3">
              <label for="tipe">Posisi</label>
              <select name="tipe[]" id="tipe" class="form-control border-deta" required>
                <option value="">Pilih Posisi</option>
                <option value="D">Debet</option>
                <option value="K">Kredit</option>
              </select>
              <?= form_error('tipe', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group col-md-4">
              <label for="nominal">Nominal (Rp)</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text border-deta bg-deta text-white"><b>Rp</b></span>
                </div>
                <input type="text" name="nominal[]" class="form-control border-deta" id="nominal" autocomplete="off" placeholder="Nominal" required>
                <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
            </div>
            <!-- <div class="form-group col-md-2">
              <label for="nominal">Aksi</label><br>
              <button class="btn btn-success" type="button" onclick="tambahbaris();"><i class="fa fa-plus"></i></button>
            </div> -->
          </div>
          <div class="row">
            <div class="form-group col-md-3">
              <select name="id_akunD[]" id="id_akunD" class="form-control border-deta" required>
                <option value="">Pilih Akun</option>
                <?php foreach ($akunn as $ak) : ?>
                  <option value="<?= $ak->id_akun ?>"><?= $ak->nama_akun ?></option>
                <?php endforeach; ?>
              </select>
              <?= form_error('id_akun', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <!-- <div class="form-group col-md-3">
              <label for="id_akun">Kredit</label>
              <select name="id_akunK[]" id="id_akunK" class="form-control border-deta" required>
                <option>Pilih Akun</option>
                <?php foreach ($akunn as $ak) : ?>
                  <option value="<?= $ak->id_akun ?>"><?= $ak->nama_akun ?></option>
                <?php endforeach; ?>
              </select>
              <?= form_error('id_akun', '<small class="text-danger pl-3">', '</small>') ?>
            </div> -->
            <div class="form-group col-md-3">
              <select name="tipe[]" id="tipe" class="form-control border-deta" required>
                <option value="">Pilih Posisi</option>
                <option value="D">Debet</option>
                <option value="K">Kredit</option>
              </select>
              <?= form_error('tipe', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group col-md-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text border-deta bg-deta text-white"><b>Rp</b></span>
                </div>
                <input type="text" name="nominal[]" class="form-control border-deta" id="noominal" autocomplete="off" placeholder="Nominal" required>
                <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
            </div>
            <!-- <div class="form-group col-md-2">
              <label for="nominal">Aksi</label><br>
              <button class="btn btn-success" type="button" onclick="tambahbaris();"><i class="fa fa-plus"></i></button>
            </div> -->
          </div>
          <div id="tambahbaris"></div>
          <div class="form-group">
            <button class="btn btn-deta" type="button" onclick="tambahbaris();"><i class="fa fa-plus"></i> Tambah Baris</button>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control border-deta" id="keterangan" name="keterangan" rows="1" required></textarea>
            <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>') ?>
          </div>

          <hr class="bg-deta">
          <button type="submit" name="tmbh_jurnall" class="btn btn-deta float-right">Tambah</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ubahJurnal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Ubah Jurnal Umum</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="_jurnal"></div>
      </div>
    </div>
  </div>
</div>