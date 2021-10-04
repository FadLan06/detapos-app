<div class="col-lg-12">
    <h5><b>List Produk </b></h5>
    <hr class="bg-deta">
</div>

<?php if (!empty($cek['id_kategori'])) : ?>
    <?php $barang = $this->db->get_where('tb_barang', ['token' => $cek['token'], 'id_kategori' => $cek['id_kategori']]); ?>
    <?php foreach ($barang->result_array() as $br) : ?>
        <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.harga='$br[harga_jual]' AND t.token='$br[token]' ORDER BY qty ASC")->row_array(); ?>
        <?php $harga = $this->db->get_where('tb_barang_harga', ['token' => $br['token'], 'id_barang' => $br['id']])->row_array(); ?>
        <div class="col-6 col-sm-6 col-md-4 col-lg-3" style="margin-bottom: 0.01rem; padding-right: 6px; padding-left: 6px;">
            <div class="card m-b-30" style="border: 1px solid #00aaff">
                <a href="<?= base_url('Shop/Detail/') . $br['id'] ?>" class="text-dark alink">
                    <img class="card-img-top img-fluid" src="<?= base_url('assets/upload/barang/') . $br['gambar'] ?>" style="height: 120px" alt="Card image cap">
                    <div class="card-body" style="padding-bottom: 10px; padding-left: 12px; padding-right: 12px; padding-top: 10px; border-top: 1px solid #00aaff">
                        <p class="card-text teks"><?php echo ucwords(strtolower(substr($br['nama_barang'], 0, 20))) . " ..."; ?></p>
                        <p class="card-text teks">
                            <span class="text-deta"><b>Rp. <?= number_format($harga['harga_jual'] != null ? $harga['harga_jual'] : 0) ?></b></span>
                            <small class="text-muted float-right" <?= $stok['qty'] == 0 ? 'hidden' : '' ?>><?= number_format($stok['qty']) ?> Terjual</small>
                        </p>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>