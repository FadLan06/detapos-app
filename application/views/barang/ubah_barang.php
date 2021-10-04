<div class="page-content-wrapper ">

  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="#">Data Barang</a></li>
              <li class="breadcrumb-item active"><?= $judul ?></li>
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
          <?php $dt = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $data->kode_barang, 'token' => $data->token]);
          $cb = $dt->num_rows();
          if ($cb > 0) {
            $aktif = 'readonly';
            $in = 'disabled';
          } else {
            $aktif = 'kosong';
            $in = 'kosong';
          }
          ?>
          <?php $gam = $this->db->get_where('tb_barang_tmp', ['kode_barang' => $data->kode_barang, 'token' => $data->token])->result(); ?>
          <div class="card-body">
            <?= $this->session->flashdata('message') ?>
            <?php if (isset($retail['menu_id'])) : ?>
              <form method="post" action="<?= base_url('Barang/Aksi') ?>">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputEmail4">KODE BARANG</label>
                    <input type="hidden" class="form-control" id="inputEmail4" name="id" autocomplete="off" readonly value="<?= $data->id ?>">
                    <input type="hidden" class="form-control" id="inputEmail4" name="id" autocomplete="off" readonly value="<?= $data->id ?>">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="text" class="form-control border-deta" id="kodeee" name="kode_barang" autocomplete="off" <?= $aktif ?> value="<?= $data->kode_barang ?>">
                      </div>
                      <div class="input-group-append">
                        <button class="btn btn-outline-deta" onclick="myFunctionn()" type="button" <?= $in ?>>Generate</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">NAMA BARANG</label>
                    <input type="text" class="form-control border-deta" id="inputPassword4" name="nama_barang" autocomplete="off" value="<?= $data->nama_barang ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputPassword4">JATUH TEMPO</label>
                    <input type="date" class="form-control border-deta" id="inputPassword4" name="tgl_tempo" autocomplete="off" value="<?= $data->tgl_tempo ?>">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="modal">HARGA MODAL</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="modal1" name="harga_beli" autocomplete="off" value="<?= $data->harga_beli ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan" autocomplete="off" value="<?= $data->satuan ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">ISI/PCS</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="isi" autocomplete="off" value="<?= $data->isi ?>">
                  </div>
                </div>
                <!-- HARGA JUAL -->
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="jual">HARGA ECER</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="jual1" name="harga_jual" autocomplete="off" value="<?= $data->harga_jual ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="persen">PERSENTASE</label>
                    <div class="input-group">

                      <input type="text" class="form-control border-deta" id="persen1" name="persen" autocomplete="off" value="<?= $data->persen ?>">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend">%</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="profit">PROFIT/KEUNTUNGAN</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="profit1" name="profit" autocomplete="off" value="<?= $data->profit ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan1" autocomplete="off" value="<?= $data->satuan1 ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">ISI/PCS</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="isi1" autocomplete="off" value="<?= $data->isi1 ?>">
                  </div>
                </div>
                <!-- HARGA JUAL1 -->
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="jual">HARGA GROSIR</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="jual4" name="harga_jual1" autocomplete="off" value="<?= $data->harga_jual1 ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="persen">PERSENTASE</label>
                    <div class="input-group">

                      <input type="text" class="form-control border-deta" id="persen4" name="persen1" autocomplete="off" value="<?= $data->persen1 ?>">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend">%</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="profit">PROFIT/KEUNTUNGAN</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="profit4" name="profit1" autocomplete="off" value="<?= $data->profit1 ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan2" autocomplete="off" value="<?= $data->satuan2 ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">ISI/PCS</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="isi2" autocomplete="off" value="<?= $data->isi2 ?>">
                  </div>
                </div>
                <!-- HARGA JUAL2 -->
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="jual">HARGA AGEN/DISTRIBUTOR</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="jual5" name="harga_jual2" autocomplete="off" value="<?= $data->harga_jual2 ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="persen">PERSENTASE</label>
                    <div class="input-group">

                      <input type="text" class="form-control border-deta" id="persen5" name="persen2" autocomplete="off" value="<?= $data->persen2 ?>">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend">%</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="profit">PROFIT/KEUNTUNGAN</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="profit5" name="profit2" autocomplete="off" value="<?= $data->profit2 ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan3" autocomplete="off" value="<?= $data->satuan3 ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">ISI/PCS</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="isi3" autocomplete="off" value="<?= $data->isi3 ?>">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="kategori">KATEGORI</label>
                    <select id="kategori" class="form-control border-deta" name="kode_kategori">
                      <option selected>Pilih...</option>
                      <?php foreach ($kategori as $ket) : ?>
                        <option value="<?= $ket->kode_kategori ?>" <?= $data->id_kategori == $ket->kode_kategori ? 'selected="selected"' : '' ?>><?= $ket->kode_kategori ?> / <?= $ket->nama_kategori ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputCity">JUMLAH STOK</label>
                    <input type="text" class="form-control border-deta" id="inputCity" name="jml_stok" autocomplete="off" value="<?= $data->jml_stok ?>">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputCity">MINIMAL STOK</label>
                    <input type="text" class="form-control border-deta" id="inputCity" name="minimal_stok" autocomplete="off" value="<?= $data->minimal_stok ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputZip">DESKRIPSI</label>
                  <textarea class="form-control border-deta" name="deskripsi" id="inputZip"><?= $data->deskripsi ?></textarea>
                </div>
                <hr class="bg-deta">
                <button type="submit" class="btn btn-deta float-right" name="ubh_brng_rt">Simpan Perubahan</button>
                <a class="btn btn-warning float-right mr-3" href="<?= base_url('Barang') ?>">Kembali</a>
              </form>
            <?php elseif (isset($check['menu_id'])) : ?>
              <?= form_open_multipart('Barang/Aksi'); ?>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="inputEmail4">KODE BARANG</label>
                    <input type="hidden" class="form-control" id="inputEmail4" name="id" autocomplete="off" readonly value="<?= $data->id ?>">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="text" class="form-control border-deta" id="kodeee" name="kode_barang" autocomplete="off" <?= $aktif ?> value="<?= $data->kode_barang ?>">
                      </div>
                      <div class="input-group-append">
                        <button class="btn btn-outline-deta" onclick="myFunctionn()" type="button" <?= $in ?>>Generate</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword4">NAMA BARANG</label>
                    <input type="text" class="form-control border-deta" id="inputPassword4" name="nama_barang" autocomplete="off" value="<?= $data->nama_barang ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputPassword4">LINK</label>
                    <input type="text" class="form-control border-deta" id="link" name="link" autocomplete="off" value="<?= $data->slug ?>">
                    <small><?= site_url('link/' . $data->token . '/') ?><span id="link_cek"></span></small>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword4">BERAT BARANG</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Gr</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="inputPassword4" name="berat" autocomplete="off" value="<?= $data->berat ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword4">JATUH TEMPO</label>
                    <input type="date" class="form-control border-deta" id="inputPassword4" name="tgl_tempo" autocomplete="off" value="<?= $data->tgl_tempo ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputPassword4">GAMBAR PRODUK</label>
                    <div class="row">
                      <?php foreach ($gam as $key) : ?>
                        <img src="<?= base_url('assets/upload/barang/') . $key->gambar ?>" class="form-control col-md-4 border-white" type="button" data-toggle="modal" data-id="<?= $data->kode_barang ?>" data-gam="<?= $key->gambar ?>" data-target="#staticBackdrop" style="height: 100px;" alt="">
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="modal">HARGA MODAL</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="modal1" name="harga_beli" autocomplete="off" value="<?= $data->harga_beli ?>">
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputZip">SATUAN</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="satuan" autocomplete="off" value="<?= $data->satuan ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">ISI/PCS</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="isi" autocomplete="off" value="<?= $data->isi ?>">
                    </div>
                  </div>
                  <!-- HARGA JUAL -->
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="jual">HARGA ECER</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="jual1" name="harga_jual" autocomplete="off" value="<?= $data->harga_jual ?>">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="persen">PERSENTASE</label>
                      <div class="input-group">

                        <input type="text" class="form-control border-deta" id="persen1" name="persen" autocomplete="off" value="<?= $data->persen ?>">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend">%</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="profit">PROFIT/KEUNTUNGAN</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="profit1" name="profit" autocomplete="off" value="<?= $data->profit ?>">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">SATUAN</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="satuan1" autocomplete="off" value="<?= $data->satuan1 ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">ISI/PCS</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="isi1" autocomplete="off" value="<?= $data->isi1 ?>">
                    </div>
                  </div>
                  <!-- HARGA JUAL1 -->
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="jual">HARGA GROSIR</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="jual4" name="harga_jual1" autocomplete="off" value="<?= $data->harga_jual1 ?>">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="persen">PERSENTASE</label>
                      <div class="input-group">

                        <input type="text" class="form-control border-deta" id="persen4" name="persen1" autocomplete="off" value="<?= $data->persen1 ?>">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend">%</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="profit">PROFIT/KEUNTUNGAN</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="profit4" name="profit1" autocomplete="off" value="<?= $data->profit1 ?>">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">SATUAN</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="satuan2" autocomplete="off" value="<?= $data->satuan2 ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">ISI/PCS</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="isi2" autocomplete="off" value="<?= $data->isi2 ?>">
                    </div>
                  </div>
                  <!-- HARGA JUAL2 -->
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="jual">HARGA AGEN/DISTRIBUTOR</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="jual5" name="harga_jual2" autocomplete="off" value="<?= $data->harga_jual2 ?>">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="persen">PERSENTASE</label>
                      <div class="input-group">

                        <input type="text" class="form-control border-deta" id="persen5" name="persen2" autocomplete="off" value="<?= $data->persen2 ?>">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend">%</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="profit">PROFIT/KEUNTUNGAN</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="profit5" name="profit2" autocomplete="off" value="<?= $data->profit2 ?>">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">SATUAN</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="satuan3" autocomplete="off" value="<?= $data->satuan3 ?>">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">ISI/PCS</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="isi3" autocomplete="off" value="<?= $data->isi3 ?>">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="kategori">KATEGORI</label>
                      <select id="kategori" class="form-control border-deta" name="kode_kategori">
                        <option selected>Pilih...</option>
                        <?php foreach ($kategori as $ket) : ?>
                          <option value="<?= $ket->kode_kategori ?>" <?= $data->id_kategori == $ket->kode_kategori ? 'selected="selected"' : '' ?>><?= $ket->kode_kategori ?> / <?= $ket->nama_kategori ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputCity">JUMLAH STOK</label>
                      <input type="text" class="form-control border-deta" id="inputCity" name="jml_stok" autocomplete="off" value="<?= $data->jml_stok ?>">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputCity">MINIMAL STOK</label>
                      <input type="text" class="form-control border-deta" id="inputCity" name="min_stok" autocomplete="off" value="<?= $data->minimal_stok ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputZip">DESKRIPSI</label>
                    <textarea class="form-control ckeditor border-deta" name="deskripsi"><?= $data->deskripsi ?></textarea>
                  </div>
                  <hr class="bg-deta">
                  <!-- <input type="submit" class="btn btn-deta float-right" name="ubh_brng_ck" value="Simpan Perubahan"> -->
                  <button type="submit" class="btn btn-deta float-right" name="ubh_brng_ck"> Simpan Perubahan</button>
                  <a class="btn btn-warning float-right mr-3" href="<?= base_url('Barang') ?>">Kembali</a>
                </div>
              </div>
              </form>
            <?php elseif (isset($butik['menu_id'])) : ?>
              <form method="post" action="<?= base_url('Barang/Aksi') ?>" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputEmail4">KODE BARANG</label>
                    <input type="hidden" class="form-control" id="inputEmail4" name="id" autocomplete="off" readonly value="<?= $data->id ?>">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="text" class="form-control border-deta" id="kodeee" name="kode_barang" autofocus autocomplete="off" <?= $aktif ?> value="<?= $data->kode_barang ?>">
                      </div>
                      <div class="input-group-append">
                        <button class="btn btn-outline-deta" onclick="myFunctionn()" type="button" <?= $in ?>>Generate</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">NAMA BARANG</label>
                    <input type="text" class="form-control border-deta" id="inputPassword4" name="nama_barang" autocomplete="off" value="<?= $data->nama_barang ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputPassword4">JATUH TEMPO</label>
                    <input type="date" class="form-control border-deta" id="inputPassword4" name="tgl_tempo" autocomplete="off" value="<?= $data->tgl_tempo ?>">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="modal">HARGA MODAL</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="modal" name="harga_beli" autocomplete="off" value="<?= $data->harga_beli ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuann" autocomplete="off" value="<?= $data->satuan ?>">
                  </div>
                  <!-- <div class="form-group col-md-2">
                    <label for="inputZip">ISI/PCS</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="isi" autocomplete="off" value="<?= $data->isi ?>">
                  </div> -->
                </div>
                <!-- HARGA JUAL -->
                <?php $hg = $this->db->get_where('tb_barang_harga', ['token' => $data->token, 'id_barang' => $data->kode_barang]); ?>
                <?php $no = 1;
                $noo = 1;
                $nooo = 1;
                $noooo = 1;
                $rem = 1;
                $reem = 1;
                $j = 1;
                $p = 1;
                $t = 1;
                foreach ($hg->result() as $dt) : ?>
                  <input type="hidden" class="form-control" id="inputEmail4" name="iid[]" autocomplete="off" readonly value="<?= $dt->id_barang_harga ?>">
                  <?php $remove = 'removeclass' . $noo++; ?>
                  <?php $harga = $hg->row(); ?>
                  <div class="<?= $remove ?>">
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="jual">HARGA JUAL</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                          </div>
                          <input type="text" class="form-control border-deta juall" id="jual" name="harga_jual[]" autocomplete="off" value="<?= $dt->harga_jual ?>" required>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="persen">PERSENTASE</label>
                        <div class="input-group">
                          <input type="text" class="form-control border-deta persenn" id="persen" name="persen[]" autocomplete="off" value="<?= $dt->persen ?>" required>
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="profit">PROFIT/KEUNTUNGAN</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                          </div>
                          <input type="text" class="form-control border-deta profitt" id="profit" name="profit[]" autocomplete="off" value="<?= $dt->profit ?>" required>
                        </div>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="inputZip">SATUAN</label>
                        <input type="text" class="form-control border-deta" id="inputZip" name="satuan[]" autocomplete="off" value="<?= $dt->satuan ?>">
                      </div>
                      <div class="form-group col-md-1" <?= $noooo++ != 1 ? 'hidden' : '' ?>>
                        <label for="inputZip">AKSI</label><br>
                        <button class="btn btn-deta" type="button" onclick="tambah_baris();"><i class="fa fa-plus"></i></button>
                      </div>
                      <div class="form-group col-md-1" <?= $nooo++ == 1 ? 'hidden' : '' ?>>
                        <label for="inputZip">AKSI</label><br>
                        <button class="btn btn-danger" type="button" onclick="remove_tambahbaris(<?= $rem++ ?>);"> <i class="fa fa-minus"></i> </button>
                      </div>
                    </div>
                  </div>

                  <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
                  <script type="text/javascript">
                    var room = <?= $reem++ ?>;

                    function tambah_baris() {
                      console.log(room);
                      room++;
                      var objTo = document.getElementById('tambah_baris')
                      var divtest = document.createElement("div");
                      divtest.setAttribute("class", "form-group removeclass" + room);
                      var rdiv = 'removeclass' + room;
                      divtest.innerHTML =
                        `
                        <div class="form-row">
                          <div class="form-group col-md-3">
                            <label for="jual">HARGA JUAL</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                              </div>
                              <input type="text" class="form-control border-deta juall` + room + `" id="jual` + room + `" name="harga_jual[]" autocomplete="off" required>
                            </div>
                          </div>
                          <div class="form-group col-md-3">
                            <label for="persen">PERSENTASE</label>
                            <div class="input-group">
                              <input type="text" class="form-control border-deta persenn` + room + `" id="persen` + room + `" name="persen[]" autocomplete="off" required>
                              <div class="input-group-prepend">
                                <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-md-3">
                            <label for="profit">PROFIT/KEUNTUNGAN</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                              </div>
                              <input type="text" class="form-control border-deta profitt` + room + `" id="profit` + room + `" name="profit[]" autocomplete="off" required>
                            </div>
                          </div>
                          <div class="form-group col-md-2">
                            <label for="inputZip">SATUAN</label>
                            <input type="text" class="form-control border-deta" id="inputZip" name="satuan[]" autocomplete="off">
                          </div>
                          <div class="form-group col-md-1">
                            <label for="inputZip">AKSI</label><br>
                            <button class="btn btn-danger" type="button" onclick="remove_tambahbaris(` + room + `);"> <i class="fa fa-minus"></i> </button>
                          </div>
                        </div>

                        `;
                      objTo.appendChild(divtest);

                      $("#jual" + room).number(true);
                      $("#persen" + room).number(true);
                      $("#profit" + room).number(true);

                      $("#modal").keyup(function() {
                        var muodal = $("#modal").val();
                        if (muodal > 0) {
                          $("#jual" + room).prop("disabled", false);
                          $("#persen" + room).prop("disabled", false);
                          $("#profit" + room).prop("disabled", false);
                        } else {
                          $("#jual" + room).prop("disabled", true);
                          $("#persen" + room).prop("disabled", true);
                          $("#profit" + room).prop("disabled", true);
                        }
                      });

                      $("#jual" + room).keyup(function() {
                        var modal = $("#modal").val();
                        var jual = $("#jual" + room).val();

                        var profit = parseInt(jual) - parseInt(modal);
                        var persen = (profit / modal) * 100;

                        if (jual > 0) {
                          $("#profit" + room).val(profit);
                          $("#persen" + room).val(persen);
                        } else {
                          $("#profit" + room).val("");
                          $("#persen" + room).val("");
                        }
                      });

                      $("#persen" + room).keyup(function() {
                        var modal = $("#modal").val();
                        var persen = $("#persen" + room).val();

                        var profit = persen / 100 * modal;
                        var jual = parseInt(profit) + parseInt(modal);

                        if (persen > 0) {
                          $("#jual" + room).val(jual);
                          $("#profit" + room).val(profit);
                        } else {
                          $("#jual" + room).val("");
                          $("#profit" + room).val("");
                        }
                      });

                      $("#profit" + room).keyup(function() {
                        var modal = $("#modal").val();
                        var profit = $("#profit" + room).val();

                        var jual = parseInt(profit) + parseInt(modal);
                        var persen = profit / modal * 100;

                        if (profit > 0) {
                          $("#jual" + room).val(jual);
                          $("#persen" + room).val(persen);
                        } else {
                          $("#jual" + room).val("");
                          $("#persen" + room).val("");
                        }
                      });

                    }

                    function remove_tambahbaris(rid) {
                      $('.removeclass' + rid).remove();
                    }
                  </script>
                <?php endforeach; ?>
                <div id="tambah_baris"></div>

                <?php if ($set['reseller'] == 1) : ?>
                  <?php $hgr = $this->db->get_where('tb_barang_harga_reseller', ['token' => $data->token, 'id_barang' => $data->kode_barang])->row_array(); ?>
                  <?php if (!empty($hgr)) : ?>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="jual">HARGA RESELLER</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                          </div>
                          <input type="hidden" class="form-control" id="inputEmail4" name="iid_r" autocomplete="off" readonly value="<?= $hgr['id_barang_harga_reseller'] ?>">
                          <input type="text" class="form-control border-deta juall" id="jual_r" name="harga_r" autocomplete="off" value="<?= $hgr['harga_reseller'] ?>" required>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="persen">PERSENTASE</label>
                        <div class="input-group">
                          <input type="text" class="form-control border-deta persenn" id="persen_r" name="persen_r" autocomplete="off" value="<?= $hgr['persen'] ?>" required>
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="profit">PROFIT/KEUNTUNGAN</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                          </div>
                          <input type="text" class="form-control border-deta profitt" id="profit_r" name="profit_r" value="<?= $hgr['profit'] ?>" autocomplete="off" required>
                        </div>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="inputZip">SATUAN</label>
                        <input type="text" class="form-control border-deta" id="inputZip" name="satuan_r" value="<?= $hgr['satuan'] ?>" autocomplete="off">
                      </div>
                    </div>
                  <?php else : ?>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="jual">HARGA RESELLER</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                          </div>
                          <input type="text" class="form-control border-deta juall" id="jual_r" name="harga_r" autocomplete="off">
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="persen">PERSENTASE</label>
                        <div class="input-group">
                          <input type="text" class="form-control border-deta persenn" id="persen_r" name="persen_r" autocomplete="off">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="profit">PROFIT/KEUNTUNGAN</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                          </div>
                          <input type="text" class="form-control border-deta profitt" id="profit_r" name="profit_r" autocomplete="off">
                        </div>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="inputZip">SATUAN</label>
                        <input type="text" class="form-control border-deta" id="inputZip" name="satuan_r" autocomplete="off">
                      </div>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>

                <div class="form-row">
                  <div class="form-group col-md-2">
                    <label for="kategori">KATEGORI</label>
                    <select id="kategori" class="form-control border-deta" name="kode_kategori">
                      <option selected>Pilih...</option>
                      <?php foreach ($kategori as $ket) : ?>
                        <option value="<?= $ket->kode_kategori ?>" <?= $data->id_kategori == $ket->kode_kategori ? 'selected="selected"' : '' ?>><?= $ket->kode_kategori ?> / <?= $ket->nama_kategori ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="kategori">SUB KATEGORI</label>
                    <select id="subkategorii" class="form-control border-deta" name="sub_kategori">
                      <option selected>Pilih...</option>
                      <?php foreach ($sub_kategori as $sub) : ?>
                        <option value="<?= $sub->kode_sub_kategori ?>" <?= $data->sub_kategori == $sub->nama_sub_kategori ? 'selected="selected"' : '' ?>><?= $sub->kode_sub_kategori ?> / <?= $sub->nama_sub_kategori ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="warna">WARNA</label>
                    <?php $warn = $this->db->get_where('tb_barang_warna', ['kode_barang' => $data->kode_barang])->result();
                    $wa = [];
                    foreach ($warn as $dat) {
                      $wa[] = $dat->warna;
                    } ?>
                    <select id="warna" class="form-control border-deta select2 warna select2-multiple" name="warna[]" multiple="multiple" data-placeholder="Pilih...">
                      <option value="">Pilih...</option>
                      <?php foreach ($warna as $war) : ?>
                        <option value="<?= $war->nama_warna ?>" <?= in_array($war->nama_warna, $wa) ? 'selected' : '' ?>><?= $war->nama_warna ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="ukuran">UKURAN</label>
                    <?php $uku = $this->db->get_where('tb_barang_ukuran', ['kode_barang' => $data->kode_barang])->result();
                    $uuk = [];
                    foreach ($uku as $da) {
                      $uuk[] = $da->ukuran;
                    } ?>
                    <select id="ukuran" class="form-control border-deta select2 select2-multiple" name="ukuran[]" multiple="multiple" data-placeholder="Pilih...">
                      <option value="">Pilih...</option>
                      <?php foreach ($ukuran as $uk) : ?>
                        <option value="<?= $uk->nama_ukuran ?>" <?= in_array($uk->nama_ukuran, $uuk) ? 'selected' : '' ?>><?= $uk->nama_ukuran ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputCity">JUMLAH STOK</label>
                    <input type="text" class="form-control border-deta" id="inputCity" name="jml_stok" autocomplete="off" value="<?= $data->jml_stok ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputCity">MINIMAL STOK</label>
                    <input type="text" class="form-control border-deta" id="inputCity" name="minimal_stok" autocomplete="off" value="<?= $data->minimal_stok ?>">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputCity">Berat (Gr)</label>
                    <input type="number" min="0" class="form-control border-deta" name="berat" value="<?= $data->berat ?>" autocomplete="off">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputCity">Dropshipper</label>
                    <select name="dropship" id="dropship" class="form-control" required>
                      <option value="1" <?= $data->dropship == 1 ? 'selected' : '' ?>>Aktifkan kirim sebagai Dropshipper</option>
                      <option value="0" <?= $data->dropship == 0 ? 'selected' : '' ?>>Non Aktifkan kirim sebagai Dropshipper</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputCity">View TokoOnline</label>
                    <select name="status" id="status1" class="form-control" required>
                      <option value="1" <?= $data->status == 1 ? 'selected' : '' ?>>Tampilkan</option>
                      <option value="0" <?= $data->status == 0 ? 'selected' : '' ?>>Tidak di Tampilkan</option>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputCity">GAMBAR PRODUK</label>
                    <input type="file" class="form-control border-deta" id="produk_load" onchange="previeww(this);" name="gambar" autocomplete="off">
                    <small>Size = 600 x 600 pixel <br> Filesize = 1 MB (1024 KB)</small><br>
                    <?php if ($data->gambar == null) : ?>
                      <img class="mt-3" src="<?= base_url('assets/img/') . $data->gambar ?>" width="150px" alt="" id="preview_produk">
                    <?php else : ?>
                      <img class="mt-3" src="<?= base_url('assets/upload/barang/') . $data->gambar ?>" width="150px" alt="" id="preview_produk">
                    <?php endif; ?>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="inputZip">DESKRIPSI</label>
                    <textarea class="form-control border-deta" name="deskripsi" id="editor1"><?= $data->deskripsi ?></textarea>
                  </div>
                </div>
                <hr class="bg-deta">
                <button type="submit" class="btn btn-deta float-right" name="ubh_brng_bt">Simpan Perubahan</button>
                <a class="btn btn-warning float-right mr-3" href="<?= base_url('Barang') ?>">Kembali</a>
              </form>
            <?php else : ?>
              <form method="post" action="<?= base_url('Barang/Aksi') ?>">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputEmail4">KODE BARANG</label>
                    <input type="hidden" class="form-control" name="id" autocomplete="off" readonly value="<?= $data->id ?>">
                    <input type="hidden" class="form-control" id="inputEmail4" name="id" autocomplete="off" readonly value="<?= $data->id ?>">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="text" class="form-control border-deta" id="kodeee" name="kode_barang" autocomplete="off" <?= $aktif ?> value="<?= $data->kode_barang ?>">
                      </div>
                      <div class="input-group-append">
                        <button class="btn btn-outline-deta" onclick="myFunctionn()" type="button" <?= $in ?>>Generate</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">NAMA BARANG</label>
                    <input type="text" class="form-control border-deta" id="inputPassword4" name="nama_barang" autocomplete="off" value="<?= $data->nama_barang ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputPassword4">JATUH TEMPO</label>
                    <input type="date" class="form-control border-deta" id="inputPassword4" name="tgl_tempo" autocomplete="off" value="<?= $data->tgl_tempo ?>">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="modal">HARGA MODAL</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="modal1" name="harga_beli" autocomplete="off" value="<?= $data->harga_beli ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="jual">HARGA JUAL</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="jual1" name="harga_jual" autocomplete="off" value="<?= $data->harga_jual ?>">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="persen">PERSENTASE</label>
                    <div class="input-group">

                      <input type="text" class="form-control border-deta" id="persen1" name="persen" autocomplete="off" value="<?= $data->persen ?>">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend">%</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="profit">PROFIT/KEUNTUNGAN</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="profit1" name="profit" autocomplete="off" value="<?= $data->profit ?>">
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="kategori">KATEGORI</label>
                    <select id="kategori" class="form-control border-deta" name="kode_kategori">
                      <option selected>Pilih...</option>
                      <?php foreach ($kategori as $ket) : ?>
                        <option value="<?= $ket->kode_kategori ?>" <?= $data->id_kategori == $ket->kode_kategori ? 'selected="selected"' : '' ?>><?= $ket->kode_kategori ?> / <?= $ket->nama_kategori ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputCity">JUMLAH STOK</label>
                    <input type="text" class="form-control border-deta" id="inputCity" name="jml_stok" autocomplete="off" value="<?= $data->jml_stok ?>">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputCity">MINIMAL STOK</label>
                    <input type="text" class="form-control border-deta" id="inputCity" name="minimal_stok" autocomplete="off" value="<?= $data->minimal_stok ?>">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan" autocomplete="off" value="<?= $data->satuan ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputZip">DESKRIPSI</label>
                  <textarea class="form-control border-deta" name="deskripsi" id="inputZip"><?= $data->deskripsi ?></textarea>
                </div>
                <hr class="bg-deta">
                <button type="submit" class="btn btn-deta float-right" name="ubh_brng">Simpan Perubahan</button>
                <a class="btn btn-warning float-right mr-3" href="<?= base_url('Barang') ?>">Kembali</a>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace('editor1');
