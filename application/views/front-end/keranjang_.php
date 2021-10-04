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

        <?php echo form_open('Shop/ubah'); ?>

        <?php $tot = 0;
        foreach ($data as $dt) : ?>
            <?php $i = 1; ?>
            <?php $jml = 0;
            $total = 0;
            $tot_berat = 0; ?>
            <div class="card mt-2 dtscroll">
                <div class="card-body">
                    <table class="table" style="width: 1070px;">
                        <thead>
                            <tr>
                                <th width="13%">Jumlah</th>
                                <th width="50%">Nama Barang</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                                <th width="8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $kr = $this->db->query("SELECT *, sum(harga * qty) as subtotal FROM tb_keranjang_tmp WHERE token='$dt[token]' AND id_pel='$use[id_pel_shop]' GROUP BY id_barang")->result_array(); ?>
                            <?php $app = $this->db->get_where('setting_app', ['token' => $dt['token']])->row_array(); ?>
                            <div class="mb-2">
                                <img class="mr-3" src="<?= base_url('assets/upload/') . $app['logo'] ?>" height="30" width="30">
                                <?= $app['nama_toko'] ?>
                            </div>
                            <?php foreach ($kr as $items) : ?>
                                <?php
                                $jml = $jml + $items['qty'];
                                $total = $total + $items['subtotal'];

                                $barang = $this->db->get_where('tb_barang', ['id' => $items['id_barang']])->row_array();
                                $berat = $items['qty'] * $barang['berat'];

                                $tot_berat += $berat;
                                ?>
                                <tr>
                                    <td width="13%" align="center">
                                        <input type="number" class="form-control" min="1" size="5" maxlength="3" value="<?= $items['qty'] ?>" name="qty[]" style="width: 65%;">
                                        <input type="hidden" class="form-control" value="<?= $items['id_keranjang_tmp'] ?>" name="id[]" style="width: 65%;">
                                        <input type="hidden" class="form-control" value="<?= $items['id_barang'] ?>" name="id_barang[]" style="width: 65%;">
                                    </td>
                                    <td width="50%"> <?php echo $items['nama_barang']; ?> </td>
                                    <td>Rp. <?php echo number_format($items['harga']); ?></td>
                                    <td>Rp. <?php echo number_format($items['subtotal']); ?></td>
                                    <td width="8%"><a href="<?= base_url('Shop/hapus/') . $items['id_keranjang_tmp'] ?>" class="badge badge-danger">hapus</a></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php $tot += $total; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <!-- <div class="col-md-8"><strong>Total</strong></div> -->
                    <div class="col-md-10">
                        <div class="float-right"><strong>Total</strong> = Rp. <?php echo number_format($tot); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-deta btn-sm" type="submit"> <i class="fas fa-edit"></i> Update</button>
                        <button class="btn btn-danger btn-sm" type="button" onclick="location.href='<?= base_url('Shop/Clear/') . $use['id_pel_shop'] ?>'"> <i class="fas fa-trash"></i> Kosongkan</button>
                        <button class="btn btn-warning btn-sm" type="button" onclick="location.href='<?= base_url('Shop/Checkout') ?>'"> <i class="fas fa-save"></i> Checkout</button>
                    </div>
                </div>
            </div>
        </div>

        <?= form_close() ?>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->