<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item active"><a href=""><?= $judul ?></a></li>
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
                    <div class="card-header bg-light">
                        <h5><?= $akun['nama_akun'] ?> (<?= $akun['kode_akun'] ?>)
                            <button class="btn btn-warning btn-sm mr-1 float-right" onclick="location.href='<?= base_url('Kas_Bank') ?>'" type="button"><i class="fas fa-return"></i>Kembali</button>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm" id="datatabledetail" width="100%">
                                <thead align="center" class="bg-deta text-white">
                                    <tr>
                                        <th width="2%">#</th>
                                        <th width="30%">Keterangan</th>
                                        <th width="15%">Tanggal</th>
                                        <th width="15%">Terima</th>
                                        <th width="15%">Keluar</th>
                                        <th width="15%">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody id="viewDetail">
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
        var id = '<?= $this->uri->segment(3); ?>';

        $.ajax({
            type: 'POST',
            url: "<?= base_url('Kas_Bank/viewDetail') ?>",
            data: {
                id: id
            },
            success: function(hasil) {
                $('#viewDetail').html(hasil);
                var table = $('#datatabledetail').DataTable();
                table.page('last').draw('page');
            }
        });
    });
</script>