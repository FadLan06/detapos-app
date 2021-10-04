<table class="table table-sm">
    <thead>
        <tr align="center">
            <th width="5%">#</th>
            <th>Serial</th>
            <th>Exp. Date</th>
            <th>Kode Barang</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($data as $da) : ?>
            <tr align="center">
                <td><?= $no++ ?></td>
                <td><?= $da->serial_num ?></td>
                <td><?= $da->expired ?></td>
                <td><?= $da->kode_bar ?></td>
                <td>
                    <?php if ($da->status == 1) {
                        echo 'Belum';
                    } else {
                        echo 'Sudah';
                    } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>