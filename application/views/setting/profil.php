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
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-md-6 m-b-30">
                <div class="card card-body border-deta hm table-responsive">
                    <h5>Profil Toko</h5>
                    <hr class="bg-deta">
                    <table cellspacing="0" cellpadding="10" width="100%">
                        <tr>
                            <td width="30%">Nama Toko</td>
                            <td width="5%" align="center">:</td>
                            <td><?= $setting['nama_toko'] ?></td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top">Alamat</td>
                            <td width="5%" align="center" valign="top">:</td>
                            <td><?= $setting['alamat'] ?></td>
                        </tr>
                        <tr>
                            <td width="30%">No. HP/Whatsapp</td>
                            <td width="5%" align="center">:</td>
                            <td><?= $setting['no_telpon'] ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Email</td>
                            <td width="5%" align="center">:</td>
                            <td><?= $setting['email_toko'] ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Template Barcode </td>
                            <td width="5%" align="center">:</td>
                            <td>
                                <?php if ($setting['barcode'] == 'standart') {
                                    echo 'Standart Detapos';
                                } elseif ($setting['barcode'] == '1') {
                                    echo '1 Baris 1 Label';
                                } elseif ($setting['barcode'] == '2') {
                                    echo '1 Baris 2 Label';
                                } elseif ($setting['barcode'] == '3') {
                                    echo '1 Baris 3 Label';
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Printer Struk</td>
                            <td width="5%" align="center">:</td>
                            <td>
                                <?php if ($setting['struk'] == 'thermal') {
                                    echo 'Thermal [Printer Kertas Kecil]';
                                } elseif ($setting['struk'] == 'matrix') {
                                    echo 'Dot Matrix [Ex. L310]';
                                } elseif ($setting['struk'] == 'biasa') {
                                    echo 'Printer Biasa [Ex. Canon IP 2770]';
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Zona Waktu</td>
                            <td width="5%" align="center">:</td>
                            <td>
                                <?php if ($setting['zona'] == 'Asia/Jakarta') {
                                    echo 'WIB - Waktu Indonesia Barat';
                                } elseif ($setting['zona'] == 'Asia/Hong_Kong') {
                                    echo 'WITA - Waktu Indonesia Tengah';
                                } elseif ($setting['zona'] == 'Asia/Tokyo') {
                                    echo 'WIT - Waktu Indonesia Timur';
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Logo Toko</td>
                            <td width="5%" align="center">:</td>
                            <td>
                                <?php if ($setting['logo'] == null) : ?>
                                    <img src="<?= base_url() ?>assets/img/LOGO.webp" width="110" height="35" class="d-inline-block align-top" alt="">
                                <?php else : ?>
                                    <img src="<?= base_url() ?>assets/upload/<?= $setting['logo'] ?>" class="d-inline-block align-top" alt="">
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6 m-b-30">
                <div class="card card-body hm border-deta">
                    <h5>Edit Profil Toko</h5>
                    <hr class="bg-deta">
                    <form method="POST" action="<?= base_url('Profil/Aksi') ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputAddress">Nama Toko</label>
                            <input type="text" name="nama_toko" class="form-control border-deta" id="inputAddress" autocomplete="off" value="<?= $setting['nama_toko'] ?>">
                            <?= form_error('nama_toko', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="inputEmail4">Email</label>
                                <input type="email" name="email" class="form-control border-deta" id="inputEmail4" autocomplete="off" value="<?= $setting['email_toko'] ?>">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputPassword4">Nomor HP / Whatsapp</label>
                                <input type="number" name="no_telpon" class="form-control border-deta" id="inputPassword4" autocomplete="off" value="<?= $setting['no_telpon'] ?>">
                                <?= form_error('no_telpon', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="barcode">Template Barcode</label>
                                <select class="form-control border-deta" name="barcode">
                                    <option>-- Pilih --</option>
                                    <option value="standart" <?= $setting['barcode'] == 'standart' ? 'selected' : '' ?>>Standart Detapos</option>
                                    <option value="1" <?= $setting['barcode'] == '1' ? 'selected' : '' ?>>1 Baris 1 Label</option>
                                    <option value="2" <?= $setting['barcode'] == '2' ? 'selected' : '' ?>>1 Baris 2 Label</option>
                                    <option value="3" <?= $setting['barcode'] == '3' ? 'selected' : '' ?>>1 Baris 3 Label</option>
                                </select>
                                <?= form_error('barcode', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="struk">Printer Struk</label>
                                <select class="form-control border-deta" name="struk">
                                    <option>-- Pilih --</option>
                                    <option value="thermal" <?= $setting['struk'] == 'thermal' ? 'selected' : '' ?>>Thermal [Printer Kertas Kecil]</option>
                                    <option value="matrix" <?= $setting['struk'] == 'matrix' ? 'selected' : '' ?>>Dot Matrix [Ex. L310]</option>
                                    <option value="biasa" <?= $setting['struk'] == 'biasa' ? 'selected' : '' ?>>Printer Biasa [Ex. Canon IP 2770]</option>
                                </select>
                                <?= form_error('struk', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zona">Zona Waktu</label>
                            <select class="form-control border-deta" name="zona">
                                <option>-- Pilih --</option>
                                <option value="Asia/Jakarta" <?= $setting['zona'] == 'Asia/Jakarta' ? 'selected' : '' ?>>WIB - Waktu Indonesia Barat</option>
                                <option value="Asia/Hong_Kong" <?= $setting['zona'] == 'Asia/Hong_Kong' ? 'selected' : '' ?>>WITA - Waktu Indonesia Tengah</option>
                                <option value="Asia/Tokyo" <?= $setting['zona'] == 'Asia/Tokyo' ? 'selected' : '' ?>>WIT - Waktu Indonesia Timur</option>
                            </select>
                            <?= form_error('zona', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo Toko</label>
                            <input type="file" name="gambar" class="form-control border-deta" accept="image/*" id="logo">
                            <small>Size logo : 150px x 50px</small>
                            <?= form_error('logo', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="logo">Provinsi</label>
                                <select name="provinsi" id="provinsi" class="form-control border-deta">
                                    <?php foreach ($provinsi as $prov) : ?>
                                        <option value="<?= $prov['id_prov'] ?>" <?= $setting['provinsi'] == $prov['id_prov'] ? 'selected' : '' ?>><?= $prov['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="logo">Kota</label>
                                <select name="kota" id="kota" class="form-control border-deta">
                                    <?php $kota = $this->db->get_where('tb_kabupaten', ['id_prov' => $setting['provinsi']])->result_array(); ?>
                                    <?php foreach ($kota as $kot) : ?>
                                        <option value="<?= $kot['id_kab'] ?>" <?= $setting['kota'] == $kot['id_kab'] ? 'selected' : '' ?>><?= $kot['nama'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kode_unik">Kode Unik Link Checkout</label>
                            <select class="form-control border-deta" name="kode_unik">
                                <option>-- Pilih --</option>
                                <option value="Mengurangi" <?= $setting['kode_unik'] == 'Mengurangi' ? 'selected' : '' ?>>Mengurangi (-)</option>
                                <option value="Menambahkan" <?= $setting['kode_unik'] == 'Menambahkan' ? 'selected' : '' ?>>Menambahkan (+)</option>
                            </select>
                            <?= form_error('kode_unik', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control border-deta" rows="2"><?= $setting['alamat'] ?></textarea>
                            <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <button type="submit" name="ubh_toko" class="btn btn-deta float-right">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            type: "POST",
            url: "<?php echo base_url('Profil/Ambil_data') ?>",
            cache: false,
        });

        $("#provinsi").change(function() {
            var value = $(this).val();

            if (value > 0) {
                $.ajax({
                    data: {
                        modul: 'kabupaten',
                        id: value
                    },
                    success: function(respond) {
                        $("#kota").html(respond);
                    }
                })
            }
        });

    });
</script>