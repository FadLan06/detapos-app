<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Data Penjualan</a></li>
                            <li class="breadcrumb-item active"><?= $judul ?></li>
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
                        <table class="table table-sm" style="font-size: 12px">
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="200px">No. Transaksi</td>
                                <td width="10px">:</td>
                                <td><b><?= $penjualan['no_transaksi'] ?></b></td>
                            </tr>

                            <?php $pel = $this->db->get_where('tb_pelanggan', ['token' => $penjualan['token'], 'nama_pel' => $penjualan['kode_pelanggan']])->row(); ?>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td>Kode / Nama Pelanggan</td>
                                <td>:</td>
                                <td>
                                    <b>
                                        <?php
                                        if ($penjualan['kode_pelanggan'] == NULL) {
                                            echo 'Umum';
                                        } else {
                                            echo $pel->kode_pel . ' / ' . $pel->nama_pel;
                                        }
                                        ?>
                                    </b>
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td>Tanggal Transaksi</td>
                                <td>:</td>
                                <td><b><?= date('d-m-Y | H:i:s', strtotime($penjualan['timestmp'])) ?></b></td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td>Status</td>
                                <td>:</td>
                                <td>
                                    <b>
                                        <?php
                                        if (($this->session->userdata('token') == 'DPE8DR8MRWKYNHJPV')) {
                                            if ($penjualan['status'] == 'Lunas') {
                                                echo 'LUNAS';
                                            } else {
                                                echo 'PENDING';
                                            }
                                        } else {
                                            if ($penjualan['status'] == 'Lunas') {
                                                echo 'LUNAS';
                                            } else {
                                                echo 'HUTANG';
                                            }
                                        }
                                        ?>
                                    </b>
                                </td>
                            </tr>
                        </table>
                        <h4>Detail Barang</h4>
                        <?= $this->session->flashdata('message') ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" style="font-size: 12px">
                                <?php if (isset($akses1['menu_id'])) : ?>
                                    <thead class="bg-deta text-white" style="font-size: 14px">
                                        <tr class="w3-blue">
                                            <th>#</th>
                                            <th>KODE</th>
                                            <th>BARANG</th>
                                            <th>ITEM</th>
                                            <th>HARGA</th>
                                            <th>POTONGAN</th>
                                            <th width="15%">SUB TOTAL</th>
                                            <th width="15%">RETUR CUSTOMER</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $total_harga = 0; ?>
                                        <?php $no = 1;
                                        foreach ($list_pen as $lp) : ?>
                                            <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$lp[kode_barang]' AND token='$lp[token]'")->row_array(); ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $pen['kode_barang'] ?></td>
                                                <td><?= $pen['nama_barang'] ?></td>
                                                <td><?= $lp['kty'] ?></td>
                                                <td>Rp. <?= number_format($lp['harga']) ?></td>
                                                <td>Rp. <?= number_format($lp['potongan']) ?></td>
                                                <td>Rp. <?= number_format($lp['sub_total']) ?></td>
                                                <td align="center"><a href="" class="btn btn-outline-danger btn-sm" data-target="#returJual" data-toggle="modal" data-id="<?= $lp['kd_penjualan'] ?>" data-no_transaksi="<?= $lp['no_transaksi'] ?>"><i class="fas fa-undo"></i> Retur</a></td>
                                            </tr>
                                            <?php
                                            $total_harga = $total_harga + $lp['sub_total'];
                                            $total = $total_harga - (($total_harga * $penjualan['diskon']) / 100);
                                            $diskon = $total_harga - $total;
                                            $total_bayar = $total_harga - $diskon;
                                            $sisa = $penjualan['bayar'] - $total_bayar;
                                            ?>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr class="w3-light-grey">
                                            <td colspan="5"><b>Total Harga</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total_harga); ?></b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="5"><b>Diskon</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($diskon) . ' (' . $penjualan['diskon'] . '%)'; ?></b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="5"><b>Total Bayar</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total_bayar); ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="5"><b>Pembayaran</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($penjualan['bayar']) ?></b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="5"><b>Kembali</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($sisa) ?></b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php elseif (isset($akses2['menu_id'])) : ?>
                                    <thead class="bg-deta text-white" style="font-size: 14px">
                                        <tr class="w3-blue">
                                            <th>#</th>
                                            <th>KODE</th>
                                            <th>BARANG</th>
                                            <th>ITEM</th>
                                            <th>HARGA</th>
                                            <th>POTONGAN</th>
                                            <th width="15%">SUB TOTAL</th>
                                            <th width="15%">RETUR CUSTOMER</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $total_bayar = 0; ?>
                                        <?php $no = 1;
                                        foreach ($list_pen as $lp) : ?>
                                            <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$lp[kode_barang]' AND token='$lp[token]'")->row_array(); ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $pen['kode_barang'] ?></td>
                                                <td><?= $pen['nama_barang'] ?></td>
                                                <td><?= $lp['kty'] ?></td>
                                                <td>Rp. <?= number_format($lp['harga']) ?></td>
                                                <td>Rp. <?= number_format($lp['potongan']) ?></td>
                                                <td>Rp. <?= number_format($lp['sub_total']) ?></td>
                                                <td align="center"><a href="" class="btn btn-outline-danger btn-sm" data-target="#returJual" data-toggle="modal" data-id="<?= $lp['kd_penjualan'] ?>" data-no_transaksi="<?= $lp['no_transaksi'] ?>"><i class="fas fa-undo"></i> Retur</a></td>
                                            </tr>
                                            <?php
                                            $total_bayar = $total_bayar + $lp['sub_total'];
                                            $diskon = $total_bayar - (($total_bayar * $penjualan['disc']) / 100);
                                            $total = $total_bayar - $diskon;
                                            $sisa = $penjualan['bayar'] - $diskon;
                                            ?>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Sub Total</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total_bayar); ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Diskon</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total) . ' (' . number_format($penjualan['disc']) . '%)'; ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Total Bayar</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($diskon); ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Pembayaran</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($penjualan['bayar']) ?></b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Kembali</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($sisa) ?></b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php elseif (isset($akses['menu_id'])) : ?>
                                    <thead class="bg-deta text-white" style="font-size: 14px">
                                        <tr class="w3-blue">
                                            <th>#</th>
                                            <th>KODE</th>
                                            <th>BARANG</th>
                                            <th>ITEM</th>
                                            <th>HARGA</th>
                                            <th>POTONGAN</th>
                                            <th width="15%">SUB TOTAL</th>
                                            <th width="15%">RETUR CUSTOMER</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $total_bayar = 0; ?>
                                        <?php $no = 1;
                                        foreach ($list_pen as $lp) : ?>
                                            <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$lp[kode_barang]' AND token='$lp[token]'")->row_array(); ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $pen['kode_barang'] ?></td>
                                                <td><?= $pen['nama_barang'] ?></td>
                                                <td><?= $lp['kty'] ?></td>
                                                <td>Rp. <?= number_format($lp['harga']) ?></td>
                                                <td>Rp. <?= number_format($lp['potongan']) ?></td>
                                                <td>Rp. <?= number_format($lp['sub_total']) ?></td>
                                                <td align="center"><a href="" class="btn btn-outline-danger btn-sm" data-target="#returJual" data-toggle="modal" data-id="<?= $lp['kd_penjualan'] ?>" data-no_transaksi="<?= $lp['no_transaksi'] ?>"><i class="fas fa-undo"></i> Retur</a></td>
                                            </tr>
                                            <?php
                                            $total_bayar = $total_bayar + $lp['sub_total'];
                                            $diskon = $total_bayar - (($total_bayar * $penjualan['disc']) / 100);
                                            $total = $total_bayar - $diskon;
                                            $sisa = $penjualan['bayar'] - $diskon;
                                            ?>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Sub Total</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total_bayar); ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Diskon</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total) . ' (' . number_format($penjualan['disc']) . '%)'; ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Total Bayar</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($diskon); ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Pembayaran</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($penjualan['bayar']) ?></b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Kembali</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($sisa) ?></b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php elseif (isset($akses3['menu_id'])) : ?>
                                    <thead class="bg-deta text-white" style="font-size: 14px">
                                        <tr class="w3-blue">
                                            <th>#</th>
                                            <th>KODE</th>
                                            <th>BARANG</th>
                                            <th>ITEM</th>
                                            <th>HARGA</th>
                                            <th>POTONGAN</th>
                                            <th width="15%">SUB TOTAL</th>
                                            <th width="15%">RETUR CUSTOMER</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $total_bayar = 0; ?>
                                        <?php $no = 1;
                                        foreach ($list_pen as $lp) : ?>
                                            <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$lp[kode_barang]' AND token='$lp[token]'")->row_array(); ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $pen['kode_barang'] ?></td>
                                                <td><?= $pen['nama_barang'] ?></td>
                                                <td><?= $lp['kty'] ?></td>
                                                <td>Rp. <?= number_format($lp['harga']) ?></td>
                                                <td>Rp. <?= number_format($lp['potongan']) ?></td>
                                                <td>Rp. <?= number_format($lp['sub_total']) ?></td>
                                                <td align="center"><a href="" class="btn btn-outline-danger btn-sm" data-target="#returJual" data-toggle="modal" data-id="<?= $lp['kd_penjualan'] ?>" data-no_transaksi="<?= $lp['no_transaksi'] ?>"><i class="fas fa-undo"></i> Retur</a></td>
                                            </tr>
                                            <?php
                                            $total_bayar = $total_bayar + $lp['sub_total'];
                                            $diskon = $total_bayar - (($total_bayar * $penjualan['disc']) / 100);
                                            $total = $total_bayar - $diskon;
                                            $sisa = $penjualan['bayar'] - $diskon;
                                            ?>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Sub Total</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total_bayar); ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Diskon</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total) . ' (' . number_format($penjualan['disc']) . '%)'; ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Total Bayar</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($diskon); ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Pembayaran</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($penjualan['bayar']) ?></b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Kembali</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($sisa) ?></b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php elseif (isset($akses4['menu_id'])) : ?>
                                    <thead class="bg-deta text-white" style="font-size: 14px">
                                        <tr class="w3-blue">
                                            <th>#</th>
                                            <th>KODE</th>
                                            <th>BARANG</th>
                                            <th>ITEM</th>
                                            <th>HARGA</th>
                                            <th>POTONGAN</th>
                                            <th width="15%">SUB TOTAL</th>
                                            <th width="15%">RETUR CUSTOMER</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $total_bayar = 0; ?>
                                        <?php $no = 1;
                                        foreach ($list_pen as $lp) : ?>
                                            <?php $pen = $this->db->query("SELECT * FROM tb_barang WHERE kode_barang='$lp[kode_barang]' AND token='$lp[token]'")->row_array(); ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $pen['kode_barang'] ?></td>
                                                <td><?= $pen['nama_barang'] ?><br><?= $lp['varian'] . ' / ' . $lp['ukuran'] ?></td>
                                                <td><?= $lp['kty'] ?></td>
                                                <td>Rp. <?= number_format($lp['harga']) ?></td>
                                                <td>Rp. <?= number_format($lp['potongan']) ?></td>
                                                <td>Rp. <?= number_format($lp['sub_total']) ?></td>
                                                <td align="center"><a href="" class="btn btn-outline-danger btn-sm" data-target="#returJual" data-toggle="modal" data-id="<?= $lp['kd_penjualan'] ?>" data-no_transaksi="<?= $lp['no_transaksi'] ?>"><i class="fas fa-undo"></i> Retur</a></td>
                                            </tr>
                                            <?php
                                            $total_bayar = $total_bayar + $lp['sub_total'];
                                            $diskon = $total_bayar - (($total_bayar * $penjualan['disc']) / 100);
                                            $total = $total_bayar - $diskon;
                                            $sisa = $penjualan['bayar'] - $diskon;
                                            ?>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Sub Total</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total_bayar); ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Diskon</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($total) . ' (' . number_format($penjualan['disc']) . '%)'; ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Total Bayar</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($diskon); ?> </b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Pembayaran</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($penjualan['bayar']) ?></b>
                                            </td>
                                        </tr>
                                        <tr class="w3-light-grey">
                                            <td colspan="6"><b>Kembali</b></td>
                                            <td colspan="2">
                                                <b>Rp. <?= number_format($sisa) ?></b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                        <hr>
                        <span>
                            <a class="btn btn-warning btn-sm" href="<?= base_url('Penjualan') ?>">Kembali</a>

                            <?php if (isset($akses1['menu_id'])) : ?>
                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir_Diskon/Cetak_struk/' . $penjualan['no_transaksi'] ?>'" class="btn btn-deta btn-sm">
                                    <i class="fa fa-print"></i>
                                    <b>Cetak Struk</b>
                                </button>

                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir_Diskon' ?>'" class="btn btn-success btn-sm">
                                    <i class="fa fa-cart-plus"></i>
                                    <b>Transaksi Baru</b>
                                </button>
                            <?php elseif (isset($akses2['menu_id'])) : ?>
                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir_Checkout/Cetak_struk/' . $penjualan['no_transaksi'] ?>'" class="btn btn-deta btn-sm">
                                    <i class="fa fa-print"></i>
                                    <b>Cetak Struk</b>
                                </button>

                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir_Checkout' ?>'" class="btn btn-success btn-sm">
                                    <i class="fa fa-cart-plus"></i>
                                    <b>Transaksi Baru</b>
                                </button>
                            <?php elseif (isset($akses['menu_id'])) : ?>
                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir/Cetak_struk/' . $penjualan['no_transaksi'] ?>'" class="btn btn-deta btn-sm">
                                    <i class="fa fa-print"></i>
                                    <b>Cetak Struk</b>
                                </button>

                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir' ?>'" class="btn btn-success btn-sm">
                                    <i class="fa fa-cart-plus"></i>
                                    <b>Transaksi Baru</b>
                                </button>
                            <?php elseif (isset($akses3['menu_id'])) : ?>
                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir_Retail/Cetak_struk/' . $penjualan['no_transaksi'] ?>'" class="btn btn-deta btn-sm">
                                    <i class="fa fa-print"></i>
                                    <b>Cetak Struk</b>
                                </button>

                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir_Retail' ?>'" class="btn btn-success btn-sm">
                                    <i class="fa fa-cart-plus"></i>
                                    <b>Transaksi Baru</b>
                                </button>
                            <?php elseif (isset($akses4['menu_id'])) : ?>
                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir_Butik/Cetak_struk/' . $penjualan['no_transaksi'] ?>'" class="btn btn-deta btn-sm">
                                    <i class="fa fa-print"></i>
                                    <b>Cetak Struk</b>
                                </button>

                                <button type="button" onclick="location.href='<?= base_url('') . 'Kasir_Butik' ?>'" class="btn btn-success btn-sm">
                                    <i class="fa fa-cart-plus"></i>
                                    <b>Transaksi Baru</b>
                                </button>
                            <?php endif; ?>
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

<div class="modal fade" id="returJual" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalCenterTitle">Retur Barang Customer</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="retur_jual"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#returJual').on('show.bs.modal', function(e) {
            var no_transaksi = $(e.relatedTarget).data('no_transaksi');
            var id = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Penjualan/retur_jual') ?>',
                data: {
                    no_transaksi: no_transaksi,
                    id: id
                },
                success: function(data) {
                    $('.retur_jual').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>