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

        <div class="card m-b-30">

            <div class="card-body">
                <a href="<?= base_url('Pesanan/Reseller_export') ?>" class="btn btn-success btnn btn-sm"><i class="fas fa-download"></i> Export Excel</a>
                <a href="<?= base_url('Pesanan/Reseller_cetak') ?>" target="_blank" class="btn btn-danger btnn btn-sm"><i class="fas fa-print"></i> Cetak</a>
                <hr class="bg-deta">
                <div class="table-responsive b-0" data-pattern="priority-columns">
                    <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead align="center">
                            <tr>
                                <th width="5%">#</th>
                                <th>NAMA</th>
                                <th>EMAIL</th>
                                <th>NO. TELPON</th>
                                <th>ALAMAT</th>
                                <th width="6%">COUNT</th>
                                <th width="15%">TOTAL</th>
                                <th width="5%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($res as $data) : ?>
                                <?php $coun = $this->db->query("SELECT COUNT(s.id_shop_pel) as pel FROM tb_shop s WHERE s.id_shop_pel='$data[id_shop_pel]' AND s.status_bayar='1'")->row(); ?>
                                <?php $total = $this->db->query("SELECT SUM(total) as tot FROM tb_shop s WHERE s.id_shop_pel='$data[id_shop_pel]' AND s.status_bayar='1'")->row(); ?>
                                <?php if ($data['is_active'] == 1) {
                                    $b = 'success';
                                    $n = 'Aktif';
                                    $a = 0;
                                } else {
                                    $b = 'danger';
                                    $n = 'Non Aktif';
                                    $a = 1;
                                } ?>
                                <tr>
                                    <td align="center"><?= $no++ ?></td>
                                    <td><?= $data['nama_pel'] ?></td>
                                    <td><?= $data['email'] ?></td>
                                    <td><?= $data['no_hp'] ?></td>
                                    <td><?= $data['alamat'] ?></td>
                                    <td align="center"><?= $coun->pel ?> Kali</td>
                                    <td align="center">Rp. <?= number_format($total->tot) ?></td>
                                    <td align="center"><a href="<?= base_url('Pesanan/Reseller_aksi/') . $a . '/' . $data['id_shop_pel'] ?>" class="badge badge-<?= $b ?>"><?= $n ?></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>