</script>
<script src="<?= base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<script>
  function myFunctionn() {
    var as = Math.ceil(Math.random() * 8928389218398);
    $('#kodeee').val(as);
  }
</script>
<script>
  $(function() {
    var link = $('#link').val();
    var en = link.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    $('#link_cek').html(en);

    $(document).on('keyup', function() {
      var link = $('#link').val();
      var en = link.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
      $('#link_cek').html(en);
    });
  });

  $(document).ready(function() {
    $('#staticBackdrop').on('show.bs.modal', function(e) {
      var kd = $(e.relatedTarget).data('id');
      var gam = $(e.relatedTarget).data('gam');
      //menggunakan fungsi ajax untuk pengambilan data
      $.ajax({
        type: 'post',
        url: '<?= base_url('Barang/detail_barang') ?>',
        data: {
          kd: kd,
          gam: gam
        },
        success: function(data) {
          $('.vDetail').html(data); //menampilkan data ke dalam modal
        }
      });
    });
  });
</script>

<script>
  window.previeww = function(input) {
    if (input.files && input.files[0]) {
      $(input.files).each(function() {
        var reader = new FileReader();
        reader.readAsDataURL(this);
        reader.onload = function(e) {
          $("#preview_produk").attr('src', e.target.result);
        }
      });
    }
  }
