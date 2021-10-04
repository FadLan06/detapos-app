<nav aria-label="breadcrumb" class="" style="margin-top: 90px">
    <ol class="breadcrumb bg-danger text-white" style="font-size: 20px">
        <div class="pela">Home >> Data Master >> <b>Barang</b></div>
    </ol>
</nav>

<div class="card mt-4 bg-default mb-5 border-danger">
    <div class="card-body">
        <div class="mx-auto">
            <?php if ($this->session->userdata('token') == '2346643242123345') : ?>
                <a href="<?= base_url('Barang/Tambah_Barang') ?>" class="btn btn-danger btnn btn-sm"><i class="fas fa-plus-circle"></i> Tambah</a>
                <a href="" class="btn btn-success btnn btn-sm" data-toggle="modal" data-target="#ModalUpload"><i class="fas fa-upload"></i> Upload Data Excel</a>
                <a href="" class="btn btn-info btnn btn-sm" data-toggle="modal" data-target="#ModalBarcode"><i class="fas fa-print"></i> Cetak Barcode</a>
                <a href="" class="btn btn-warning btnn btn-sm" data-toggle="modal" data-target="#ModalBarang"><i class="fas fa-eye"></i> Lihat Data Barang</a>
                <button type="button" class="btn btn-danger btnn btn-sm" id="btn-delete-barang"><i class="fas fa-trash"></i> Hapus</button>
            <?php else : ?>
                <a href="<?= base_url('Barang/Tambah_Barang') ?>" class="btn btn-danger btnn btn-sm"><i class="fas fa-plus-circle"></i> Tambah</a>
                <a href="" class="btn btn-success btnn btn-sm" data-toggle="modal" data-target="#ModalUpload"><i class="fas fa-upload"></i> Upload Data Excel</a>
                <a href="" class="btn text-white btn-secondary btnn btn-sm" data-toggle="modal" data-target="#bukalapak"><img src="<?= base_url('assets/img/bukalapak.png') ?>" alt="" class="gam"> Bukalapak</a>
                <a href="" class="btn text-white btn-secondary btnn btn-sm" data-toggle="modal" data-target="#tokopedia"><img src="<?= base_url('assets/img/tokopedia.png') ?>" alt="" class="gam"> Tokopedia</a>
                <a href="" class="btn text-white btn-secondary btnn btn-sm" data-toggle="modal" data-target="#shopee"><img src="<?= base_url('assets/img/shopee.png') ?>" alt="" class="gam"> Shopee</a>
                <a href="" class="btn text-white btn-secondary btnn btn-sm" data-toggle="modal" data-target="#lazada"><img src="<?= base_url('assets/img/lazada.png') ?>" alt="" class="gam"> Lazada</a>
                <a href="" class="btn btn-info btnn btn-sm" data-toggle="modal" data-target="#ModalBarcode"><i class="fas fa-print"></i> Cetak Barcode</a>
                <button type="button" class="btn btn-danger btnn btn-sm" id="btn-delete-barang"><i class="fas fa-trash"></i> Hapus</button>
            <?php endif; ?>
        </div>
        <hr class="bg-danger">
        <?= $this->session->flashdata('message') ?>
        <?= $this->session->flashdata('barang') ?>
        <?php echo $this->session->flashdata('notif') ?>
        <?php if (isset($retail['menu_id'])) : ?>
            <table class="table table-striped table-sm table-bordered responsive" id="example" style="width:100%">
                <thead class="center" style="text-align:center; ">
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Kode</th>
                        <th width="30%">Nama Barang</th>
                        <th width="15%">Harga Modal</th>
                        <th width="15%">Harga Jual</th>
                        <th width="15%">Terjual / Stok</th>
                        <th width="15%">Retur Supplier</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($barang as $br) : ?>
                        <?php $stok = $this->db->query("SELECT *, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
                        <?php
                        $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']]);
                        $kd = $query->num_rows();
                        ?>
                        <tr>
                            <td align="center">
                                <?php if ($kd > 0) : ?>
                                    <input type='checkbox' class='check-item-barang1' title="Barang ini tidak bisa di Hapus, Karna barang ini sudah pernah dijual!" checked disabled>
                                <?php else : ?>
                                    <input type='checkbox' class='check-item-barang' name='bar[]' value='<?= $br['id'] ?>'>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="kodee_brangg"><?= $br['kode'] ?> <br> <a href="<?= base_url('Checkout') ?>" target="_blank" class="badge badge-info link"><i class="fas fa-check-circle"></i> checkout</a> </div>
                            </td>
                            <td><?= $br['nama_barang'] ?></td>
                            <td align="center">Rp. <?= number_format($br['harga_beli']) ?></td>
                            <td align="center">
                                <span <?= $br['harga_jual'] == 0 ? 'hidden' : '' ?>>Rp. <?= number_format($br['harga_jual']) ?></span><br>
                                <span <?= $br['harga_jual1'] == 0 ? 'hidden' : '' ?>>Rp. <?= number_format($br['harga_jual1']) ?></span><br>
                                <span <?= $br['harga_jual2'] == 0 ? 'hidden' : '' ?>>Rp. <?= number_format($br['harga_jual2']) ?></span>
                            </td>
                            <td><?= number_format($stok['qty']) . ' / ' . number_format($br['jml_stok']) . ' ' . $br['satuan'] ?></td>
                            <td align="center">
                                <a href="" class="btn btn-warning btn-sm" data-target="#mRetur" data-toggle="modal" data-id="<?= $br['id'] ?>"><i class="fas fa-undo"></i> Retur</a>
                            </td>
                            <td align="center">
                                <a href="<?= base_url('Barang/Ubah_Barang/') . $br['id'] ?>"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('Barang/Hapus_brng/') . $br['id'] . '/' . $br['kode_barang'] ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <table>
                <?php else : ?>
                    <table class="table table-striped table-bordered responsive" id="example" style="width:100%">
                        <thead class="center" style="text-align:center; ">
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Kode</th>
                                <th width="30%">Nama Barang</th>
                                <th width="15%">Harga Jual</th>
                                <th width="15%">Terjual / Stok</th>
                                <th width="15%">Retur Supplier</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($barang as $br) : ?>
                                <?php $stok = $this->db->query("SELECT *, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
                                <?php
                                $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']]);
                                $kd = $query->num_rows();
                                ?>
                                <tr>
                                    <td align="center">
                                        <?php if ($kd > 0) : ?>
                                            <input type='checkbox' class='check-item-barang1' title="Barang ini tidak bisa di Hapus, Karna barang ini sudah pernah dijual!" checked disabled>
                                        <?php else : ?>
                                            <input type='checkbox' class='check-item-abrang' name='bar[]' value='<?= $br['id'] ?>'>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $br['kode'] ?></td>
                                    <td><?= $br['nama_barang'] ?></td>
                                    <td>Rp. <?= number_format($br['harga_jual']) ?></td>
                                    <td align="center"><?= number_format($stok['qty']) . ' / ' . number_format($br['jml_stok']) . ' ' . $br['satuan'] ?></td>
                                    <td align="center">
                                        <a href="" class="btn btn-warning btn-sm" data-target="#mRetur" data-toggle="modal" data-id="<?= $br['id'] ?>"><i class="fas fa-undo"></i> Retur</a>
                                    </td>
                                    <td align="center">
                                        <a href="<?= base_url('Barang/Ubah_Barang/') . $br['id'] ?>"><i class="fas fa-edit"></i></a>
                                        <a href="<?= base_url('Barang/Hapus_brng/') . $br['id'] . '/' . $br['kode_barang'] ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <table>
                        <?php endif; ?>
    </div>
</div>
<?php $this->load->view('barang/modal'); ?>
<script src="<?= base_url('assets/') ?>jquery-3.4.1.js"></script>
<script>
    $(document).ready(function() {
        $("#btn-delete-barang").prop("hidden", true);

        $("#check-all-barang").click(function() {
            if ($(this).is(":checked")) {
                $(".check-item-barang").prop("checked", true);
                $("#btn-delete-barang").prop("hidden", false);
            } else {
                $(".check-item-barang").prop("checked", false);
                $("#btn-delete-barang").prop("hidden", true);
            }
        });

        var $checkboxes = $('.check-item-barang');
        var jumlahdata = $('#jumlahdatabarang').val();

        $checkboxes.change(function() {
            var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
            if (countCheckedCheckboxes > 0) {
                $("#btn-delete-barang").prop("hidden", false);
            } else {
                $("#btn-delete-barang").prop("hidden", true);
                $("#check-all-barang").prop("checked", false);
            }

            if (countCheckedCheckboxes == jumlahdata) {
                $("#check-all-barang").prop("checked", true);
            } else {
                $("#check-all-barang").prop("checked", false);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('#btn-delete-barang').click(function() {

            if (confirm("Anda yakin ingin menghapus data yang dicentang?")) {
                var bar = [];

                $(':checkbox:checked').each(function(i) {
                    bar[i] = $(this).val();
                });

                if (bar.length === 0) {
                    alert("Anda belum centang data yang ingin dihapus");
                } else {
                    $.ajax({
                        url: '<?php echo base_url('Barang/Hapus_bar') ?>',
                        method: 'POST',
                        data: {
                            bar: bar
                        },
                        success: function() {
                            <?php $this->session->set_flashdata('barang', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data Barang Berhasil di Hapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); ?>;
                            location.reload();
                        }

                    });
                }

            } else {
                return false;
            }

        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#ModalBarang').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Barang/detail') ?>',
                data: 'kode_barang=' + kd,
                success: function(data) {
                    $('.mBarang').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>