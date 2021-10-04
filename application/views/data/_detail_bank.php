<?php if ($data->nominal != 0) : ?>
    <table class="table table-sm">
        <tr>
            <td width="35%">Rekening</td>
            <td width="2%">:</td>
            <td><?= $data->rekening ?></td>
        </tr>
        <tr>
            <td width="35%">Bukti</td>
            <td width="2%">:</td>
            <td><img src="<?= base_url('assets/upload/bukti/bukti.jpg') ?>" class="card-img"></td>
        </tr>
    </table>
<?php endif; ?>