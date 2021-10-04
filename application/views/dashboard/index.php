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
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col align-self-center text-center">
                                <div class="m-l-10">
                                    <h3 class="mt-0 round-inner text-white"><?= $users ?></h3>
                                    <p class="mb-0 text-white">Jumlah Member</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="fas fa-database"></i>
                                </div>
                            </div>
                            <div class="col text-center align-self-center">
                                <div class="m-l-10 ">
                                    <h3 class="mt-0 round-inner text-white"><?= $users_aktif ?></h3>
                                    <p class="mb-0 text-white">Member Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round ">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                            </div>
                            <div class="col align-self-center text-center">
                                <div class="m-l-10 ">
                                    <h3 class="mt-0 round-inner text-white"><?= $users_nonaktif ?></h3>
                                    <p class="mb-0 text-white">Member Non Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30 bg-deta">
                    <div class="card-body">
                        <?php $query = $this->db->query("SELECT *, (600000*$users) as total FROM user WHERE role_id")->row(); ?>
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="col align-self-center text-center">
                                <div class="m-l-10">
                                    <h5 class="mt-0 round-inner text-white">Rp. <?= number_format($query->total) ?></h5>
                                    <p class="mb-0 text-white">Penghasilan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead>
                                    <tr align="center">
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Masa Aktif</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Tanggal Expaired</th>
                                        <th>Sisa Waktu</th>
                                        <th>Last Login</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($tanggal as $tgl) : ?>
                                        <?php
                                        $produk = $tgl['produk'];
                                        if ($produk == '3m') {
                                            $tanggalakhir = date('Y-m-d', strtotime('+90 day', $tgl['date_created']));
                                            $tanggalsekarang    = date('Y-m-d');
                                            $hari = 90;
                                        } else if ($produk == '1m') {
                                            $tanggalakhir = date('Y-m-d', strtotime('+30 day', $tgl['date_created']));
                                            $tanggalsekarang    = date('Y-m-d');
                                            $hari = 30;
                                        } else if ($produk == '6m') {
                                            $tanggalakhir = date('Y-m-d', strtotime('+180 day', $tgl['date_created']));
                                            $tanggalsekarang    = date('Y-m-d');
                                            $hari = 180;
                                        } else {
                                            $tanggalakhir = date('Y-m-d', strtotime('+365 day', $tgl['date_created']));
                                            $tanggalsekarang    = date('Y-m-d');
                                            $hari = 365;
                                        }

                                        $har = IntervalDays($tanggalsekarang, $tanggalakhir);
                                        ?>
                                        <tr>
                                            <td align="center"><?= $no++ ?></td>
                                            <td><?= $tgl['username'] ?></td>
                                            <td><?= $hari ?> Hari</td>
                                            <td><?= longdate_indo(date('Y-m-d', $tgl['date_created'])) ?></td>
                                            <td><?= longdate_indo($tanggalakhir) ?></td>
                                            <td align="center"><?= $har > 0 ? $har . ' Hari' : 'Expired' ?></td>
                                            <td><?= $tgl['last_login'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- <?= strtotime("18 February 2021 11:27:30") ?> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>