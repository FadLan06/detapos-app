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
                    <h4 style="font-size: 20px; margin-bottom: 0; margin-top: 0;"><?= $judul ?></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="pesan"></div>
                        <form method="post">
                            <div class="form-group">
                                <!-- <label for="kode_barang">Kode Barang</label> -->
                                <input type="text" class="form-control" name="kode_barang" id="kode2" onkeyup="isi_otomatisbut()" placeholder="Kode Barang" autocomplete="off" autofocus required>
                            </div>
                            <div class="form-group">
                                <!-- <label for="nama_barang">Nama Barang</label> -->
                                <input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang" id="nama_barang2" readonly>
                            </div>
                            <div class="form-group">
                                <!-- <label for="nama_barang">Varian</label> -->
                                <select class="form-control" name="varian" id="varian" disabled>
                                    <option value="0" selected>- Pilih Varian Warna -</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- <label for="nama_barang">Ukuran</label> -->
                                <select class="form-control" name="ukuran" id="ukuran" disabled>
                                    <option value="0" selected>- Pilih Ukuran -</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- <label for="nama_barang">Harga Satuan</label> -->
                                <!-- <input type="hidden" class="form-control" name="harga" id="harga2" readonly> -->
                                <input type="hidden" class="form-control" name="harga_beli" id="harga_beli2" readonly>
                                <select class="form-control" name="satuan" id="satuan" disabled>
                                    <option value="0" selected>- Pilih Harga Satuan -</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- <label for="qty">POTONGAN (Rp)</label> -->
                                <input type="number" class="form-control" min="0" name="potongan" id="potongan" autocomplete="off" placeholder="POTONGAN (Rp)">
                            </div>
                            <div class="form-group">
                                <!-- <label for="qty">QTY</label> -->
                                <input type="number" min="1" class="form-control" name="qty" id="qty2" autocomplete="off" required placeholder="QTY">
                            </div>
                            <div class="form-group">
                                <h4><button type="submit" class="btn btn-danger" disabled style="background-color: #00aaff; border-color: #00aaff" id="btn_simpan2" name="kirim"><i class="fas fa-send"></i> Kirim</button></h4>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card m-b-30 mt-3">
                    <div class="card-body mx-auto">
                        <a href="https://play.google.com/store/apps/details?id=com.arifdauhi.detapos" class="btn btn-outline-deta" target="_blank">Download App Android</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="table-responsive anyClass1">
                            <table class="table table-striped table-sm" style="width: 100%; font-size: 12px" id="mydata2">
                                <thead>
                                    <tr style="border-bottom:1px solid #ccc;">
                                        <th>#</th>
                                        <th>Barang</th>
                                        <th>Harga</th>
                                        <th>Item</th>
                                        <th>Potongan</th>
                                        <th colspan="2">Sub Total</th>
                                        <!-- <th></th> -->
                                    </tr>
                                </thead>
                                <tbody id="list2">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer" style="background-color: white; border-top: solid 2px #00aaff">
                        <form action="<?= base_url('Kasir_Butik/smpn_pen') ?>" method="post">
                            <div class="form-row">
                                <input type="hidden" name="username" value="<?= $user['username'] ?>">
                                <input type="hidden" name="toke" value="<?= $user['date_created'] ?>">
                                <input type="hidden" name="total" id="total2">
                                <input type="hidden" name="totval" id="totval2">
                                <input type="hidden" name="totpok" id="totpok">
                                <input type="hidden" name="pot2" id="pot2">
                                <input type='hidden' name='no_kwitansi' class='form-control input-sm' id='nomor_nota' value="<?= $no_kwitansi ?>">
                                <input type="hidden" name="no_jurnal" class="form-control" id="no_jurnal" autocomplete="off" value="<?= $no_jurnal ?>" readonly>
                                <div class="form-group col-md-3">
                                    <label for="">Status Pembayaran :</label><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="lunas" onclick="tampil(this.value)" name="status" class="custom-control-input" value="Lunas" checked>
                                        <label class="custom-control-label" for="lunas">Lunas</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="hutang" onclick="tampil(this.value)" name="status" class="custom-control-input" value="Hutang">
                                        <?php if (($this->session->userdata('token') == 'DPE8DR8MRWKYNHJPV')) : ?>
                                            <label class="custom-control-label" for="hutang">Uang Muka</label>
                                        <?php else : ?>
                                            <label class="custom-control-label" for="hutang">Hutang</label>
                                        <?php endif; ?>
                                    </div>
                                    <input type="date" class="form-control tempo mt-2" style="display:none; width: 85%" name="tempo" id="tempo" autocomplete="off">
                                </div><input type="hidden" id="result">
                                <div class="form-group col-md-3">
                                    <label for="pelanggan">Pelanggan :</label>
                                    <input type="text" class="form-control" name="pelanggan" id="pelanggan2" autocomplete="off" style="width: 95%" placeholder="Ketik Pelanggan">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="diskon">Diskon :</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="diskon2" name="diskon" autocomplete="off" value="0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                                        </div>
                                    </div>
                                </div>
                                <?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) : ?>
                                    <div class="form-group col-md-4">
                                        <label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="tunai" name="metodePem" class="custom-control-input" value="Tunai" checked>
                                                <label class="custom-control-label" for="tunai">Tunai</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="transfer" name="metodePem" class="custom-control-input" value="Transfer">
                                                <label class="custom-control-label" for="transfer">Transfer</label>
                                            </div>
                                        </label>
                                        <select name="bank" id="bank" class="form-control mb-1" style="display: none;">
                                            <option value="">Pilih Bank ...</option>
                                            <?php foreach ($rekening as $data) : ?>
                                                <option value="<?= strtoupper(substr($data->jenis, 5)) . ' - ' . $data->no_rekening ?>"><?= strtoupper(substr($data->jenis, 5)) . ' - ' . $data->no_rekening ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="text" name="bayar" class="form-control" placeholder="Bayar (Rp)" id="bayar2" autocomplete="off">
                                        <button class="btn btn-danger mt-3 btn-sm btnn" style="background-color: #008FD4; border-color: #008FD4" id="tombol2" name="enter"><i class="fas fa-save"></i> BAYAR (ENTER)</button><br>
                                        <span class="text-danger" id="span2"></span>
                                    </div>
                                <?php else : ?>
                                    <div class="form-group col-md-4">
                                        <label for="">Bayar (Rp) :</label>
                                        <input type="text" name="bayar" class="form-control" id="bayar2" autocomplete="off">
                                        <button class="btn btn-danger mt-3 btn-sm btnn" style="background-color: #008FD4; border-color: #008FD4" id="tombol2" name="enter"><i class="fas fa-save"></i> BAYAR (ENTER)</button><br>
                                        <span class="text-danger" id="span2"></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                <p>Nama Kasir = <b><?= $user['nama'] ?></b></p>
                <div class="row">
                    <div class="col-md">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <p>BAYAR :</p>
                                <input type="text" class="form-control" name="bayartotval" id="bayartotval2" hidden>
                                <h3 style="color: red"><b><span id="bayartot2">0</span> </b></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <p>KEMBALIAN :</p>
                                <h3 style="color: green"><b><span id="kembali2">0</span></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script src="<?= base_url() ?>assets/js/popper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#kode2').autocomplete({
            source: "<?php echo site_url('Kasir_Butik/Auto_kasir'); ?>",

            select: function(event, ui) {
                $('[name="kode_barang"]').val(ui.item.label);
                $('[name="nama_barang"]').val(ui.item.nama);
                $('[name="satuan"]').val(ui.item.satuan);
                $('[name="harga"]').val(ui.item.harga);
                $('[name="harga_beli"]').val(ui.item.harga_beli);
            }
        });

    });

    $(document).ready(function() {

        $('#pelanggan2').autocomplete({
            source: "<?php echo site_url('Kasir_Butik/Auto_pel'); ?>",

            select: function(event, ui) {
                $('[name="pelanggan"]').val(ui.item.label);
                $('[name="diskon"]').val(ui.item.diskon);

                var pot = $("#diskon2").val();
                var total = $("#total2").val();

                var tot_bar = total - ((total * pot) / 100);
                var tot = (total * pot) / 100;
                if (tot_bar > 0) {
                    $("#bayartot2").html(to_rupiah(tot_bar));
                    $("#bayartotval2").val(tot_bar);
                    $("#totval2").val(tot_bar);
                    $("#pot2").val(tot);
                } else {
                    $("#bayartot2").html(to_rupiah(0));
                    $("#bayartotval2").val();
                    $("#totval2").val();
                    $("#pot2").val();
                }
            }
        });

        $('#diskon2').keyup(function() {
            var diskon = $("#diskon2").val();
            var total = $("#total2").val();

            var tots = total - ((total * diskon) / 100);
            var tot = (total * diskon) / 100;
            if (tots > 0) {
                $("#bayartot2").html(to_rupiah(tots));
                $("#bayartotval2").val(tots);
                $("#totval2").val(tots);
                $("#pot2").val(tot);
            } else {
                $("#bayartot2").html(to_rupiah(0));
                $("#bayartotval2").val();
                $("#totval2").val();
                $("#pot2").val();
            }
        });

    });

    function isi_otomatisbut() {
        var kode = $("#kode2").val();
        $.ajax({
            url: '<?= site_url() . 'Kasir_Butik/Proses' ?>',
            data: {
                kode: kode
            },
            dataType: 'json',
            success: function(data) {
                var obj = data;
                $('[name="nama_barang"]').val(obj.nama_barang);
                $('[name="satuan"]').val(obj.satuan);
                $('[name="harga_beli"]').val(obj.harga_beli);
            }
        });
    }

    document.onkeydown = function(e) {
        switch (e.keyCode) {
            case 119:
                $('#bayar2').focus();
                return false;
        }
    };

    tampil_data_barang2(); //pemanggilan fungsi tampil barang.

    $('#mydata2');

    //fungsi tampil barang
    function tampil_data_barang2() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Kasir_Butik/data_kasir',
            async: true,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;
                var tot = 0;
                var tot1 = 0;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    if (data[i].varian != 0) {
                        var varian = '<td width="30%">' + data[i].nama_barang + ' <br>' + data[i].varian + ' / ' + data[i].ukuran + '</td>';
                    } else {
                        var varian = '<td width="30%">' + data[i].nama_barang + '</td>';
                    };

                    html += '<tr>' +
                        '<td width="5%">' + no++ + '</td>' +
                        varian +
                        '<td width="20%">' + to_rupiah(data[i].harga) + '</td>' +
                        '<td width="10%">' + data[i].kty + '</td>' +
                        '<td width="20%">' + to_rupiah(data[i].potongan) + '</td>' +
                        '<td width="20%">' + to_rupiah(data[i].sub_total) + '</td>' +
                        '<td style="text-align:center; width:20%">' +
                        '<a href="" class="badge badge-danger hpus" id="' + data[i].kode_barang + '" hg="' + data[i].harga + '" vr="' + data[i].varian + '" uk="' + data[i].ukuran + '">Hapus</a>' +
                        '</td>' +
                        '</tr>';
                    tot = parseInt(tot) + parseInt(data[i].sub_total);
                    tot1 = parseInt(tot1) + parseInt(data[i].hg_pokok);
                }
                $("#total2").val(tot);
                $("#bayartotval2").val(tot);
                $("#totval2").val(tot);
                $("#totpok").val(tot1);
                $("#bayartot2").html(to_rupiah(tot));
                $('#list2').html(html);
                $('#kembali2').html(to_rupiah(0));
                $("#tombol2").prop("disabled", true);

                // $("#pelanggan").val('Umum');
            }

        });
    };

    function tampil(status) {
        document.getElementById("result").value = status;
    }

    $(function() {
        // $("#bayar").val();
        $("#bayar2").number(true);
        $('#bayar2').keyup(function() {
            var bayar = $('#bayar2').val();
            // $("#bayar2").val(parseInt(bayar));
            // var kembali = $('#kembali').html(to_rupiah(0));
            if (bayar == '') {
                $("#span2").prop("hidden", true);
            }

            var total = $("#bayartotval2").val();
            var uang = $("#bayar2").val();

            if (total != '0') {
                if (bayar == '') {
                    $("#span2").prop("hidden", true);
                } else if (parseInt(bayar) >= parseInt(total)) {
                    var kembali = uang - total;
                    $("#span2").html('');
                    $("#kembali2").html(to_rupiah(kembali));
                    $("#tombol2").prop("disabled", false);
                } else {
                    var status = document.getElementById("result").value;
                    if ((status == 'Hutang')) {
                        $("#tombol2").prop("disabled", false);
                    } else {
                        $("#span2").html('Jumlah Uang Tidak Cukup');
                        $("#kembali2").html(to_rupiah(0));
                        $("#tombol2").prop("disabled", true);
                    }
                }
            }
        });
    });

    <?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR')) : ?>
        // $('.tempo').hide();
        $(document).ready(function() {
            $('#hutang').on('change', function() {
                $(".tempo").prop('required', true);
                $(".tempo").show();
            });
            $('#lunas').on('change', function() {
                $(".tempo").prop('required', false);
                $(".tempo").hide();
            });
        });

        $(document).ready(function() {
            $('#transfer').on('change', function() {
                $("#bank").show();
                $("#bank").prop('required', true);
            });
            $('#tunai').on('change', function() {
                $("#bank").hide();
                $("#bank").val("");
                $("#bank").prop('required', false);
            });
        });
    <?php endif; ?>

    //Simpan Barang
    $('#btn_simpan2').on('click', function() {
        var valid = this.form.checkValidity();
        if (valid) {
            event.preventDefault();
            var kobar = $('#kode2').val();
            var nabar = $('#nama_barang2').val();
            var harga = $('#satuan').val();
            var harga_beli = $('#harga_beli2').val();
            var potongan = $('#potongan').val();
            var ukuran = $('#ukuran').val();
            var varian = $('#varian').val();
            var petugas = $('#petugas2').val();
            var qty = $('#qty2').val();
            var token = $('#token2').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Kasir_Butik/simpan_barang') ?>",
                dataType: "JSON",
                data: {
                    kobar: kobar,
                    nabar: nabar,
                    harga: harga,
                    harga_beli: harga_beli,
                    potongan: potongan,
                    ukuran: ukuran,
                    varian: varian,
                    petugas: petugas,
                    qty: qty,
                    token: token
                },
                success: function(data) {
                    $('[name="kode_barang"]').val("").focus();
                    $('[name="nama_barang"]').val("");
                    $('#satuan').attr('disabled', 'disabled').html("<option value=''>- Pilih Satuan Harga -</option>");
                    $('#ukuran').attr('disabled', 'disabled').html("<option value=''>- Pilih Ukuran -</option>");
                    $('#varian').attr('disabled', 'disabled').html("<option value=''>- Pilih Varian Warna-</option>");
                    $('[name="satuan"]').prop("disabled", true);
                    $('[name="ukuran"]').prop("disabled", true);
                    $('[name="varian"]').prop("disabled", true);
                    $('[name="harga_beli"]').val("");
                    $('[name="potongan"]').val('');
                    $('[name="petugas"]').val("");
                    $('[name="qty"]').val("");
                    $('[name="token"]').val("");
                    $('#btn_simpan2').prop('disabled', true);
                    tampil_data_barang2();
                }
            });
            return false;
        }
    });

    // Hapus
    $(document).on('click', '.hpus', function() {
        var id = $(this).attr("id");
        var hg = $(this).attr("hg");
        var vr = $(this).attr("vr");
        var uk = $(this).attr("uk");
        $.ajax({
            url: "<?php echo base_url(); ?>Kasir_Butik/delete",
            method: "POST",
            data: {
                id: id,
                hg: hg,
                vr: vr,
                uk: uk,
            },
            success: function(data) {
                $('[name="kode_barang"]').focus();
                tampil_data_barang2();
            }
        });
        return false;
    });

    function to_rupiah(angka) {
        var rev = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2 = '';
        for (var i = 0; i < rev.length; i++) {
            rev2 += rev[i];
            if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                rev2 += '.';
            }
        }
        return 'Rp. ' + rev2.split('').reverse().join('');
    }
