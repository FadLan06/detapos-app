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

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header" align="center">
                        <?php if ($user['produk'] == '3m') {
                            $produk = '50';
                        } elseif ($user['produk'] == '6m') {
                            $produk = '500';
                        } elseif ($user['produk'] == '1y') {
                            $produk = '2000';
                        } else {
                            $produk = '2000';
                        } ?>
                        <?php if (($barang < $produk)) : ?>
                            <a href="<?= base_url('Barang/Tambah_Barang') ?>" class="btn btn-deta btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-plus-circle"></i> Tambah</a>
                            <a href="" class="btn btn-success btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>" data-toggle="modal" data-target="#ModalUploadButik"><i class="fas fa-upload"></i> Upload Data Excel</a>
                        <?php else : ?>
                            <a href="" class="btn btn-deta btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-plus-circle"></i> Tambah 1</a>
                            <a href="" class="btn btn-success btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-upload"></i> Upload Data Excel 1</a>
                        <?php endif; ?>
                        <a href="" class="btn btn-danger btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>" data-toggle="modal" data-target="#ModalBarcode"><i class="fas fa-print"></i> Cetak Barcode</a>
                        <a href="<?= base_url('Barang/export_bar') ?>" class="btn btn-primary btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-download"></i> Download Data Excel</a>
                        <!-- <a href="" class="btn btn-warning btnn btn-sm" data-toggle="modal" data-target="#ModalBarang"><i class="fas fa-eye"></i> Lihat Data Barang</a> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <span id="data_barangB"></span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalUploadButik" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalCenterTitle"><b>Upload Data Barang</b></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('barang/import_data'); ?>
                <div class="form-group mb-3">
                    <label for="file">Upload Data Barang</label>
                    <input type="file" class="form-control" accept=".xlsx, .xls, .csv" id="file" name="file" autocomplete="off" required>
                </div>
                <button type="submit" name="submit_bt" class="btn btn-info float-right"><i class="fas fa-upload"></i> Upload</button>
                <a href="<?= base_url('assets/fileexcel/formatexceluploadbarangbutikk.xls') ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Download Format Excel</a>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('barang/modal'); ?>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ModalBarang').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Barang/detail') ?>',
                data: 'kode_barang=' + kd,
                success: function(data) {
                    $('.mBarang').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<script>
    window.addEventListener('load', ambilBarangB);

    function ambilBarangB() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 1 || xhttp.readyState == 2 || xhttp.readyState == 3) {
                document.getElementById("data_barangB").innerHTML = "<tr><td colspan='7'><div class='spinner-border spinner-border-sm' role='status'><span class='sr-only'>Loading...</span></div> Memuat data...</td></tr>";
            }

            if (xhttp.readyState == 4) {
                document.getElementById("data_barangB").innerHTML = this.responseText;
                var table = $('#ambilBarangBTable').DataTable();
                // table.page('last').draw('page');
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Barang/get_barangB", true);
        xhttp.send();
    }
</script>
<script>
    function to_rupiahb(angka) {
        var rev = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2 = '';
        for (var i = 0; i < rev.length; i++) {
            rev2 += rev[i];
            if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                rev2 += '.';
            }
        }
        return 'Rp. ' + rev2.split('').reverse().join('');
    }
</script>