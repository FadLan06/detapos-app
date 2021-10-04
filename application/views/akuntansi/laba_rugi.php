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
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="input-group">
                            <form action="" method="post">
                                <div class="form-row">
                                    <div class="col-auto">
                                        <label class="mr-2">Cari Berdasarkan</label>
                                    </div>
                                    <div class="col-auto">
                                        <select name="filter" id="filter" class="form-control-sm" required>
                                            <option value="semua" selected>Semua Data </option>
                                            <option value="1">Tanggal</option>
                                            <option value="2">Bulan dan Tahun</option>
                                            <option value="3">Tahun</option>
                                        </select>
                                    </div>
                                    <div class="col-auto" id="f-tanggal">
                                        <label class="sr-only" for="inlineFormInput">Name</label>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control-sm">
                                    </div>
                                    <div class="col-auto" id="f-bulan">
                                        <select class="form-control-sm" id="bulan" name="bulan" autocomplate="off" required>
                                            <option selected>
                                                <-- Pilih Bulan -->
                                            </option>
                                            <option value="01">Januari</option>
                                            <option value="02">Februari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                    <div class="col-auto" id="f-tahun">
                                        <select class="form-control-sm" id="tahun" name="tahun" autocomplate="off">
                                            <option selected>
                                                <-- Pilih Tahun -->
                                            </option>
                                            <?php foreach ($tahun as $th) : ?>
                                                <?php $dataa = explode('-', $th['tgl_jurnal']);
                                                $tah = $dataa[0]; ?>
                                                <option value="<?= $tah ?>"><?= $tah ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button class="mr-1 btn btn-deta btn-sm" type="submit" id="cari" name="cari"><i class="fas fa-search"></i> View</button>
                                    </div>
                                </div>
                            </form>
                            <div id="viewFilter"></div>
                        </div>
                        <hr class="bg-deta">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead align="center" class="bg-deta text-white">
                                    <tr>
                                        <th width="5%">NO</th>
                                        <th width="10%">Kode Akun</th>
                                        <th width="40%">Nama Akun</th>
                                        <th width="20%" colspan="2">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody id="viewLaba">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#cari').click(function() {
            var filter = $('[name="filter"]').val();
            var tanggal = $('[name="tanggal"]').val();
            var bulan = $('[name="bulan"]').val();
            var tahun = $('[name="tahun"]').val();
            $.ajax({
                type: 'POST',
                url: "<?= base_url('Laba_rugi/viewLaba') ?>",
                data: {
                    filter: filter,
                    tanggal: tanggal,
                    bulan: bulan,
                    tahun: tahun,
                },
                beforeSend: function() {
                    document.getElementById("viewLaba").innerHTML = "<tr><td colspan='4'><div class='spinner-border spinner-border-sm' role='status'><span class='sr-only'>Loading...</span></div> Memuat data...</td></tr>";
                },
                success: function(hasil) {
                    $('#viewLaba').html(hasil);
                }
            });
            return false;
        });
    });

    $(document).ready(function() {
        $('#cari').click(function() {
            var filter = $('[name="filter"]').val();
            var tanggal = $('[name="tanggal"]').val();
            var bulan = $('[name="bulan"]').val();
            var tahun = $('[name="tahun"]').val();
            $.ajax({
                type: 'POST',
                url: "<?= base_url('Laba_rugi/viewFilter') ?>",
                data: {
                    filter: filter,
                    tanggal: tanggal,
                    bulan: bulan,
                    tahun: tahun,
                },
                success: function(hasil) {
                    $('#viewFilter').html(hasil);
                }
            });
            return false;
        });
    });
</script>