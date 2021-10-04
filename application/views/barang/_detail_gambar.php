<div class="modal-header bg-danger text-white">
  <h6 class="modal-title" id="staticBackdropLabel"><?=$data->kode_barang.' - '.$data->nama_barang?></h6>
  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <table class="table" width="100%">
    <tr>
      <td><img src="<?=base_url('assets/upload/barang/').$gambar->gambar?>" class="card-img" alt=""></td>
    </tr>
    <tr>
      <td>
        <?=form_open_multipart('Barang/Aksi');?>
          <div class="form-group">
            <label for="inputCity">UBAH FILE</label>
            <input type="file" class="form-control border-danger" name="file_upload" autocomplete="off">
          </div>
          <input type="hidden" name="id" value="<?=$data->id?>">
          <input type="hidden" name="kode" value="<?=$gambar->kd_barang_tmp?>">
          <input type="hidden" name="gambar" value="<?=$gambar->gambar?>">
          <input type="hidden" name="slug" value="<?=$gambar->slug?>">
          <input type="hidden" name="kode_barang" value="<?=$gambar->kode_barang?>">
          <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Keluar</button>
          <input type="submit" class="btn btn-danger float-right mx-2" name="" value="Hapus">
          <input type="submit" class="btn btn-info float-right" name="ubah_gambar" value="Ubah">
        <?=form_close();?>
      </td>
    </tr>
  </table>
</div>
