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
        <input type="hidden" name="link" value="<?= $this->uri->segment(2) ?>">
        <div class="card card-body">
            <table class="table" cellpadding="6" cellspacing="1" style="width:100%" border="0">
                <tr>
                    <th style="width: 10%;">Jumlah</th>
                    <th style="width: 45%;">Nama Barang</th>
                    <th style="text-align:right">Harga</th>
                    <th style="text-align:right">Sub-Total</th>
                    <th style="text-align:center">Aksi</th>
                </tr>

                <?php $i = 1; ?>
                <?php foreach ($this->cart->contents() as $items) : ?>
                    <tr>
                        <td><?php echo form_input(array('name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'min' => '1', 'size' => '5', 'type' => 'number', 'class' => 'form-control')); ?></td>
                        <td>
                            <?php echo $items['name']; ?>
                        </td>
                        <td style="text-align:right">Rp. <?php echo number_format($items['price']); ?></td>
                        <td style="text-align:right">Rp. <?php echo number_format($items['subtotal']); ?></td>
                        <td style="text-align:center"><a href="<?= base_url('Shop/Hapus/') . $items['rowid'] . '/' . $this->uri->segment(2) ?>" class="badge badge-danger">hapus</a></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>

                <tr>
                    <td colspan="2"> </td>
                    <td class="right"><strong>Total</strong></td>
                    <td class="right">Rp. <?php echo number_format($this->cart->total()); ?></td>
                    <td></td>
                </tr>
            </table>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-deta btn-sm" type="submit"> <i class="fas fa-edit"></i> Update</button>
                        <button class="btn btn-danger btn-sm" type="button" onclick="location.href='<?= base_url('Shop/Clear/') . $this->uri->segment(2) ?>'"> <i class="fas fa-trash"></i> Kosongkan</button>
                        <button class="btn btn-warning btn-sm" type="button" onclick="location.href='<?= base_url('Shop/Checkout') ?>'"> <i class="fas fa-save"></i> Checkout</button>
                    </div>
                </div>
            </div>
        </div>

        <?= form_close() ?>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->