</script>

<script type="text/javascript">
    $(document).on('keyup', '#qty2', function() {
        var kode = $('#kode2').val();
        var qty = $('#qty2').val();

        if (qty) {
            $.ajax({
                url: "<?= base_url('Kasir_Butik/cek_barang') ?>",
                type: 'POST',
                data: {
                    kode: kode,
                    qty: qty
                },
                success: function(response) {
                    //var resp = $.trim(response);
                    if (response != '') {
                        $(".pesan").removeAttr('disabled', 'disabled').html(response);
                        $('#btn_simpan2').prop('disabled', true);
                    } else {
                        $('#btn_simpan2').prop('disabled', false);
                    }
                    // console.log(response)
                }
            });
        }
    });

    $(document).on('blur', '#kode2', function() {
        var kode = $(this).val();
        if (kode != "") {
            $.ajax({
                url: "<?= base_url('Kasir_Butik/Ambil_data') ?>",
                type: 'POST',
                data: {
                    kode: kode
                },
                success: function(response) {
                    //var resp = $.trim(response);
                    if (response != '') {
                        $("#satuan").removeAttr('disabled', 'disabled').html(response);
                    } else {
                        $("#satuan").attr('disabled', 'disabled').html("<option value=''>- Pilih Harga Satuan -</option>");
                    }
                }
            });
        } else {
            $("#satuan").attr('disabled', 'disabled').html("<option value=''>- Pilih Harga Satuan -</option>");
        }
    });

    $(document).on('blur', '#kode2', function() {
        var kode = $(this).val();
        if (kode != "") {
            $.ajax({
                url: "<?= base_url('Kasir_Butik/Ambil_data1') ?>",
                type: 'POST',
                data: {
                    kode: kode
                },
                success: function(response) {

                    if (response != '') {
                        $("#varian").removeAttr('disabled', 'disabled').html(response);
                    } else {
                        $("#varian").prop('hidden', true);
                    }
                }
            });
        } else {
            $("#varian").attr('disabled', 'disabled').html("<option value=''>- Pilih Varian Warna -</option>");
        }
    });

    $(document).on('blur', '#kode2', function() {
        var kode = $(this).val();
        if (kode != "") {
            $.ajax({
                url: "<?= base_url('Kasir_Butik/Ambil_data2') ?>",
                type: 'POST',
                data: {
                    kode: kode
                },
                success: function(response) {
                    //var resp = $.trim(response);
                    if (response != '') {
                        $("#ukuran").removeAttr('disabled', 'disabled').html(response);
                    } else {
                        $("#ukuran").prop('hidden', true);
                    }
                }
            });
        } else {
            $("#ukuran").attr('disabled', 'disabled').html("<option value=''>- Pilih Ukuran -</option>");
        }
    });
</script>