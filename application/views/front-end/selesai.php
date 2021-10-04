<div class="page-content-wrapper ">

    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <!-- <li class="breadcrumb-item"><a href="#">Annex</a></li> -->
                            <li class="breadcrumb-item"><a href="<?= base_url('Shop') ?>">Home</a></li>
                            <li class="breadcrumb-item active"><?= $judul ?></li>
                        </ol>
                    </div>
                    <h4><?= $judul ?></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 mx-auto my-5">
                <div class="card card-body">
                    <h4 align="center"><b>Terimakasih Telah Melakukan Pembayaran</b></h4>
                    <!-- <p align="center">Pesanan anda sementara kami proses mohon tunggu yaa!!!</p> -->
                    <p align="center">Cek pesanan anda untuk mendapatkan info selanjutnya terkait pesanan anda.</p>
                    <hr class="bg-deta">
                    <button class="btn btn-deta mx-auto" style="width: 40%;" onclick="location.href='<?= base_url('Shop') ?>'"><i class="fas fa-home"></i> Home</button>
                </div>
            </div>
        </div>

    </div><!-- container -->

</div> <!-- Page content Wrapper -->