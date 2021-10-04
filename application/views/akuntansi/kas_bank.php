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
                    <div class="card-header bg-light">
                        <button class="btn btn-deta btn-sm mr-1 float-right" type="button" data-target="#tmbhakun" data-toggle="modal" <?= $akses->tambah != 1 ? 'disabled' : '' ?>><i class="fas fa-plus-circle"></i> Tambah Saldo Bank</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm" id="datatablebank" width="100%">
                                <thead align="center" class="bg-deta text-white">
                                    <tr>
                                        <th width="5%">NO</th>
                                        <th width="15%">Kode Akun</th>
                                        <th width="25%">AKUN</th>
                                        <th width="20%">Saldo Bank</th>
                                        <th>Saldo Jurnal</th>
                                    </tr>
                                </thead>
                                <tbody id="viewKasBank">
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
        $.ajax({
            type: 'POST',
            url: "<?= base_url('Kas_Bank/viewKasBank') ?>",
            success: function(hasil) {
                $('#viewKasBank').html(hasil);
                $('#datatablebank').DataTable({
                    "order": [
                        [0, 'asc']
                    ]
                });
            }
        });
    });
</script>