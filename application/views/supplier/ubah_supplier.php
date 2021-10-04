<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Data Supplier</a></li>
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
                        <form method="POST" action="<?= base_url('Supplier/Aksi') ?>">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Kode Supplier</label>
                                    <input type="text" name="kode_sup" class="form-control border-deta" id="inputEmail4" autocomplete="off" value="<?= $data->kode_sup ?>" readonly>
                                    <input type="hidden" name="kd_supplier" class="form-control" id="inputEmail4" autocomplete="off" value="<?= $data->kd_supplier ?>">
                                    <?= form_error('kode_sup', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="inputAddress">Nama Supplier</label>
                                    <input type="text" name="nama_toko" class="form-control border-deta" id="inputAddress" autocomplete="off" value="<?= $data->nama_toko ?>">
                                    <?= form_error('nama_toko', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Email</label>
                                    <input type="text" name="email" class="form-control border-deta" id="inputAddress" autocomplete="off" value="<?= $data->email ?>">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Nomor Telpon/Hp</label>
                                    <input type="number" name="telpon" class="form-control border-deta" id="inputPassword4" autocomplete="off" value="<?= $data->telpon ?>">
                                    <?= form_error('telpon', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="logo">Provinsi</label>
                                        <select name="provinsi" id="provinsi" class="form-control border-deta" required>
                                            <option selected disabled>
                                                <-- Pilih Provinsi -->
                                            </option>
                                            <?php foreach ($provinsi as $prov) : ?>
                                                <option value="<?= $prov['id_prov'] ?>" <?= $data->provinsi == $prov['id_prov'] ? 'selected' : '' ?>><?= $prov['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="logo">Kota</label>
                                        <select name="kota" id="kota" class="form-control border-deta" required>
                                            <option selected disabled>
                                                <-- Pilih Kota/Kabupaten -->
                                            </option>
                                            <?php $kota = $this->db->get_where('tb_kabupaten', ['id_prov' => $data->provinsi])->result_array(); ?>
                                            <?php foreach ($kota as $kot) : ?>
                                                <option value="<?= $kot['id_kab'] ?>" <?= $data->kota == $kot['id_kab'] ? 'selected' : '' ?>><?= $kot['nama'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control border-deta" rows="4" required><?= $data->alamat ?></textarea>
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <button type="submit" name="ubah" class="btn btn-deta float-right">Simpan Perubahan</button>
                            <a class="btn btn-warning float-right mr-3" href="<?= base_url('Supplier') ?>">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    $(function() {
        $.ajaxSetup({
            type: "POST",
            url: "<?php echo base_url('Supplier/Ambil_kota') ?>",
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