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
                    <div class="card-header">
                        <a href="<?= base_url('Supplier/Tambah_Supplier') ?>" class="btn btn-deta btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>" class="btn btn-danger"><i class="fas fa-plus-circle"></i> Tambah</a>
                        <a href="<?= base_url('Supplier/Export') ?>" class="btn btn-success btn-sm"><i class="fas fa-download"></i> Export Excel</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead style="text-align:center; ">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Kode Sup.</th>
                                        <th>Nama Toko</th>
                                        <th>Alamat</th>
                                        <th>Telpon</th>
                                        <th>Email</th>
                                        <th width="6%">COUNT</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    $token = $this->session->userdata('token');
                                    foreach ($supplier as $sup) : ?>
                                        <?php $coun = $this->db->query("SELECT COUNT(kd_supplier) as pem FROM tb_pembelian WHERE kd_supplier='$sup->kode_sup' AND token='$token'")->row(); ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $sup->kode_sup ?></td>
                                            <td><?= $sup->nama_toko ?></td>
                                            <td><?= $sup->alamat ?></td>
                                            <td><?= $sup->telpon ?></td>
                                            <td><?= $sup->email ?></td>
                                            <td align="center"> <?= $coun->pem ?> Kali</td>
                                            <td align="center">
                                                <a href="<?= base_url('Supplier/Ubah_Supplier/') . $sup->kd_supplier ?>" <?= $akses->ubah != 1 ? 'hidden' : '' ?>><i class="fas fa-edit"></i></a>
                                                <a href="<?= base_url('Supplier/hapus/') . $sup->kd_supplier ?>" <?= $akses->hapus != 1 ? 'hidden' : '' ?> onclick="return confirm('Yakin hapus data ?')"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>