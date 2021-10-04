<form method="POST" action="<?= base_url('No_rekening/Proses_rek') ?>" enctype="multipart/form-data">
    <div class="form-group">
        <label for="inputAddress">No. Rekening</label>
        <input type="hidden" name="kd_rekening" class="form-control border-danger" id="inputAddress" autocomplete="off" autofocus required value="<?= $data['kd_rekening'] ?>">
        <input type="number" name="no_rekening" class="form-control border-danger" id="inputAddress" autocomplete="off" autofocus required value="<?= $data['no_rekening'] ?>">
        <?= form_error('no_rekening', '<small class="text-danger pl-3">', '</small>') ?>
    </div>
    <div class="form-group">
        <label for="inputAddress">Atas Nama</label>
        <input type="text" name="atas_nama" class="form-control border-danger" id="inputAddress" autocomplete="off" required value="<?= $data['atas_nama'] ?>">
        <?= form_error('atas_nama', '<small class="text-danger pl-3">', '</small>') ?>
    </div>
    <div class="form-group">
        <label for="struk">Jenis Rekening</label>
        <select class="form-control border-danger" name="jenis" required>
            <option value="bank-bca" <?= $data['jenis'] == 'bank-bca' ? 'selected' : '' ?>>Bank Central Asia (BCA)</option>
            <option value="bank-mandiri" <?= $data['jenis'] == 'bank-mandiri' ? 'selected' : '' ?>>Bank Mandiri</option>
            <option value="bank-bni" <?= $data['jenis'] == 'bank-bni' ? 'selected' : '' ?>>Bank Negara Indonesia (BNI)</option>
            <option value="bank-bri" <?= $data['jenis'] == 'bank-bri' ? 'selected' : '' ?>>Bank Rakyat Indonesia (BRI)</option>
            <option value="bank-bsi" <?= $data['jenis'] == 'bank-bsi' ? 'selected' : '' ?>>Bank Syariah Indonesia (BSI)</option>
            <!-- <option value="btn">Bank Tabungan Negara (BTN)</option> -->
        </select>
        <?= form_error('jenis', '<small class="text-danger pl-3">', '</small>') ?>
    </div>
    <button type="submit" name="ubah_rek" class="btn btn-danger float-right"><i class="fas fa-save"></i> Simpan</button>
</form>