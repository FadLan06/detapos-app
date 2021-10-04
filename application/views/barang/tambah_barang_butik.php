<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Data Barang</a></li>
                            <li class="breadcrumb-item active"><?= $judul ?></li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?= $judul ?></h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <?= $this->session->flashdata('message') ?>
                        <form method="post" action="<?= base_url('Barang/Aksi') ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">KODE BARANG</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="text" class="form-control border-deta" id="kodee1" name="kode_barang" autocomplete="off" required autofocus>
                                            <?= form_error('kode_barang', '<small class="text-white pl-3">', '</small>') ?>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-deta" onclick="myFunction()" type="button">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">NAMA BARANG</label>
                                    <input type="text" class="form-control border-deta" id="inputPassword4" name="nama_barang" autocomplete="off" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">EXP. DATE</label>
                                    <input type="date" class="form-control border-deta" id="inputPassword4" name="tgl_tempo" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="modal">HARGA MODAL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                                        </div>
                                        <input type="text" class="form-control border-deta modall" id="modal" name="harga_beli" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputZip">SATUAN</label>
                                    <input type="text" class="form-control border-deta" id="inputZip" name="satuann" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="jual">HARGA JUAL 1</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                                        </div>
                                        <input type="text" class="form-control border-deta juall" id="jual" name="harga_jual[]" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="persen">PERSENTASE</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control border-deta persenn" id="persen" name="persen[]" autocomplete="off" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="profit">PROFIT/KEUNTUNGAN</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                                        </div>
                                        <input type="text" class="form-control border-deta profitt" id="profit" name="profit[]" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZip">SATUAN</label>
                                    <input type="text" class="form-control border-deta" id="inputZip" name="satuan[]" autocomplete="off">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="inputZip">AKSI</label><br>
                                    <button class="btn btn-deta" type="button" onclick="tambah_baris();"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div id="tambah_baris"></div>

                            <?php if ($set['reseller'] == 1) : ?>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="jual">HARGA RESELLER</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                                            </div>
                                            <input type="text" class="form-control border-deta juall" id="jual_r" name="harga_r" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="persen">PERSENTASE</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control border-deta persenn" id="persen_r" name="persen_r" autocomplete="off" required>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="profit">PROFIT/KEUNTUNGAN</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                                            </div>
                                            <input type="text" class="form-control border-deta profitt" id="profit_r" name="profit_r" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZip">SATUAN</label>
                                        <input type="text" class="form-control border-deta" id="inputZip" name="satuan_r" autocomplete="off">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="kategori">KATEGORI</label>
                                    <select id="kategorii" class="form-control border-deta" name="kode_kategori">
                                        <option value="">Pilih...</option>
                                        <?php foreach ($kategori as $ket) : ?>
                                            <option value="<?= $ket->kode_kategori ?>"><?= $ket->kode_kategori ?> / <?= $ket->nama_kategori ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="kategori">SUB KATEGORI</label>
                                    <select id="subkategorii" class="form-control border-deta" name="sub_kategori">
                                        <option value="">Pilih...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="warna">WARNA</label>
                                    <select id="warna" class="form-control border-deta select2 select2-multiple" name="warna[]" multiple="multiple" data-placeholder="Pilih...">
                                        <option value="">Pilih...</option>
                                        <?php foreach ($warna as $war) : ?>
                                            <option value="<?= $war->nama_warna ?>"><?= $war->nama_warna ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="ukuran">UKURAN</label>
                                    <select id="ukuran" class="form-control border-deta select2 select2-multiple" name="ukuran[]" multiple="multiple" data-placeholder="Pilih...">
                                        <option value="">Pilih...</option>
                                        <?php foreach ($ukuran as $uk) : ?>
                                            <option value="<?= $uk->nama_ukuran ?>"><?= $uk->nama_ukuran ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputCity">JUMLAH STOK</label>
                                    <input type="number" class="form-control border-deta" id="inputCity" name="jml_stok" autocomplete="off" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputCity">MINIMAL STOK</label>
                                    <input type="number" class="form-control border-deta" id="inputCity" name="min_stok" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCity">Berat (Gr)</label>
                                    <input type="number" min="0" class="form-control border-deta" name="berat" required autocomplete="off">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCity">Dropshipper</label>
                                    <select name="dropship" id="dropship" class="form-control" required>
                                        <option value="1">Aktifkan kirim sebagai Dropshipper</option>
                                        <option value="0">Non Aktifkan kirim sebagai Dropshipper</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCity">View TokoOnline</label>
                                    <select name="status" id="status1" class="form-control" required>
                                        <option value="1">Tampilkan</option>
                                        <option value="0">Tidak di Tampilkan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCity">GAMBAR PRODUK</label>
                                    <input type="file" class="form-control border-deta" id="produk_load" onchange="previeww(this);" name="gambar" autocomplete="off">
                                    <small>Size = 600 x 600 pixel <br> Filesize = 1 MB (1024 KB)</small><br>
                                    <img class="mt-3" src="<?= base_url('assets/images/no-image.png') ?>" width="150px" alt="" id="preview_produk">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="inputZip">DESKRIPSI</label>
                                    <textarea class="form-control border-deta" name="deskripsi" id="editor1" required></textarea>
                                </div>
                            </div>
                            <hr class="bg-deta">
                            <button type="submit" class="btn btn-deta float-right" name="smpn_brng_bt">Tambah</button>
                            <a class="btn btn-warning float-right mr-3" href="<?= base_url('Barang') ?>">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1');
