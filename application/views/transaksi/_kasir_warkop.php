<div class="modal-content">
    <div class="modal-header bg-deta text-white">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Transaksi Kasir (Meja <?= $data ?>)</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4">
                <form method="post">
                    <div class="form-group">
                        <label for="kode_barang">KODE</label>
                        <!-- <input type="text" class="form-control" name="kode_barang" id="kode2" placeholder="Kode" autocomplete="off" autofocus required> -->
                        <select name="kode_barang" id="kode2" class="select2 form-control custom-select" autofocus required>
                            <option selected>-- Pilih --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">MENU</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="harga">HARGA</label>
                        <input type="text" class="form-control" name="harga" id="harga" readonly>
                        <input type="hidden" class="form-control" name="harga_beli" id="harga_beli" readonly>
                    </div>
                    <div class="form-group">
                        <label for="qty">JUMLAH</label>
                        <input type="text" class="form-control" name="qty" id="qty" autocomplete="off" required placeholder="0">
                    </div>
                    <div class="form-group">
                        <h4><button type="submit" class="badge badge-danger" style="background-color: #00aaff; border-color: #00aaff" id="btn_simpan2" name="kirim">Kirim</button></h4>
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                <div class="table-responsive anyClass3">
                    <table class="table table-striped table-sm" style="width: 100%; font-size: 12px" id="mydata2">
                        <thead>
                            <tr style="border-bottom:1px solid #ccc;">
                                <th>#</th>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th colspan="2">Sub Total</th>
                                <!-- <th></th> -->
                            </tr>
                        </thead>
                        <tbody id="list2">

                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <hr class="bg-deta">
                    <div class="row">
                        <div class="col-md">
                            <p>BAYAR :</p>
                            <input type="text" class="form-control" name="bayartotval" id="bayartotval2" hidden>
                            <h3 style="color: red"><b><span id="bayartot2">0</span> </b></h3>
                        </div>
                        <div class="col-md">
                            <p>KEMBALIAN :</p>
                            <h3 style="color: green"><b><span id="kembali2">0</span></b></h3>
                        </div>
                        <div class="col-md-3">
                            <p>MEJA :</p>
                            <h3 style="color: #00aaff"><b><span><?= $data ?></span></b></h3>
                        </div>
                    </div>
                    <hr class="bg-deta">
                    <form action="<?= base_url('Kasir_Warkop/smpn_pen') ?>" method="post">
                        <div class="form-row">
                            <div class="form-group col-sm-3">
                                <input type="text" class="form-control" name="pelanggan" id="pelanggan2" autocomplete="off" placeholder="Ketik Pelanggan">
                            </div>
                            <div class="form-group col-sm-3">
                                <input type="text" name="bayar" class="form-control" id="bayar2" autocomplete="off" placeholder="Bayar (Rp)">
                                <span class="text-danger" id="span2"></span>
                            </div>
                            <div class="form-group col-sm-2">
                                <button class="btn btn-deta btn-sm btn-block" id="tombol2" name="enter"><i class="fas fa-save"></i> BAYAR</button>
                            </div>
                            <div class="form-group col-sm-2">
                                <button class="btn btn-success btn-sm btn-block" id="tombol2" name="enter"><i class="fas fa-save"></i> SIMPAN</button>
                            </div>
                            <div class="form-group col-sm-2">
                                <button class="btn btn-warning btn-sm btn-block" id="tombol2" name="enter"><i class="fas fa-print"></i> CETAK</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/jquery-ui.js"></script>
<script src="<?= base_url() ?>assets/js/popper.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<script type="text/javascript">
    tampil_data();

    $('#mydata2');

    //fungsi tampil barang
    function tampil_data() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Kasir_Warkop/data_kasir',
            async: true,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;
                var tot = 0;
                var tot1 = 0;
                var no = 1;
                for (i = 0; i < data.length; i++) {
                    html += '<tr>' +
                        '<td width="5%">' + no++ + '</td>' +
                        '<td width="30%">' + data[i].nama_barang + '</td>' +
                        '<td width="20%">' + to_rupiah(data[i].harga) + '</td>' +
                        '<td width="10%">' + data[i].kty + '</td>' +
                        '<td width="20%">' + to_rupiah(data[i].sub_total) + '</td>' +
                        '<td style="text-align:center; width:20%">' +
                        '<a href="" class="badge badge-danger hpus" id="' + data[i].kode_barang + '" hg="' + data[i].harga + '">Hapus</a>' +
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

    $('#btn_simpan2').on('click', function() {
        var valid = this.form.checkValidity();
        if (valid) {
            event.preventDefault();
            var kobar = $('#kode2').val();
            var nabar = $('#nama_barang').val();
            var harga_beli = $('#harga_beli').val();
            var harga = $('#harga').val();
            var qty = $('#qty').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Kasir_Warkop/simpan_barang') ?>",
                dataType: "JSON",
                data: {
                    kobar: kobar,
                    nabar: nabar,
                    harga: harga,
                    harga_beli: harga_beli,
                    qty: qty
                },
                success: function(data) {
                    // $('#view').modal('show');

                    $('[name="kode_barang"]').select("");
                    $('[name="nama_barang"]').val("");
                    $('[name="harga_beli"]').val("");
                    $('[name="harga"]').val("");
                    $('[name="qty"]').val("");
                    tampil_data();
                }
            });
            return false;
        }
    });


    $(document).ready(function() {
        $("#kode2").select2();
    });

    $(document).ready(function() {
        var app = {
            show: function() {
                $.ajax({
                    url: "<?= base_url('Kasir_Warkop/show_data') ?>",
                    method: "GET",
                    success: function(data) {
                        $("#kode2").html(data)
                    }
                })
            },
            tampil: function() {
                var kode = $(this).val();
                $.ajax({
                    url: "<?= base_url('Kasir_Warkop/get_data') ?>",
                    method: "POST",
                    data: {
                        kode: kode
                    },
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data.nama_barang);
                        $('[name="nama_barang"]').val(data.nama_barang);
                        $('[name="harga"]').val(data.harga);
                        $('[name="harga_beli"]').val(data.harga_beli);
                    }
                })
            }
        }
        app.show();
        $(document).on("change", "#kode2", app.tampil)
    });
</script>