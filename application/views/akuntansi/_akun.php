<form method="POST" action="<?= base_url('Akun/Aksi') ?>">
    <div class="form-group">
        <label for="kode_akun">Nomor / Kode Akun</label>
        <input type="hidden" name="id_akun" class="form-control border-deta" id="id_akun" autocomplete="off" value="<?= $data['id_akun'] ?>">
        <input type="text" name="kode_akun" class="form-control border-deta" id="kode_akun" autocomplete="off" value="<?= $data['kode_akun'] ?>">
        <?= form_error('kode_akun', '<small class="text-danger pl-3">', '</small>') ?>
    </div>
    <div class="form-group">
        <label for="nama_akun">Nama Akun</label>
        <input type="text" name="nama_akun" class="form-control border-deta" id="nama_akun" autocomplete="off" value="<?= $data['nama_akun'] ?>">
        <?= form_error('nama_akun', '<small class="text-danger pl-3">', '</small>') ?>
    </div>
    <div class="form-group">
        <label for="kategori">Posisi Awal Saldo</label>
        <select name="kategori" id="kategori" class="form-control border-deta">
            <option value="HL" <?= $data['kategori'] == 'HL' ? 'selected' : '' ?>>Debet</option>
            <option value="HT" <?= $data['kategori'] == 'HT' ? 'selected' : '' ?>>Kredit</option>
        </select>
        <?= form_error('nama_pel', '<small class="text-danger pl-3">', '</small>') ?>
    </div>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" name="ubah_akun" class="btn btn-danger float-right">Ubah</button>
</form>