</script>
<script>
    $(document).ready(function() {

        $('#kodee1').autocomplete({
            source: "<?php echo site_url('Barang/Auto_Barang_Butik'); ?>",

            select: function(event, ui) {
                $('[name="kode_barang"]').val(ui.item.label);
                $('[name="nama_barang"]').val(ui.item.nama_barang).prop('readonly', true);
                $('[name="harga_beli"]').val(ui.item.harga_beli).prop('readonly', true);
                $('[name="satuan"]').val(ui.item.satuan).prop('readonly', true);
                $('[name="jml_stok"]').val(ui.item.kty).prop('readonly', true);
            }
        });

    });

    $(document).ready(function() {

        $('#kategorii').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?php echo site_url('Barang/get_sub_kategori'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {

                    var html = '<option>Pilih...</option>';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].nama_sub_kategori + '>' + data[i].nama_sub_kategori + '</option>';
                    }
                    $('#subkategorii').html(html);

                }
            });
            return false;
        });

    });

    function myFunction() {
        var as = Math.ceil(Math.random() * 8928389218398);
        $('#kodee1').val(as);
    }
</script>

<script>
    window.previeww = function(input) {
        if (input.files && input.files[0]) {
            $(input.files).each(function() {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function(e) {
                    $("#preview_produk").attr('src', e.target.result);
                }
            });
        }
    }
</script>

<script src="<?= base_url('assets/') ?>cleave.min.js"></script>
<script>
    function to_rupiahh(angka) {
        var rev = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2 = '';
        for (var i = 0; i < rev.length; i++) {
            rev2 += rev[i];
            if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                rev2 += '.';
            }
        }
        return '' + rev2.split('').reverse().join('');
    }
