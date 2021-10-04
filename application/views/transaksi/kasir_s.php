<div style="margin-top: 85px; margin-bottom: 50px; font-size: 14px; margin-left: 40px; margin-right: 40px;">

    <div class="row">
        <div class="col-md-3 mt-2 mb-2">
            <div class="card border-deta hm">
                <div class="card-body">
                    <p class="mb-4">Petugas = <b><?= $user['nama'] ?></b></p>

                    <div class="card border-deta hm">
                        <div class="card-body">
                            <p>TOTAL :</p>
                            <input type="text" class="form-control" name="bayartotval" id="bayartotval2" hidden>
                            <div style="color: red" class="rp"><b><span id="bayartot2">0</span> </b></div>
                        </div>
                    </div>
                    <div class="card border-deta mt-3 hm">
                        <div class="card-body">
                            <p>KODE TRANSAKSI :</p>
                            <div style="color: green; text-align:center; font-size:17px"><b><?= $no_kwitansi ?></b></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 mt-2 mb-2">
            <div class="card border-deta hm">
                <div class="card-header bg-deta text-white pela">
                    <b>Transaksi Penjualan</b>
                </div>
                <div class="card-body">
                    <div class="pesan"></div>
                    <form method="post">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="kode_barang">Kode Barang</label>
                                <input type="text" class="form-control" name="kode_barang" id="kode3" onkeyup="isi()" placeholder="Kode Barang" autocomplete="off" autofocus required>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control" name="nama_barang" id="nama_barang2" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nama_barang">Harga Satuan</label>
                                <!-- <input type="hidden" class="form-control" name="harga" id="harga2" readonly> -->
                                <input type="hidden" class="form-control" name="harga_beli" id="harga_beli2" readonly>
                                <select class="form-control" name="satuan" id="satuan" disabled>
                                    <option value="0">- Pilih Satuan -</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="qty">POTONGAN</label>
                                <input type="text" class="form-control" name="potongan" id="potongan" autocomplete="off" value="0" required>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="qty">JUMLAH</label>
                                <input type="text" class="form-control" name="qty" id="qty2" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-1">
                                <h4><button type="submit" class="badge badge-danger kirim" style="background-color: #008FD4; border-color: #008FD4" id="btn_simpan2" name="kirim">Kirim</button></h4>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
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
                <hr class="mt-3">
                <div class="card-footer">
                    <form action="<?= base_url('Kasir_S/smpn_pen') ?>" method="post">
                        <div class="form-row">
                            <input type="hidden" name="username" value="<?= $user['username'] ?>">
                            <input type="hidden" name="toke" value="<?= $user['date_created'] ?>">
                            <input type="hidden" name="total" id="total2">
                            <input type="hidden" name="totval" id="totval2">
                            <input type="hidden" name="pot2" id="pot2">
                            <input type='hidden' name='no_kwitansi' class='form-control input-sm' id='nomor_nota' value="<?= $no_kwitansi ?>">
                            <input type="hidden" name="no_jurnal" class="form-control" id="no_jurnal" autocomplete="off" value="<?= $no_jurnal ?>" readonly>
                            <div class="form-group col-md-3">
                                <label for="pelanggan">Pelanggan :</label>
                                <input type="text" class="form-control" name="pelanggan" id="pelanggan2" autocomplete="off" style="width: 95%" placeholder="Kode/Nama Pelanggan">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Sales :</label><br>
                                <input type="text" class="form-control" name="sales" id="sales" autocomplete="off" style="width: 95%" placeholder="Sales">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Jam Janjian :</label><br>
                                <input type="datetime-local" class="form-control" name="jam" id="jam" autocomplete="off" style="width: 95%" placeholder="Jam Janjian">
                            </div>
                            <div class="form-group col-md-3">
                                <br>
                                <button class="btn btn-danger mt-2 btn-sm btnn" style="background-color: #008FD4; border-color: #008FD4" id="tombol2" name="enter"><i class="fas fa-save"></i> SIMPAN</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="<?= base_url('assets/') ?>jquery-3.4.1.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script src="<?= base_url('assets/') ?>popper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#kode3').autocomplete({
            source: "<?php echo site_url('Kasir_S/Auto_kasir'); ?>",

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
            source: "<?php echo site_url('Kasir_S/Auto_pel'); ?>",

            select: function(event, ui) {
                $('[name="pelanggan"]').val(ui.item.label);
                $('[name="diskon"]').val(ui.item.diskon);

            }
        });

    });

    function isi() {
        var kode = $("#kode3").val();
        $.ajax({
            url: '<?= site_url() . 'Kasir_S/Proses' ?>',
            data: {
                kode: kode
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                var json = data,
                    obj = jQuery.parseJSON(json);
                $('#nama_barang2').val(obj.nama_barang);
                $('#harga2').val(obj.harga);
                $('#harga_beli2').val(obj.harga_beli);
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
            url: '<?php echo base_url() ?>Kasir_S/data_kasir',
            async: true,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;
                var tot = 0;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    html += '<tr>' +
                        '<td width="5%">' + no++ + '</td>' +
                        '<td width="30%">' + data[i].nama_barang + '</td>' +
                        '<td width="20%">' + to_rupiah(data[i].harga) + '</td>' +
                        '<td width="10%">' + data[i].kty + '</td>' +
                        '<td width="20%">' + to_rupiah(data[i].potongan) + '</td>' +
                        '<td width="20%">' + to_rupiah(data[i].sub_total) + '</td>' +
                        '<td style="text-align:center; width:20%">' +
                        '<a href="" class="badge badge-danger hpus" id="' + data[i].kode_barang + '" hg="' + data[i].harga + '">Hapus</a>' +
                        '</td>' +
                        '</tr>';
                    tot = parseInt(tot) + parseInt(data[i].sub_total);
                }
                $("#total2").val(tot);
                $("#bayartotval2").val(tot);
                $("#totval2").val(tot);
                $("#bayartot2").html(to_rupiah(tot));
                $('#list2').html(html);
                $('#kembali2').html(to_rupiah(0));
                $("#tombol2").prop("disabled", true);

                // $("#pelanggan").val('Umum');
            }

        });
    };

    $(function() {
        $('#jam').change(function() {
            var jam = $('#jam').val();

            var total = $("#bayartotval2").val();

            if (jam != null) {
                $("#tombol2").prop("disabled", false);
            } else if (jam == '') {
                $("#tombol2").prop("disabled", true);
            } else {
                $("#tombol2").prop("disabled", true);
            }

        });
    });

    //Simpan Barang
    $('#btn_simpan2').on('click', function() {
        var valid = this.form.checkValidity();
        if (valid) {
            event.preventDefault();
            var kobar = $('#kode3').val();
            var nabar = $('#nama_barang2').val();
            var harga = $('#satuan').val();
            var harga_beli = $('#harga_beli2').val();
            var potongan = $('#potongan').val();
            var petugas = $('#petugas2').val();
            var qty = $('#qty2').val();
            var token = $('#token2').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Kasir_S/simpan_barang') ?>",
                dataType: "JSON",
                data: {
                    kobar: kobar,
                    nabar: nabar,
                    harga: harga,
                    harga_beli: harga_beli,
                    potongan: potongan,
                    petugas: petugas,
                    qty: qty,
                    token: token
                },
                success: function(data) {
                    $('[name="kode_barang"]').val("").focus();
                    $('[name="nama_barang"]').val("");
                    $('[name="satuan"]').prop("disabled", true);
                    $('[name="harga_beli"]').val("");
                    $('[name="potongan"]').val(0);
                    $('[name="petugas"]').val("");
                    $('[name="qty"]').val("");
                    $('[name="token"]').val("");
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
        $.ajax({
            url: "<?php echo base_url(); ?>Kasir_S/delete",
            method: "POST",
            data: {
                id: id,
                hg: hg
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
        var kode = $('#kode3').val();
        var qty = $('#qty2').val();

        if (qty) {
            $.ajax({
                url: "<?= base_url('Kasir_S/cek_barang') ?>",
                type: 'POST',
                data: {
                    kode: kode,
                    qty: qty
                },
                success: function(response) {
                    //var resp = $.trim(response);
                    if (response) {
                        $(".pesan").removeAttr('disabled', 'disabled').html(response);
                    }
                }
            });
        }
    });

    $(document).on('blur', '#kode3', function() {
        var kode = $(this).val();
        if (kode != "") {
            $.ajax({
                url: "<?= base_url('Kasir_S/Ambil_data') ?>",
                type: 'POST',
                data: {
                    kode: kode
                },
                success: function(response) {
                    //var resp = $.trim(response);
                    if (response != '') {
                        $("#satuan").removeAttr('disabled', 'disabled').html(response);
                    } else {
                        $("#satuan").attr('disabled', 'disabled').html("<option value=''>- Pilih Satuan -</option>");
                    }
                }
            });
        } else {
            $("#satuan").attr('disabled', 'disabled').html("<option value=''>- Pilih Satuan -</option>");
        }
    });
</script>