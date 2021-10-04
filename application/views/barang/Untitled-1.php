<!-- Standar -->
<?php $no = 1; ?>
<?php foreach ($barang as $br) : ?>
    <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
    <?php
    $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']]);
    $kd = $query->num_rows();
    ?>
    <tr>
        <td align="center"><?= $no++ ?> </td>
        <td><?= $br['kode'] ?></td>
        <td><?= $br['nama_barang'] ?></td>
        <td align="center">Rp. <?= number_format($br['harga_beli']) ?></td>
        <td align="center">Rp. <?= number_format($br['harga_jual']) ?></td>
        <td align="center"><?= number_format($stok['qty']) . ' / ' . number_format($br['jml_stok']) ?></td>
        <td align="center">
            <a href="" class="btn btn-warning btn-sm" data-target="#mRetur" data-toggle="modal" data-id="<?= $br['id'] ?>"><i class="fas fa-undo"></i> Retur</a>
        </td>
        <td align="center">
            <a href="<?= base_url('Barang/Ubah_Barang/') . $br['id'] ?>" class="btn btn-primary btn-sm <?= $akses->ubah != 1 ? 'disabled' : '' ?>"><i class="fas fa-edit"></i></a>
            <a href="<?= base_url('Barang/Hapus_brng/') . $br['id'] . '/' . $br['kode_barang'] ?>" class="btn btn-danger btn-sm <?= $akses->hapus != 1 ? 'disabled' : '' ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-white"></i></a>
        </td>
    </tr>
<?php endforeach; ?>

<!-- Butik -->
<?php $no = 1; ?>
<?php foreach ($barang as $br) : ?>
    <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
    <?php $stok1 = $this->db->query("SELECT t.qty, t.id_barang, t.token, SUM(t.qty) as qty FROM tb_shop_detail t WHERE t.id_barang='$br[kode_barang]' AND t.token='$br[token]' AND t.status_bayar='1' ")->row_array(); ?>

    <?php $kat = $this->db->get_where('tb_kategori_barang', ['token' => $br['token'], 'kode_kategori' => $br['id_kategori']])->row_array(); ?>
    <?php $hg = $this->db->get_where('tb_barang_harga', ['token' => $br['token'], 'id_barang' => $br['kode_barang']])->result_array(); ?>
    <?php
    $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']]);
    $kd = $query->num_rows();
    ?>
    <tr>
        <td align="center"><?= $no++ ?> </td>
        <td>
            <div class="kodee_brangg"><?= $br['kode'] ?></div>
        </td>
        <td>
            <?= $br['nama_barang'] ?>
        </td>
        <td align="center">Rp. <?= number_format($br['harga_beli']) ?></td>
        <td align="center">
            <?php foreach ($hg as $data) : ?>
                <li style="list-style-type: none">Rp. <?= number_format($data['harga_jual']) ?></li>
            <?php endforeach; ?>
        </td>
        <td align="center"><?= number_format($stok['qty'] + $stok1['qty']) . ' / ' . number_format($br['jml_stok']) ?> </td>
        <td align="center">
            <a href="<?= base_url('Barang/Ubah_Barang/') . $br['id'] ?>" class="btn btn-deta btn-sm <?= $akses->ubah != 1 ? 'disabled' : '' ?>"><i class="fas fa-edit"></i></a>
            <a href="<?= base_url('Barang/Hapus_brng_bt/') . $br['id'] . '/' . $br['kode_barang'] ?>" class="btn btn-danger btn-sm <?= $akses->hapus != 1 ? 'disabled' : '' ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-white"></i></a>
        </td>
    </tr>
<?php endforeach; ?>

