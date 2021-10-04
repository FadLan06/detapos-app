<form method="POST" action="<?= base_url('Jurnal_umum/Act_Jurnal') ?>">
    <div class="form-group">
        <label for="tgl_jurnal">Tanggal Transaksi</label>
        <input type="date" name="tgl_jurnal" class="form-control border-deta" id="tgl_jurnal" autocomplete="off" value="<?= $data1['tgl_jurnal'] ?>" readonly>
        <input type="hidden" name="id_jurnal_tmp" class="form-control" id="no_jurnal" autocomplete="off" value="<?= $data1['id_jurnal_tmp'] ?>" readonly>
        <input type="hidden" name="no_jurnal" class="form-control" id="no_jurnal" autocomplete="off" value="<?= $data1['no_jurnal'] ?>" readonly>
        <?= form_error('tgl_jurnal', '<small class="text-danger pl-3">', '</small>') ?>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <?php foreach ($data as $dt) : ?>
                <input type="hidden" name="id_jurnalD[]" class="form-control" id="no_jurnal" autocomplete="off" value="<?= $dt['id_jurnal'] ?>" readonly>
                <label for="id_akun">Debet</label>
                <select name="id_akunD[]" id="id_akunD" class="form-control border-deta" required>
                    <option>Pilih Akun</option>
                    <?php foreach ($akunn as $ak) : ?>
                        <option value="<?= $ak->id_akun ?>" <?= $ak->id_akun == $dt['id_akun'] ? 'selected' : '' ?>><?= $ak->nama_akun ?></option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('id_akun', '<small class="text-danger pl-3">', '</small>') ?>
            <?php endforeach; ?>
        </div>
        <div class="form-group col-md-3">
            <?php foreach ($dataa as $dt1) : ?>
                <input type="hidden" name="id_jurnalK[]" class="form-control" id="no_jurnal" autocomplete="off" value="<?= $dt1['id_jurnal'] ?>" readonly>
                <label for="id_akun">Kredit</label>
                <select name="id_akunK[]" id="id_akunK" class="form-control border-deta" required>
                    <option>Pilih Akun</option>
                    <?php foreach ($akunn as $ak) : ?>
                        <option value="<?= $ak->id_akun ?>" <?= $ak->id_akun == $dt1['id_akun'] ? 'selected' : '' ?>><?= $ak->nama_akun ?></option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('id_akun', '<small class="text-danger pl-3">', '</small>') ?>
            <?php endforeach; ?>
        </div>
        <div class="form-group col-md-4">
            <?php foreach ($data as $dt) : ?>
                <label for="id_akun">Nominal</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white"><b>Rp</b></span>
                    </div>
                    <input type="text" name="nominal[]" class="form-control border-deta" id="nominal" autocomplete="off" placeholder="Nominal" value="<?= $dt['nominal'] ?>" required>
                    <?= form_error('nominal', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea class="form-control border-deta" id="keterangan" name="keterangan" rows="1" required><?= $data1['keterangan'] ?></textarea>
        <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>') ?>
    </div>

    <hr class="bg-deta">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" name="ubah_jurnall" class="btn btn-deta float-right">Ubah</button>
</form>