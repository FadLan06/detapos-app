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
            <div class="col-12">
                <?= $this->session->flashdata('message') ?>
                <div id="hsl"></div>
                <div class="card card-body m-b-30">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Mutasi Manual</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Moota</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-4 mt-2">
                                    <h5>Tambah Rekening</h5>
                                    <hr class="bg-deta">
                                    <?= $this->session->flashdata('message1') ?>
                                    <?php if (empty($rek->token)) : ?>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                                <label class="form-check-label" for="gridCheck">
                                                    Aktifkan transaksi mutasi ini
                                                </label>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input aktif" type="checkbox" id="gridCheck" <?= aktif($this->session->userdata('token')) ?> data-token="<?= $this->session->userdata('token') ?>">
                                                <label class="form-check-label" for="gridCheck">
                                                    Aktifkan transaksi mutasi ini
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($rek->token) && $rek->aktif == 0) {
                                        $akt = 'disabled';
                                    } else {
                                        $akt = '';
                                    } ?>
                                    <form method="POST" action="<?= base_url('No_rekening/Proses_rek') ?>" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="inputAddress">No. Rekening</label>
                                            <input type="number" name="no_rekening" class="form-control border-deta" <?= $akt ?> id="inputAddress" autocomplete="off" autofocus required>
                                            <?= form_error('no_rekening', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Atas Nama</label>
                                            <input type="text" name="atas_nama" class="form-control border-deta" <?= $akt ?> id="inputAddress" autocomplete="off" required>
                                            <?= form_error('atas_nama', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="struk">Nama Bank</label>
                                            <select class="form-control border-deta" name="jenis" <?= $akt ?> required>
                                                <option disabled selected>
                                                    <-- Pilih Nama Bank -->
                                                </option>
                                                <option value="bank-bca">Bank Central Asia (BCA)</option>
                                                <option value="bank-mandiri">Bank Mandiri</option>
                                                <option value="bank-bni">Bank Negara Indonesia (BNI)</option>
                                                <option value="bank-bri">Bank Rakyat Indonesia (BRI)</option>
                                                <option value="bank-bsi">Bank Syariah Indonesia (BSI)</option>
                                                <!-- <option value="btn">Bank Tabungan Negara (BTN)</option> -->
                                            </select>
                                            <?= form_error('jenis', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <button type="submit" name="tambah_rek" <?= $akt ?> class="btn btn-deta float-right"><i class="fas fa-plus-circle"></i> Tambah</button>
                                    </form>
                                </div>
                                <div class="col-md-8 mt-2">
                                    <h5>Rekening</h5>
                                    <hr class="bg-deta">
                                    <div class="row row-cols-1 row-cols-md-3">
                                        <?php if (!empty($rek->token)) : ?>
                                            <?php if ($rek->aktif == 1) : ?>
                                                <?php foreach ($rekening as $rek) : ?>
                                                    <?php if ($rek['jenis'] == 'bank-bca') {
                                                        $gambar = 'bank-bca.png';
                                                    } elseif ($rek['jenis'] == 'bank-mandiri') {
                                                        $gambar = 'bank-mandiri.png';
                                                    } elseif ($rek['jenis'] == 'bank-bni') {
                                                        $gambar = 'bank-bni.png';
                                                    } elseif ($rek['jenis'] == 'bank-bri') {
                                                        $gambar = 'bank-bri.png';
                                                    } elseif ($rek['jenis'] == 'bank-bsi') {
                                                        $gambar = 'bank-bsi.png';
                                                    } ?>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card mx-auto m-b-30">
                                                            <img src="<?= base_url('assets/img/') . $gambar ?>" class="card-img-top mx-auto mt-3" alt="...">
                                                            <div class="card-body">
                                                                <table class="table" width="100%">
                                                                    <tr align="center">
                                                                        <td>No. Rekening : <b><?= $rek['no_rekening'] ?></b></td>
                                                                    </tr>
                                                                    <tr align="center">
                                                                        <td>a.n : <b><?= $rek['atas_nama'] ?></b></td>
                                                                    </tr>
                                                                </table>
                                                                <a href="" class="btn btn-deta btn-sm" data-target="#ubhrek" data-toggle="modal" data-id="<?= $rek['kd_rekening'] ?>"><i class="fas fa-edit"></i> Ubah</a>
                                                                <a href="<?= base_url('No_rekening/hapus/') . $rek['kd_rekening'] ?>" onclick="return confirm('Anda yakin ?')" class="btn btn-danger btn-sm float-right"><i class="fas fa-trash"></i> Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card card-body mx-auto">
                                                        <span style="text-align: center;">Silahkan aktifkan terlebih dahulu agar sistem transaksi manual bisa digunakan</span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-4 mt-2">
                                    <h5>Integrasi Moota</h5>
                                    <hr class="bg-deta">
                                    <?php if (empty($moota->token)) : ?>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                                <label class="form-check-label" for="gridCheck1">
                                                    Aktifkan transaksi mutasi ini
                                                </label>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input aktif1" type="checkbox" id="gridCheck1" <?= aktif1($this->session->userdata('token')) ?> data-token="<?= $this->session->userdata('token') ?>">
                                                <label class="form-check-label" for="gridCheck1">
                                                    Aktifkan transaksi mutasi ini
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($moota->apikey)) {
                                        $key1 = $moota->apikey;
                                        $nm = 'ubah_moota';
                                        $ak = '';
                                    } else {
                                        $ak = 'disabled';
                                        $key1 = '';
                                        $nm = 'tambah_moota';
                                    } ?>
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="inputAddress">API Token</label>
                                            <input type="text" name="apikey" class="form-control border-deta" id="apikey" value="<?= $key1 ?>" autocomplete="off" autofocus required>
                                            <?= form_error('apikey', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <button type="submit" name="<?= $nm ?>" id="<?= $nm ?>" class="btn btn-deta float-right"><i class="fas fa-save"></i> Simpan</button>
                                    </form>
                                </div>
                                <div class="col-md-8 mt-2">
                                    <h5>Rekening Moota</h5>
                                    <hr class="bg-deta">
                                    <?php if (!empty($moota->apikey)) : ?>
                                        <?php if ($moota->is_active == 1) : ?>
                                            <div class="dataBank"></div>
                                        <?php else : ?>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="card card-body mx-auto">
                                                        <span style="text-align: center;">Silahkan aktifkan terlebih dahulu agar sistem transaksi otomatis bisa digunakan</span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ubhrek" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ubah Rekening</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="ubh_rek"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script src="<?= base_url() ?>assets/js/popper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#ubhrek').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?= base_url('No_rekening/ubah_rek') ?>',
                data: 'kd_rekening=' + kd,
                success: function(data) {
                    $('.ubh_rek').html(data);
                }
            });
        });
    });
