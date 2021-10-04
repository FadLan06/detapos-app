<?php if ($data->nominal != 0) : ?>
    <table class="table table-sm">
        <tr>
            <td width="35%">Nama Penerima</td>
            <td width="2%">:</td>
            <td><?= $data->nm_pen ?></td>
        </tr>
        <tr>
            <td width="35%">Posisi</td>
            <td width="2%">:</td>
            <td><?= $data->posisi ?></td>
        </tr>
    </table>
<?php endif; ?>