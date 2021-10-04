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
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills nav-justified" role="tablist">
                            <li class="nav-item waves-effect waves-light" style="border: 1px solid #00aaff; border-radius: 10px; margin: 0px 5px">
                                <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">Semua</a>
                            </li>
                            <li class="nav-item waves-effect waves-light" style="border: 1px solid #00aaff; border-radius: 10px; margin: 0px 5px">
                                <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">Diproses</a>
                            </li>
                            <li class="nav-item waves-effect waves-light" style="border: 1px solid #00aaff; border-radius: 10px; margin: 0px 5px">
                                <a class="nav-link" data-toggle="tab" href="#messages-1" role="tab">Dikirim</a>
                            </li>
                            <li class="nav-item waves-effect waves-light" style="border: 1px solid #00aaff; border-radius: 10px; margin: 0px 5px">
                                <a class="nav-link" data-toggle="tab" href="#settings-1" role="tab">Selesai</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <!-- Semua -->
                            <div class="tab-pane active mt-3 table-responsive" id="home-1" role="tabpanel">
                                <table class="table table-sm table-bordered" id="pesanTable" cellspacing="0" width="100%">
                                    <thead>
                                        <tr align="center">
                                            <th width="3%">#</th>
                                            <th width="20%">Order ID</th>
                                            <th width="20%">Tanggal</th>
                                            <th>Expedisi</th>
                                            <th width="15%">Total Bayar</th>
                                            <th width="15%">Status</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showPesanan">

                                    </tbody>
                                </table>
                            </div>
                            <!-- Diproses -->
                            <div class="tab-pane mt-3 table-responsive" id="profile-1" role="tabpanel">
                                <table class="table table-sm table-bordered" id="prosesTable" cellspacing="0" width="100%">
                                    <thead>
                                        <tr align="center">
                                            <th width="3%">#</th>
                                            <th width="20%">Order ID</th>
                                            <th width="20%">Tanggal</th>
                                            <th>Expedisi</th>
                                            <th width="15%">Total Bayar</th>
                                            <th width="15%">Status</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showProses">

                                    </tbody>
                                </table>
                            </div>
                            <!-- Dikirim -->
                            <div class="tab-pane mt-3 table-responsive" id="messages-1" role="tabpanel">
                                <table class="table table-sm table-bordered" id="kirimTable" cellspacing="0" width="100%">
                                    <thead>
                                        <tr align="center">
                                            <th width="3%">#</th>
                                            <th width="20%">Order ID</th>
                                            <th width="20%">Tanggal</th>
                                            <th>Expedisi</th>
                                            <th width="15%">Total Bayar</th>
                                            <th width="15%">NO. RESI</th>
                                            <th width="10%">Tracking</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showKirim">

                                    </tbody>
                                </table>
                            </div>
                            <!-- Selesai -->
                            <div class="tab-pane mt-3 table-responsive" id="settings-1" role="tabpanel">
                                <table class="table table-sm table-bordered" id="selesaiTable" cellspacing="0" width="100%">
                                    <thead>
                                        <tr align="center">
                                            <th width="3%">#</th>
                                            <th width="20%">Order ID</th>
                                            <th width="20%">Tanggal</th>
                                            <th>Expedisi</th>
                                            <th width="15%">Total Bayar</th>
                                            <th width="10%">Status</th>
                                            <th width="15%">NO. RESI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showSelesai">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach ($shop as $dataa) : ?>
    <div class="modal fade" id="verifikasi<?= $dataa->order_id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-deta">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Pesanan - <?= $dataa->order_id ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <h6><b>Detail Pembelian</b></h6>
                    <hr class="bg-deta">
                    <div class="col-md-12 pesan">
                        <table class="table" width='100%'>
                            <thead>
                                <tr>
                                    <th width="15%">Order ID</th>
                                    <th width="30%">Nama Barang</th>
                                    <th width="20%">Harga</th>
                                    <th>Jumlah</th>
                                    <th width="20%">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $detail = $this->db->get_where('tb_shop_detail', ['token' => $dataa->token, 'order_id' => $dataa->order_id])->result(); ?>
                                <?php $pel = $this->db->get_where('tb_shop_pel', ['id_shop_pel' => $dataa->id_shop_pel])->row(); ?>
                                <?php foreach ($detail as $data) : ?>
                                    <?php $barang = $this->db->get_where('tb_barang', ['kode_barang' => $data->id_barang])->row(); ?>
                                    <?php
                                    $harga = $this->db->get_where('tb_barang_harga', ['id_barang' => $data->id_barang])->row();
                                    $harga_r = $this->db->get_where('tb_barang_harga_reseller', ['id_barang' => $data->id_barang])->row();
                                    if ($pel->reseller == 1) {
                                        $hg = $harga_r->harga_reseller;
                                        $subtotal = $data->qty * $hg;
                                    } else {
                                        $hg = $harga->harga_jual;
                                        $subtotal = $data->qty * $hg;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $data->order_id ?></td>
                                        <td><?= $barang->nama_barang ?></td>
                                        <td>Rp. <?= number_format($hg) ?></td>
                                        <td align="center"><?= $data->qty ?></td>
                                        <td>Rp. <?= number_format($subtotal) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" align="right"><b>Total</b></td>
                                    <td>Rp. <?= number_format($dataa->total) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Expedisi</b></td>
                                    <td><?= '<b>' . strtoupper($dataa->expedisi) . '</b> - ' . $dataa->paket . ' - Rp. ' . number_format($dataa->ongkir) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Kode Unik</b></td>
                                    <td>
                                        <?php if ($dataa->metodePem == 'transfer') : ?>
                                            Rp. <?= $dataa->nilaiPem ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Total Bayar</b></td>
                                    <td>Rp. <?= number_format($dataa->total_bayar) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <h6><b>Bukti Transfer</b></h6>
                    <hr class="bg-deta">
                    <div class="row">
                        <div class="col-md-6 table-responsive-sm">
                            <?php $this->db->join('tb_rekening', 'tb_rekening.kd_rekening = tb_shop_tmp.transfer_ke');
                            $konf = $this->db->get_where('tb_shop_tmp', ['tb_shop_tmp.order_id' => $data->order_id, 'tb_shop_tmp.token' => $data->token])->row(); ?>
                            <table class="table" width="100%">
                                <?php if (empty($konf->order_id)) : ?>
                                    <tr>
                                        <td colspan="3" align="center"><i>
                                                <--- tidak ada data --->
                                            </i></td>
                                    </tr>
                                <?php else : ?>
                                    <tr>
                                        <th width="35%">Atas Nama</th>
                                        <th width="5%">:</th>
                                        <td><?= $konf->nama ?></td>
                                    </tr>
                                    <tr>
                                        <th width="35%">Transfer Ke</th>
                                        <th width="5%">:</th>
                                        <td><b>No. Rekening : </b> <?= $konf->no_rekening ?><br /> <b>a.n : </b> <?= $konf->atas_nama ?></td>
                                    </tr>
                                    <tr>
                                        <th width="35%">Tanggal Transfer</th>
                                        <th width="5%">:</th>
                                        <td><?= date('d F Y', strtotime($konf->tgl_transfer)) ?></td>
                                    </tr>
                                    <tr>
                                        <th width="35%">Jumlah Transfer</th>
                                        <th width="5%">:</th>
                                        <td>Rp. <?= number_format($konf->jml_transfer) ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <?php if (empty($konf->order_id)) : ?>
                                <img class="card-img" src="<?= base_url('assets/img/noimage.png') ?>" alt="">
                            <?php else : ?>
                                <img class="card-img" src="http://localhost:84/detashop/assets/upload/konfirmasi/<?= $konf->bukti_transfer ?>" alt="" width="10%">
                            <?php endif; ?>
                        </div>
                    </div>
                    <hr class="bg-deta">
                    <div class="col-md-12 mx-auto">
                        <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($proses as $data) : ?>
    <div class="modal fade" id="kirim<?= $data->order_id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-deta">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Pesanan - <?= $data->order_id ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= form_open('Pesanan/Kirim/' . $data->order_id . '/' . $data->token) ?>
                    <table class="table" width="100%">
                        <tr>
                            <th width="25%">Ekspedisi</th>
                            <td width="5%">:</td>
                            <td><b><?= strtoupper($data->expedisi) ?></b></td>
                        </tr>
                        <tr>
                            <th width="25%">Paket</th>
                            <td width="5%">:</td>
                            <td><?= $data->paket ?></td>
                        </tr>
                        <tr>
                            <th width="25%">Ongkir</th>
                            <td width="5%">:</td>
                            <td>Rp. <?= number_format($data->ongkir) ?></td>
                        </tr>
                        <tr>
                            <th width="25%">No Resi</th>
                            <td width="5%">:</td>
                            <td><input type="text" class="form-control" name="no_resi" autocomplete="off"></td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-danger float-right">Kirim</button>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($proses as $dataa) : ?>
    <div class="modal fade" id="verifikasi<?= $dataa->order_id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-deta">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Pesanan - <?= $dataa->order_id ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6><b>Detail Pembelian</b></h6>
                    <hr class="bg-deta">
                    <div class="col-md-12 pesan">
                        <table class="table" width='100%'>
                            <thead>
                                <tr>
                                    <th width="15%">Order ID</th>
                                    <th width="30%">Nama Barang</th>
                                    <th width="20%">Harga</th>
                                    <th>Jumlah</th>
                                    <th width="20%">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $detail = $this->db->get_where('tb_shop_detail', ['token' => $dataa->token, 'order_id' => $dataa->order_id])->result(); ?>
                                <?php $pel = $this->db->get_where('tb_shop_pel', ['id_shop_pel' => $dataa->id_shop_pel])->row(); ?>
                                <?php foreach ($detail as $data) : ?>
                                    <?php $barang = $this->db->get_where('tb_barang', ['kode_barang' => $data->id_barang])->row(); ?>
                                    <?php
                                    $harga = $this->db->get_where('tb_barang_harga', ['id_barang' => $data->id_barang])->row();
                                    $harga_r = $this->db->get_where('tb_barang_harga_reseller', ['id_barang' => $data->id_barang])->row();
                                    if ($pel->reseller == 1) {
                                        $hg = $harga_r->harga_reseller;
                                        $subtotal = $data->qty * $hg;
                                    } else {
                                        $hg = $harga->harga_jual;
                                        $subtotal = $data->qty * $hg;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $data->order_id ?></td>
                                        <td><?= $barang->nama_barang ?></td>
                                        <td>Rp. <?= number_format($hg) ?></td>
                                        <td align="center"><?= $data->qty ?></td>
                                        <td>Rp. <?= number_format($subtotal) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" align="right"><b>Total</b></td>
                                    <td>Rp. <?= number_format($dataa->total) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Expedisi</b></td>
                                    <td><?= '<b>' . strtoupper($dataa->expedisi) . '</b> - ' . $dataa->paket . ' - Rp. ' . number_format($dataa->ongkir) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Kode Unik</b></td>
                                    <td>
                                        <?php if ($dataa->metodePem == 'transfer') : ?>
                                            Rp. <?= $dataa->nilaiPem ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Total Bayar</b></td>
                                    <td>Rp. <?= number_format($dataa->total_bayar) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr class="bg-deta">
                    <div class="col-md-12 mx-auto">
                        <a href="<?= base_url('pesanan/cetak_label') ?>" target="_blank" class="btn btn-sm btn-outline-danger">Cetak Label</a>
                        <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($shop as $dataa) : ?>
    <div class="modal fade" id="verifikasicod<?= $dataa->order_id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-deta">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Pesanan - <?= $dataa->order_id ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <h6><b>Detail Pembelian</b></h6>
                    <hr class="bg-deta">
                    <div class="col-md-12 pesan">
                        <table class="table" width='100%'>
                            <thead>
                                <tr>
                                    <th width="15%">Order ID</th>
                                    <th width="30%">Nama Barang</th>
                                    <th>Ukuran</th>
                                    <th>Varian</th>
                                    <th width="20%">Harga</th>
                                    <th>Jumlah</th>
                                    <th width="20%">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $detail = $this->db->get_where('tb_shop_detail', ['token' => $dataa->token, 'order_id' => $dataa->order_id])->result(); ?>
                                <?php foreach ($detail as $data) : ?>
                                    <?php $barang = $this->db->get_where('tb_barang', ['kode_barang' => $data->id_barang])->row(); ?>
                                    <?php $harga = $this->db->get_where('tb_barang_harga', ['id_barang' => $data->id_barang])->row(); ?>
                                    <?php $subtotal = $data->qty * $harga->harga_jual; ?>
                                    <tr>
                                        <td><?= $data->order_id ?></td>
                                        <td><?= $barang->nama_barang ?></td>
                                        <td><?= $data->ukuran ?></td>
                                        <td><?= $data->varian ?></td>
                                        <td>Rp. <?= number_format($harga->harga_jual) ?></td>
                                        <td align="center"><?= $data->qty ?></td>
                                        <td>Rp. <?= number_format($subtotal) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" align="right"><b>Total</b></td>
                                    <td>Rp. <?= number_format($dataa->total) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right"><b>Expedisi</b></td>
                                    <td><?= '<b>' . strtoupper($dataa->expedisi) . '</b> - ' . $dataa->paket . ' - Rp. ' . number_format($dataa->ongkir) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right"><b>COD</b></td>
                                    <td>
                                        <?php if ($dataa->metodePem == 'cod') : ?>
                                            Rp. <?= number_format($dataa->nilaiPem) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right"><b>Total Bayar</b></td>
                                    <td>Rp. <?= number_format($dataa->total_bayar) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($proses as $dataa) : ?>
    <div class="modal fade" id="verifikasicod<?= $dataa->order_id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-deta">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Pesanan - <?= $dataa->order_id ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6><b>Detail Pembelian</b></h6>
                    <hr class="bg-deta">
                    <div class="col-md-12 pesan">
                        <table class="table" width='100%'>
                            <thead>
                                <tr>
                                    <th width="15%">Order ID</th>
                                    <th width="30%">Nama Barang</th>
                                    <th>Ukuran</th>
                                    <th>Varian</th>
                                    <th width="20%">Harga</th>
                                    <th>Jumlah</th>
                                    <th width="20%">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $detail = $this->db->get_where('tb_shop_detail', ['token' => $dataa->token, 'order_id' => $dataa->order_id])->result(); ?>
                                <?php foreach ($detail as $data) : ?>
                                    <?php $barang = $this->db->get_where('tb_barang', ['kode_barang' => $data->id_barang])->row(); ?>
                                    <?php $harga = $this->db->get_where('tb_barang_harga', ['id_barang' => $data->id_barang])->row(); ?>
                                    <?php $subtotal = $data->qty * $harga->harga_jual; ?>
                                    <tr>
                                        <td><?= $data->order_id ?></td>
                                        <td><?= $barang->nama_barang ?></td>
                                        <td><?= $data->ukuran ?></td>
                                        <td><?= $data->varian ?></td>
                                        <td>Rp. <?= number_format($harga->harga_jual) ?></td>
                                        <td align="center"><?= $data->qty ?></td>
                                        <td>Rp. <?= number_format($subtotal) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" align="right"><b>Total</b></td>
                                    <td>Rp. <?= number_format($dataa->total) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Expedisi</b></td>
                                    <td><?= '<b>' . strtoupper($dataa->expedisi) . '</b> - ' . $dataa->paket . ' - Rp. ' . number_format($dataa->ongkir) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>COD</b></td>
                                    <td>
                                        <?php if ($dataa->metodePem == 'cod') : ?>
                                            Rp. <?= number_format($dataa->nilaiPem) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Total Bayar</b></td>
                                    <td>Rp. <?= number_format($dataa->total_bayar) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr class="bg-deta">
                    <div class="col-md-12 mx-auto">
                        <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($kirim as $dataa) : ?>
    <div class="modal fade" id="lacak<?= $dataa->order_id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header bg-deta">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Pesanan - <?= $dataa->no_resi ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <style>
                        .vertical-timeline {
                            width: 100%;
                            position: relative;
                            padding: 1.5rem 0 1rem
                        }

                        .vertical-timeline::before {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: 67px;
                            height: 100%;
                            width: 4px;
                            background: #e9ecef;
                            border-radius: .25rem
                        }

                        .vertical-timeline-element {
                            position: relative;
                            margin: 0 0 1rem
                        }

                        .vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
                            visibility: visible;
                            animation: cd-bounce-1 .8s
                        }

                        .vertical-timeline-element-icon {
                            position: absolute;
                            top: 0;
                            left: 60px
                        }

                        .vertical-timeline-element-icon .badge-dot-xl {
                            box-shadow: 0 0 0 5px #fff
                        }

                        .badge-dot-xl {
                            width: 18px;
                            height: 18px;
                            position: relative
                        }

                        .badge:empty {
                            display: none
                        }

                        .badge-dot-xl::before {
                            content: '';
                            width: 10px;
                            height: 10px;
                            border-radius: .25rem;
                            position: absolute;
                            left: 50%;
                            top: 50%;
                            margin: -5px 0 0 -5px;
                            background: #fff
                        }

                        .vertical-timeline-element-content {
                            position: relative;
                            margin-left: 90px;
                            font-size: .8rem
                        }

                        .vertical-timeline-element-content .timeline-title {
                            font-size: .8rem;
                            text-transform: uppercase;
                            margin: 0 0 .5rem;
                            padding: 2px 0 0;
                            font-weight: bold
                        }

                        .vertical-timeline-element-content .vertical-timeline-element-date {
                            display: block;
                            position: absolute;
                            left: -90px;
                            top: 0;
                            padding-right: 10px;
                            text-align: right;
                            color: #adb5bd;
                            font-size: .7619rem;
                            white-space: nowrap
                        }

                        .vertical-timeline-element-content:after {
                            content: "";
                            display: table;
                            clear: both
                        }
                    </style>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="main-card mb-3">
                                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">

                                    <div id="hasilLacak<?= $dataa->no_resi ?>"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            var waybill = '<?= $dataa->no_resi ?>';
                            var courier = '<?= $dataa->expedisi ?>';
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url('Raja_ongkir/lacak') ?>",
                                data: 'waybill=' + waybill + '&courier=' + courier,
                                success: function(hasil) {
                                    $('#hasilLacak<?= $dataa->no_resi ?>').html(hasil);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    window.addEventListener('load', showPesanan);

    function showPesanan() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showPesanan").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "<?= base_url('Pesanan/semua') ?>", true);
        xhttp.send();
    };

    window.addEventListener('load', showProses);

    function showProses() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showProses").innerHTML = this.responseText;
                $('#prosesTable').DataTable();
            }
        };
        xhttp.open("GET", "<?= base_url('Pesanan/diproses') ?>", true);
        xhttp.send();
    };

    window.addEventListener('load', showKirim);

    function showKirim() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showKirim").innerHTML = this.responseText;
                $('#kirimTable').DataTable();
            }
        };
        xhttp.open("GET", "<?= base_url('Pesanan/dikirim') ?>", true);
        xhttp.send();
    };

    window.addEventListener('load', showSelesai);

    function showSelesai() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showSelesai").innerHTML = this.responseText;
                $('#selesaiTable').DataTable();
            }
        };
        xhttp.open("GET", "<?= base_url('Pesanan/selesai') ?>", true);
        xhttp.send();
    };
</script>

<script>
    window.addEventListener('load', semua);

    function semua() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showPesanan").innerHTML = this.responseText;
                $('#pesanTable').DataTable();
            }
        };
        xhttp.open("GET", "<?= base_url('Pesanan/semua') ?>", true);
        xhttp.send();
    }

    window.addEventListener('load', diproses);

    function diproses() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showProses").innerHTML = this.responseText;
                $('#prosesTable').DataTable();
            }
        };
        xhttp.open("GET", "<?= base_url('Pesanan/diproses') ?>", true);
        xhttp.send();
    }

    window.addEventListener('load', dikirim);

    function dikirim() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showKirim").innerHTML = this.responseText;
                $('#kirimTable').DataTable();
            }
        };
        xhttp.open("GET", "<?= base_url('Pesanan/dikirim') ?>", true);
        xhttp.send();
    }

    window.addEventListener('load', selesai);

    function selesai() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("showSelesai").innerHTML = this.responseText;
                $('#selesaiTable').DataTable();
            }
        };
        xhttp.open("GET", "<?= base_url('Pesanan/selesai') ?>", true);
        xhttp.send();
    }
</script>