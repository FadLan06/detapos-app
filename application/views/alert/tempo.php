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
                        $dta = $this->db->get_where('tb_barang', ['token' => $token])->row_array();
                        $tgl_skrng = date('Y-m-d');
                        $bra1 = $this->db->query("SELECT * FROM tb_barang WHERE token = '$token' AND tgl_tempo = '$tgl_skrng'")->result_array();
                        foreach ($bra1 as $dt1) {
                            if ($dt1['tgl_tempo'] <= $tgl_skrng) {
                                echo '<div class="alert text-dark alert-dismissible fade show" style="background-color: yellow;" role="alert"><b>Data barang ' . $dt1['kode_barang'] . ' - ' . $dt1['nama_barang'] . ' sudah memasuki jatuh tempo, segera lakukan pembayaran!</b></div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>