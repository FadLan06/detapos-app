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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body mx-auto">
                        <span>Backup Database</span><br>
                        <button class="btn btn-deta mt-2" onclick="location.href='<?= base_url('DB_Backup/Backup') ?>'"><i class="fas fa-download"></i> Backup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>