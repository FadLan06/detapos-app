<div class="page-content-wrapper ">

    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <!-- <li class="breadcrumb-item"><a href="#">Annex</a></li> -->
                            <li class="breadcrumb-item"><a href="<?= base_url('Shop') ?>">Home</a></li>
                            <li class="breadcrumb-item active"><?= $judul ?></li>
                        </ol>
                    </div>
                    <h4><?= $judul ?></h4>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-3 mb-2">
                <div class="card card-body">
                    <div class="media mx-auto">
                        <img class="d-flex" src="<?= base_url('assets/upload/') . $set['logo'] ?>" alt="Generic placeholder image" height="100" width="100">
                    </div>
                    <hr class="bg-deta">
                    <div class="list-group"><button class="list-group-item list-group-item-action mb-1" style="border: 1px solid #00aaff" onclick="location.reload()">Semua</button></div>
                    <?php foreach ($ket->result_array() as $ak) : ?>
                        <?php $jum = $this->db->query("SELECT count(id_kategori) as jumlah FROM tb_barang WHERE id_kategori='$ak[kode_kategori]'")->row(); ?>
                        <div class="list-group"><button class="list-group-item list-group-item-action mb-1" id='id_kategori' style="border: 1px solid #00aaff" onclick="detail(<?= $ak['kode_kategori'] ?>)"><?= $ak['nama_kategori'] ?> (<?= $jum->jumlah ?>)</button></div>
                    <?php endforeach; ?>
                    <!-- <hr class="bg-deta">
                    <p><?= $set['alamat'] ?></p>
                    <p><?= $set['no_telpon'] ?></p> -->
                </div>
            </div>
            <div class="col-sm-9">
                <div class="card card-body" style="margin-bottom: 30px;">
                    <div class="row" id="detail_ket">
                        <div class="col-lg-12">
                            <h5><b>List Produk </b></h5>
                            <hr class="bg-deta">
                        </div>
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
                    </div>
                </div>
            </div>
        </div>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    function detail(kode) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 1 || xhttp.readyState == 2 || xhttp.readyState == 3) {
                document.getElementById("detail_ket").innerHTML = "Memuat data...";
            }

            if (xhttp.readyState == 4) {
                document.getElementById("detail_ket").innerHTML = xhttp.responseText;
            }

        };
        xhttp.open("GET", "<?= base_url('Shop/detail_ket') ?>?kode=" + kode, true);
        xhttp.send();
    }
</script>