</script>
<script>
  <?php $hg = $this->db->get_where('tb_barang_harga', ['token' => $data->token, 'id_barang' => $data->kode_barang])->result(); ?>
  <?php $no = 1;
  $j = 1;
  $jj = 1;
  $p = 1;
  $pp = 1;
  $t = 1;
  $tt = 1;
  foreach ($hg as $dt) : ?>

    $("#jual<?= $j++ ?>").keyup(function() {
      var modal = $("#modal1").val();
      var jual = $("#jual<?= $jj++ ?>").val();

      var profit = jual - modal;
      var persen = (profit / modal) * 100;

      if (jual > 0) {
        $("#profit<?= $t++ ?>").val(profit);
        $("#persen<?= $p++ ?>").val(persen);
      } else {
        $("#profit<?= $tt++ ?>").val("");
        $("#persen<?= $pp++ ?>").val("");
      }
    });

  <?php endforeach; ?>

  <?php $hg = $this->db->get_where('tb_barang_harga', ['token' => $data->token, 'id_barang' => $data->kode_barang])->result(); ?>
  <?php $no = 1;
  $j = 1;
  $jj = 1;
  $p = 1;
  $pp = 1;
  $t = 1;
  $tt = 1;
  foreach ($hg as $dt) : ?>

    $("#persen<?= $p++ ?>").keyup(function() {
      var modal = $("#modal1").val();
      var persen = $("#persen<?= $pp++ ?>").val();

      var profit = persen / 100 * modal;
      var jual = parseInt(profit) + parseInt(modal);

      if (persen > 0) {
        $("#jual<?= $j++ ?>").val(parseInt(jual));
        $("#profit<?= $t++ ?>").val(profit);
      } else {
        $("#jual<?= $jj++ ?>").val("");
        $("#profit<?= $tt++ ?>").val("");
      }
    });

  <?php endforeach; ?>

  <?php $hg = $this->db->get_where('tb_barang_harga', ['token' => $data->token, 'id_barang' => $data->kode_barang])->result(); ?>
  <?php $no = 1;
  $j = 1;
  $jj = 1;
  $p = 1;
  $pp = 1;
  $t = 1;
  $tt = 1;
  foreach ($hg as $dt) : ?>

    $("#profit<?= $t++ ?>").keyup(function() {
      var modal = $("#modal1").val();
      var profit = $("#profit<?= $tt++ ?>").val();

      var jual = parseInt(profit) + parseInt(modal);
      var persen = profit / modal * 100;

      if (profit > 0) {
        $("#jual<?= $j++ ?>").val(parseInt(jual));
        $("#persen<?= $p++ ?>").val(persen);
      } else {
        $("#jual<?= $jj++ ?>").val("");
        $("#persen<?= $pp++ ?>").val("");
      }
    });

  <?php endforeach; ?>
