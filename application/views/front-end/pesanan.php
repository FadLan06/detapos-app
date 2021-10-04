<div class="page-content-wrapper ">

    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <!-- <li class="breadcrumb-item"><a href="#">Annex</a></li> -->
                            <li class="breadcrumb-item"><a href="<?= base_url('Shop') ?>">Home</a></li>
                            <li class="breadcrumb-item active"><?= $judul ?></li>
                        </ol>
                    </div>
                    <h4><?= $judul ?></h4>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 100px;">
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
                    <div class="tab-pane active p-3" id="home-1" role="tabpanel">
                        <table class="table table-sm table-bordered" cellspacing="0" width="100%">
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
                            <tbody>
                                <?php $no = 1;
                                foreach ($shop as $data) : ?>
                                    <tr>
                                        <td align="center"><?= $no++ ?></td>
                                        <td align="center"><?= $data->order_id ?></td>
                                        <td align="center"><?= longdate_indo($data->tgl_order) ?></td>
                                        <td>
                                            <b><?= strtoupper($data->expedisi) ?></b><br>
                                            Paket : <?= $data->paket ?><br>
                                            Ongkir : Rp. <?= number_format($data->ongkir) ?><br>
                                        </td>
                                        <td align="center">
                                            Rp. <?= number_format($data->totbar) ?>
                                        </td>
                                        <td align="center">
                                            <?php if ($data->tusbar == 0) : ?>
                                                <span class="badge badge-warning badge-pill">belum bayar</span>
                                            <?php else : ?>
                                                <span class="badge badge-success badge-pill">sudah bayar</span>
                                                <span class="badge badge-deta text-white badge-pill">menunggu konfirmasi</span>
                                            <?php endif; ?>
                                        </td>
                                        <td align="center">
                                            <?php if ($data->tusbar == 0) : ?>
                                                <a href="javascript:void(0);" onclick="location.href='<?= base_url('Shop/Bayar/') . $data->order_id . '/' . $data->id_shop_detail ?>'" class="btn btn-sm btn-deta">Bayar</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="profile-1" role="tabpanel">
                        <table class="table table-sm table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr align="center">
                                    <th width="3%">#</th>
                                    <th width="20%">Order ID</th>
                                    <th width="20%">Tanggal</th>
                                    <th>Expedisi</th>
                                    <th width="15%">Total Bayar</th>
                                    <th width="15%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($shopp as $data) : ?>
                                    <tr>
                                        <td align="center"><?= $no++ ?></td>
                                        <td align="center"><?= $data->order_id ?></td>
                                        <td align="center"><?= $data->waktu_proses ?></td>
                                        <td>
                                            <b><?= strtoupper($data->expedisi) ?></b><br>
                                            Paket : <?= $data->paket ?><br>
                                            Ongkir : Rp. <?= number_format($data->ongkir) ?><br>
                                        </td>
                                        <td align="center">
                                            Rp. <?= number_format($data->totbar) ?>
                                        </td>
                                        <td align="center">
                                            <span class="badge badge-deta text-white badge-pill">Diproses / Dikemas</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="messages-1" role="tabpanel">
                        <table class="table table-sm table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr align="center">
                                    <th width="3%">#</th>
                                    <th width="20%">Order ID</th>
                                    <th width="20%">Tanggal</th>
                                    <th>Expedisi</th>
                                    <th width="15%">Total Bayar</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">NO RESI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($shoppi as $data) : ?>
                                    <tr>
                                        <td align="center"><?= $no++ ?></td>
                                        <td align="center"><?= $data->order_id ?></td>
                                        <td align="center"><?= $data->waktu_kirim ?></td>
                                        <td>
                                            <b><?= strtoupper($data->expedisi) ?></b><br>
                                            Paket : <?= $data->paket ?><br>
                                            Ongkir : Rp. <?= number_format($data->ongkir) ?><br>
                                        </td>
                                        <td align="center">
                                            Rp. <?= number_format($data->totbar) ?>
                                        </td>
                                        <td align="center">
                                            <span class="badge badge-deta text-white badge-pill">Dikirim</span>
                                        </td>
                                        <td align="center">
                                            <span style="font-size: 20px;"><?= $data->no_resi ?></span><br>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#terima<?= $data->order_id ?>" class="badge badge-danger text-white badge-pill">Diterima</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="settings-1" role="tabpanel">
                        <table class="table table-sm table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr align="center">
                                    <th width="3%">#</th>
                                    <th width="20%">Order ID</th>
                                    <th width="20%">Tanggal</th>
                                    <th>Expedisi</th>
                                    <th width="15%">Total Bayar</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">NO RESI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($shopping as $data) : ?>
                                    <tr>
                                        <td align="center"><?= $no++ ?></td>
                                        <td align="center"><?= $data->order_id ?></td>
                                        <td align="center"><?= $data->waktu_selesai ?></td>
                                        <td>
                                            <b><?= strtoupper($data->expedisi) ?></b><br>
                                            Paket : <?= $data->paket ?><br>
                                            Ongkir : Rp. <?= number_format($data->ongkir) ?><br>
                                        </td>
                                        <td align="center">
                                            Rp. <?= number_format($data->totbar) ?>
                                        </td>
                                        <td align="center">
                                            <span class="badge badge-deta text-white badge-pill">Selesai</span>
                                        </td>
                                        <td align="center">
                                            <span style="font-size: 20px;"><?= $data->no_resi ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->

<?php foreach ($shoppi as $data) : ?>
    <div class="modal fade" id="terima<?= $data->order_id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-deta">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Pesanan - <?= $data->order_id ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4><b>Konfirmasi Penerimaan</b></h4><br>
                    <?= form_open_multipart('Shop/terima') ?>
                    <div class="form-group">
                        <label><b>Order ID <span class="text-danger">*</span></b></label>
                        <input type="hidden" value="<?= $data->token ?>" name="token">
                        <input type="text" name="order_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Order ID" autocomplete="off" value="<?= $data->order_id ?>" readonly>
                        <?= form_error('order_id', '<small class="text-white pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label><b>Nomor Resi <span class="text-danger">*</span></b></label>
                        <input type="text" name="no_resi" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Order ID" autocomplete="off" value="<?= $data->no_resi ?>" readonly>
                        <?= form_error('no_resi', '<small class="text-white pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label><b>Bukti Penerimaan<span class="text-danger">*</span></b></label>
                        <input type="file" name="bukti_terima" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Bukti Penerimaan" autocomplete="off" required>
                        <?= form_error('bukti_terima', '<small class="text-white pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label><b>Ulasan <span class="text-danger">*</span></b></label>
                        <textarea name="ulasan" id="ulasan" cols="30" rows="10" required class="form-control"></textarea>
                        <?= form_error('nama', '<small class="text-white pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block text-white bg-deta btn-outline-light mt-3 mb-2 shadow" name="terima"><b>K I R I M </b> <i class="fas fa-paper-plane"></i></button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>