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
          <div class="card-body">
            <?= $this->session->flashdata('message') ?>
            <?php if (isset($retail['menu_id'])) : ?>
              <form method="post" action="<?= base_url('Barang/Aksi') ?>">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputEmail4">KODE BARANG</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="text" class="form-control border-deta" id="kodee1" name="kode_barang" autocomplete="off" required autofocus>
                      </div>
                      <div class="input-group-append">
                        <button class="btn btn-outline-deta" onclick="myFunction1()" type="button">Generate</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">NAMA BARANG</label>
                    <input type="text" class="form-control border-deta" id="inputPassword4" name="nama_barang" autocomplete="off" required>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputPassword4">EXP. DATE</label>
                    <input type="date" class="form-control border-deta" id="inputPassword4" name="tgl_tempo" autocomplete="off">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="modal">HARGA MODAL</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="modal" name="harga_beli" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan" autocomplete="off" required>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">ISI/PCS</label>
                    <input type="number" class="form-control border-deta" id="inputZip" name="isi" autocomplete="off">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="jual">HARGA ECER</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="jual" name="harga_jual" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="persen">PERSENTASE</label>
                    <div class="input-group">
                      <input type="text" class="form-control border-deta" id="persen" name="persen" autocomplete="off" required>
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
                      <input type="text" class="form-control border-deta" id="profit" name="profit" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan1" autocomplete="off">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">ISI/PCS</label>
                    <input type="number" class="form-control border-deta" id="inputZip" name="isi1" autocomplete="off">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="jual">HARGA GROSIR</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="jual2" name="harga_jual1" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="persen">PERSENTASE</label>
                    <div class="input-group">
                      <input type="text" class="form-control border-deta" id="persen2" name="persen1" autocomplete="off">
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
                      <input type="text" class="form-control border-deta" id="profit2" name="profit1" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan2" autocomplete="off">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">ISI/PCS</label>
                    <input type="number" class="form-control border-deta" id="inputZip" name="isi2" autocomplete="off">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="jual">HARGA AGEN/DISTRIBUTOR</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="jual3" name="harga_jual2" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="persen">PERSENTASE</label>
                    <div class="input-group">
                      <input type="text" class="form-control border-deta" id="persen3" name="persen2" autocomplete="off">
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
                      <input type="text" class="form-control border-deta" id="profit3" name="profit2" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan3" autocomplete="off">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputZip">ISI/PCS</label>
                    <input type="number" class="form-control border-deta" id="inputZip" name="isi3" autocomplete="off">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="kategori">KATEGORI</label>
                    <select id="kategori" class="form-control border-deta" name="kode_kategori">
                      <option selected>Pilih...</option>
                      <?php foreach ($kategori as $ket) : ?>
                        <option value="<?= $ket->kode_kategori ?>"><?= $ket->kode_kategori ?> / <?= $ket->nama_kategori ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputCity">JUMLAH STOK</label>
                    <input type="number" class="form-control border-deta" id="inputCity" name="jml_stok" autocomplete="off" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputCity">MINIMAL STOK</label>
                    <input type="number" class="form-control border-deta" id="inputCity" name="min_stok" autocomplete="off" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputZip">DESKRIPSI</label>
                  <textarea class="form-control border-deta" name="deskripsi" id="inputZip"></textarea>
                </div>
                <hr class="bg-deta">
                <button type="submit" class="btn btn-deta float-right" name="smpn_brng_rt">Tambah</button>
                <a class="btn btn-warning float-right mr-3" href="<?= base_url('Barang') ?>">Kembali</a>
              </form>
            <?php elseif (isset($check['menu_id'])) : ?>
              <?= form_open_multipart('Barang/Aksi'); ?>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="inputEmail4">KODE BARANG</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="text" class="form-control border-deta" id="kodee" name="kode_barang" autocomplete="off" required autofocus>
                      </div>
                      <div class="input-group-append">
                        <button class="btn btn-outline-deta" onclick="myFunction()" type="button">Generate</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword4">NAMA BARANG</label>
                    <input type="text" class="form-control border-deta" id="inputPassword4" name="nama_barang" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword4">EXP. DATE</label>
                    <input type="date" class="form-control border-deta" id="inputPassword4" name="tgl_tempo" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="inputPassword4">BERAT BARANG</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Gr</span>
                      </div>
                      <input type="number" class="form-control border-deta" id="inputPassword4" name="berat" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputZip">FILE GAMBAR</label>
                    <input type="file" class="form-control border-deta" onchange="preview(this);" name="file_upload[]" autocomplete="off" multiple="" required>
                    <small><i>Rekomendasi dimensi gambar 400 x 800 pixels</i></small>
                  </div>
                  <div class="form-group">
                    <div id="previewImg"></div>
                  </div>
                  <hr class="bg-deta">
                </div>
                <div class="col-md-8">
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="modal">HARGA MODAL</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="modal" name="harga_beli" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputZip">SATUAN</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="satuan" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">ISI/PCS</label>
                      <input type="number" class="form-control border-deta" id="inputZip" name="isi" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="jual">HARGA ECER</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="jual" name="harga_jual" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="persen">PERSENTASE</label>
                      <div class="input-group">
                        <input type="text" class="form-control border-deta" id="persen" name="persen" autocomplete="off" required>
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
                        <input type="text" class="form-control border-deta" id="profit" name="profit" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">SATUAN</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="satuan1" autocomplete="off">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">ISI/PCS</label>
                      <input type="number" class="form-control border-deta" id="inputZip" name="isi1" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="jual">HARGA GROSIR</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="jual2" name="harga_jual1" autocomplete="off">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="persen">PERSENTASE</label>
                      <div class="input-group">
                        <input type="text" class="form-control border-deta" id="persen2" name="persen1" autocomplete="off">
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
                        <input type="text" class="form-control border-deta" id="profit2" name="profit1" autocomplete="off">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">SATUAN</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="satuan2" autocomplete="off">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">ISI/PCS</label>
                      <input type="number" class="form-control border-deta" id="inputZip" name="isi2" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="jual">HARGA AGEN/DISTRIBUTOR</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                        </div>
                        <input type="text" class="form-control border-deta" id="jual3" name="harga_jual2" autocomplete="off">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="persen">PERSENTASE</label>
                      <div class="input-group">
                        <input type="text" class="form-control border-deta" id="persen3" name="persen2" autocomplete="off">
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
                        <input type="text" class="form-control border-deta" id="profit3" name="profit2" autocomplete="off">
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">SATUAN</label>
                      <input type="text" class="form-control border-deta" id="inputZip" name="satuan3" autocomplete="off">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputZip">ISI/PCS</label>
                      <input type="number" class="form-control border-deta" id="inputZip" name="isi3" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="kategori">KATEGORI</label>
                      <select id="kategori" class="form-control border-deta" name="kode_kategori">
                        <option selected>Pilih...</option>
                        <?php foreach ($kategori as $ket) : ?>
                          <option value="<?= $ket->kode_kategori ?>"><?= $ket->kode_kategori ?> / <?= $ket->nama_kategori ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputCity">JUMLAH STOK</label>
                      <input type="number" class="form-control border-deta" id="inputCity" name="jml_stok" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputCity">MINIMAL STOK</label>
                      <input type="number" class="form-control border-deta" id="inputCity" name="min_stok" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputZip">DESKRIPSI</label>
                    <textarea class="form-control border-deta ckeditor" name="deskripsi" id="inputZip"></textarea>
                  </div>
                  <hr class="bg-deta">
                  <input type="submit" class="btn btn-deta float-right" name="smpn_brng_ck" value="Tambah">

                  <a class="btn btn-warning float-right mr-3" href="<?= base_url('Barang') ?>">Kembali</a>
                </div>
              </div>
              <?php echo form_close(); ?>

            <?php else : ?>
              <form method="post" action="<?= base_url('Barang/Aksi') ?>">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputEmail4">KODE BARANG</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="text" class="form-control border-deta" id="kodee2" name="kode_barang" autocomplete="off" required autofocus>
                        <?= form_error('kode_barang', '<small class="text-white pl-3">', '</small>') ?>
                      </div>
                      <div class="input-group-append">
                        <button class="btn btn-outline-deta" onclick="myFunction2()" type="button">Generate</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">NAMA BARANG</label>
                    <input type="text" class="form-control border-deta" id="inputPassword4" name="nama_barang" autocomplete="off" required>
                    <?= form_error('nama_barang', '<small class="text-white pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputPassword4">EXP. DATE</label>
                    <input type="date" class="form-control border-deta" id="inputPassword4" name="tgl_tempo" autocomplete="off">
                    <?= form_error('tgl_tempo', '<small class="text-white pl-3">', '</small>') ?>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="modal">HARGA MODAL</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="modal" name="harga_beli" autocomplete="off" required>
                      <?= form_error('harga_beli', '<small class="text-white pl-3">', '</small>') ?>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="jual">HARGA JUAL</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="jual" name="harga_jual" autocomplete="off" required>
                      <?= form_error('harga_jual', '<small class="text-white pl-3">', '</small>') ?>
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="persen">PERSENTASE</label>
                    <div class="input-group">
                      <input type="text" class="form-control border-deta" id="persen" name="persen" autocomplete="off" required>
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                      </div>
                      <?= form_error('persen', '<small class="text-white pl-3">', '</small>') ?>
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="profit">PROFIT/KEUNTUNGAN</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                      </div>
                      <input type="text" class="form-control border-deta" id="profit" name="profit" autocomplete="off" required>
                      <?= form_error('profit', '<small class="text-white pl-3">', '</small>') ?>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="kategori">KATEGORI</label>
                    <select id="kategori" class="form-control border-deta" name="kode_kategori">
                      <option selected>Pilih...</option>
                      <?php foreach ($kategori as $ket) : ?>
                        <option value="<?= $ket->kode_kategori ?>"><?= $ket->kode_kategori ?> / <?= $ket->nama_kategori ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputCity">JUMLAH STOK</label>
                    <input type="number" class="form-control border-deta" id="inputCity" name="jml_stok" autocomplete="off" required>
                    <?= form_error('jml_stok', '<small class="text-white pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="inputCity">MINIMAL STOK</label>
                    <input type="number" class="form-control border-deta" id="inputCity" name="min_stok" autocomplete="off" required>
                    <?= form_error('min_stok', '<small class="text-white pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputZip">SATUAN</label>
                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan" autocomplete="off" required>
                    <?= form_error('satuan', '<small class="text-white pl-3">', '</small>') ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputZip">DESKRIPSI</label>
                  <textarea class="form-control border-deta" name="deskripsi" id="inputZip"></textarea>
                  <?= form_error('deskripsi', '<small class="text-white pl-3">', '</small>') ?>
                </div>
                <hr class="bg-deta">
                <button type="submit" class="btn btn-deta float-right" name="smpn_brng">Tambah</button>
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
<script type="text/javascript" src="<?= base_url() ?>assets/ckeditor/adapters/jquery.js"></script>
<script>
  window.preview = function(input) {
    if (input.files && input.files[0]) {
      $(input.files).each(function() {
        var reader = new FileReader();
        reader.readAsDataURL(this);
        reader.onload = function(e) {
          $("#previewImg").append("<a href='#' class='img_rmv btn btn-deta1'><img class='thumbb mx-1' width='100px' src='" + e.target.result + "'></a>");
        }
      });
    }
  }

  $("#previewImg").on("click", ".thumbb", function() {
    $(this).parent().remove();
    return false;
  });

  function myFunction() {
    var as = Math.ceil(Math.random() * 8928389218398);
    $('#kodee').val(as);
  }

  function myFunction1() {
    var as = Math.ceil(Math.random() * 8928389218398);
    $('#kodee1').val(as);
  }

  function myFunction2() {
    var as = Math.ceil(Math.random() * 8928389218398);
    $('#kodee2').val(as);
  }
</script>