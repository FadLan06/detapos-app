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
            <div class="col-md-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5><b>AKUN</b></h5>
                        <hr class="bg-deta">
                        <?php if ($akun->row() > NULL) : ?>
                            <?php $no = 1;
                            foreach ($akun->result_array() as $ak) : ?>
                                <div class="list-group"><button class="list-group-item list-group-item-action mb-1" style="border: 1px solid #00aaff" id='id_akun' onclick="detail_akun(<?= $ak['idakun'] ?>)"><?= $ak['nama_akun'] ?> (<?= $ak['jumlah_akun'] ?>)</button></div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="list-group"><i class="list-group-item list-group-item-action" style="border: 1px solid #00aaff">Tidak Ada Data Akun</i></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card m-b-30">
                    <div class="card-body" id="detail_akun">
                        <h5><b>DETAIL AKUN</b></h5>
                        <hr class="bg-deta">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>