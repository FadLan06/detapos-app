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

        <?php $dt = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $data->kode_barang, 'token' => $data->token]);
        $cb = $dt->num_rows();
        if ($cb > 0) {
            $aktif = 'readonly';
            $in = 'disabled';
        } else {
            $aktif = 'kosong';
            $in = 'kosong';
        }
        ?>
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
                                            <input type="hidden" class="form-control" name="id" autocomplete="off" readonly value="<?= $data->id ?>">
                                            <input type="text" class="form-control border-deta" id="kodee1" name="kode_barang" autocomplete="off" <?= $aktif ?> value="<?= $data->kode_barang ?>" required>
                                            <?= form_error('kode_barang', '<small class="text-white pl-3">', '</small>') ?>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-deta" onclick="myFunction()" type="button">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">NAMA BARANG</label>
                                    <input type="text" class="form-control border-deta" id="inputPassword4" name="nama_barang" autocomplete="off" value="<?= $data->nama_barang ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">SERIAL</label>
                                    <a href="" class="form-control btn btn-deta" data-target="#mSeriall" id="serial" data-toggle="modal" type="button">Tambah Serial</a>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="modal">HARGA MODAL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                                        </div>
                                        <input type="text" class="form-control border-deta modall" id="modal" name="harga_beli" autocomplete="off" value="<?= $data->harga_beli ?>" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputZip">SATUAN</label>
                                    <input type="text" class="form-control border-deta" id="inputZip" name="satuann" autocomplete="off" value="<?= $data->satuan ?>" required>
                                </div>
                            </div>
                            <?php $hg = $this->db->get_where('tb_barang_harga', ['token' => $data->token, 'id_barang' => $data->kode_barang])->result(); ?>
                            <?php foreach ($hg as $dt) : ?>
                                <input type="hidden" class="form-control border-deta juall" id="idd" name="idd" autocomplete="off" required value="<?= $dt->id_barang_harga ?>">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="jual">HARGA JUAL</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-deta text-light" id="inputGroupPrepend2">Rp</span>
                                            </div>
                                            <input type="text" class="form-control border-deta juall" id="jual" name="harga_jual" autocomplete="off" required value="<?= $dt->harga_jual ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="persen">PERSENTASE</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control border-deta persenn" id="persen" name="persen" autocomplete="off" required value="<?= $dt->persen ?>">
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
                                            <input type="text" class="form-control border-deta profitt" id="profit" name="profit" autocomplete="off" value="<?= $dt->profit ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZip">SATUAN</label>
                                        <input type="text" class="form-control border-deta" id="inputZip" name="satuan" autocomplete="off" value="<?= $dt->satuan ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="kategori">KATEGORI</label>
                                    <select id="kategorii" class="form-control border-deta" name="kode_kategori">
                                        <option selected>Pilih...</option>
                                        <?php foreach ($kategori as $ket) : ?>
                                            <option value="<?= $ket->kode_kategori ?>" <?= $data->id_kategori == $ket->kode_kategori ? 'selected="selected"' : '' ?>><?= $ket->kode_kategori ?> / <?= $ket->nama_kategori ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="kategori">SUB KATEGORI</label>
                                    <select id="subkategorii" class="form-control border-deta" name="sub_kategori">
                                        <option selected>Pilih...</option>
                                        <?php foreach ($sub_kategori as $sub) : ?>
                                            <option value="<?= $sub->kode_sub_kategori ?>" <?= $data->sub_kategori == $sub->nama_sub_kategori ? 'selected="selected"' : '' ?>><?= $sub->kode_sub_kategori ?> / <?= $sub->nama_sub_kategori ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="warna">WARNA</label>
                                    <input type="text" name="warna" id="warna" class="form-control" autocomplete="off" value="<?= $data->warna ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="ukuran">UKURAN</label>
                                    <input type="text" name="ukuran" id="ukuran" class="form-control" autocomplete="off" value="<?= $data->ukuran ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputCity">JUMLAH STOK</label>
                                    <input type="number" class="form-control border-deta" id="inputCity" name="jml_stok" autocomplete="off" value="<?= $data->jml_stok ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputCity">MINIMAL STOK</label>
                                    <input type="number" class="form-control border-deta" id="inputCity" name="min_stok" autocomplete="off" value="<?= $data->minimal_stok ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputZip">DESKRIPSI</label>
                                    <textarea class="form-control ckeditor border-deta" name="deskripsi" id="inputZip" required><?= $data->deskripsi ?></textarea>
                                </div>
                            </div>
                            <hr class="bg-deta">
                            <button type="submit" class="btn btn-deta float-right" name="ubah_brng_el">Ubah</button>
                            <a class="btn btn-warning float-right mr-3" href="<?= base_url('Barang') ?>">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SERIAL -->
