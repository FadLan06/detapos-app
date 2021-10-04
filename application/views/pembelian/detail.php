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
                        <?php $sup = $this->db->get_where('tb_supplier', ['kode_sup' => $tra['kd_supplier'], 'token' => $tra['token']])->row_array(); ?>
                        <table class="table table-sm" style="font-size: 12px">
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="150px">No. Invoice</td>
                                <td width="10px">:</td>
                                <td><b><?= $tra['no_faktur'] ?></b></td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td>Kode / Nama Supplier</td>
                                <td>:</td>
                                <td><b>
                                        <?php if ($tra['kd_supplier'] == '') : ?>
                                            <?= '' ?>
                                        <?php else : ?>
                                            <?php echo $sup['kode_sup'] . ' / ' . $sup['nama_toko']; ?>
                                        <?php endif; ?>
                                    </b></td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td>Tanggal Transaksi</td>
                                <td>:</td>
                                <td><b><?= date('d-m-Y | H:i:s', strtotime($tra['timestmp'])) ?></b></td>
                            </tr>
                        </table>
                        <h4>Detail Barang</h4>
                        <?= $this->session->flashdata('message') ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" style="font-size: 12px">

                                <thead class="bg-deta text-white" style="font-size: 14px">
                                    <tr align="center">
                                        <th>#</th>
                                        <th>KODE</th>
                                        <th>BARANG</th>
                                        <th>ITEM</th>
                                        <th>HARGA</th>
                                        <th>SATUAN</th>
                                        <th>POTONGAN</th>
                                        <th width="15%">SUB TOTAL</th>
                                        <th width="10%">RETUR</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $total_harga = 0; ?>
                                    <?php $no = 1;
                                    foreach ($pembelian as $p) : ?>
                                        <?php $dt = $this->db->get_where('tb_pembelian', ['id_pembelian' => $p['no_faktur']])->row_array(); ?>
                                        <tr align="center">
                                            <td align="center"><?= $no++ ?></td>
                                            <td><?= $p['kode_barang'] ?></td>
                                            <td><?= $p['nama_barang'] ?></td>
                                            <td><?= $p['kty'] ?></td>
                                            <td>Rp. <?= number_format($p['harga_beli']) ?></td>
                                            <td><?= $p['satuan'] ?></td>
                                            <td>Rp. <?= number_format($p['potongan']) ?></td>
                                            <td>Rp. <?= number_format($p['sub_total']) ?></td>
                                            <td align="center">
                                                <a href="" class="btn btn-danger btn-sm" data-target="#mRetur" data-toggle="modal" data-id="<?= $p['kd_pembelian'] ?>" data-no_faktur="<?= $p['no_faktur'] ?>"><i class="fas fa-undo"></i> Retur</a>
                                            </td>
                                        </tr>
                                        <?php
                                        $total_harga = $total_harga + $p['sub_total'];
                                        $diskon = ($total_harga * $dt['diskon']) / 100;
                                        $total_byar = $total_harga - (($total_harga * $dt['diskon']) / 100);
                                        ?>
                                    <?php endforeach; ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td align="right"><b>Total Harga</b></td>
                                        <td align="center">
                                            <b>Rp. <?= number_format($total_harga); ?></b>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td align="right"><b>Diskon</b></td>
                                        <td align="center">
                                            <b>Rp. <?= number_format($diskon); ?> (<?= number_format($dt['diskon']); ?>%)</b>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td align="right"><b>Total</b></td>
                                        <td align="center">
                                            <b>Rp. <?= number_format($total_byar); ?></b>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                        <hr>
                        <span>
                            <a class="btn btn-warning btn-sm" href="<?= base_url('Pembelian') ?>">Kembali</a>

                            <button type="button" onclick="location.href='<?= base_url('') . 'Pembelian/Invoice/' . $tra['no_faktur'] . '/' . $tra['id_pembelian'] ?>'" class="btn btn-primary btn-sm">
                                <i class="fa fa-print"></i>
                                <b>Cetak Invoice</b>
                            </button>

                            <button type="button" onclick="location.href='<?= base_url('') . 'Pembelian/Transaksi' ?>'" class="btn btn-success btn-sm">
                                <i class="fa fa-cart-plus"></i>
                                <b>Transaksi Baru</b>
                            </button>

                            <label class="w3-validate" style="color:red;">
                                <i>*Note : Gunakan Mozilla Firefox Di PC/Laptop Jika Cetak Struk Tidak Berfungsi</i>
                            </label>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mRetur" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalCenterTitle"><b>Detail Pengembalian Barang</b></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="_retur"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#mRetur').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            var no_faktur = $(e.relatedTarget).data('no_faktur');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Pembelian/retur_barang') ?>',
                data: {
                    id: id,
                    no_faktur: no_faktur,
                },
                success: function(data) {
                    $('._retur').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>