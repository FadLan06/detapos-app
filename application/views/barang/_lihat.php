<table class="table table-striped table-bordered table-sm">
    <thead class="center" style="text-align:center; ">
        <tr>
            <th width="5%">#</th>
            <th width="25%">Nama Barang</th>
            <th>Harga Modal</th>
            <th>Harga Jual</th>
            <th>Sisa Stok</th>
            <th>Jml Modal</th>
            <th>Jml Jual</th>
            <th>Keuntungan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        $ttl_beli = 0;
        $ttl_jual = 0;
        $ttl_sisa = 0;
        $ttl_modal = 0;
        $ttl_juall = 0;
        $ttl_untung = 0; ?>
        <?php foreach ($barang as $br) : ?>
            <?php $stok = $this->db->query("SELECT *, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
            <?php
            $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']]);
            $kd = $query->num_rows();
            $sisa = $br['jml_stok'];
            $modal = $sisa * $br['harga_beli'];
            $jual = $sisa * $br['harga_jual'];
            $untung = $jual - $modal;
            ?>
            <tr>
                <td align="center"><?= $no++ ?></td>
                <td><?= $br['nama_barang'] ?></td>
                <td>Rp. <?= number_format($br['harga_beli']) ?></td>
                <td>Rp. <?= number_format($br['harga_jual']) ?></td>
                <td align="center"><?= number_format($sisa) ?></td>
                <td>Rp. <?= number_format($modal) ?></td>
                <td>Rp. <?= number_format($jual) ?></td>
                <td>Rp. <?= number_format($untung) ?></td>
            </tr>
            <?php
            $ttl_beli += $br['harga_beli'];
            $ttl_jual += $br['harga_jual'];
            $ttl_sisa += $sisa;
            $ttl_modal += $modal;
            $ttl_juall += $jual;
            $ttl_untung += $untung;
            ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr align="center">
            <th colspan="2">TOTAL</th>
            <th>Rp. <?= number_format($ttl_beli) ?></th>
            <th>Rp. <?= number_format($ttl_jual) ?></th>
            <th><?= number_format($ttl_sisa) ?></th>
            <th>Rp. <?= number_format($ttl_modal) ?></th>
            <th>Rp. <?= number_format($ttl_juall) ?></th>
            <th>Rp. <?= number_format($ttl_untung) ?></th>
        </tr>
    </tfoot>
    <table>