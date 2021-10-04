<div class="page-content-wrapper ">

    <style>
        .lineChart {
            width: auto;
            height: auto;
        }

        @media (max-width: 575.98px) {
            .lineChart {
                width: 900px;
                height: auto;
            }
        }
    </style>

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
            <div class="col-md">
                <div id="pesanAktif"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md">
                <?php if ($alert['control'] == 'Aktiv') : ?>
                    <div class="alert alert-success alert-dismissible fade show mb-3 text-dark" role="alert">
                        <strong><?= $alert['sapaan'] ?></strong> <?= $alert['kalimat'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row justify-content-center">

            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta shadow">
                    <div class="card-body" style="padding: 1rem .5rem;">
                        <a href="<?=base_url('Barang')?>">
                            <div class="d-flex flex-row">
                                <div class="col-2 align-self-center">
                                    <div class="round">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center text-center">
                                    <div class="m-l-10">
                                        <h6 class="mt-0 round-inner text-white">Rp. <?= number_format($modal) ?></h6>
                                        <p class="mb-0 text-white">Modal</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta shadow">
                    <div class="card-body" style="padding: 1rem .5rem;">
                        <a href="<?= base_url('Neraca_saldo') ?>">
                            <div class="d-flex flex-row">
                                <div class="col-2 align-self-center">
                                    <div class="round">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center text-center">
                                    <div class="m-l-10">
                                        <h6 class="mt-0 round-inner text-white">Rp. <?= number_format($pendapatan) ?></h6>
                                        <p class="mb-0 text-white">Pendapatan</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta shadow">
                    <div class="card-body" style="padding: 1rem .5rem;">
                        <a href="<?= base_url('Pengeluaran') ?>">
                            <div class="d-flex flex-row">
                                <div class="col-2 align-self-center">
                                    <div class="round">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center text-center">
                                    <div class="m-l-10">
                                        <h6 class="mt-0 round-inner text-white">Rp. <?= number_format($pengeluaran) ?></h6>
                                        <p class="mb-0 text-white">Pengeluaran</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta shadow">
                    <div class="card-body" style="padding: 1rem .5rem;">
                        <a href="<?= base_url('Laba_rugi') ?>">
                            <div class="d-flex flex-row">
                                <div class="col-2 align-self-center">
                                    <div class="round">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center text-center">
                                    <div class="m-l-10">
                                        <h6 class="mt-0 round-inner text-white">Rp. <?= number_format($laba) ?></h6>
                                        <p class="mb-0 text-white">Laba Bersih</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta shadow">
                    <div class="card-body" style="padding: 1rem .5rem;">
                        <a href="<?= base_url('Penjualan') ?>">
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
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta shadow">
                    <div class="card-body" style="padding: 1rem .5rem;">
                        <a href="<?= base_url('Barang') ?>">
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
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta shadow">
                    <div class="card-body" style="padding: 1rem .5rem;">
                        <a href="<?= base_url('Supplier') ?>">
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
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta shadow">
                    <div class="card-body" style="padding: 1rem .5rem;">
                        <a href="<?= base_url('Pelanggan') ?>">
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
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>

        <div class="card bg-white m-b-30" style="width: 100%; overflow-x: auto; overflow-y: hidden">
            <div class="card-body new-user lineChart">
                <h5 class="header-title mt-0 mb-4">Grafik Pendapatan & Pengeluaran Bulan <?= date('F Y') ?></h5>
                <canvas id="lineChart" height="100"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5 class="header-title pb-3 mt-0">10 Barang Terlaris</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th width="10%">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="terlaris">
                                </tbody>
                            </table>
                        </div>
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
    var ctxB = document.getElementById("lineChart").getContext('2d');
    var myBarChart = new Chart(ctxB, {
        type: 'line',
        data: {
            labels: [
                <?php foreach ($tanggal as $tgl) {
                    echo '"' . date('d/m', strtotime($tgl['tgl_jurnal'])) . '", ';
                } ?>
            ],
            datasets: [{
                    label: 'Pendapatan',
                    data: [
                        <?php foreach ($tanggal as $tgl) {
                            $neraca = $this->db->query("SELECT *, sum(j.nominal) as total FROM tb_jurnal j LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE j.token='$tgl[token]' AND a.nama_akun LIKE '%Pendapatan%' AND t.tgl_jurnal='$tgl[tgl_jurnal]'")->row();
                            echo $neraca->total != 0 ? $neraca->total . ',' : 0 . ',';
                        } ?>
                    ],
                    fill: false,
                    borderColor: '#00aaff',
                    tension: 0.1
                },
                {
                    label: 'Pengeluaran',
                    data: [
                        <?php foreach ($tanggal as $tgl) {
                            $neraca = $this->db->query("SELECT *, sum(j.nominal) as total FROM tb_jurnal j LEFT JOIN tb_jurnal_tmp t ON t.no_jurnal=j.no_jurnal LEFT JOIN tb_akun a ON a.id_akun=j.id_akun WHERE j.token='$tgl[token]' AND a.nama_akun LIKE '%Beban%' AND t.tgl_jurnal='$tgl[tgl_jurnal]'")->row();
                            echo $neraca->total != 0 ? $neraca->total . ',' : 0 . ',';
                        } ?>
                    ],
                    fill: false,
                    borderColor: '#ff2929',
                    tension: 0.1
                }
            ]
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
        xhttp.open("GET", "<?= base_url('Home/ambil_stok') ?>", true);
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
        xhttp.open("GET", "<?= base_url('Home/ambil_tempo') ?>", true);
        xhttp.send();
    }
</script>
<script>
    window.addEventListener('load', terlaris);

    function terlaris() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 1 || xhttp.readyState == 2 || xhttp.readyState == 3) {
                document.getElementById("terlaris").innerHTML = "<tr><td colspan='4'>Memuat data...</td></tr>";
            }

            if (xhttp.readyState == 4) {
                document.getElementById("terlaris").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "<?= base_url('Home/ambil_terlaris') ?>", true);
        xhttp.send();
    }
</script>

<script>
    pesanAktif();

    function pesanAktif() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Home/ambil_pesan') ?>',
            dataType: 'json',
            success: function(data) {
                $('#pesanAktif').html(data);
            }
        });
    }
</script>