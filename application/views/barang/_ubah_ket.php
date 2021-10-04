<form method="post" action="<?=base_url('Barang/Aksi')?>">
    <div class="form-group">
        <label for="inputEmail4">Kode Kategori</label>
        <input type="hidden" name="id_kat" class="form-control" autocomplete="off" autofocus value="<?=$data->id_kategori?>">
        <input type="text" name="kd_kat" class="form-control" autocomplete="off" autofocus value="<?=$data->kode_kategori?>">
    </div>
    <div class="form-group">
        <label for="inputAddress">Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control" autocomplete="off" value="<?=$data->nama_kategori?>">
    </div>
    <button type="submit" name="ubah_ket" class="btn btn-primary float-right">Ubah</button>
</form>