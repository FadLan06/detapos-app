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
                        <?php if (($this->session->userdata('token') == '0137242275-MQ07B-NAJWN-7VPXY-VYXZH') || (($this->session->userdata('token') == 'DPHNJ3FMWEHPNUG1'))) : ?>
                            <a href="<?= base_url('Barang/Tambah_Barang') ?>" class="btn btn-deta btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-plus-circle"></i> Tambah</a>
                            <a href="" class="btn btn-success btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>" data-toggle="modal" data-target="#ModalUpload"><i class="fas fa-upload"></i> Upload Data Excel</a>
                            <a href="" class="btn btn-danger btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>" data-toggle="modal" data-target="#ModalBarcode"><i class="fas fa-print"></i> Cetak Barcode</a>
                            <a href="" class="btn btn-warning btnn btn-sm" data-toggle="modal" data-target="#ModalBarang"><i class="fas fa-eye"></i> Lihat Data Barang</a>
                        <?php else : ?>
                            <a href="<?= base_url('Barang/Tambah_Barang') ?>" class="btn btn-deta btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-plus-circle"></i> Tambah</a>
                            <a href="" class="btn btn-success btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>" data-toggle="modal" data-target="#ModalUpload"><i class="fas fa-upload"></i> Upload Data Excel</a>
                            <a href="" class="btn btn-danger btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>" data-toggle="modal" data-target="#ModalBarcode"><i class="fas fa-print"></i> Cetak Barcode</a>
                            <a href="<?= base_url('Barang/export_bar') ?>" class="btn btn-primary btnn btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-download"></i> Download Data Excel</a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="ambilBarangETable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="center" style="text-align:center; ">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Kode</th>
                                        <th width="30%">Nama Barang</th>
                                        <th>Harga Modal</th>
                                        <th>Harga Jual</th>
                                        <th width="10%">Stok</th>
                                        <th>Serial</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data_barangE">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

    $(document).ready(function() {
        $('#mSerial').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Barang/cek_serial') ?>',
                data: 'id=' + kd,
                success: function(data) {
                    $('._serial').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<script>
    window.addEventListener('load', ambilBarangE);

    function ambilBarangE() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 1 || xhttp.readyState == 2 || xhttp.readyState == 3) {
                document.getElementById("data_barangE").innerHTML = "<tr><td colspan='7'>Memuat data...</td></tr>";
            }

            if (xhttp.readyState == 4) {
                document.getElementById("data_barangE").innerHTML = this.responseText;
                $('#ambilBarangETable').DataTable();
                // table.page('last').draw('page');
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Barang/get_barangE", true);
        xhttp.send();
    }

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