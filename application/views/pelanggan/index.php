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
                        <a href="<?= base_url('Pelanggan/Tambah_Pelanggan') ?>" class="btn btn-deta btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-plus-circle"></i> Tambah</a>
                        <a href="<?= base_url('Pelanggan/Export') ?>" class="btn btn-success btn-sm"><i class="fas fa-download"></i> Export Excel</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead align="center">
                                    <?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR') || ($this->session->userdata('token') == 'DPQTT39LS7ETWKXE')) : ?>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>NAMA PELANGGAN</th>
                                            <th>EMAIL</th>
                                            <th>NO. TELPON</th>
                                            <th>ALAMAT</th>
                                            <th width="6%">COUNT</th>
                                            <th width="15%">TOTAL</th>
                                            <th width="6%">POINT</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    <?php else : ?>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>KODE PEL.</th>
                                            <th>NAMA PELANGGAN</th>
                                            <th>EMAIL</th>
                                            <th>NO. TELPON</th>
                                            <th>ALAMAT</th>
                                            <th width="6%">DISKON</th>
                                            <th width="6%">COUNT</th>
                                            <th>Aksi</th>
                                        </tr>
                                    <?php endif; ?>
                                </thead>
                                <tbody>
                                    <?php if (($this->session->userdata('token') == 'DPVL3N5K7VYF7ZSR') || ($this->session->userdata('token') == 'DPQTT39LS7ETWKXE')) : ?>
                                        <?php $no = 1;
                                        foreach ($pelanggan as $pel) : ?>
                                            <?php $coun = $this->db->query("SELECT COUNT(kode_pelanggan) as pen FROM tb_penjualan WHERE kode_pelanggan='$pel->nama_pel' AND token='$pel->token'")->row(); ?>
                                            <?php $tot = $this->db->query("SELECT sum(total) as tot FROM tb_penjualan WHERE kode_pelanggan='$pel->nama_pel' AND token='$pel->token'")->row(); ?>
                                            <?php $disk = $this->db->query("SELECT sum(pot) as pot FROM tb_penjualan WHERE kode_pelanggan='$pel->nama_pel' AND token='$pel->token'")->row(); ?>
                                            <?php $total = $tot->tot - $disk->pot; ?>
                                            <?php $sisaBagi =  fmod($total, $pel->point);
                                            if ($pel->point != 0) {
                                                $hasilbagi = ($total - $sisaBagi) / $pel->point;
                                            }
                                            ?>
                                            <tr align="left">
                                                <td align="center"><?= $no++ ?></td>
                                                <td><?= $pel->nama_pel ?></td>
                                                <td><?= $pel->email ?></td>
                                                <td><?= $pel->no_hp ?></td>
                                                <td><?= $pel->alamat ?></td>
                                                <td align="center"> <?= $coun->pen ?> Kali</td>
                                                <td align="center">Rp. <?= number_format($total) ?></td>
                                                <td align="center"> <?= $pel->point != '0' ? $hasilbagi : 0 ?></td>
                                                <td align="center">
                                                    <a href="<?= base_url('Pelanggan/View/') . $pel->kd_pelanggan ?>" title="Lihat Detail"><i class="fas fa-eye text-warning"></i></a>
                                                    <a href="<?= base_url('Pelanggan/Ubah_Pelanggan/') . $pel->kd_pelanggan ?>" <?= $akses->ubah != 1 ? 'hidden' : '' ?> title="Ubah"><i class="fas fa-edit mx-2"></i></a>
                                                    <a href="<?= base_url('Pelanggan/hapus/') . $pel->kd_pelanggan ?>" <?= $akses->hapus != 1 ? 'hidden' : '' ?> title="Hapus" onclick="return confirm('Yakin hapus data ?')"><i class="fas fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <?php $no = 1;
                                        foreach ($pelanggan as $pel) : ?>
                                            <?php $coun = $this->db->query("SELECT COUNT(kode_pelanggan) as pen FROM tb_penjualan WHERE kode_pelanggan='$pel->nama_pel' AND token='$pel->token'")->row(); ?>
                                            <tr align="left">
                                                <td align="center"><?= $no++ ?></td>
                                                <td><?= $pel->kode_pel ?></td>
                                                <td><?= $pel->nama_pel ?></td>
                                                <td><?= $pel->email ?></td>
                                                <td><?= $pel->no_hp ?></td>
                                                <td><?= $pel->alamat ?></td>
                                                <td align="center"><?= number_format($pel->diskon) ?>%</td>
                                                <td align="center"> <?= $coun->pen ?> Kali</td>
                                                <td align="center">
                                                    <a href="<?= base_url('Pelanggan/Ubah_Pelanggan/') . $pel->kd_pelanggan ?>" <?= $akses->ubah != 1 ? 'hidden' : '' ?>><i class="fas fa-edit"></i></a>
                                                    <a href="<?= base_url('Pelanggan/hapus/') . $pel->kd_pelanggan ?>" <?= $akses->hapus != 1 ? 'hidden' : '' ?> onclick="return confirm('Yakin hapus data ?')"><i class="fas fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>