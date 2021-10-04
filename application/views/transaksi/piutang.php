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
                        <?php if ($user['role_id'] == 3) : ?>
                            <button class="btn btn-info btn-sm mt-1" data-toggle="modal" data-target="#lpharian"><i class="fas fa-print"></i> Cetak Laporan Harian</button>
                            <button href="" class="btn btn-success btn-sm mt-1" data-toggle="modal" data-target="#lpbulan"><i class="fas fa-print"></i> Cetak Laporan Minggu/Bulan</button>
                            <hr class="bg-deta">
                        <?php endif; ?>

                        <?= $this->session->flashdata('message') ?>
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead class="center" style="text-align:center; ">
                                    <tr>
                                        <th width="2%">#</th>
                                        <th width="15%">No. Transaksi</th>
                                        <th width="10%">Pelanggan</th>
                                        <th width="12%">Tanggal</th>
                                        <th width="15%">Total</th>
                                        <th width="5%">MetodePem</th>
                                        <th width="10%">Deadline</th>
                                        <th width="10%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($user['role_id'] == 2) : ?>
                                        <?php foreach ($penjualan as $pen) : ?>
                                            <?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $pen->token, 'nama_pel' => $pen->kode_pelanggan])->row(); ?>
                                            <?php $total = $pen->total - (($pen->total * $pen->diskon) / 100); ?>
                                            <?php
                                            $awal  = strtotime($pen->tempo);
                                            $akhir = time(); // Waktu sekarang
                                            $diff  = $awal - $akhir;
                                            $selisih = floor($diff / (60 * 60 * 24)) + 1;
                                            ?>
                                            <tr>
                                                <td align="center"><?= $no++ ?></td>
                                                <td align="center"><?= $pen->no_transaksi ?></td>
                                                <td>
                                                    <?php
                                                    if ($pen->kode_pelanggan == NULL) {
                                                        echo 'Umum';
                                                    } else {
                                                        echo $pel->nama_pel;
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= date('d F Y | H:i:s', strtotime($pen->timestmp)) ?></td>
                                                <td>Rp. <?= number_format($total) ?></td>
                                                <td align="center"><?= $pen->metodePem ?></td>
                                                <td align="center"><?= $selisih > 0 ? $selisih . ' Hari' : 'Expired' ?></td>
                                                <td align="center">
                                                    <?php
                                                    if ($pen->status == 'Lunas') {
                                                        $cl = "btn btn-outline-success";
                                                    } else {
                                                        $cl = "btn btn-outline-danger";
                                                    }
                                                    $status = $pen->status;
                                                    ?>
                                                    <a href="" class="<?= $cl ?> btn-sm" data-target="#ubhstatus" data-toggle="modal" data-id="<?= $pen->no_transaksi ?>"><?= $status ?></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ubhstatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ubah Status</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="ubh_status"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ubhstatus').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Penjualan/ubh_status') ?>',
                data: 'no_transaksi=' + kd,
                success: function(data) {
                    $('.ubh_status').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>