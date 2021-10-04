<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?= $judul ?></h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <div class="row">
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="col align-self-center text-center">
                                <div class="m-l-10">
                                    <h3 class="mt-0 round-inner text-white"><?= $penjualan ?></h3>
                                    <p class="mb-0 text-white">Penjualan Hari Ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="fas fa-database"></i>
                                </div>
                            </div>
                            <div class="col text-center align-self-center">
                                <div class="m-l-10 ">
                                    <h3 class="mt-0 round-inner text-white"><?= $barang ?></h3>
                                    <p class="mb-0 text-white">Data Barang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round ">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                            </div>
                            <div class="col align-self-center text-center">
                                <div class="m-l-10 ">
                                    <h3 class="mt-0 round-inner text-white"><?= $supplier ?></h3>
                                    <p class="mb-0 text-white">Data Supplier</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col align-self-center text-center">
                                <div class="m-l-10">
                                    <h3 class="mt-0 round-inner text-white"><?= $pelanggan ?></h3>
                                    <p class="mb-0 text-white">Data Pelanggan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5 class="header-title pb-3 mt-0">10 Barang Terlaris</h5>
                        <canvas id="barChart" height="102"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5 class="header-title pb-3 mt-0">Aktivitas Transaksi. <?= longdate_indo(date('Y-m-d')) ?></h5>
                        <div class="anyClass">
                            <p>Aktivitas Transaksi Hari Ini <b><?php echo $user['nama']; ?></b></p>
                            <table class="table table-hover table-bordered">
                                <?php foreach ($log as $l) : ?>
                                    <tr>
                                        <td style="border-left: 3px solid #00aaff">
                                            <?= $l['deskripsi'] ?><br>
                                            <b><?= $l['timestmp'] ?></b>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card bg-white m-b-30">
                    <div class="card-body new-user">
                        <h5 class="header-title mt-0 mb-4">Exp. Date</h5>
                        <div class="anyClass">
                            <div id="tempo"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-white m-b-30">
                    <div class="card-body new-user">
                        <h5 class="header-title mt-0 mb-4">Stok Minimum</h5>
                        <div class="anyClass">
                            <div id="stok"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- container -->


</div> <!-- Page content Wrapper -->

<!-- Chart JS -->
<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/chart.js/chart.min.js"></script>
<script type="text/javascript">
    //bar
    var ctxB = document.getElementById("barChart").getContext('2d');
    var myBarChart = new Chart(ctxB, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($namabarang as $b) {
                    $br = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$b[kode_barang]' AND token='$b[token]'")->row_array();
                    echo '"' . $br['kode_barang'] . '",';
                } ?>
            ],
            datasets: [{
                label: 'Jumlah Barang Terlaris',
                data: [
                    <?php foreach ($banyakbeli as $p) {
                        $stok = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$b[kode_barang]' AND token='$b[token]'")->row_array();
                        echo '"' . $p['total'] . '",';
                    } ?>
                ],
                backgroundColor: "#00aaff",
                borderColor: "#00aaff",
                borderWidth: 1,
                hoverBackgroundColor: "#008fd6",
                hoverBorderColor: "#008fd6"
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

<script>
    window.addEventListener('load', stok);

    function stok() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("stok").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "<?= base_url('Beranda/ambil_stok') ?>", true);
        xhttp.send();
    }
</script>
<script>
    window.addEventListener('load', tempo);

    function tempo() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tempo").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "<?= base_url('Beranda/ambil_tempo') ?>", true);
        xhttp.send();
    }
</script>

<script>
    pesanAktif();

    function pesanAktif() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Beranda/ambil_pesan') ?>',
            dataType: 'json',
            success: function(data) {
                $('#pesanAktif').html(data);
            }
        });
    }
</script>