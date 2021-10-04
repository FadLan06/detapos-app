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

        <div class="card m-b-30">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <form action="" method="POST">
                                <div class="form-row mt-1">
                                    <div class="col-auto">
                                        <label class="mr-2">Cari </label>
                                        <select name="report" id="report_pes" class="form-control-sm" required>
                                            <option value="" selected>
                                                <-- Pilih Report -->
                                            </option>
                                            <option value="harian">Report Harian</option>
                                            <option value="minggu">Report Minggu/Bulan</option>
                                        </select>
                                    </div>
                                    <div class="col-auto" id="fs-tanggal">
                                        <label class="sr-only" for="inlineFormInput">Name</label>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control-sm">
                                    </div>
                                    <div class="form-row" id="fs-range">
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
                                        <button class="mr-1 btn btn-deta btn-sm" type="submit" name="cari"><i class="fas fa-search"></i> Cari</button>
                                    </div>
                                </div>
                            </form>
                            <?php if (isset($_POST['cari'])) { ?>
                                <form action="<?= base_url('Pesanan/Report_export') ?>" method="post">
                                    <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                                    <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                                    <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                                    <input type="hidden" name="report" id="report" class="form-control" value="<?= $_POST['report'] ?>">
                                    <button type="submit" class="btn btn-success mr-1 mt-1 btn-sm"><i class="fas fa-download"></i> Export Data Excel</button>
                                </form>
                            <?php } ?>
                            <?php if (isset($_POST['cari'])) { ?>
                                <form action="<?= base_url('Pesanan/Report_cetak') ?>" method="post" target="_blank">
                                    <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                                    <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                                    <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                                    <input type="hidden" name="report" id="report" class="form-control" value="<?= $_POST['report'] ?>">
                                    <a href="<?= base_url('Pesanan/Report') ?>" class="btn btn-warning btn-sm mt-1"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    <button class="btn btn-danger btn-sm mt-1" type="submit" onclick="return valid();"><i class="fas fa-print"></i> Cetak</button>
                                </form>
                            <?php } ?>
                        </div>
                        <hr class="bg-deta">

                        <?php if (isset($_POST['cari'])) { ?>
                            <table width="100%" class="mb-2 mt-0">
                                <tr>
                                    <td width="8%"><b>Report</b></td>
                                    <td width="2%"><b>:</b></td>
                                    <td>
                                        <b>
                                            <?php if ($_POST['report'] == 'harian') {
                                                echo 'Harian (' . $_POST['tanggal'] . ')';
                                            } elseif ($_POST['report'] == 'minggu') {
                                                echo 'Minggu/Bulan (' . $_POST['tgl_awal'] . ' sampai ' . $_POST['tgl_akhir'] . ')';
                                            } elseif ($_POST['report'] == 'terlaris') {
                                                echo 'Terlaris';
                                            } ?>
                                        </b>
                                    </td>
                                </tr>
                            </table>
                        <?php } ?>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead align="center">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>KODE BARANG</th>
                                        <th>NAMA BARANG</th>
                                        <th>MODAL</th>
                                        <th>JUAL</th>
                                        <th width="5%">TERJUAL</th>
                                        <th>KEUNTUNGAN</th>
                                    </tr>
                                </thead>
                                <?php if (isset($_POST['cari'])) { ?>
                                    <?php if (!empty($dataa)) : ?>
                                        <tbody>
                                            <?php $no = 1;
                                            $tt = 0;
                                            $ttl = 0; ?>
                                            <?php foreach ($dataa as $shop) : ?>
                                                <?php if ($_POST['report'] == 'harian') : ?>
                                                    <?php $dt = $this->db->query("SELECT a.kode_barang, a.nama_barang, a.token, a.harga_beli, b.id_barang, SUM(b.qty) as kty, b.status_bayar, c.id_barang as kd_hg, c.harga_jual FROM tb_shop_detail b LEFT JOIN tb_barang a ON a.kode_barang=b.id_barang LEFT JOIN tb_barang_harga c ON c.id_barang=a.kode_barang WHERE b.token='$shop[token]' AND b.tgl_order_detail='$_POST[tanggal]' AND b.status_bayar='1' AND b.id_barang='$shop[id_barang]' GROUP BY b.id_barang")->row_array(); ?>
                                                <?php else : ?>
                                                    <?php $dt = $this->db->query("SELECT a.kode_barang, a.nama_barang, a.token, a.harga_beli, b.id_barang, SUM(b.qty) as kty, b.status_bayar, c.id_barang as kd_hg, c.harga_jual FROM tb_shop_detail b LEFT JOIN tb_barang a ON a.kode_barang=b.id_barang LEFT JOIN tb_barang_harga c ON c.id_barang=a.kode_barang WHERE b.token='$shop[token]' AND b.tgl_order_detail BETWEEN '$_POST[tgl_awal]' AND '$_POST[tgl_akhir]' AND b.status_bayar='1' AND b.id_barang='$shop[id_barang]' GROUP BY b.id_barang")->row_array(); ?>
                                                <?php endif; ?>
                                                <?php $ken = ($dt['harga_jual'] * $shop['kkty']) - ($dt['harga_beli'] * $shop['kkty']); ?>
                                                <tr>
                                                    <td align="center"><?= $no++ ?></td>
                                                    <td><?= $dt['id_barang'] ?></td>
                                                    <td><?= $dt['nama_barang'] ?></td>
                                                    <td>Rp. <span class="float-right"><?= number_format($dt['harga_beli']) ?></span></td>
                                                    <td>Rp. <span class="float-right"><?= number_format($dt['harga_jual']) ?></span></td>
                                                    <td align="center"><?= $shop['kkty'] ?></td>
                                                    <td>Rp. <span class="float-right"><?= number_format($ken) ?></span></td>
                                                </tr>
                                                <?php $tt += $shop['kkty']; ?>
                                                <?php $ttl += $ken; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" align="center"><b>TOTAL</b></td>
                                                <td align="center"><b><?= $tt ?></b></td>
                                                <td>Rp. <b class="float-right"><?= number_format($ttl) ?></b></td>
                                            </tr>
                                        </tfoot>
                                    <?php else : ?>
                                        <tbody>
                                            <tr>
                                                <td colspan='7'>
                                                    <i>
                                                        <center>
                                                            -----------
                                                            Tidak Ada Data
                                                            -----------
                                                        </center>
                                                    </i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php endif; ?>
                                <?php } else { ?>
                                    <tbody>
                                        <tr>
                                            <td colspan='7'>
                                                <i>
                                                    <center>
                                                        -----------
                                                        Tidak Ada Data
                                                        -----------
                                                    </center>
                                                </i>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php } ?>
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
        $('#fs-bulan, #fs-tahun, #fs-tanggal, #fs-range, #fill').hide();

        $('#report_pes').change(function() {
            if ($(this).val() == 'harian') {
                $('#fs-tanggal').show();
                $('#fs-bulan, #fs-tahun, #fill, #fs-range').hide();
            } else if ($(this).val() == 'minggu') {
                $('#fs-range').show();
                $('#fill, #fs-bulan, #fs-tahun, #fs-tanggal').hide();
            } else if ($(this).val() == '') {
                $('#fs-bulan, #fs-tahun, #fs-tanggal, #fs-range, #fill').hide();
            }

            $('#bulan select, #tahun select').val('');
        })
    })
</script>