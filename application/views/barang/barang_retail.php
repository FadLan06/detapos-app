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
                            <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead style="text-align:center; ">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Kode</th>
                                        <th width="30%">Nama Barang</th>
                                        <th>Harga Modal</th>
                                        <th>Harga Jual</th>
                                        <th width="10%">Terjual / Stok</th>
                                        <th>Retur Supplier</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data_barangR">
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

</script>
<script>

    ambilBarangR();

    function ambilBarangR() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>Barang/get_barangR',
            async: false,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    $returr = '<a href="" class="btn btn-warning btn-sm" data-target="#mRetur" data-toggle="modal" data-id="' + data[i].id + '"><i class="fas fa-undo"></i> Retur</a>';
                    $aksir = '<a href="<?= base_url('Barang/Ubah_Barang/') ?>' + data[i].id + '"><i class="fas fa-edit"></i></a> <a href="<?= base_url('Barang/Hapus_brng/') ?>' + data[i].id + '/' + data[i].kode_barang + '" onclick="return confirm("Yakin anda ?")"><i class="fas fa-trash text-danger"></i></a>';

                    if (data[i].harga_jual2 == '0' || data[i].harga_jual2 == null) {
                        $dis2 = 'none';
                    } else {
                        $dis2 = '';
                    }

                    if (data[i].harga_jual1 == '0' || data[i].harga_jual1 == null) {
                        $dis1 = 'none';
                    } else {
                        $dis1 = '';
                    }

                    if (data[i].harga_jual == '0' || data[i].harga_jual == null) {
                        $dis = 'none';
                    } else {
                        $dis = '';
                    }

                    html += '<tr>' +
                        '<td width="5%" align="center">' + no++ + '</td>' +
                        '<td>' + data[i].kode + '</td>' +
                        '<td>' + data[i].nama_barang + '</td>' +
                        '<td align="center">' + to_rupiahb(data[i].harga_beli) + '</td>' +
                        '<td align="center"><li style="list-style-type: none; display: ' + $dis + '">' + to_rupiahb(data[i].harga_jual) + '</li><li style="list-style-type: none; display: ' + $dis1 + '">' + to_rupiahb(data[i].harga_jual1) + '</li><li style="list-style-type: none; display: ' + $dis2 + '">' + to_rupiahb(data[i].harga_jual2) + '</li></td>' +
                        '<td width="10%" style="text-align: center;">' + data[i].jml_stok + '</td>' +
                        '<td width="10%" style="text-align: center;">' + $returr + '</td>' +
                        '<td style="text-align:center; width:10%">' + $aksir + '</td>' +
                        '</tr>';
                }
                $('#data_barangR').html(html);

            }

        });
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