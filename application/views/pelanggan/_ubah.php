<form method="POST" action="<?= base_url('Pelanggan/Aksi') ?>">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputEmail4">Kode Pelanggan</label>
            <input type="text" name="kode_pel" class="form-control" id="inputEmail4" value="<?=$pelanggan->kode_pel?>" autocomplete="off" readonly>
            <input type="hidden" name="kd_pelanggan" class="form-control" id="inputEmail4" value="<?=$pelanggan->kd_pelanggan?>" autocomplete="off" readonly>
            <?= form_error('kode_pel', '<small class="text-danger pl-3">', '</small>') ?>
        </div>
        <div class="form-group col-md-8">
            <label for="inputPassword4">Nomor HP</label>
            <input type="text" name="no_hp" class="form-control" id="inputPassword4" autocomplete="off" value="<?=$pelanggan->no_hp?>">
            <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>') ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputAddress">Nama Pelanggan</label>
        <input type="text" name="nama_pel" class="form-control" id="inputAddress" autocomplete="off" value="<?=$pelanggan->nama_pel?>">
        <?= form_error('nama_pel', '<small class="text-danger pl-3">', '</small>') ?>
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control"><?=$pelanggan->alamat?></textarea>
        <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
    </div>
    <button type="submit" name="ubah" class="btn btn-danger float-right">Ubah</button>
</form>