</script>
<script type="text/javascript">
    var room = 1;

    function tambah_baris() {
        room++;
        var objTo = document.getElementById('tambah_baris')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "removeclass" + room);
        var rdiv = 'removeclass' + room;
        divtest.innerHTML =
            `
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="jual">HARGA JUAL ` + room + `</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
            </div>
            <input type="text" class="form-control border-deta juall` + room + `" id="jual` + room + `" name="harga_jual[]" autocomplete="off" required>
          </div>
        </div>
        <div class="form-group col-md-3">
          <label for="persen">PERSENTASE</label>
          <div class="input-group">
            <input type="text" class="form-control border-deta persenn` + room + `" id="persen` + room + `" name="persen[]" autocomplete="off" required>
            <div class="input-group-prepend">
              <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
            </div>
          </div>
        </div>
        <div class="form-group col-md-3">
          <label for="profit">PROFIT/KEUNTUNGAN</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
            </div>
            <input type="text" class="form-control border-deta profitt` + room + `" id="profit` + room + `" name="profit[]" autocomplete="off" required>
          </div>
        </div>
        <div class="form-group col-md-2">
          <label for="inputZip">SATUAN</label>
          <input type="text" class="form-control border-deta" id="inputZip" name="satuan[]" autocomplete="off">
        </div>
        <div class="form-group col-md-1">
          <label for="inputZip">AKSI</label><br>
          <button class="btn btn-danger" type="button" onclick="remove_tambahbaris(` + room + `);"> <i class="fa fa-minus"></i> </button>
        </div>
      </div>

      `;
        objTo.appendChild(divtest);

        $("#jual" + room).number(true);
        $("#persen" + room).number(true);
        $("#profit" + room).number(true);

        $("#modal").keyup(function() {
            var muodal = $("#modal").val();
            if (muodal > 0) {
                $("#jual" + room).prop("disabled", false);
                $("#persen" + room).prop("disabled", false);
                $("#profit" + room).prop("disabled", false);

                var profit = $("#profit" + room).val();
                var jual = parseInt(muodal) + parseInt(profit);
                var persen = (parseInt(profit) / parseInt(muodal)) * 100;

                if (jual > 0) {
                    $("#jual" + room).val(jual);
                    $("#persen" + room).val(persen);
                }
            } else {
                $("#jual" + room).prop("disabled", true);
                $("#persen" + room).prop("disabled", true);
                $("#profit" + room).prop("disabled", true);
            }
        });

        $("#jual" + room).keyup(function() {
            var modal = $("#modal").val();
            var jual = $("#jual" + room).val();

            var profit = parseInt(jual) - parseInt(modal);
            var persen = (profit / modal) * 100;

            if (jual > 0) {
                $("#profit" + room).val(profit);
                $("#persen" + room).val(persen);
            } else {
                $("#profit" + room).val("");
                $("#persen" + room).val("");
            }
        });

        $("#persen" + room).keyup(function() {
            var modal = $("#modal").val();
            var persen = $("#persen" + room).val();

            var profit = persen / 100 * modal;
            var jual = parseInt(profit) + parseInt(modal);

            if (persen > 0) {
                $("#jual" + room).val(jual);
                $("#profit" + room).val(profit);
            } else {
                $("#jual" + room).val("");
                $("#profit" + room).val("");
            }
        });

        $("#profit" + room).keyup(function() {
            var modal = $("#modal").val();
            var profit = $("#profit" + room).val();

            var jual = parseInt(profit) + parseInt(modal);
            var persen = profit / modal * 100;

            if (profit > 0) {
                $("#jual" + room).val(jual);
                $("#persen" + room).val(persen);
            } else {
                $("#jual" + room).val("");
                $("#persen" + room).val("");
            }
        });

    }

    function remove_tambahbaris(rid) {
        $('.removeclass' + rid).remove();
    }
</script>
<script>
    $("#jual_r").keyup(function() {
        var modal = $("#modal").val();
        var jual = $("#jual_r").val();

        var profit = jual - modal;
        var persen = (profit / modal) * 100;

        if (jual > 0) {
            $("#profit_r").val(profit);
            $("#persen_r").val(persen);
        } else {
            $("#profit_r").val("");
            $("#persen_r").val("");
        }
    });

    $("#persen_r").keyup(function() {
        var modal = $("#modal").val();
        var persen = $("#persen_r").val();

        var profit = persen / 100 * modal;
        var jual = parseInt(profit) + parseInt(modal);

        if (persen > 0) {
            $("#jual_r").val(parseInt(jual));
            $("#profit_r").val(profit);
        } else {
            $("#jual_r").val("");
            $("#profit_r").val("");
        }
    });

    $("#profit_r").keyup(function() {
        var modal = $("#modal").val();
        var profit = $("#profit_r").val();

        var jual = parseInt(profit) + parseInt(modal);
        var persen = profit / modal * 100;

        if (profit > 0) {
            $("#jual_r").val(parseInt(jual));
            $("#persen_r").val(persen);
        } else {
            $("#jual_r").val("");
            $("#persen_r").val("");
        }
    });
</script>