</script>

<script>
  $("#jual_r").keyup(function() {
    var modal = $("#modal").val();
    var jual = $("#jual_r").val();

    var profit = jual - modal;
    var persen = (profit / modal) * 100;

    if (jual > 0) {
      $("#profit_r").val(profit);
      $("#persen_r").val(persen);
    } else {
      $("#profit_r").val("");
      $("#persen_r").val("");
    }
  });

  $("#persen_r").keyup(function() {
    var modal = $("#modal").val();
    var persen = $("#persen_r").val();

    var profit = persen / 100 * modal;
    var jual = parseInt(profit) + parseInt(modal);

    if (persen > 0) {
      $("#jual_r").val(parseInt(jual));
      $("#profit_r").val(profit);
    } else {
      $("#jual_r").val("");
      $("#profit_r").val("");
    }
  });

  $("#profit_r").keyup(function() {
    var modal = $("#modal").val();
    var profit = $("#profit_r").val();

    var jual = parseInt(profit) + parseInt(modal);
    var persen = profit / modal * 100;

    if (profit > 0) {
      $("#jual_r").val(parseInt(jual));
      $("#persen_r").val(persen);
    } else {
      $("#jual_r").val("");
      $("#persen_r").val("");
    }
  });
</script>

<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="vDetail"></div>
    </div>
  </div>
</div>