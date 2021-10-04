<div class="form-group">
    <label for="formGroupExampleInput">Kode Barang</label>
    <input type="text" class="form-control" name="jumlah_barang" id="formGroupExampleInput" required autocomplete="off" value="<?= $br['kode_barang'] ?>" readonly>
</div>
<div class="form-group">
    <label for="formGroupExampleInput">Nama Barang</label>
    <input type="text" class="form-control" name="jumlah_barang" id="formGroupExampleInput" required autocomplete="off" value="<?= $br['nama_barang'] ?>" readonly>
</div>
<div class="form-group">
    <label for="formGroupExampleInput">Stok Tersedia</label>
    <input type="text" class="form-control" name="jumlah_barang" id="formGroupExampleInput" required autocomplete="off" value="<?= $br['jml_stok'] . ' ' . $br['satuan'] ?>" readonly>
</div>
<div class="form-group">
    <label for="formGroupExampleInput">Supplier</label>
    <select name="kode_supplier" id="kode_sup" class="form-control">
        <option selected disabled>
            <-- Pilih Supplier -->
        </option>
        <option value="<?= $asal->kota ?>">Kota Asal</option>
        <?php foreach ($sup as $data) : ?>
            <option value="<?= $data['kota'] ?>"><?= $data['kode_sup'] ?> / <?= $data['nama_toko'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="form-group">
    <label for="formGroupExampleInput">Link Checkout</label>
    <input type="text" class="form-control" name="jumlah_barang" required autocomplete="off" hidden>
    <textarea class="form-control" id="linkCheck"></textarea>
</div>
<div class="form-group">
    <button class="btn btn-secondary btn-sm copyLink" onclick="linkCh()"><i class="fas fa-copy"></i> Copy</button>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#kode_sup').change(function() {
            var kota = $(this).val();
            var link = '<?= base_url() ?>';
            var token = '<?= $br['token'] ?>';
            var slug = '<?= $br['slug'] ?>';
            <?php if ($br['token'] == 'DPVL3N') : ?>
                $('#linkCheck').val(link + 'kirim/' + token + '/' + kota + '/' + slug);
            <?php else : ?>
                $('#linkCheck').val(link + 'link/' + token + '/' + kota + '/' + slug);
            <?php endif; ?>
        });
    });

    function linkCh() {
        /* Get the text field */
        var copyText = document.getElementById("linkCheck");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        alert("Link berhasil dicopy : " + copyText.value);
    }
</script>