</script>
<script>
    $.ajax({
        type: 'GET',
        url: "<?= base_url('Moota/Bank') ?>",
        async: true,
        success: function(data) {
            // console.log(data);
            $('.dataBank').html(data);
        }
    });

    tampil();

    function tampil() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>No_rekening',
            async: true,
            dataType: 'json',
            success: function() {
                reload();
            }
        });
    }

    $(document).on('click', '.aktif', function() {
        const token = $(this).data('token');

        $.ajax({
            url: "<?= base_url('No_rekening/Aktif'); ?>",
            type: 'post',
            data: {
                token: token,
            },
            success: function() {
                // document.location.href = "<?= base_url('No_rekening'); ?>";
                location.reload();
                tampil();
            }
        });
    });

    $(document).on('click', '.aktif1', function() {
        const token = $(this).data('token');

        $.ajax({
            url: "<?= base_url('No_rekening/Aktif1'); ?>",
            type: 'post',
            data: {
                token: token,
            },
            success: function() {
                // document.location.href = "<?= base_url('No_rekening'); ?>";
                location.reload();
                tampil();
            }
        });
    });

    $('#tambah_moota').on('click', function() {
        var valid = this.form.checkValidity();
        if (valid) {
            // event.preventDefault();
            var apikey = $('#apikey').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('No_rekening/simpan') ?>",
                dataType: "JSON",
                data: {
                    apikey: apikey,
                },
                success: function(data) {
                    // $('[name="apikey"]').val("").focus();
                    location.reload();
                    tampil();
                }
            });
        };
    });

    $('#ubah_moota').on('click', function() {
        var valid = this.form.checkValidity();
        if (valid) {
            // event.preventDefault();
            var apikey = $('#apikey').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('No_rekening/simpan1') ?>",
                dataType: "JSON",
                data: {
                    apikey: apikey,
                },
                success: function(data) {
                    location.reload();
                }
            });
        };
    });
</script>