<!-- CHeckout -->
<?php $no = 1; ?>
<?php foreach ($barang as $br) : ?>
    <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
    <?php $stok1 = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_checkout t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
    <?php
    $kd = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']])->num_rows();
    $kd1 = $this->db->get_where('tb_checkout', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']])->num_rows();
    ?>
    <tr>
        <td align="center"><?= $no++ ?> </td>
        <td>
            <div class="kodee_brangg"><?= $br['kode'] ?></div>
        </td>
        <td><?= $br['nama_barang'] ?></td>
        <td align="center">Rp. <?= number_format($br['harga_beli']) ?></td>
        <td align="center">
            <li style="display: <?= $br['harga_jual'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual']) ?></li>
            <li style="display: <?= $br['harga_jual1'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual1']) ?></li>
            <li style="display: <?= $br['harga_jual2'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual2']) ?></li>
        </td>
        <td align="center"><?= number_format($stok['qty'] + $stok1['qty']) . ' / ' . number_format($br['jml_stok']) ?></td>
        <td align="center">
            <a href="" class="btn btn-secondary btn-sm <?= $akses->ubah != 1 ? 'disabled' : '' ?>" data-target="#mLink" data-toggle="modal" data-id="<?= $br['id'] ?>"><i class="fas fa-link"></i> Link</a>
        </td>
        <td align="center">
            <a href="" class="btn btn-warning btn-sm <?= $akses->ubah != 1 ? 'disabled' : '' ?>" data-target="#mRetur" data-toggle="modal" data-id="<?= $br['id'] ?>"><i class="fas fa-undo"></i> Retur</a>
        </td>
        <td align="center">
            <a href="<?= base_url('Barang/Ubah_Barang/') . $br['id'] ?>" <?= $akses->ubah != 1 ? 'hidden' : '' ?>><i class="fas fa-edit"></i></a>
            <a href="<?= base_url('Barang/hapus_brng_cek/') . $br['id'] . '/' . $br['kode_barang'] ?>" <?= $akses->hapus != 1 ? 'hidden' : '' ?> onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-danger"></i></a>
        </td>
    </tr>
<?php endforeach; ?>

<!-- Retail -->
<?php $no = 1; ?>
<?php foreach ($barang as $br) : ?>
    <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
    <?php
    $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']]);
    $kd = $query->num_rows();
    ?>
    <tr>
        <td align="center"><?= $no++ ?> </td>
        <td>
            <div class="kodee_brangg"><?= $br['kode'] ?></div>
        </td>
        <td><?= $br['nama_barang'] ?></td>
        <td align="center">Rp. <?= number_format($br['harga_beli']) ?></td>
        <td align="center">
            <li style="display: <?= $br['harga_jual'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual']) ?></li>
            <li style="display: <?= $br['harga_jual1'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual1']) ?></li>
            <li style="display: <?= $br['harga_jual2'] == 0 ? 'none' : '' ?>;list-style-type: none">Rp. <?= number_format($br['harga_jual2']) ?></li>
        </td>
        <td align="center"><?= number_format($stok['qty']) . ' / ' . number_format($br['jml_stok']) ?></td>
        <td align="center">
            <a href="" class="btn btn-warning btn-sm" data-target="#mRetur" data-toggle="modal" data-id="<?= $br['id'] ?>"><i class="fas fa-undo"></i> Retur</a>
        </td>
        <td align="center">
            <a href="<?= base_url('Barang/Ubah_Barang/') . $br['id'] ?>" class="btn btn-primary btn-sm <?= $akses->ubah != 1 ? 'disabled' : '' ?>"><i class="fas fa-edit"></i></a>
            <a href="<?= base_url('Barang/Hapus_brng/') . $br['id'] . '/' . $br['kode_barang'] ?>" class="btn btn-danger btn-sm <?= $akses->hapus != 1 ? 'disabled' : '' ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-white"></i></a>
        </td>
    </tr>
<?php endforeach; ?>

<!-- Electronik -->
<?php $no = 1; ?>
<?php foreach ($barang as $br) : ?>
    <?php $stok = $this->db->query("SELECT t.qty, t.kode_barang, t.token, SUM(t.qty) as qty FROM tb_detail_penjualan t WHERE t.kode_barang='$br[kode_barang]' AND t.token='$br[token]'")->row_array(); ?>
    <?php $hg = $this->db->get_where('tb_barang_harga', ['token' => $br['token'], 'id_barang' => $br['kode_barang']])->result_array(); ?>
    <?php
    $query = $this->db->get_where('tb_detail_penjualan', ['kode_barang' => $br['kode_barang'], 'token' => $br['token']]);
    $kd = $query->num_rows();
    ?>
    <tr>
        <td align="center"><?= $no++ ?> </td>
        <td><?= $br['kode'] ?></td>
        <td><?= $br['nama_barang'] ?></td>
        <td align="center">Rp. <?= number_format($br['harga_beli']) ?></td>
        <td align="center">
            <?php foreach ($hg as $data) : ?>
                <li style="list-style-type: none">Rp. <?= number_format($data['harga_jual']) ?></li>
            <?php endforeach; ?>
        </td>
        <td align="center"><?= number_format($br['jml_stok']) ?></td>
        <td align="center">
            <a href="" class="btn btn-warning btn-sm" data-target="#mSerial" data-toggle="modal" data-id="<?= $br['kode_barang'] ?>"><i class="fas fa-key"></i> Serial</a>
        </td>
        <td align="center">
            <a href="<?= base_url('Barang/Ubah_Barang/') . $br['id'] ?>" class="btn btn-deta btn-sm <?= $akses->ubah != 1 ? 'disabled' : '' ?>"><i class="fas fa-edit"></i></a>
            <a href="<?= base_url('Barang/Hapus_brng/') . $br['id'] . '/' . $br['kode_barang'] ?>" class="btn btn-danger btn-sm <?= $akses->hapus != 1 ? 'disabled' : '' ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-white"></i></a>
        </td>
    </tr>
<?php endforeach; ?>