<div class="modal fade" id="mSeriall" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalCenterTitle"><b>Data Serial Barang</b></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="formSerial" method="post">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="inputCity">Serial Number</label>
                            <input type="number" class="form-control border-deta" id="inputSerial" min="1" name="serial_num" autocomplete="off" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputCity">Exp. Date</label>
                            <input type="date" class="form-control border-deta" id="inputExp" name="expired" autocomplete="off" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputCity">Kode Barang</label>
                            <input type="text" class="form-control border-deta" id="kod_bar" name="kod_bar" readonly autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-deta" id="simpan" name="simpan" type="submit"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
                <hr class="bg-deta">
                <table class="table table-sm">
                    <thead>
                        <tr align="center">
                            <th width="5%">#</th>
                            <th>Serial</th>
                            <th>Exp. Date</th>
                            <th>Kode Barang</th>
                            <th>Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="viewSerial">

                    </tbody>
                </table>

                <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
                <script>
                    const form = document.querySelector('.formSerial'),
                        inputSerial = form.querySelector('#inputSerial'),
                        inputExp = form.querySelector('#inputExp'),
                        kodeBar = form.querySelector('#kode_bar'),
                        btnSimpan = form.querySelector('#simpan'),
                        viewSerial = document.querySelector('#viewSerial');

                    form.onsubmit = (e) => {
                        e.preventDefault();
                    }

                    btnSimpan.onclick = () => {
                        let xhr = new XMLHttpRequest();
                        xhr.open("POST", "<?= base_url('Barang/serial') ?>", true);
                        xhr.onload = () => {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    document.getElementById('inputSerial').value = '';
                                    document.getElementById('inputExp').value = '<?= date('Y-m-d') ?>';
                                    document.getElementById('kode_bar').value = '';
                                }
                            }
                        }

                        let formData = new FormData(form);
                        xhr.send(formData);
                    }

                    setInterval(function() {
                        let xhr = new XMLHttpRequest();
                        xhr.open("POST", "<?= base_url('Barang/get_serial') ?>", true);
                        xhr.onload = () => {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    let data = xhr.response;
                                    viewSerial.innerHTML = data;
                                    tombol();
                                }
                            }
                        }

                        let formData = new FormData(form);
                        xhr.send(formData);
                    }, 500);

                    function tombol() {
                        var btnHapus = document.getElementsByClassName('btnHapus');

                        for (var i = 0; i < btnHapus.length; i++) {
                            btnHapus[i].addEventListener('click', hapus);
                        }
                    }

                    function hapus() {
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                let data = xhttp.response;
                                viewSerial.innerHTML = data;
                            }
                        };
                        xhttp.open("GET", "<?= base_url('Barang/del_serial/') ?>" + this.value, true);
                        xhttp.send();
                    }
                </script>
                <script>
                    $('#serial').on('click', function() {
                        var kode = document.getElementById("kodee1").value;

                        $('#kod_bar').val(kode);
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>
<!-- panggil adapter jquery ckeditor -->
<script type="text/javascript" src="<?= base_url() ?>assets/ckeditor/adapters/jquery.js"></script>
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