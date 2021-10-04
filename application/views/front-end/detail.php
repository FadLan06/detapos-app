<div class="page-content-wrapper ">

    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <!-- <li class="breadcrumb-item"><a href="#">Annex</a></li> -->
                            <li class="breadcrumb-item"><a href="<?= base_url('Shop') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Detail Produk</li>
                        </ol>
                    </div>
                    <h4>Detail Produk</h4>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 100px;">
            <div class="card-body">
                <div class="row">
                    <?php $produk = $this->db->get_where('tb_barang_produk', ['token' => $barang['token'], 'id_barang' => $barang['id']])->result_array(); ?>
                    <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$barang[kode_barang]' AND t.harga='$barang[harga_jual]' AND t.token='$barang[token]' ORDER BY qty ASC")->row_array(); ?>
                    <?php $harga = $this->db->get_where('tb_barang_harga', ['token' => $barang['token'], 'id_barang' => $barang['id']])->row_array(); ?>
                    <div class="col-lg-6">
                        <div id="carouselExampleControlsNoTouching" class="carousel slide" data-touch="false" data-interval="false">
                            <div class="carousel-inner">
                                <div class="popup-gallery">
                                    <div class="carousel-item active">
                                        <a class="pull-left" href="<?= base_url('assets/upload/barang/') . $barang['gambar'] ?>" title="Project 1">
                                            <div class="img-fluid">
                                                <img src="<?= base_url('assets/upload/barang/') . $barang['gambar'] ?>" class="d-block w-100">
                                            </div>
                                        </a>
                                    </div>

                                    <?php foreach ($produk as $dt) : ?>
                                        <div class="carousel-item">
                                            <a class="pull-left" href="<?= base_url('assets/upload/barang/') . $dt['produk'] ?>" title="Project 1">
                                                <div class="img-fluid">
                                                    <img src="<?= base_url('assets/upload/barang/') . $dt['produk'] ?>" class="d-block w-100">
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControlsNoTouching" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControlsNoTouching" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <hr class="bg-deta">
                        <div class="popup-gallery">
                            <div class="mr-1 mb-1 pull-left" title="Project 1">
                                <div class="img-fluid">
                                    <img src="<?= base_url('assets/upload/barang/') . $barang['gambar'] ?>" width="90">
                                </div>
                            </div>
                            <?php foreach ($produk as $dt) : ?>
                                <div class="mr-1 mb-1 pull-left" title="Project 1">
                                    <div class="img-fluid">
                                        <img src="<?= base_url('assets/upload/barang/') . $dt['produk'] ?>" width="90">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div> <!-- end col -->

                    <div class="col-lg-6">
                        <span style="font-size: 18px; font-weight: 500;"><?= $barang['nama_barang'] ?></span><br>
                        <span <?= $stok['qty'] == 0 ? 'hidden' : '' ?>><b><?= number_format($stok['qty']) ?></b> Terjual</span>
                        <hr class="bg-deta">
                        <div style="width: 100%; background-color: #f7f7f7;">
                            <span class="ml-3 text-deta harga">Rp. <?= number_format($harga['harga_jual'] != null ? $harga['harga_jual'] : 0) ?></span>
                        </div>
                        <hr class="bg-deta">
                        <span><?= htmlspecialchars_decode($barang['deskripsi']) ?></span><br>
                        <?= form_open('Shop/m_keranjang'); ?>
                        <input type="hidden" class="form-control" name="id" id="id" value="<?= $barang['id'] ?>">
                        <input type="hidden" class="form-control" name="price" id="price" value="<?= $harga['harga_jual'] ?>">
                        <input type="hidden" class="form-control" name="name" id="name" value="<?= $barang['nama_barang'] ?>">
                        <input type="hidden" name="link" value="<?= base_url('Olshop/') . $this->uri->segment(2) . '/Detail/' . $this->uri->segment(4); ?>">
                        <div class="form-row">
                            <div class="form-group col-2">
                                <label class="mt-2 float-right">Jumlah</label>
                            </div>
                            <div class="form-group col-3">
                                <input type="number" class="form-control" name="qty" id="qty" value="1" min="1">
                            </div>
                            <div class="form-group col-6">
                                <button class="btn btn-deta cart" type="submit" id="btn_cart" onclick="kirim()"><i class="fas fa-shopping-cart"></i> Keranjang</button>
                                <button class="btn btn-warning cart" type="submit" id="btn_check" onclick="check()">Checkout</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    $('#btn_check').on('click', function() {
        var valid = this.form.checkValidity();
        if (valid) {
            event.preventDefault();
            var id = $('#id').val();
            var qty = $('#qty').val();
            var price = $('#price').val();
            var name = $('#name').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Shop/masuk_check') ?>",
                dataType: "JSON",
                data: {
                    id: id,
                    qty: qty,
                    price: price,
                    name: name,
                },
                success: function(data) {
                    if (data == true) {
                        location.href = '<?= base_url('Shop/Checkout') ?>';
                    }
                }
            });
        }
    });
</script>