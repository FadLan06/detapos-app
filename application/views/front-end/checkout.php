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

        <div class="card mt-3 dtscroll" style="margin-bottom: 100px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm" cellspacing="0" style="width: 1070px;">
                            <tr>
                                <td style="text-align:right;"><strong>Total :</strong></td>
                                <td>Rp.</td>
                                <td style="text-align:right;"><strong>Ongkir :</strong></td>
                                <td>Rp. <span id="ongkir">0</span></td>
                                <td style="text-align:right;"><strong>Total Bayar :</strong></td>
                                <td>Rp. <span id="tot_bayar"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">


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