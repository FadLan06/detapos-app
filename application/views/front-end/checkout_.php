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
        <!--  -->

        <!-- <div class="dtscroll"> -->

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h4><i class="fas fa-shopping-cart"></i> Checkout
                            <small class="float-right"><?= date('d/m/Y') ?></small></h4>
                    </div>
                </div>
            </div>
        </div>

        <?php $i = 1; ?>
        <?php $tot = 0;
        foreach ($data as $dt) : ?>
            <?php $jml = 0;
            $total = 0;
            $tot_berat = 0; ?>
            <div class="card mt-2 dtscroll">
                <div class="card-body">
                    <table class="table" style="width: 1070px;">
                        <thead>
                            <tr>
                                <th width="5%">Jumlah</th>
                                <th width="55%">Nama Barang</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                                <!-- <th width="8%">Aksi</th> -->
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
                                    <td width="5%" align="center"><?= $items['qty'] ?> </td>
                                    <td width="55%"> <?php echo $items['nama_barang']; ?> </td>
                                    <td>Rp. <?php echo number_format($items['harga']); ?></td>
                                    <td>Rp. <?php echo number_format($items['subtotal']); ?></td>
                                    <!-- <td width="8%"><a href="<?= base_url('Shop/hapus/') . $items['id_keranjang_tmp'] ?>" class="badge badge-danger">hapus</a></td> -->
                                </tr>
                            <?php endforeach; ?>
                            <?php $tot += $total; ?>
                        </tbody>
                    </table>
                    <table style="width: 1070px;">
                        <tr>
                            <td width="25%">
                                <div class="form-group">
                                    <select name="ekspedisi<?= $dt['token'] ?>" class="form-control">
                                        <option disabled selected>
                                            <-- Pilih Expedisi -->
                                        </option>
                                    </select>
                                    <?= form_error('ekspedisi', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </td>
                            <td width="25%">
                                <div class="form-group ml-2">
                                    <select name="paket<?= $dt['token'] ?>" class="form-control">
                                        <option disabled selected>
                                            <-- Pilih Paket -->
                                        </option>
                                    </select>
                                    <?= form_error('paket', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </td>
                            <td align="center">
                                <div class="form-group ml-2">
                                    <strong>Ongkir : </strong> Rp. <span id="<?= $dt['token'] ?>">0</span>
                                </div>
                            </td>
                            <td align="center">
                                <div class="form-group ml-2">
                                    <strong>Total : </strong> Rp. <span><?= number_format($total) ?></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <form action="<?= base_url('Shop/Proses_checkout') ?>" method="post">
                        <input type="hidden" id="ong<?= $dt['token'] ?>" name="ong<?= $dt['token'] ?>">
                        <input type="hidden" id="expedisi<?= $dt['token'] ?>" name="expedisi<?= $dt['token'] ?>">
                        <input type="hidden" id="paket<?= $dt['token'] ?>" name="paket<?= $dt['token'] ?>">
                        <input type="hidden" id="estimasi<?= $dt['token'] ?>" name="estimasi<?= $dt['token'] ?>">

                        <input type="hidden" id="berat" name="berat<?= $dt['token'] ?>" value="<?= $tot_berat ?>">
                        <input type="hidden" id="totaal<?= $dt['token'] ?>" name="totaal<?= $dt['token'] ?>" value="<?php echo $total ?>">
                        <input type="hidden" id="total_bayarr<?= $dt['token'] ?>" name="total_bayarr<?= $dt['token'] ?>" value="<?php echo $total ?>">

                        <?php foreach ($kr as $items) : ?>
                            <input type="hidden" id="qty" name="qty<?= $dt['token'] ?>" value="<?= $items['qty'] ?>">
                        <?php endforeach; ?>
                        <input type="hidden" id="token" name="token" value="<?= $dt['token'] ?>">
                </div>
            </div>
        <?php endforeach; ?>

        <div class="card mt-3 dtscroll" style="margin-bottom: 100px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm" cellspacing="0" style="width: 1070px;">
                            <tr>
                                <td style="text-align:right;"><strong>Total :</strong></td>
                                <td>Rp. <?php echo number_format($tot); ?></td>
                                <td style="text-align:right;"><strong>Ongkir :</strong></td>
                                <td>Rp. <span id="ongkir">0</span></td>
                                <td style="text-align:right;"><strong>Total Bayar :</strong></td>
                                <td>Rp. <span id="tot_bayar"><?php echo number_format($tot); ?></span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <input type="hidden" id="order_id" name="order_id" value="<?= strtoupper(random_string('alnum', 8)) . date('Ymd')  ?>">
                        <!-- <input type="text" id="order_id" name="order_id" value="<?= $order_id ?>"> -->
                        <input type="hidden" id="tgl_order" name="tgl_order" value="<?= date('Y-m-d'); ?>">
                        <input type="hidden" id="id_pel_shop" name="id_pel_shop" value="<?= $use['id_pel_shop']; ?>">
                        <input type="hidden" id="nama_penerima" name="nama_penerima" value="<?= $use['nama_pel']; ?>">
                        <input type="hidden" id="no_hp" name="no_hp" value="<?= $use['no_hp']; ?>">
                        <input type="hidden" id="provinsi" name="provinsi" value="<?= $use['provinsi']; ?>">
                        <input type="hidden" id="kota" name="kota" value="<?= $use['kota']; ?>">
                        <input type="hidden" id="alamat" name="alamat" value="<?= $use['alamat']; ?>">

                        <input type="hidden" id="total" name="total" value="<?php echo $tot ?>">
                        <input type="hidden" id="ongkirr" name="ongkir" value="0">
                        <input type="hidden" id="total_bayar" name="total_bayar" value="<?php echo $tot ?>">


                        <a href="<?= base_url('Shop/Keranjang') ?>" class="btn btn-sm btn-warning"><i class="fas fa-backward"></i> Kembali</a>
                        <button type="submit" class="btn btn-sm btn-deta float-right" id="proses" name="proses" disabled><i class="fas fa-save"></i> Proses Checkout </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <!-- </div> -->

    </div><!-- container -->

</div> <!-- Page content Wrapper -->

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script>
    function number_formatt(number, decimals, decPoint, thousandsSep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
        var n = !isFinite(+number) ? 0 : +number
        var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
        var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
        var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
        var s = ''

        var toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec)
            return '' + (Math.round(n * k) / k)
                .toFixed(prec)
        }

        // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || ''
            s[1] += new Array(prec - s[1].length + 1).join('0')
        }

        return s.join(dec)
    }

    $(document).ready(function() {

        <?php foreach ($data as $dt) : ?>
            var jum = 0;
            $.ajax({
                type: "POST",
                url: "<?= base_url('Raja_ongkir/Ekspedisi') ?>",
                success: function(hasil_ekspedisi) {
                    $('select[name="ekspedisi<?= $dt['token'] ?>"]').html(hasil_ekspedisi);
                }
            });

            $('select[name="ekspedisi<?= $dt['token'] ?>"]').on("change", function() {
                var ekspedisi = $('select[name="ekspedisi<?= $dt['token'] ?>"]').val();
                $('#expedisi<?= $dt['token'] ?>').val(ekspedisi);
                var id_kota = <?= $use['kota'] ?>;
                var berat = <?= $tot_berat ?>;
                var kota_asal = 130;
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('Raja_ongkir/Paket') ?>",
                    data: 'ekspedisi=' + ekspedisi + '&id_kota=' + id_kota + '&berat=' + berat + '&kota_asal=' + kota_asal,
                    success: function(hasil_paket) {
                        $('select[name="paket<?= $dt['token'] ?>"]').html(hasil_paket);
                    }
                });
            });

            $('select[name="paket<?= $dt['token'] ?>"]').on("change", function() {
                var datapaket = $('option:selected', this).attr('value');
                $('#paket<?= $dt['token'] ?>').val(datapaket);

                var dataestimasi = $('option:selected', this).attr('estimasi');
                $('#estimasi<?= $dt['token'] ?>').val(dataestimasi);

                var dataongkir = $('option:selected', this).attr('ongkir');
                $('#<?= $dt['token'] ?>').html(number_formatt(dataongkir));
                var ong = $('#ong<?= $dt['token'] ?>').val(dataongkir);
                $('#ongkirr<?= $dt['token'] ?>').val(dataongkir);

                // console.log(dataongkir);

                $("#ong<?= $dt['token'] ?>").each(function() {
                    jum += parseInt($(this).val());
                });
                $('#ongkir').html(number_formatt(jum));
                $('#ongkirr').val(jum);

                var total = $('#total').val();
                var totaal = $('#totaal<?= $dt['token'] ?>').val();
                var ong = $('#ong<?= $dt['token'] ?>').val();

                var tot_bayar = parseInt(total) + parseInt(jum);
                var tot_bayarr = parseInt(totaal) + parseInt(ong);

                $('#tot_bayar').html(number_formatt(tot_bayar));
                $('#total_bayar').val(tot_bayar);
                $('#total_bayarr<?= $dt['token'] ?>').val(tot_bayarr);

                if (tot_bayar > jum) {
                    $('#proses').prop('disabled', false);
                } else {
                    $('#proses').prop('disabled', true);
                }
            });

        <?php endforeach; ?>

    });
</script>