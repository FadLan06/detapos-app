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
                <div class="card m-b-30">
                    <div class="card-body">
                        <?php
                        $token = $this->session->userdata('token');
                        $row = $this->db->get_where('tb_barang', ['token' => $token])->num_rows();
                        if ($row > 0) {
                            $dta = $this->db->get_where('tb_barang', ['token' => $token])->result_array();
                            foreach ($dta as $dat) {
                                $bra = $this->db->query("SELECT * FROM tb_barang WHERE token='$token' AND jml_stok <= $dat[minimal_stok]")->result_array();
                                foreach ($bra as $dt) {
                                    if ($dt['minimal_stok'] > 0) {
                                        echo '<div class="alert text-dark alert-dismissible fade show" style="background-color: #00FF00;" role="alert"><b>Stok barang ' . $dt['kode_barang'] . ' - ' . $dt['nama_barang'] . ' menipis, Segera lakukan pemesanan obat!</b></div>';
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>