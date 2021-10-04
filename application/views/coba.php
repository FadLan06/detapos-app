<!DOCTYPE html>
<html>

<head>
    <title>warna</title>
</head>

<body>
    <?php echo form_open('coba/kirim') ?>
    <input type="checkbox" name="check_list[]" alt="Checkbox" value="merah"> merah
    <input type="checkbox" name="check_list[]" alt="Checkbox" value="kuning"> kuning
    <input type="checkbox" name="check_list[]" alt="Checkbox" value="hijau"> hijau
    <input type="checkbox" name="check_list[]" alt="Checkbox" value="biru"> biru
    <input type="submit" name="tampil" value="Simpan">
    <?php echo form_close() ?>

    <table border="1">
        <tr>
            <td>No</td>
            <td>Nama Warna</td>
        </tr>
        <?php $i = 1;
        foreach ($tampil_warna as $tampil) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $tampil->resep ?></td>
            </tr>
        <?php $i++;
        } ?>
    </table>
</body>

</html>