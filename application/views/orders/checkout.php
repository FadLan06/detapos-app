<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Required meta tags -->

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="shortcut icon" href="<?= base_url('assets/') ?>favicon.ico" />

    <title><?= $judul ?> - Detapos</title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>jquery-ui.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
    <style>
        .border-deta {
            border-color: #00aaff;
        }

        .bg-deta {
            background-color: #00aaff;
        }

        .btn-deta {
            background-color: #00aaff;
            border: 1px solid #00aaff;
        }

        .btn-deta:active,
        .btn-deta:focus,
        .btn-deta:hover,
        .btn-deta.active,
        .btn-deta.focus,
        .btn-deta:active,
        .btn-deta:focus,
        .btn-deta:hover,
        .open>.dropdown-toggle.btn-deta,
        .btn-outline-deta.active,
        .btn-outline-deta:active,
        .show>.btn-outline-deta.dropdown-toggle,
        .btn-outline-deta:hover,
        .btn-deta.active,
        .btn-deta:active,
        .show>.btn-deta.dropdown-toggle {
            background-color: #00aaff;
            border: 1px solid #00aaff;
        }
    </style>
</head>

<body style="background-color: #f7f7f7;">

    <div class="container" style="margin-top: 40px; margin-bottom: 30px; text-align:center">
        <!-- background-color: #891e2b; -->
        <img src="<?= base_url('assets/img/logodeta1.webp') ?>" width="100" alt="" class="mb-3">
        <div class="card col-md-12 mx-auto shadow-danger shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php foreach ($gambar as $key => $value) : ?>
                                    <?php if ($key == 0) : ?>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key ?>" class="active"></li>
                                    <?php else : ?>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key ?>"></li>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </ol>
                            <div class="carousel-inner border-deta">
                                <?php foreach ($gambar as $key => $value) : ?>
                                    <?php if ($key == 0) : ?>
                                        <div class="carousel-item active">
                                            <img src="<?php echo base_url('assets/upload/barang/') . $value->gambar ?>" class="d-block w-100" alt="">
                                        </div>
                                    <?php else : ?>
                                        <div class="carousel-item">
                                            <img src="<?php echo base_url('assets/upload/barang/') . $value->gambar ?>" class="d-block w-100" alt="">
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div align="left">
                            <?= htmlspecialchars_decode($barang->deskripsi) ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-body border-deta mb-3">
                            <table width="100%">
                                <tr align="left">
                                    <td colspan="2"><b>Rincian Pemesanan :</b></td>
                                </tr>
                                <tr align="left">
                                    <td><?= $barang->nama_barang ?></td>
                                    <td align="right">Rp. <?= number_format($barang->harga_jual) ?> <input type="hidden" id="harga" value="<?= $barang->harga_jual ?>"> </td>
                                </tr>
                                <tr align="left">
                                    <td>QTY</td>
                                    <td align="right"><input type="text" class="form-control" id="qty" style="width: 75px;" value="1" autocomplete="off"> </td>
                                </tr>
                                <tr align="left">
                                    <td><b>Kode Unik</b></td>
                                    <td align="right"><b><?php if (($set->kode_unik == 'Mengurangi') || ($set->kode_unik == '')) {
                                                                echo '-';
                                                            } ?> Rp. <span id="kode_unik"><?= substr(str_shuffle("1234567890"), 0, 3); ?></span></b></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr class="bg-deta">
                                    </td>
                                </tr>
                                <tr align="left">
                                    <td><b>Grand Total</b></td>
                                    <td align="right"><b>Rp. <span id="total"></span></b> <input type="hidden" id="tott"></td>
                                </tr>
                                <tr align="left">
                                    <td><b>Ongkir</b></td>
                                    <td align="right"><b>Rp. <span id="ongkir">0</span></b> </td>
                                </tr>
                                <tr align="left">
                                    <td><b>Total Bayar</b></td>
                                    <td align="right"><b>Rp. <span id="total_bayar">0</span></b> </td>
                                </tr>
                            </table>
                        </div>
                        <h5 align="left" class="mb-2"><b>Data Penerima :</b></h5>
                        <form method="POST" action="<?= base_url('link/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)) ?>" align="left">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="order_id" value="<?= rand() ?>">
                                <input type="hidden" class="form-control" name="token" value="<?= $barang->token ?>">
                                <input type="hidden" class="form-control" name="harga_jual" value="<?= $barang->harga_jual ?>">
                                <input type="hidden" class="form-control" name="kode_barang" value="<?= $barang->kode_barang ?>">
                                <input type="hidden" class="form-control" name="nama_barang" value="<?= $barang->nama_barang ?>">
                                <input type="hidden" class="form-control" name="berat" value="<?= $barang->berat ?>">
                                <input type="hidden" class="form-control" name="total" id="tot">
                                <input type="hidden" class="form-control" name="qty" id="qtyy">
                                <input type="hidden" class="form-control" name="kode_unik" id="kode_unikk">
                                <input type="hidden" class="form-control" name="estimasi">
                                <input type="hidden" class="form-control" name="ongkir">
                                <input type="hidden" class="form-control" name="total_bayar" id="toot">
                                <input type="text" name="nama_lengkap" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Lengkap" autocomplete="off" value="<?= set_value('nama_lengkap') ?>" autofocus>
                                <?= form_error('nama_lengkap', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <?php
                            $no = 1;
                            $noo = 1;
                            $nooo = 1;
                            if (!empty($rekening)) :
                                foreach ($rekening as $key) :  ?>
                                    <?php if (($key['aktif'] == 1)) : ?>
                                        <input type="hidden" class="form-control" name="nr<?= $no++ ?>" value="<?= $key['no_rekening'] ?>">
                                        <input type="hidden" class="form-control" name="an<?= $noo++ ?>" value="<?= $key['atas_nama'] ?>">
                                        <input type="hidden" class="form-control" name="js<?= $nooo++ ?>" value="<?= $key['jenis'] ?>">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <input type="hidden" class="form-control" id="nomor" name="nr<?= $no++ ?>">
                                <input type="hidden" class="form-control" id="nama" name="an<?= $noo++ ?>">
                                <input type="hidden" class="form-control" id="jenis" name="js<?= $nooo++ ?>">
                            <?php endif; ?>

                            <div class="form-group">
                                <input type="text" name="no_wa" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nomor HP / Whatsapp" autocomplete="off" value="<?= set_value('no_wa') ?>">
                                <?= form_error('no_wa', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" autocomplete="off" value="<?= set_value('email') ?>">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <select name="provinsi" class="form-control">
                                    <option disabled selected>
                                        <-- Pilih Provinsi -->
                                    </option>
                                </select>
                                <?= form_error('provinsi', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <select name="kota" class="form-control">
                                    <option disabled selected>
                                        <-- Pilih Kota -->
                                    </option>
                                </select>
                                <?= form_error('kota', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <select name="kecamatan" class="form-control">
                                    <option disabled selected>
                                        <-- Pilih Kecamatan -->
                                    </option>
                                </select>
                                <?= form_error('kecamatan', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <select name="ekspedisi" class="form-control">
                                    <option disabled selected>
                                        <-- Pilih Expedisi-->
                                    </option>
                                </select>
                                <?= form_error('ekspedisi', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <select name="paket" class="form-control">
                                    <option disabled selected>
                                        <-- Pilih Paket -->
                                    </option>
                                </select>
                                <?= form_error('paket', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="alamat" autocomplete="off" value="<?= set_value('alamat') ?>" placeholder="Alamat"></textarea>
                                <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <input type="text" name="kode_pos" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Kode Pos" autocomplete="off" value="<?= set_value('kode_pos') ?>">
                                <?= form_error('kode_pos', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block text-white btn-deta btn-outline-light mt-3 mb-2 shadow" name="beli" id="beli"><b>BELI SEKARANG</b> <i class="fas fa-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="page-footer font-small text-dark mt-2">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">Powered By :
            <a href="https://gammaadvertisa.co.id/" class="text-danger" target="_blank">Gamma Advertisa</a><br> <small>Copyright ©2020</small>
        </div>
        <!-- Mohammad Fadhlan Zainuddin -->
        <!-- Copyright -->

    </footer>
    <!-- Footer -->

    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
    <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var acak = $('#kode_unik').html();
            var harga = $('#harga').val();
            var qty = $('#qty').val();
            <?php if (($set->kode_unik == 'Mengurangi') || ($set->kode_unik == '')) : ?>
                var total = harga - acak;
            <?php else : ?>
                var total = parseInt(harga) + parseInt(acak);
            <?php endif; ?>

            $('#kode_unik').html(acak);
            $('#kode_unikk').val(acak);
            $('#total').html(number_formatt(total));
            $('#total_bayar').html(number_formatt(total));
            $('#tott').val(total);
            $('#tot').val(total);
            $('#toot').val(total);
            $('#qtyy').val(qty);

            $('#qty').keyup(function() {
                var qty = $('#qty').val();
                <?php if (($set->kode_unik == 'Mengurangi') || ($set->kode_unik == '')) : ?>
                    var tot = (harga * qty) - parseInt(acak);
                <?php else : ?>
                    var tot = (harga * qty) + parseInt(acak);
                <?php endif; ?>

                $('#total').html(number_formatt(tot));
                $('#total_bayar').html(number_formatt(tot));
                $('#tott').val(tot);
                $('#tot').val(tot);
                $('#toot').val(tot);
                $('#qtyy').val(qty);
                $('#kode_unikk').val(acak);

                var ong = $('#ongkir').html();
                var toba = $('#total_bayar').html();
                if (toba <= ong) {
                    $('#beli').prop('disabled', true);
                }
            });
        });

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
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('Raja_ongkir/Provinsi') ?>",
                success: function(hasil_provinsi) {
                    $('select[name="provinsi"]').html(hasil_provinsi);
                }
            });

            $('select[name="provinsi"]').on("change", function() {
                var id_provinsi = $('option:selected', this).attr('id_provinsi');
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('Raja_ongkir/Kota') ?>",
                    data: 'id_provinsi=' + id_provinsi,
                    success: function(hasil_kota) {
                        $('select[name="kota"]').html(hasil_kota);
                    }
                });
            });

            $('select[name="kota"]').on("change", function() {
                var id_kota = $('option:selected', this).attr('id_kota');
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('Raja_ongkir/Kecamatan') ?>",
                    data: 'id_kota=' + id_kota,
                    success: function(hasil_kecamatan) {
                        $('select[name="kecamatan"]').html(hasil_kecamatan);
                    }
                });
            });

            $('select[name="kota"]').on("change", function() {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('Raja_ongkir/Ekspedisi') ?>",
                    success: function(hasil_ekspedisi) {
                        $('select[name="ekspedisi"]').html(hasil_ekspedisi);
                    }
                });
            });

            $('select[name="ekspedisi"]').on("change", function() {
                var ekspedisi = $('select[name="ekspedisi"]').val();
                var id_kota = $('option:selected', 'select[name="kota"]').attr('id_kota');
                var berat = <?= $barang->berat ?>;
                var token = '<?= $barang->token ?>';
                var kota_asal = '<?= $this->uri->segment(3) ?>';
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('Raja_ongkir/Paket') ?>",
                    data: 'ekspedisi=' + ekspedisi + '&id_kota=' + id_kota + '&berat=' + berat + '&token=' + token + '&kota_asal=' + kota_asal,
                    success: function(hasil_paket) {
                        $('select[name="paket"]').html(hasil_paket);
                        // console.log(kota_asal);
                    }
                });
            });

            $('select[name="paket"]').on("change", function() {
                var dataongkir = $('option:selected', this).attr('ongkir');
                $('#ongkir').html(number_formatt(dataongkir));

                var tot = $('#tott').val();
                var total_bayar = parseInt(dataongkir) + parseInt(tot);
                $('#total_bayar').html(number_formatt(total_bayar));

                var estimasi = $('option:selected', this).attr('estimasi');
                $('input[name="estimasi"]').val(estimasi);
                $('input[name="ongkir"]').val(dataongkir);
                $('input[name="total_bayar"]').val(total_bayar);

                if (total_bayar > dataongkir) {
                    $('#beli').prop('disabled', false);
                } else {
                    $('#beli').prop('disabled', true);
                }
            });

        });

        $.ajax({
            type: 'GET',
            url: "<?= base_url('Moota/Bank') ?>",
            async: true,
            dataType: 'json',
            success: function(dr) {
                // console.log(dr);
                var rek = dr['data'][0]['account_number'];
                var an = dr['data'][0]['atas_nama'];
                var bank_id = dr['data'][0]['bank_id'];
                var jenis = 'bank-' + dr['data'][0]['bank_type'];
                var hasil = '<img src="<?= base_url('assets/img/bank-') ?>' + dr['data'][0]['bank_type'] + '.png" class="card-img-top mx-auto mt-3">';
                $('#nomor').val(rek);
                $('#nama').val(an);
                $('#jenis').val(jenis);
            }
        });
    </script>

</body>

</html>