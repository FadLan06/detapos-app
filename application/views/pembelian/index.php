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
          <div class="card-header"><a href="<?= base_url() ?>Pembelian/Transaksi" class="btn btn-deta btn-sm <?= $akses->tambah != 1 ? 'disabled' : '' ?>"><i class="fas fa-plus-circle"></i> Tambah</a></div>
          <div class="card-body">
            <?= $this->session->flashdata('message') ?>
            <div class="table-responsive b-0" data-pattern="priority-columns">
              <table id="datatable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead class="center" style="text-align:center; ">
                  <tr>
                    <th width="5%">#</th>
                    <th width="20%">No. Invoice</th>
                    <th width="20%">Nama Toko</th>
                    <th width="20%">Tanggal</th>
                    <th width="10%">Petugas</th>
                    <th width="10%">Total</th>
                    <th width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($pembelian as $pen) : ?>
                    <?php $sup = $this->db->get_where('tb_supplier', ['kode_sup' => $pen->kd_supplier, 'token' => $pen->token])->row(); ?>
                    <tr>
                      <td align="center"><?= $no++ ?></td>
                      <td align="center">
                        <button class="btn btn-outline-deta" onclick="location.href='<?= base_url('Pembelian/Detail/') . $pen->no_faktur . '/' . $pen->id_pembelian ?>'"><?= $pen->no_faktur ?></button>
                      </td>
                      <td>
                        <?php if ($pen->kd_supplier == '') : ?>
                          <?= '' ?>
                        <?php else : ?>
                          <?= $sup->kode_sup . ' / ' . $sup->nama_toko ?>
                        <?php endif; ?>
                      </td>
                      <td align="center"><?= date('d F Y | H:i:s', strtotime($pen->timestmp)) ?></td>
                      <td><?= $pen->petugas ?></td>
                      <td>Rp. <?= number_format($pen->total) ?></td>
                      <td align="center">
                        <a href="<?= base_url('Pembelian/hapuss/') . $pen->no_faktur . '/' . $pen->id_pembelian ?>" class="btn <?= $akses->hapus != 1 ? 'disabled' : '' ?>" onclick="return confirm('Yakin anda ?')"><i class="fas fa-trash text-danger"></i></a>
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