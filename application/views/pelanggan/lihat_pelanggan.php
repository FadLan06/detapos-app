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
                            <form action="" method="POST">
                                <div class="form-row mt-1">
                                    <div class="col-auto">
                                        <label class="mr-2">Cari </label>
                                        <select name="report" id="report_pes" class="form-control-sm" required>
                                            <option value="" selected>
                                                <-- Pilih Range -->
                                            </option>
                                            <option value="harian">Range Harian</option>
                                            <option value="minggu">Range Minggu/Bulan</option>
                                        </select>
                                    </div>
                                    <div class="col-auto" id="fs-tanggal">
                                        <label class="sr-only" for="inlineFormInput">Name</label>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control-sm">
                                        <input type="hidden" name="kd_pelanggan" class="form-control" value="<?= $this->uri->segment(3); ?>">
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
                                <form action="<?= base_url('Pelanggan/Range_export') ?>" method="post">
                                    <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                                    <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                                    <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                                    <input type="hidden" name="report" id="report" class="form-control" value="<?= $_POST['report'] ?>">
                                    <input type="hidden" name="token" id="token" class="form-control" value="<?= $this->session->userdata('token') ?>">
                                    <input type="hidden" name="kd_pelanggan" id="kd_pelanggan" class="form-control" value="<?= $this->uri->segment(3); ?>">
                                    <button type="submit" class="btn btn-success mr-1 mt-1 btn-sm"><i class="fas fa-download"></i> Export Data Excel</button>
                                </form>
                            <?php } ?>
                            <?php if (isset($_POST['cari'])) { ?>
                                <form action="<?= base_url('Pelanggan/Range_cetak') ?>" method="post" target="_blank">
                                    <input type="hidden" name="tanggal" id="tanggal" class="form-control" value="<?= $_POST['tanggal'] ?>">
                                    <input type="hidden" name="tgl_awal" id="tgl_awal" class="form-control" value="<?= $_POST['tgl_awal'] ?>">
                                    <input type="hidden" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?= $_POST['tgl_akhir'] ?>">
                                    <input type="hidden" name="report" id="report" class="form-control" value="<?= $_POST['report'] ?>">
                                    <input type="hidden" name="token" id="token" class="form-control" value="<?= $this->session->userdata('token') ?>">
                                    <input type="hidden" name="kd_pelanggan" id="kd_pelanggan" class="form-control" value="<?= $this->uri->segment(3); ?>">
                                    <a href="<?= base_url('Pelanggan/View/') . $this->uri->segment(3) ?>" class="btn btn-warning btn-sm mt-1"><i class="fas fa-sync-alt"></i> Refresh</a>
                                    <button class="btn btn-danger btn-sm mt-1" type="submit" onclick="return valid();"><i class="fas fa-print"></i> Cetak</button>
                                </form>
                            <?php } ?>
                        </div>
                        <hr class="bg-deta">

                        <?php if (isset($_POST['cari'])) { ?>
                            <table width="100%" class="mb-2 mt-0">
                                <tr>
                                    <td width="8%"><b>Range</b></td>
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

                        <?php if (isset($_POST['cari'])) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead align="center">
                                        <tr>
                                            <th>NO</th>
                                            <th>NO. TRANSAKSI</th>
                                            <th>NAMA PELANGGAN</th>
                                            <th>TGL. TRANSAKSI</th>
                                            <th>PETUGAS</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <?php if (!empty($data)) : ?>
                                        <tbody>
                                            <?php $total = 0;
                                            $poto = 0;
                                            $no = 1;
                                            foreach ($data as $pen) { ?>
                                                <?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $pen['token'], 'nama_pel' => $pen['kode_pelanggan']])->row(); ?>
                                                <tr class="bg-light">
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $pen['no_transaksi'] ?></td>
                                                    <td>
                                                        <?php if ($pen['kode_pelanggan'] == NULL) {
                                                            echo 'UMUM';
                                                        } else {
                                                            echo $pel->nama_pel;
                                                        } ?>
                                                    </td>
                                                    <td><?= date('d F Y', strtotime($pen['timestmp'])) ?></td>
                                                    <td><?= $pen['petugas'] ?></td>
                                                    <td></td>
                                                </tr>
                                                <?php $total += $pen['total'] ?>
                                                <?php $poto = $poto + $pen['pot']  ?>
                                                <?php $potto = $pen['pot']  ?>
                                                <?php $per = $pen['diskon']  ?>
                                                <tr align="center">
                                                    <th></th>
                                                    <th>NAMA BARANG</th>
                                                    <th>QTY</th>
                                                    <th>HARGA</th>
                                                    <th>POTONGAN</th>
                                                    <th>SUB TOTAL</th>
                                                </tr>
                                                <?php
                                                $sub = $this->db->query("SELECT *, sum(harga*qty-potongan) as sub_total, sum(qty) as kty FROM tb_detail_penjualan WHERE no_transaksi='$pen[no_transaksi]' AND token='$pen[token]' GROUP BY harga, kode_barang ORDER BY kode_barang");
                                                $count = $sub->num_rows() + 1;
                                                ?>
                                                <tr>
                                                    <td rowspan="<?= $count ?>"></td>
                                                    <?php $ttl_ju = 0;
                                                    foreach ($sub->result() as $data) : ?>
                                                        <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$data->kode_barang' AND token='$data->token'")->row(); ?>
                                                <tr align="center">
                                                    <td><?= $pen->nama_barang ?></td>
                                                    <td><?= $data->kty ?></td>
                                                    <td>RP. <?= number_format($data->harga) ?></td>
                                                    <td>Rp. <?= number_format($data->potongan) ?></td>
                                                    <td>Rp. <?= number_format($data->sub_total) ?></td>
                                                </tr>
                                                <?php $ttl_ju += $data->sub_total; ?>
                                            <?php endforeach; ?>
                                            <?php if ($potto > 0) : ?>
                                                <tr>
                                                    <td colspan="5" align="right"><b>SUB TOTAL</b></td>
                                                    <td align="center"><b>Rp. <?= number_format($ttl_ju) ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" align="right"><b>DISKON</b></td>
                                                    <td align="center"><b>Rp. <?= number_format($potto) . ' (' . number_format($per) . '%)' ?></b></td>
                                                </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td colspan="5" align="right"><b>TOTAL PENJUALAN</b></td>
                                                <td align="center"><b>Rp. <?= number_format($ttl_ju - $potto) ?></b></td>
                                            </tr>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5"><b>Total Pendapatan</b></td>
                                                <td><b>Rp. <?= number_format($total - $poto) ?></b></td>
                                            </tr>
                                        </tfoot>
                                    <?php else : ?>
                                        <tbody>
                                            <tr>
                                                <td colspan='6'>
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
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" style="border-bottom: 1px solid #d3d3d3" id="example">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NO. TRANSAKSI</th>
                                            <th>NAMA PELANGGAN</th>
                                            <th>TGL. TRANSAKSI</th>
                                            <th>PETUGAS</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan='6'>
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
                                </table>
                            </div>
                        <?php } ?>
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