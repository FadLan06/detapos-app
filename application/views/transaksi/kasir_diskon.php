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
                    <h4 class="page-title"><?= $judul ?></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="post">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input type="text" class="form-control" name="kode_barang" id="kode1" onkeyup="isi_otomatis1()" placeholder="Kode Barang" autocomplete="off" autofocus required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang" id="nama_barang1" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="harga">Harga</label>
                                    <input type="text" class="form-control" name="harga" id="harga1" readonly>
                                    <input type="hidden" class="form-control" name="harga_beli" id="harga_beli1" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="qty">QTY</label>
                                    <input type="text" class="form-control" name="qty" id="qty1" autocomplete="off" required>
                                    <button type="submit" hidden class="btn btn-success" id="btn_simpan1" name="kirim">kirim</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive anyClass1">
                            <table class="table table-striped table-sm" style="width: 100%; font-size: 12px" id="mydata1">
                                <thead>
                                    <tr style="border-bottom:1px solid #ccc;">
                                        <th>#</th>
                                        <th>Barang</th>
                                        <th>Harga</th>
                                        <th>Item</th>
                                        <th colspan="2">Sub Total</th>
                                        <!-- <th></th> -->
                                    </tr>
                                </thead>
                                <tbody id="list1">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer" style="background-color: white; border-top: solid 2px #00aaff">
                        <form action="<?= base_url('Kasir_Diskon/smpn_pen') ?>" method="post">
                            <div class="form-row">
                                <input type="hidden" name="username" value="<?= $user['username'] ?>">
                                <input type="hidden" name="token" value="<?= $user['date_created'] ?>">
                                <input type="hidden" name="total" id="total1">
                                <input type="hidden" name="pot" id="pot">
                                <input type='hidden' name='no_kwitansi' class='form-control input-sm' id='nomor_nota' value="<?= $no_kwitansi ?>">
                                <div class="form-group col-md-3">
                                    <label for="">Status Pembayaran :</label><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline1" name="status" class="custom-control-input" value="Lunas" checked>
                                        <label class="custom-control-label" for="customRadioInline1">Lunas</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="status" class="custom-control-input" value="Hutang">
                                        <label class="custom-control-label" for="customRadioInline2">Hutang</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pelanggan">Pelanggan :</label>
                                    <input type="text" class="form-control" name="pelanggan" id="pelanggan1" autocomplete="off" placeholder="Ketik Pelanggan">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="diskon">Diskon :</label>
                                    <div class="input-group" style="width: 70%">
                                        <input type="text" class="form-control" id="diskon" name="diskon" autocomplete="off" value="0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-deta text-light" id="inputGroupPrepend">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Bayar (Rp) :</label>
                                    <input type="text" name="bayar" class="form-control" id="bayar1" autocomplete="off">
                                    <span class="text-danger" id="span1"></span>
                                    <button class="btn btn-danger mt-3 btnn btn-sm" style="background-color: #008FD4; border-color: #008FD4" id="tombol1" name="enter"><i class="fas fa-save"></i> BAYAR (ENTER)</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <p>Nama Kasir = <b><?= $user['nama'] ?></b></p>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <p>BAYAR :</p>
                                <input type="text" class="form-control" name="bayartotval" id="bayartotval1" hidden>
                                <h3 style="color: red" class="rp"><b><span id="bayartot1">0</span> </b></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <p>KEMBALIAN :</p>
                                <h3 class="rp" style="color: green"><b><span id="kembali1">0</span></b></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <p><b> <i class="fas fa-keyboard"></i> Shortcut Keyboard :</b> <br> F8 = Fokus Ke Field Bayar</p>
                        <label class="w3-validate" style="color:red; font-size: 12px;">
                            <i>*Note : Gunakan Mozilla Firefox Di PC/Laptop Jika Cetak Struk Tidak Berfungsi</i>
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>