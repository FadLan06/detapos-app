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
                                        <label class="sr-only" for="inlineFormInputGroup">Username</label>
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
                                        <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                        <select class="form-control-sm" id="tahun" name="tahun" autocomplate="off">
                                            <option selected>
                                                <-- Pilih Tahun -->
                                            </option>
                                            <?php foreach ($tahun as $th) : ?>
                                                <?php $data = explode('-', $th['tgl_rekon_tmp']);
                                                $tah = $data[0]; ?>
                                                <option value="<?= $tah ?>"><?= $tah ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button class="mr-1 btn btn-danger btn-sm" type="submit" name="cari"><i class="fas fa-search"></i> Cari</button>
                                        <button class="mr-1 btn btn-deta btn-sm" type="button" name="cari" <?= $akses->tambah != 1 ? 'disabled' : '' ?> data-toggle="modal" data-target="#tambahRek"><i class="fas fa-plus-circle"></i> Tambah</button>
                                    </div>
                                </div>
                            </form>
                            <?php if (isset($_POST['cari'])) { ?>
                                <form action="<?= base_url('Data_setoran/Export') ?>" method="post">
                                    <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                                    <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                                    <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                                    <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                                    <button type="submit" class="btn btn-success mr-1 btn-sm"><i class="fas fa-download"></i> Export Data Excel</button>
                                </form>
                            <?php } ?>
                            <?php if (isset($_POST['cari'])) { ?>
                                <form action="<?= base_url('Data_setoran/Cetak') ?>" method="post" target="_blank">
                                    <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                                    <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                                    <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                                    <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                                    <a href="<?= base_url('Data_setoran') ?>" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    <button class="btn btn-primary btn-sm" type="submit" onclick="return valid();"><i class="fas fa-print"></i> Cetak</button>
                                </form>
                            <?php } ?>
                        </div>
                        <hr class="bg-deta">
                        <?php if (isset($_POST['cari'])) { ?>
                            <table width="100%" class="mb-2 mt-0">
                                <tr>
                                    <td width="13%"><b>Periode</b></td>
                                    <td width="2%"><b>:</b></td>
                                    <td><b>
                                            <?php
                                            if ($_POST['filter'] == '2') {

                                                if ($_POST['bulan'] == 1) {
                                                    $bulan = 'Januari';
                                                } elseif ($_POST['bulan'] == 2) {
                                                    $bulan = 'Februari';
                                                } elseif ($_POST['bulan'] == 3) {
                                                    $bulan = 'Maret';
                                                } elseif ($_POST['bulan'] == 4) {
                                                    $bulan = 'April';
                                                } elseif ($_POST['bulan'] == 5) {
                                                    $bulan = 'Mei';
                                                } elseif ($_POST['bulan'] == 6) {
                                                    $bulan = 'Juni';
                                                } elseif ($_POST['bulan'] == 7) {
                                                    $bulan = 'Juli';
                                                } elseif ($_POST['bulan'] == 8) {
                                                    $bulan = 'Agustus';
                                                } elseif ($_POST['bulan'] == 9) {
                                                    $bulan = 'September';
                                                } elseif ($_POST['bulan'] == 10) {
                                                    $bulan = 'Oktober';
                                                } elseif ($_POST['bulan'] == 11) {
                                                    $bulan = 'November';
                                                } elseif ($_POST['bulan'] == 12) {
                                                    $bulan = 'Desember';
                                                }
                                                echo 'Bulan ' . $bulan . ' Tahun ' . $_POST['tahun'];
                                            } elseif ($_POST['filter'] == '3') {
                                                echo 'Tahun ' . $_POST['tahun'];
                                            } elseif ($_POST['filter'] == '1') {
                                                echo longdate_indo($_POST['tanggal']);
                                            } else {
                                                echo 'Semua Periode';
                                            }
                                            ?>
                                        </b></td>
                                </tr>
                            </table>

                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                <table id="datatable" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%" rowspan="2" style="vertical-align: middle;">#</th>
                                            <th width="15%" rowspan="2" style="vertical-align: middle;">TANGGAL</th>
                                            <th width="40%" rowspan="2" style="vertical-align: middle;">URAIAN</th>
                                            <th colspan="2">EXPEDISI</th>
                                            <th rowspan="2" width="10%" style="vertical-align: middle;">AKSI</th>
                                        </tr>
                                        <tr>
                                            <th>BANK</th>
                                            <th>TUNAI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $all = 0;
                                        $all1 = 0;
                                        foreach ($setoran->result_array() as $data) : ?>
                                            <?php $tmp = $this->db->get_where('tb_setoran_tmp', ['token' => $data['token'], 'no_setoran' => $data['no_setoran']])->result();
                                            $ttl = 0;
                                            $ttl1 = 0;
                                            ?>
                                            <?php foreach ($tmp as $dt) : ?>
                                                <?php if ($dt->expedisi == 'T') {
                                                    $tunai = $dt->nominal;
                                                    $bank = 0;
                                                    $ttl += $tunai;
                                                    $id = $dt->id_setoran_tmp;
                                                } else {
                                                    $bank = $dt->nominal;
                                                    $tunai = 0;
                                                    $ttl1 += $bank;
                                                    $id = $dt->id_setoran_tmp;
                                                } ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= date('d F Y', strtotime($data['tgl_setoran'])) ?></td>
                                                    <td align="left"><?= $data['uraian'] ?></td>
                                                    <td>
                                                        <?php if ($bank == 0) : ?>
                                                            Rp. <?= number_format($bank) ?>
                                                        <?php else : ?>
                                                            <a href="javascript:void(0)" style="text-decoration: none;" data-target="#detail" data-toggle="modal" data-id="<?= $id ?>">Rp. <?= number_format($bank) ?></a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($tunai == 0) : ?>
                                                            Rp. <?= number_format($tunai) ?>
                                                        <?php else : ?>
                                                            <a href="javascript:void(0)" style="text-decoration: none;" data-target="#detailTU" data-toggle="modal" data-id="<?= $id ?>">Rp. <?= number_format($tunai) ?></a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-info <?= $akses->ubah != 1 ? 'disabled' : '' ?>" title="ubah" data-toggle="modal" data-target="#ubahSet" data-id="<?= $dt->no_setoran ?>"><i class="fas fa-edit"></i></a>
                                                        <a href="<?= base_url('Data_setoran/hapus/' . $dt->no_setoran) ?>" class="btn btn-sm btn-danger <?= $akses->hapus != 1 ? 'disabled' : '' ?>" title="hapus" onclick="return confirm('Yakin hapus data ?')"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $all   +=  $ttl;
                                                $all1 +=   $ttl1;
                                                ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"><b>TOTAL</b></td>
                                            <td><b>Rp. <?= number_format($all1) ?></b></td>
                                            <td><b>Rp. <?= number_format($all) ?></b></td>
                                            <td><b>-</b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahRek" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Setoran</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= base_url('Data_setoran/Aksi') ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="inputAddress">Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tgl_setoran" id="inputAddress" placeholder="1234 Main St" value="<?php echo date("Y-m-d"); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Uraian</label>
                        <textarea class="form-control" name="uraian" id="uraian" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Nominal</label>
                            <input type="number" class="form-control" id="inputCity" name="nominal" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState">Expedisi</label>
                            <select class="form-control" id="expedisi" name="expedisi" required>
                                <option selected disabled>
                                    <-- Pilih Posisi -->
                                </option>
                                <option value="B">BANK</option>
                                <option value="T">TUNAI</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row" id="bank">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Rekening</label>
                            <!-- <input type="number" class="form-control" id="inputCity" name="no_rek"> -->
                            <select name="rekening" id="rekening" class="form-control">
                                <option selected disabled>
                                    <-- Pilih Rekening -->
                                </option>
                                <option value="81826599 BNI - Hans Lamusu">81826599 BNI - Hans Lamusu</option>
                                <option value="151 000 423 7977 Mandiri - Hans Lamusu">151 000 423 7977 Mandiri - Hans Lamusu</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">Bukti</label>
                            <input type="file" class="form-control" id="inputCity" name="bukti">
                        </div>
                    </div>
                    <div class="form-row" id="tunai">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Nm. Penerima</label>
                            <input type="text" class="form-control" id="inputCity" name="nm_pen">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">Posisi</label>
                            <input type="text" class="form-control" id="inputCity" name="posisi">
                        </div>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-danger float-right">Simpan</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                </form>
                <script src="<?= base_url('assets/') ?>jquery-3.4.1.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#bank, #tunai').hide();

                        $('#expedisi').change(function() {
                            if ($(this).val() == 'B') {
                                $('#bank').show();
                                $('#tunai').hide();
                            } else if ($(this).val() == 'T') {
                                $('#bank').hide();
                                $('#tunai').show();
                            }

                            $('#expedisi select').val('');
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalLabel">Detail Expedisi Bank</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="_detailBank"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailTU" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalLabel">Detail Expedisi Tunai</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="_detailTunai"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ubahSet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data Setoran</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="_ubahSet"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ubahSet').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Data_setoran/ubah_setoran') ?>',
                data: 'id=' + id,
                success: function(data) {
                    $('._ubahSet').html(data); //menampilkan data ke dalam modal
                }
            });
        });

        $('#detail').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Data_setoran/detail_bank') ?>',
                data: 'id=' + id,
                success: function(data) {
                    $('._detailBank').html(data); //menampilkan data ke dalam modal
                }
            });
        });

        $('#detailTU').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Data_setoran/detail_tunai') ?>',
                data: 'id=' + id,
                success: function(data) {
                    $('._detailTunai').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>