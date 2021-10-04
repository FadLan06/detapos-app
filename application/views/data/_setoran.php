<?php $dt = $this->db->get_where('tb_setoran_tmp', ['token' => $data->token, 'no_setoran' => $data->no_setoran])->row(); ?>
<form method="POST" action="<?= base_url('Data_setoran/Aksi') ?>" enctype="multipart/form-data">
    <input type="hidden" value="<?= $data->id_setoran ?>" name="id_setoran">
    <input type="hidden" value="<?= $dt->id_setoran_tmp ?>" name="id_setoran_tmp">
    <div class="form-group">
        <label for="inputAddress">Tanggal Transaksi</label>
        <input type="date" class="form-control" name="tgl_setoran" id="inputAddress" placeholder="1234 Main St" value="<?= $data->tgl_setoran ?>" required>
    </div>
    <div class="form-group">
        <label for="inputAddress2">Uraian</label>
        <textarea class="form-control" name="uraian" id="uraian" required><?= $data->uraian ?></textarea>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputCity">Nominal</label>
            <input type="number" class="form-control" value="<?= $dt->nominal ?>" id="inputCity" name="nominal" required>
        </div>
        <div class="form-group col-md-6">
            <label for="inputState">Expedisi</label>
            <select class="form-control" id="expedisi" name="expedisi" required>
                <option selected disabled>
                    <-- Pilih Posisi -->
                </option>
                <option value="B" <?= $dt->expedisi == 'B' ? 'selected' : '' ?>>BANK</option>
                <option value="T" <?= $dt->expedisi == 'T' ? 'selected' : '' ?>>TUNAI</option>
            </select>
        </div>
    </div>
    <?php if ($dt->expedisi == 'B') : ?>
        <div class="form-row" id="bank">
            <div class="form-group col-md-12">
                <label for="inputCity">Rekening</label>
                <!-- <input type="number" class="form-control" id="inputCity" name="no_rek"> -->
                <select name="rekening" id="rekening" class="form-control">
                    <option selected disabled>
                        <-- Pilih Rekening -->
                    </option>
                    <option value="81826599 BNI - Hans Lamusu" <?= $dt->rekening == '81826599 BNI - Hans Lamusu' ? 'selected' : '' ?>>81826599 BNI - Hans Lamusu</option>
                    <option value="151 000 423 7977 Mandiri - Hans Lamusu" <?= $dt->rekening == '151 000 423 7977 Mandiri - Hans Lamusu' ? 'selected' : '' ?>>151 000 423 7977 Mandiri - Hans Lamusu</option>
                </select>
            </div>
        </div>
    <?php else : ?>
        <div class="form-row" id="tunai">
            <div class="form-group col-md-6">
                <label for="inputCity">Nm. Penerima</label>
                <input type="text" class="form-control" id="inputCity" value="<?= $dt->nm_pen ?>" name="nm_pen">
            </div>
            <div class="form-group col-md-6">
                <label for="inputCity">Posisi</label>
                <input type="text" class="form-control" id="inputCity" value="<?= $dt->posisi ?>" name="posisi">
            </div>
        </div>
    <?php endif; ?>
    <button type="submit" name="ubah" class="btn btn-danger float-right">Simpan</button>
    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
</form>
<script src="<?= base_url('assets/') ?>jquery-3.4.1.js"></script>
<script>
    $(document).ready(function() {
        $('#bank, #tunai').show();

        $('#expedisi').change(function() {
            if ($(this).val() == 'B') {
                $('#bank').show();
                $('#tunai').hide();
            } else if ($(this).val() == 'T') {
                $('#bank').hide();
                $('#tunai').show();
            }

            $('#expedisi select').val('');
        });
    });
</script>