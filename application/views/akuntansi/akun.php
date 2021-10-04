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
            <div class="col-md-3 mt-2">
                <div class="card card-body m-b-30">
                    <h5><b>Tambah Akun</b></h5>
                    <hr class="bg-deta">
                    <?= $this->session->flashdata('message') ?>
                    <form method="POST" action="<?= base_url('Akun/Aksi') ?>">
                        <div class="form-group">
                            <label for="kode_akun">Nomor / Kode Akun</label>
                            <input type="text" name="kode_akun" class="form-control border-deta" id="kode_akun" autocomplete="off" required>
                            <?= form_error('kode_akun', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="nama_akun">Nama Akun</label>
                            <input type="text" name="nama_akun" class="form-control border-deta" id="nama_akun" autocomplete="off" required>
                            <?= form_error('nama_akun', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Posisi Awal Saldo</label>
                            <select name="kategori" id="kategori" class="form-control border-deta">
                                <option value="HL">Debet</option>
                                <option value="HT">Kredit</option>
                            </select>
                            <?= form_error('nama_pel', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <button type="submit" name="tmbh_akun" class="btn btn-deta float-right" <?= $akses->tambah != 1 ? 'disabled' : '' ?>>Tambah</button>
                        <button type="button" class="btn btn-warning float-right mr-2" data-toggle="modal" data-target="#exampleModal">Panduan</button>
                    </form>
                </div>
            </div>
            <div class="col-md-9 mt-2">
                <div class="card card-body m-b-30">
                    <h5><b>DAFTAR AKUN</b></h5>
                    <hr class="bg-deta">
                    <?= $this->session->flashdata('message1') ?>
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                        <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead align="center" class="bg-deta text-white">
                                <tr>
                                    <th width="5%">NO</th>
                                    <th width="35%">Nama Akun</th>
                                    <th>Kode Akun</th>
                                    <th>Posisi Saldo</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($akun->row() > null) : ?>
                                    <?php $no = 1;
                                    foreach ($akun->result() as $ak) : ?>
                                        <?php
                                        if ($ak->kategori == 'HL') {
                                            $kat = 'Harta Lancar';
                                            $pos = 'Debet';
                                        } elseif ($ak->kategori == 'HT') {
                                            $kat = 'Harta Tetap';
                                            $pos = 'Kredit';
                                        }
                                        ?>
                                        <tr align="center">
                                            <td><?= $no++ ?></td>
                                            <td align="left"><?= $ak->nama_akun ?></td>
                                            <td><?= $ak->kode_akun ?></td>
                                            <td><?= $pos ?></td>
                                            <td>
                                                <?php if (($ak->kode_akun == 111) || ($ak->kode_akun == 411) || ($ak->kode_akun == 112) || ($ak->kode_akun == 511)) : ?>
                                                    <a class="btn btn-deta btn-sm disabled" href="" data-target="#UbahAkun" data-toggle="modal" data-id="<?= $ak->id_akun ?>"><i class="fas fa-edit"></i></a>
                                                    <a class="btn btn-danger btn-sm disabled" href="<?= base_url('Akun/hps_akun/') . $ak->id_akun ?>" onclick="return confirm('Yakin anda ?');"><i class="fas fa-trash"></i></a>
                                                <?php else : ?>
                                                    <a class="btn btn-deta btn-sm <?= $akses->ubah != 1 ? 'disabled' : '' ?>" href="" data-target="#UbahAkun" data-toggle="modal" data-id="<?= $ak->id_akun ?>"><i class="fas fa-edit"></i></a>
                                                    <a class="btn btn-danger btn-sm <?= $akses->hapus != 1 ? 'disabled' : '' ?>" href="<?= base_url('Akun/hps_akun/') . $ak->id_akun ?>" onclick="return confirm('Yakin anda ?');"><i class="fas fa-trash"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr align="center">
                                        <td colspan="5"><i>Tidak Ada Data Akun</i></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="UbahAkun" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Ubah Akun</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="_akun"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-deta text-white">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Panduan Penyisian Akun</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" width="100%">
                    <tr align="center">
                        <th colspan="3">Contoh Penyisian Akun</th>
                    </tr>
                    <tr>
                        <td width="30%">Nomor / Kode Akun</td>
                        <td width="5%">:</td>
                        <td>
                            <p class="text-justify">Nomor / kode akun di isi sesuai dengan kenyamanan pengguna. <br> <b>Misalnya :</b> KD01, KD01 dan seterusnya</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Nama Akun</td>
                        <td width="5%">:</td>
                        <td>
                            <p class="text-justify">Nama akun untuk mengisinya ada ketentuan yang pengguna harus lakukan nantinya berpengaruh di perhitungan akuntansinya. <br> <b>Misalnya :</b>
                                <ul>
                                    <li class="text-justify">Nama akun yang berkaitan dengan penghasilan harus memasukkan kata <b>Pendapatan</b> di awal nama akunnya</li>
                                    <li class="text-justify">Nama akun yang berkaitan dengan pengeluaran harus memasukkan kata <b>Beban</b> di awal nama akunnya</li>
                                    <li class="text-justify">Nama akun selain dari dua yang di atas di isi sesuai dengan kenyamanan pengguna.</li>
                                </ul>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Posisi Awal Saldo</td>
                        <td width="5%">:</td>
                        <td>
                            <p class="text-justify">Posisi awal saldo untuk mengisinya ada ketentuan yang pengguna harus lakukan nantinya berpengaruh di perhitungan akuntansinya. <br> <b>Misalnya :</b>
                                <ul>
                                    <li class="text-justify">Nama akun yang berkaitan dengan penghasilan harus memilih posisi saldo awal <b>Kredit</b></li>
                                    <li class="text-justify">Nama akun yang berkaitan dengan pengeluaran harus memilih posisi saldo awal <b>Debet</b></li>
                                    <li class="text-justify">Posisi awal saldo selain dari dua yang di atas di isi sesuai dengan kenyamanan pengguna.</li>
                                </ul>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>