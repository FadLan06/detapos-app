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

        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="text-center mt-0 m-b-15">
                            <a href="" class="logo logo-admin"><img src="<?= base_url('') ?>assets/img/logodeta1.webp" height="150" alt="logo"></a>
                        </h3>
                        <form action="<?= base_url('Shop/Konfirmasi') ?>" method="post" enctype="multipart/form-data">
                            <?php $barang = $this->db->get_where('tb_barang', ['id' => $id['id_barang']])->row_array(); ?>
                            <div class="form-group">
                                <input type="hidden" name="id_shop" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Order ID" autocomplete="off" value="<?= $this->uri->segment(4) ?>" readonly>
                                <input type="hidden" name="totpok" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Order ID" autocomplete="off" value="<?= $barang['harga_beli'] * $id['qty'] ?>" readonly>
                                <input type="hidden" name="token" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Order ID" autocomplete="off" value="<?= $id['token'] ?>" readonly>
                                <input type="hidden" name="no_jurnal" class="form-control" id="no_jurnal" autocomplete="off" value="<?= $no_jurnal ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label><b>Order ID <span class="text-danger">*</span></b></label>
                                <input type="text" name="order_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Order ID" autocomplete="off" value="<?= $this->uri->segment(3) ?>" readonly>
                                <?= form_error('order_id', '<small class="text-white pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label><b>Atas Nama Rekening <span class="text-danger">*</span></b></label>
                                <input type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Atas Nama Rekening" autocomplete="off" autofocus required>
                                <?= form_error('nama', '<small class="text-white pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label><b>Transfer Ke <span class="text-danger">*</span></b></label>
                                <select name="transfer_ke" id="transfer_ke" class="form-control" required>
                                    <option disabled selected>
                                        <-- Pilih Jenis Rekekning -->
                                    </option>
                                    <?php foreach ($rek as $data) : ?>
                                        <option value="<?= $data['kd_rekening'] ?>">
                                            <?php if ($data['jenis'] == 'bank-bca') {
                                                echo 'BCA - ' . $data['atas_nama'] . ' - ' . $data['no_rekening'];
                                            } elseif ($data['jenis'] == 'bank-mandiri') {
                                                echo 'Mandiri - ' . $data['atas_nama'] . ' - ' . $data['no_rekening'];
                                            } elseif ($data['jenis'] == 'bank-bni') {
                                                echo 'BNI - ' . $data['atas_nama'] . ' - ' . $data['no_rekening'];
                                            } elseif ($data['jenis'] == 'bank-bri') {
                                                echo 'BRI - ' . $data['atas_nama'] . ' - ' . $data['no_rekening'];
                                            } ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('transfer_ke', '<small class="text-white pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label><b>Tanggal Transfer <span class="text-danger">*</span></b></label>
                                <input type="date" name="tgl_transfer" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tanggal Transfer" autocomplete="off" required>
                                <?= form_error('tgl_transfer', '<small class="text-white pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label><b>Jumlah Transfer <span class="text-danger">*</span></b></label>
                                <input type="number" name="jml_transfer" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Jumlah Transfer" autocomplete="off" value="<?= $id['total_bayar'] ?>" required>
                                <?= form_error('jml_transfer', '<small class="text-white pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <label><b>Bukti Transfer<span class="text-danger">*</span></b></label>
                                <input type="file" name="bukti_transfer" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Bukti Transfer" autocomplete="off" required>
                                <?= form_error('bukti_transfer', '<small class="text-white pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block text-white btn-deta mt-3 mb-2 shadow" name="konfirmasi"><b>K I R I M </b> <i class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->