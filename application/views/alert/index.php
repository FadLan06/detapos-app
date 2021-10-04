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
                        <?= $this->session->flashdata('message') ?>
                        <form action="<?= base_url('Alert/Aksi') ?>" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="sapaan">Sapaan</label>
                                    <input type="text" class="form-control" id="sapaan" name="sapaan" value="<?= $alert['sapaan'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="control">Aktiv / Not Aktiv</label>
                                    <select class="form-control" name="control" id="control">
                                        <option value="Aktiv" <?= $alert['control'] == 'Aktiv' ? 'Selected' : '' ?>>Aktiv</option>
                                        <option value="Not Aktiv" <?= $alert['control'] == 'Not Aktiv' ? 'Selected' : '' ?>>Not Aktiv</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kalimat">Kalimat</label>
                                <textarea class="form-control" id="kalimat" name="kalimat"><?= $alert['kalimat'] ?></textarea>
                            </div>
                            <button type="submit" class="btn" style="background-color: #008FD4; border-color: #008FD4; color: white;" name="simpan"><i class="fas fa-save"></i> Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>