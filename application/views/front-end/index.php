<div class="page-content-wrapper ">

    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <!-- <li class="breadcrumb-item"><a href="#">Annex</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
                            <li class="breadcrumb-item active">Home</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Home</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 0.01rem; padding-right: 6px; padding-left: 6px;">
                <div id="carouselExampleIndicators" class="carousel slide" align="center" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="d-block img-fluid" src="<?= base_url() ?>assets/img/lorem/lorem1.jpg" style="height: 350px; width: 1200px" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="<?= base_url() ?>assets/img/lorem/lorem2.jpg" style="height: 350px; width: 1200px" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="<?= base_url() ?>assets/img/lorem/lorem3.jpg" style="height: 350px; width: 1200px" alt="Third slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid" src="<?= base_url() ?>assets/img/lorem/lorem4.jpg" style="height: 350px; width: 1200px" alt="Fourt slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <div class="col-md-12">
                <div class="mt-4">
                    <div class="row">
                        <?php foreach ($barang->result_array() as $br) : ?>
                            <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.harga='$br[harga_jual]' AND t.token='$br[token]' ORDER BY qty ASC")->row_array(); ?>
                            <?php $harga = $this->db->get_where('tb_barang_harga', ['token' => $br['token'], 'id_barang' => $br['id']])->row_array(); ?>
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3" style="margin-bottom: 0.01rem; padding-right: 6px; padding-left: 6px;">
                                <div class="card m-b-30">
                                    <a href="<?= base_url('Olshop/') . $this->uri->segment(2) . '/Detail/' . $br['id'] ?>" class="text-dark alink">
                                        <img class="card-img-top img-fluid" src="<?= base_url('assets/upload/barang/') . $br['gambar'] ?>" style="height: 200px" alt="Card image cap">
                                        <div class="card-body" style="padding-bottom: 10px; padding-left: 12px; padding-right: 12px; padding-top: 10px">
                                            <p class="card-text teks"><?php echo ucwords(strtolower(substr($br['nama_barang'], 0, 26))) . " ..."; ?></p>
                                            <p class="card-text teks">
                                                <span class="text-deta"><b>Rp. <?= number_format($harga['harga_jual'] != null ? $harga['harga_jual'] : 0) ?></b></span>
                                                <small class="text-muted float-right" <?= $stok['qty'] == 0 ? 'hidden' : '' ?>><?= number_format($stok['qty']) ?> Terjual</small>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <?php echo $pagination_links; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- container -->

</div> <!-- Page content Wrapper -->