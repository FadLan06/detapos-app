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
                                            <option value="4">Range Tanggal</option>
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
                                    <div class="form-row" id="f-range">
                                        <div class="col-auto">
                                            <label class="sr-only" for="inlineFormInput">Name</label>
                                            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control-sm">
                                        </div>
                                        <div class="col-auto">
                                            <label class="sr-only" for="inlineFormInput">Name</label>
                                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="mr-1 btn btn-danger btn-sm" type="submit" name="cari"><i class="fas fa-search"></i> Cari</button>
                                        <button class="mr-1 btn btn-deta btn-sm" type="button" name="cari" <?= $akses->tambah != 1 ? 'disabled' : '' ?> data-toggle="modal" data-target="#tambahRek"><i class="fas fa-plus-circle"></i> Tambah</button>
                                    </div>
                                </div>
                            </form>
                            <?php if (isset($_POST['cari'])) { ?>
                                <form action="<?= base_url('Data_rekon/Export_final') ?>" method="post">
                                    <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                                    <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                                    <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                                    <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                                    <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                                    <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                                    <button type="submit" class="btn btn-success mr-1 btn-sm"><i class="fas fa-download"></i> Export Data Excel</button>
                                </form>
                            <?php } ?>
                            <?php if (isset($_POST['cari'])) { ?>
                                <form action="<?= base_url('Data_rekon/Cetak_final') ?>" method="post" target="_blank">
                                    <input type="hidden" name="filter" id="filter" class="form-control" value="<?= $_POST['filter'] ?>">
                                    <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                                    <input type="hidden" name="bulan" id="bulan" class="form-control" value="<?= $_POST['bulan'] ?>">
                                    <input type="hidden" name="tahun" id="tahun" class="form-control" value="<?= $_POST['tahun'] ?>">
                                    <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                                    <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                                    <a href="<?= base_url('Data_rekon/Final_rekon') ?>" class="btn btn-warning btn-sm"><i class="fas fa-sync-alt"></i> Refresh</a>
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
                                                echo 'Tanggal ' . $_POST['tanggal'];
                                            } elseif ($_POST['filter'] == '4') {
                                                echo 'Dari ' . $_POST['tgl_awal'] . ' sampai ' . $_POST['tgl_akhir'];
                                            } else {
                                                echo 'Semua Periode';
                                            }
                                            ?>
                                        </b></td>
                                </tr>
                            </table>

                            <div class="row">
                                <?php $no = 1;
                                foreach ($final->result_array() as $data) : ?>
                                    <?php $detail = $this->db->get_where('tb_rekon_final', ['token' => $data['token'], 'tgl_final' => $data['tgl_final']]); ?>
                                    <div class="col-md-12">
                                        <p><b>FINALISASI DATA REKON <br /> Tanggal</b> : <?= longdate_indo($data['tgl_final']) ?></p>
                                        <table class="table table-bordered" width="100%" style="text-align:center;">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="30%">Uraian</th>
                                                    <th width="15%">Debet</th>
                                                    <th width="15%">Kredit</th>
                                                    <th width="15%">Saldo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $ang = 1;
                                                $saldo = 0;
                                                foreach ($detail->result_array() as $dt) : ?>
                                                    <?php if ($dt['tipe'] == 'D') {
                                                        $uraian           =   $dt['uraian'];
                                                        $kolom_debet    =   $dt['nominal'];
                                                        $kolom_kredit   =   "0";
                                                        $saldo = $saldo + $kolom_debet - $kolom_kredit;
                                                    } elseif ($dt['tipe'] == 'K') {
                                                        $uraian           =   $dt['uraian'];
                                                        $kolom_kredit   =   $dt['nominal'];
                                                        $kolom_debet    =   "0";
                                                        $saldo = $saldo - $kolom_kredit;
                                                    } ?>
                                                    <tr>
                                                        <td><?= $ang++ ?></td>
                                                        <td align="left"><?= $dt['uraian'] ?>
                                                            <div class="finall"><a href="" class="badge badge-info link" data-target="#ubahFinal" data-toggle="modal" data-id="<?= $dt['id_rekon_final'] ?>">ubah</a><a href="<?= base_url('Data_rekon/hapus_final/' . $dt['id_rekon_final']) ?>" class="badge badge-danger link ml-2" onclick="return confirm('Yakin hapus data ?')">hapus</a></div>
                                                        </td>
                                                        <td><?= number_format($kolom_debet) ?></td>
                                                        <td><?= number_format($kolom_kredit) ?></td>
                                                        <td><?= number_format($saldo) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endforeach; ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Final Rekon</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $saldo = 0;
                $this->db->order_by('id_rekon_tmp', 'desc');
                $rek = $this->db->get_where('tb_rekon_tmp', ['token' => $this->session->userdata('token')])->result();
                foreach ($rek as $rekon) {
                    if (!empty($rekon)) {
                        if ($rekon->tipe == 'D') {
                            $kolom_debet    =   $rekon->nominal;
                            $kolom_kredit   =   "0";
                            $saldo = $saldo + $kolom_debet - $kolom_kredit;
                        } elseif ($rekon->tipe == 'K') {
                            $kolom_kredit   =   $rekon->nominal;
                            $kolom_debet    =   "0";
                            $saldo = $saldo - $kolom_kredit;
                        }
                    }
                } ?>
                <?php $tgl = date('Y-m-d');
                $final = $this->db->get_where('tb_rekon_final', ['token' => $this->session->userdata('token'), 'tgl_final' => $tgl])->row(); ?>
                <?php if (!empty($final)) : ?>
                    <form method="POST" action="<?= base_url('Data_rekon/Aksi') ?>">
                        <div class="form-group">
                            <label for="inputAddress">Tanggal Transaksi</label>
                            <input type="date" class="form-control" name="tgl_rekon" id="inputAddress" placeholder="1234 Main St" value="<?php echo date("Y-m-d"); ?>" required>
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
                                <label for="inputState">Posisi</label>
                                <select id="inputState" class="form-control" name="tipe" required>
                                    <option selected disabled>
                                        <-- Pilih Posisi -->
                                    </option>
                                    <option value="D">Debet</option>
                                    <option value="K">Kredit</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="simpan_final" class="btn btn-danger float-right">Simpan</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                    </form>
                <?php else : ?>
                    <form method="POST" action="<?= base_url('Data_rekon/Aksi') ?>">
                        <div class="form-group">
                            <label for="inputAddress">Tanggal Transaksi</label>
                            <input type="date" class="form-control" name="tgl_rekon" id="inputAddress" placeholder="1234 Main St" value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Uraian</label>
                            <textarea class="form-control" name="uraian" id="uraian" required>Hasil Rekon Tanggal <?= date('d F Y', strtotime($rekon->tgl_rekon_tmp)) ?></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nominal</label>
                                <input type="number" class="form-control" id="inputCity" name="nominal" value="<?= $saldo ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState">Posisi</label>
                                <select id="inputState" class="form-control" name="tipe" required>
                                    <option value="D" selected>Debet</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="simpan_final" class="btn btn-danger float-right">Simpan</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ubahFinal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data Final Rekon</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="_ubahFinal"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ubahFinal').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Data_rekon/ubah_final_rekon') ?>',
                data: 'id_final=' + id,
                success: function(data) {
                    $('._ubahFinal').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>