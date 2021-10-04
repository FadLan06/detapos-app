<form method="POST" action="<?= base_url('Data_rekon/Aksi') ?>">
    <input type="hidden" value="<?= $data->id_rekon_final ?>" name="id_rekon">
    <input type="hidden" value="<?= $data->saldo ?>" name="saldo">
    <div class="form-group">
        <label for="inputAddress">Tanggal Transaksi</label>
        <input type="date" class="form-control" name="tgl_rekon" id="inputAddress" placeholder="1234 Main St" value="<?= $data->tgl_final ?>" readonly required>
    </div>
    <div class="form-group">
        <label for="inputAddress2">Uraian</label>
        <textarea class="form-control" name="uraian" id="uraian" required><?= $data->uraian ?></textarea>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputCity">Nominal</label>
            <input type="number" class="form-control" id="inputCity" name="nominal" value="<?= $data->nominal ?>" required>
        </div>
        <div class="form-group col-md-6">
            <label for="inputState">Posisi</label>
            <select id="inputState" class="form-control" name="tipe" required>
                <option value="D" <?= $data->tipe == 'D' ? 'selected' : '' ?>>Debet</option>
                <option value="K" <?= $data->tipe == 'K' ? 'selected' : '' ?>>Kredit</option>
            </select>
        </div>
    </div>
    <button type="submit" name="ubah_final" class="btn btn-danger float-right">Simpan</button>
    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
</form>