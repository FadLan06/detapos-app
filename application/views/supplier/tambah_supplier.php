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
                        <?= $this->session->flashdata('message') ?>
                        <form method="POST" action="<?= base_url('Supplier/Aksi') ?>">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Kode Supplier</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="text" name="kode_sup" class="form-control border-deta" id="kode_sup" autocomplete="off" required autofocus>
                                            <?= form_error('kode_sup', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-deta" onclick="kode()" type="button">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="inputPassword4">Nama Supplier</label>
                                    <input type="text" name="nama_toko" class="form-control border-deta" id="inputPassword4" autocomplete="off" required>
                                    <?= form_error('nama_toko', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Email</label>
                                    <input type="email" name="email" class="form-control border-deta" id="inputAddress" autocomplete="off">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Nomor Telpon/Hp</label>
                                    <input type="text" name="telpon" class="form-control border-deta" id="inputAddress" autocomplete="off" required>
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
                                                <option value="<?= $prov['id_prov'] ?>"><?= $prov['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="logo">Kota</label>
                                        <select name="kota" id="kota" class="form-control border-deta" required>
                                            <option selected disabled>
                                                <-- Pilih Kota/Kabupaten -->
                                            </option>
                                            <?php $kota = $this->db->get_where('tb_kabupaten', ['id_prov' => $setting['provinsi']])->result_array(); ?>
                                            <?php foreach ($kota as $kot) : ?>
                                                <option value="<?= $kot['id_kab'] ?>"><?= $kot['nama'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control border-deta" rows="4" required></textarea>
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <button type="submit" name="smpn" class="btn btn-deta float-right">Simpan</button>
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
    function kode() {
        var as = Math.ceil(Math.random() * 50000);
        $('#kode_sup').val(as);
    }

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