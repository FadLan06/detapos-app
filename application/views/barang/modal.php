<!-- MODAL RETUR -->
<div class="modal fade" id="mRetur" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalCenterTitle"><b>Data Pengembalian Barang</b></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="_retur"></div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL UPLOAD -->
<div class="modal fade" id="ModalUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalCenterTitle"><b>Upload Data Barang</b></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open_multipart('barang/import_data'); ?>
        <div class="form-group mb-3">
          <label for="file">Upload Data Barang</label>
          <input type="file" class="form-control" accept=".xlsx, .xls, .csv" id="file" name="file" autocomplete="off" required>
        </div>
        <?php if (isset($retail['menu_id'])) : ?>
          <button type="submit" name="submit_rt" class="btn btn-info float-right"><i class="fas fa-upload"></i> Upload</button>
          <a href="<?= base_url('assets/fileexcel/formatexceluploadbarangretail.xls') ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Download Format Excel</a>
        <?php elseif (isset($check['menu_id'])) : ?>
          <button type="submit" name="submit_ck" class="btn btn-info float-right"><i class="fas fa-upload"></i> Upload</button>
          <a href="<?= base_url('assets/fileexcel/formatexceluploadbarangcheckout.xls') ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Download Format Excel</a>
        <?php elseif (isset($butik['menu_id'])) : ?>
          <button type="submit" name="submit_bt" class="btn btn-info float-right"><i class="fas fa-upload"></i> Upload</button>
          <a href="<?= base_url('assets/fileexcel/formatexceluploadbarangbutikk.xls') ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Download Format Excel</a>
        <?php else : ?>
          <button type="submit" name="submit" class="btn btn-info float-right"><i class="fas fa-upload"></i> Upload</button>
          <a href="<?= base_url('assets/fileexcel/formatexceluploadbarang.xls') ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Download Format Excel</a>
        <?php endif; ?>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>

<!-- MODAL BUKALAPAK -->
<div class="modal fade" id="bukalapak" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalCenterTitle"><b>Upload Data Barang</b></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12 text-center">
          <h1><b>COMING SOON!!</b></h1>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Barang -->
<div class="modal fade" id="ModalBarang" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl " role="document">
    <div class="modal-content">
      <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalScrollableTitle">List Data Barang</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mBarang"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="<?= base_url('Barang/Cetak_barang') ?>" target="_blank" class="btn btn-deta">Cetak</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal Lik -->
<div class="modal fade" id="mLink" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalCenterTitle"><b>Link Checkout Barang</b></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="_link_check"></div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL BARCODE -->
<div class="modal fade" id="ModalBarcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalCenterTitle"><b>Cetak Barcode</b></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(); ?>Barang/Cetak_barcode" method="post" enctype="multipart/form-data">
          <div class="form-group mb-3">
            <label for="kode_bar">Kode Barang</label>
            <input type="text" class="form-control" id="kode_bar" name="kode_bar" autocomplete="off">
          </div>
          <div class="form-group mb-3">
            <label for="jumlah">Jumlah Barcode</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" autocomplete="off">
          </div>
          <button type="submit" name="submit" class="btn btn-info float-right"><i class="fas fa-print"></i> Cetak</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL SERIAL -->
<div class="modal fade" id="mSerial" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalCenterTitle"><b>Data Serial Barang</b></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="_serial"></div>
      </div>
    </div>
  </div>
</div>