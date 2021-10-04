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
                        <form method="post">
                            <?php if ($this->session->userdata('email') != '') : ?>
                                <input type="hidden" class="form-control" name="id_barang" id="id_barang" value="<?= $barang['id'] ?>">
                                <input type="hidden" class="form-control" name="harga" id="harga" value="<?= $harga['harga_jual'] ?>">
                                <input type="hidden" class="form-control" name="nama_barang" id="nama_barang" value="<?= $barang['nama_barang'] ?>">
                                <input type="hidden" class="form-control" name="token" id="token" value="<?= $barang['token'] ?>">
                                <input type="hidden" class="form-control" name="id_pel" id="id_pel" value="<?= $use['id_pel_shop'] ?>">
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
                            <?php else : ?>
                                <div class="form-row">
                                    <div class="form-group col-2">
                                        <label class="mt-2 float-right">Jumlah</label>
                                    </div>
                                    <div class="form-group col-3">
                                        <input type="number" class="form-control" name="qty" id="qty" value="1" min="1">
                                    </div>
                                    <div class="form-group col-6">
                                        <button class="btn btn-deta cart" type="button" onclick="location.href='<?= base_url('Shop/Login') ?>'"><i class="fas fa-shopping-cart"></i> Keranjang</button>
                                        <button class="btn btn-warning cart" type="button" onclick="location.href='<?= base_url('Shop/Login') ?>'">Checkout</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <?php $set = $this->db->get_where('setting_app', ['token' => $barang['token']])->row_array();
                $toko = strtolower(str_replace(' ', '-', $set['nama_toko'])); ?>
                <hr class="bg-deta">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="media">
                            <img class="d-flex align-self-start mr-3" src="<?= base_url('assets/upload/') . $set['logo'] ?>" alt="Generic placeholder image" height="80" width="80">
                            <div class="media-body">
                                <h5 class="mt-0 font-18"><?= $set['nama_toko'] ?></h5>
                                <button class="btn btn-outline-deta" onclick="location.href='<?= base_url('Shop/Toko/') . $set['token'] ?>'"><i class="fas fa-store"></i> Kunjungi Toko</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        |
                    </div>
                </div>
                <hr class="bg-deta">

            </div>
        </div>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    $('#btn_cart').on('click', function() {
        var valid = this.form.checkValidity();
        if (valid) {
            event.preventDefault();
            var id_barang = $('#id_barang').val();
            var qty = $('#qty').val();
            var harga = $('#harga').val();
            var nama_barang = $('#nama_barang').val();
            var token = $('#token').val();
            var id_pel = $('#id_pel').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Shop/masuk') ?>",
                dataType: "JSON",
                data: {
                    id_barang: id_barang,
                    qty: qty,
                    harga: harga,
                    nama_barang: nama_barang,
                    token: token,
                    id_pel: id_pel,
                },
                success: function(data) {
                    // if (data.success === true) {
                    //     toastr.success("File berhasil disimpan");
                    // }
                    location.reload();
                }
            });
        }
    });

    $('#btn_check').on('click', function() {
        var valid = this.form.checkValidity();
        if (valid) {
            event.preventDefault();
            var id_barang = $('#id_barang').val();
            var qty = $('#qty').val();
            var harga = $('#harga').val();
            var nama_barang = $('#nama_barang').val();
            var token = $('#token').val();
            var id_pel = $('#id_pel').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Shop/masuk_check') ?>",
                dataType: "JSON",
                data: {
                    id_barang: id_barang,
                    qty: qty,
                    harga: harga,
                    nama_barang: nama_barang,
                    token: token,
                    id_pel: id_pel,
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