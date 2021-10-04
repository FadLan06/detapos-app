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
        <div class="row">
          <div class="col-md-12">

            <?= $this->session->flashdata('message') ?>
            <div class="card card-body m-b-30">
              <?php if ($orderr->token == 'DPVL3N') : ?>
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Pesanan Masuk</a>
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Diproses</a>
                    <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-hasil" role="tab" aria-controls="nav-contact" aria-selected="false">Selesai</a>
                  </div>
                </nav>
                <div class="tab-content mt-3" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <table class="table table-bordered my-2 responsive" width="100%" id="mPesanan1">
                      <thead>
                        <tr align="center">
                          <th width="2%">No</th>
                          <th width="10%">Order ID</th>
                          <th width="15%">Nama</th>
                          <th width="25%">Kode / Nama Barang</th>
                          <th>Tanggal</th>
                          <th>ID Akun</th>
                          <th width="10%">Status</th>
                          <th><i class="fas fa-cogs"></i></th>
                        </tr>
                      </thead>
                      <tbody id="show_pesanan1">

                      </tbody>
                    </table>
                    <?php foreach ($order as $or) : ?>
                      <?php if ($or->status == 1) : ?>
                        <?php $awal = strtotime($or->waktu);
                        $akhir = time();
                        $selisih = $awal - $akhir;
                        $hari = floor($selisih / (60 * 60 * 24));
                        ?>
                        <?php if (($hari >= '-7') && ($or->status_bayar == 0)) {
                          $this->db->query("UPDATE tb_checkout SET status_bayar='2' WHERE DATEDIFF(CURDATE(), waktu) = 7 AND token = '$or->token' AND status_bayar='0' ");
                        } ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                  <div class="tab-pane fade table-responsive" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <table class="table table-bordered my-2" width="100%" id="mProses1">
                      <thead>
                        <tr align="center">
                          <th width="2%">No</th>
                          <th width="10%">Order ID</th>
                          <th width="15%">Nama</th>
                          <th width="25%">Kode / Nama Barang</th>
                          <th>Tanggal Proses</th>
                          <th>ID Akun</th>
                          <th width="10%">Status</th>
                          <th><i class="fas fa-cogs"></i></th>
                        </tr>
                      </thead>
                      <tbody id="show_proses1">

                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane table-responsive fade" id="nav-hasil" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <table class="table table-bordered my-2" width="100%" id="mSelesai1">
                      <thead>
                        <tr align="center">
                          <th width="2%">No</th>
                          <th width="10%">Order ID</th>
                          <th width="15%">Nama</th>
                          <th width="15%">Kode / Nama Barang</th>
                          <th>ID Akun</th>
                          <th width="5%">Status</th>
                        </tr>
                      </thead>
                      <tbody id="show_selesai1">
                      </tbody>
                    </table>
                  </div>
                </div>
              <?php else : ?>
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Pesanan Masuk</a>
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Diproses</a>
                    <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Dikirim</a>
                    <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-hasil" role="tab" aria-controls="nav-contact" aria-selected="false">Selesai</a>
                  </div>
                </nav>
                <div class="tab-content mt-3" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <table class="table table-bordered my-2 responsive" width="100%" id="mPesanan">
                      <thead>
                        <tr align="center">
                          <th width="2%">No</th>
                          <th width="10%">Order ID</th>
                          <th width="15%">Nama</th>
                          <th width="25%">Kode / Nama Barang</th>
                          <th>Tanggal</th>
                          <th>Ekspedisi</th>
                          <th width="10%">Status</th>
                          <th><i class="fas fa-cogs"></i></th>
                        </tr>
                      </thead>
                      <tbody id="show_pesanan">

                      </tbody>
                    </table>
                    <?php foreach ($order as $or) : ?>
                      <?php if ($or->status == 1) : ?>
                        <?php $awal = strtotime($or->waktu);
                        $akhir = time();
                        $selisih = $awal - $akhir;
                        $hari = floor($selisih / (60 * 60 * 24));
                        ?>
                        <?php if (($hari >= '-7') && ($or->status_bayar == 0)) {
                          $this->db->query("UPDATE tb_checkout SET status_bayar='2' WHERE DATEDIFF(CURDATE(), waktu) = 7 AND token = '$or->token' AND status_bayar='0' ");
                        } ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                  <div class="tab-pane fade table-responsive" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <table class="table table-bordered my-2" width="100%" id="mProses">
                      <thead>
                        <tr align="center">
                          <th width="2%">No</th>
                          <th width="10%">Order ID</th>
                          <th width="15%">Nama</th>
                          <th width="25%">Kode / Nama Barang</th>
                          <th>Tanggal Proses</th>
                          <th>Ekspedisi</th>
                          <th width="10%">Status</th>
                          <th><i class="fas fa-cogs"></i></th>
                        </tr>
                      </thead>
                      <tbody id="show_proses">

                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane table-responsive fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <table class="table table-bordered my-2" width="100%" id="mKirim">
                      <thead>
                        <tr align="center">
                          <th width="2%">No</th>
                          <th width="10%">Order ID</th>
                          <th width="15%">Nama</th>
                          <th width="25%">Kode / Nama Barang</th>
                          <th>Tanggal Kirim</th>
                          <th>Ekspedisi</th>
                          <th width="10%">Status</th>
                          <th>No. Resi</th>
                        </tr>
                      </thead>
                      <tbody id="show_kirim">
                      </tbody>
                    </table>
                    <?php $no = 1;
                    foreach ($order as $or) : ?>
                      <?php if ($or->status == 3) : ?>
                        <?php $awal1 = strtotime($or->waktu_kirim);
                        $akhir1 = time();
                        $selisih1 = $awal1 - $akhir1;
                        $hari1 = floor($selisih1 / (60 * 60 * 24));
                        ?>
                        <?php if (($hari1 >= '-7') && ($or->status == 3)) {
                          $this->db->query("UPDATE tb_checkout SET status='4' WHERE DATEDIFF(CURDATE(), waktu_kirim) = 7 AND token = '$or->token' AND status='3' ");
                        } ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                  <div class="tab-pane table-responsive fade" id="nav-hasil" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <table class="table table-bordered my-2" width="100%" id="mSelesai">
                      <thead>
                        <tr align="center">
                          <th width="2%">No</th>
                          <th width="10%">Order ID</th>
                          <th width="15%">Nama</th>
                          <th width="15%">Kode / Nama Barang</th>
                          <th>Ekspedisi</th>
                          <th width="5%">Status</th>
                          <th>No. Resi</th>
                          <th width="15%">Ulasan</th>
                          <th>Bukti Terima</th>
                        </tr>
                      </thead>
                      <tbody id="show_selesai">
                      </tbody>
                    </table>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
  // pesanan
  $(document).ready(function() {
    tampil_pesanan(); //pemanggilan fungsi tampil barang.

    var pesanan = $('#mPesanan').DataTable({
      buttons: [{
          text: 'Cetak Pesanan Masuk',
          extend: 'print',
          className: 'btn-danger'
        },
        {
          text: 'Export Excel',
          extend: 'excel',
          className: 'btn-success'
        }
      ],
      dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-md-6'i><'col-md-6'p>>",
    });

    pesanan.buttons().container()
      .appendTo('#mPesanan_wrapper .col-md-5:eq(0)');

    //fungsi tampil barang
    function tampil_pesanan() {
      $.ajax({
        type: 'ajax',
        url: '<?php echo base_url() ?>Orders/vpesanan',
        async: false,
        dataType: 'json',
        success: function(data) {
          var html = '';
          var i;
          var no = 1;
          for (i = 0; i < data.length; i++) {
            if (data[i].status_bayar == 0) {
              $bl = '<span class="badge badge-warning badge-pill">Belum Bayar</span>';
              $ah = '<a href="#" class="btn btn-info btn-sm" data-toggle="modal" title="Verifikasi" data-target="#Verifikasi' + data[i].order_id + '"><i class="fas fa-search"></i> </a>';
            } else if (data[i].status_bayar == 2) {
              $bl = '<span class="badge badge-secondary badge-pill">Dibatalkan</span>';
              $ah = '';
            } else {
              $bl = '<span class="badge badge-success badge-pill">Sudah Bayar</span><br><span class="badge badge-primary badge-pill">Menunggu Verifikasi</span>';
              $ah = '<a href="#" class="btn btn-info btn-sm" data-toggle="modal" title="Verifikasi" data-target="#Verifikasi' + data[i].order_id + '"><i class="fas fa-search"></i> </a> <a href="<?= base_url('Orders/Proses/') ?>' + data[i].order_id + '" class="btn btn-danger btn-sm" title="Proses"><i class="fas fa-sync-alt"></i> </a>';
            };

            html += '<tr>' +
              '<td>' + no++ + '</td>' +
              '<td><b>' + data[i].order_id + '</b></td>' +
              '<td>' + data[i].nama_lengkap + '</td>' +
              '<td>' + data[i].kode_barang + ' / ' + data[i].nama_barang + '</td>' +
              '<td>' + data[i].waktu + '</td>' +
              '<td><b>' + data[i].ekspedisi + '</b><br> Paket : ' + data[i].paket + '<br> Ongkir : Rp. ' + data[i].ongkir + '</td>' +
              '<td>' + $bl + '</td>' +
              '<td style="text-align:center;" width="6%">' + $ah + '</td>' +
              '</tr>';
          }
          $('#show_pesanan').html(html);
        }

      });
    }

  });

  $(document).ready(function() {
    tampil_pesanan1(); //pemanggilan fungsi tampil barang.

    var pesanan = $('#mPesanan1').DataTable({
      buttons: [{
          text: 'Cetak Pesanan Masuk',
          extend: 'print',
          className: 'btn-danger'
        },
        {
          text: 'Export Excel',
          extend: 'excel',
          className: 'btn-success'
        }
      ],
      dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-md-6'i><'col-md-6'p>>",
    });

    pesanan.buttons().container()
      .appendTo('#mPesanan_wrapper .col-md-5:eq(0)');

    //fungsi tampil barang
    function tampil_pesanan1() {
      $.ajax({
        type: 'ajax',
        url: '<?php echo base_url() ?>Orders/vpesanan',
        async: false,
        dataType: 'json',
        success: function(data) {
          var html = '';
          var i;
          var no = 1;
          for (i = 0; i < data.length; i++) {
            if (data[i].status_bayar == 0) {
              $bl = '<span class="badge badge-warning badge-pill">Belum Bayar</span>';
              $ah = '<a href="#" class="btn btn-info btn-sm" data-toggle="modal" title="Verifikasi" data-target="#Verifikasi' + data[i].order_id + '"><i class="fas fa-search"></i> </a>';
            } else if (data[i].status_bayar == 2) {
              $bl = '<span class="badge badge-secondary badge-pill">Dibatalkan</span>';
              $ah = '';
            } else {
              $bl = '<span class="badge badge-success badge-pill">Sudah Bayar</span><br><span class="badge badge-primary badge-pill">Menunggu Verifikasi</span>';
              $ah = '<a href="#" class="btn btn-info btn-sm" data-toggle="modal" title="Verifikasi" data-target="#Verifikasi' + data[i].order_id + '"><i class="fas fa-search"></i> </a> <a href="<?= base_url('Orders/Proses/') ?>' + data[i].order_id + '" class="btn btn-danger btn-sm" title="Proses"><i class="fas fa-sync-alt"></i> </a>';
            };

            html += '<tr>' +
              '<td>' + no++ + '</td>' +
              '<td><b>' + data[i].order_id + '</b></td>' +
              '<td>' + data[i].nama_lengkap + '</td>' +
              '<td>' + data[i].kode_barang + ' / ' + data[i].nama_barang + '</td>' +
              '<td>' + data[i].waktu + '</td>' +
              '<td><b>' + data[i].id_akun + '</td>' +
              '<td>' + $bl + '</td>' +
              '<td style="text-align:center;" width="6%">' + $ah + '</td>' +
              '</tr>';
          }
          $('#show_pesanan1').html(html);
        }

      });
    }

  });

  // proses
  $(document).ready(function() {
    tampil_proses(); //pemanggilan fungsi tampil barang.

    var proses = $('#mProses').DataTable({
      buttons: [{
          text: 'Cetak Diproses',
          extend: 'print',
          className: 'btn-danger'
        },
        {
          text: 'Export Excel',
          extend: 'excel',
          className: 'btn-success'
        }
      ],
      dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-md-6'i><'col-md-6'p>>",
    });

    proses.buttons().container()
      .appendTo('#mProses_wrapper .col-md-5:eq(0)');

    //fungsi tampil barang
    function tampil_proses() {
      $.ajax({
        type: 'ajax',
        url: '<?php echo base_url() ?>Orders/vproses',
        async: false,
        dataType: 'json',
        success: function(data) {
          var html = '';
          var i;
          var no = 1;
          for (i = 0; i < data.length; i++) {
            html += '<tr>' +
              '<td width="2%">' + no++ + '</td>' +
              '<td><b>' + data[i].order_id + '</b></td>' +
              '<td>' + data[i].nama_lengkap + '</td>' +
              '<td>' + data[i].kode_barang + ' / ' + data[i].nama_barang + '</td>' +
              '<td>' + data[i].waktu_proses + '</td>' +
              '<td><b>' + data[i].ekspedisi + '</b><br> Paket : ' + data[i].paket + '<br> Ongkir : Rp. ' + data[i].ongkir + '</td>' +
              '<td width="10%">' + '<span class="badge badge-primary badge-pill">Diproses / Dikemas</span>' + '</td>' +
              '<td style="text-align:center;" width="5%">' +
              '<a href="" data-toggle="modal" data-target="#Kirim' + data[i].kd_checkout + '" class="btn btn-danger btn-sm" title="Kirim"><i class="fas fa-paper-plane"></i> </a>' +
              '</td>' +
              '</tr>';
          }
          $('#show_proses').html(html);
        }

      });
    }

  });

  $(document).ready(function() {
    tampil_proses1(); //pemanggilan fungsi tampil barang.

    var proses = $('#mProses1').DataTable({
      buttons: [{
          text: 'Cetak Diproses',
          extend: 'print',
          className: 'btn-danger'
        },
        {
          text: 'Export Excel',
          extend: 'excel',
          className: 'btn-success'
        }
      ],
      dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-md-6'i><'col-md-6'p>>",
    });

    proses.buttons().container()
      .appendTo('#mProses_wrapper .col-md-5:eq(0)');

    //fungsi tampil barang
    function tampil_proses1() {
      $.ajax({
        type: 'ajax',
        url: '<?php echo base_url() ?>Orders/vproses',
        async: false,
        dataType: 'json',
        success: function(data) {
          var html = '';
          var i;
          var no = 1;
          for (i = 0; i < data.length; i++) {
            $ps = '<a href="<?= base_url('Orders/selesai_pesanan/') ?>' + data[i].kd_checkout + '" class="btn btn-danger btn-sm" title="Selesai"><i class="fas fa-paper-plane"></i> </a>';
            html += '<tr>' +
              '<td width="2%">' + no++ + '</td>' +
              '<td><b>' + data[i].order_id + '</b></td>' +
              '<td>' + data[i].nama_lengkap + '</td>' +
              '<td>' + data[i].kode_barang + ' / ' + data[i].nama_barang + '</td>' +
              '<td>' + data[i].waktu_proses + '</td>' +
              '<td><b>' + data[i].id_akun + '</td>' +
              '<td width="10%">' + '<span class="badge badge-primary badge-pill">Diproses</span>' + '</td>' +
              '<td style="text-align:center;" width="5%">' +
              $ps +
              '</td>' +
              '</tr>';
          }
          $('#show_proses1').html(html);
        }

      });
    }

  });

  // kirim
  $(document).ready(function() {
    tampil_kirim(); //pemanggilan fungsi tampil barang.

    var kirim = $('#mKirim').DataTable({
      buttons: [{
          text: 'Cetak Dikirim',
          extend: 'print',
          className: 'btn-danger'
        },
        {
          text: 'Export Excel',
          extend: 'excel',
          className: 'btn-success'
        }
      ],
      dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-md-6'i><'col-md-6'p>>",
    });

    kirim.buttons().container()
      .appendTo('#mKirim_wrapper .col-md-5:eq(0)');

    //fungsi tampil barang
    function tampil_kirim() {
      $.ajax({
        type: 'ajax',
        url: '<?php echo base_url() ?>Orders/vkirim',
        async: false,
        dataType: 'json',
        success: function(data) {
          var html = '';
          var i;
          var no = 1;
          for (i = 0; i < data.length; i++) {
            html += '<tr>' +
              '<td width="2%">' + no++ + '</td>' +
              '<td><b>' + data[i].order_id + '</b></td>' +
              '<td>' + data[i].nama_lengkap + '</td>' +
              '<td>' + data[i].kode_barang + ' / ' + data[i].nama_barang + '</td>' +
              '<td>' + data[i].waktu_kirim + '</td>' +
              '<td><b>' + data[i].ekspedisi + '</b><br> Paket : ' + data[i].paket + '<br> Ongkir : Rp. ' + data[i].ongkir + '</td>' +
              '<td width="10%">' + '<span class="badge badge-primary badge-pill">Dikirim</span>' + '</td>' +
              '<td width="15%"><h5>' + data[i].no_resi + '</h5></td>' +
              '</tr>';
          }
          $('#show_kirim').html(html);
        }

      });
    }

  });

  // selesai
  $(document).ready(function() {
    tampil_selesai(); //pemanggilan fungsi tampil barang.

    var selesai = $('#mSelesai').DataTable({
      buttons: [{
          text: 'Cetak Selesai',
          extend: 'print',
          className: 'btn-danger'
        },
        {
          text: 'Export Excel',
          extend: 'excel',
          className: 'btn-success'
        }
      ],
      dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-md-6'i><'col-md-6'p>>",
    });

    selesai.buttons().container()
      .appendTo('#mSelesai_wrapper .col-md-5:eq(0)');

    //fungsi tampil barang
    function tampil_selesai() {
      $.ajax({
        type: 'ajax',
        url: '<?php echo base_url() ?>Orders/vselesai',
        async: false,
        dataType: 'json',
        success: function(data) {
          var html = '';
          var i;
          var no = 1;
          for (i = 0; i < data.length; i++) {
            if (data[i].bukti_terima == '') {
              $gam = '<img src="<?= base_url('assets/img/noimage.png') ?>" style="width: 220px;" alt="">';
            } else {
              $gam = '<img src="<?= base_url('assets/upload/terima/') ?>' + data[i].bukti_terima + '" width="100 px " alt="">';
            }
            html += '<tr>' +
              '<td width="2%">' + no++ + '</td>' +
              '<td width="10%"><b>' + data[i].order_id + '</b></td>' +
              '<td>' + data[i].nama_lengkap + '</td>' +
              '<td>' + data[i].kode_barang + ' / ' + data[i].nama_barang + '</td>' +
              '<td width="13%"><b>' + data[i].ekspedisi + '</b><br> Paket : ' + data[i].paket + '<br> Ongkir : Rp. ' + data[i].ongkir + '</td>' +
              '<td width="5%">' + '<span class="badge badge-primary badge-pill">Selesai</span>' + '</td>' +
              '<td width="10%"><h5>' + data[i].no_resi + '</h5></td>' +
              '<td width="10%"><h5>' + data[i].ulasan + '</h5></td>' +
              '<td width="15%"><h5>' + $gam + '</h5></td>' +
              '</tr>';
          }
          $('#show_selesai').html(html);
        }

      });
    }

  });

  $(document).ready(function() {
    tampil_selesai1(); //pemanggilan fungsi tampil barang.

    var selesai = $('#mSelesai1').DataTable({
      buttons: [{
          text: 'Cetak Selesai',
          extend: 'print',
          className: 'btn-danger'
        },
        {
          text: 'Export Excel',
          extend: 'excel',
          className: 'btn-success'
        }
      ],
      dom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-md-6'i><'col-md-6'p>>",
    });

    selesai.buttons().container()
      .appendTo('#mSelesai_wrapper .col-md-5:eq(0)');

    //fungsi tampil barang
    function tampil_selesai1() {
      $.ajax({
        type: 'ajax',
        url: '<?php echo base_url() ?>Orders/vselesai',
        async: false,
        dataType: 'json',
        success: function(data) {
          var html = '';
          var i;
          var no = 1;
          for (i = 0; i < data.length; i++) {
            html += '<tr>' +
              '<td width="2%">' + no++ + '</td>' +
              '<td width="10%"><b>' + data[i].order_id + '</b></td>' +
              '<td>' + data[i].nama_lengkap + '</td>' +
              '<td>' + data[i].kode_barang + ' / ' + data[i].nama_barang + '</td>' +
              '<td width="13%"><b>' + data[i].id_akun + '</b></td>' +
              '<td width="5%">' + '<span class="badge badge-primary badge-pill">Selesai</span>' + '</td>' +
              '</tr>';
          }
          $('#show_selesai1').html(html);
        }

      });
    }

  });
</script>

<!-- VERIFIKASI -->
<?php foreach ($order as $or) : ?>
  <?php $this->db->join('tb_rekening', 'tb_rekening.kd_rekening = tb_checkout_tmp.transfer_ke');
  $konf = $this->db->get_where('tb_checkout_tmp', ['tb_checkout_tmp.order_id' => $or->order_id, 'tb_checkout_tmp.token' => $or->token])->row(); ?>
  <div class="modal fade" id="Verifikasi<?= $or->order_id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-deta">
          <h5 class="modal-title text-white" id="staticBackdropLabel">Pesanan - <?= $or->order_id ?></h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h6><b>Detail Pembelian</b></h6>
          <hr class="bg-deta">
          <div class="col-md-10 mx-auto">
            <table class="table" width="100%">
              <tr>
                <td width="30%"><b>Order ID</b></td>
                <td width="2%">:</td>
                <td><?= $or->order_id ?></td>
              </tr>
              <tr>
                <td width="30%"><b>Nama Barang</b></td>
                <td width="2%">:</td>
                <td><?= $or->nama_barang ?></td>
              </tr>
              <tr>
                <td width="30%"><b>Harga</b></td>
                <td width="2%">:</td>
                <td>Rp. <?= number_format($or->harga_jual) ?></td>
              </tr>
              <tr>
                <td width="30%"><b>Jumlah</b></td>
                <td width="2%">:</td>
                <td><?= $or->qty ?> <?= $or->satuan ?></td>
              </tr>
              <tr>
                <td width="30%"><b>Kode Unik</b></td>
                <td width="2%">:</td>
                <td><?php if (($set->kode_unik == 'Mengurangi') || ($set->kode_unik == '')) {
                      echo '-';
                    } ?> Rp. <?= $or->kode_unik ?></td>
              </tr>
              <?php if ($set->token != 'DPVL3N') : ?>
                <tr>
                  <td width="30%"><b>Ongkir</b></td>
                  <td width="2%">:</td>
                  <td>Rp. <?= number_format($or->ongkir) ?></td>
                </tr>
              <?php endif; ?>
              <tr>
                <td width="30%"><b>Total</b></td>
                <td width="2%">:</td>
                <td>Rp. <?= number_format($or->gran_total) ?></td>
              </tr>
            </table>
          </div>
          <h6><b>Bukti Transfer</b></h6>
          <hr class="bg-deta">
          <div class="col-md-12 mx-auto table-responsive-sm">
            <table class="table table-bordered table-sm" width="100%">
              <thead class="bg-deta text-white">
                <tr align="center">
                  <th width="20%">Atas Nama</th>
                  <th width="35%">Transfer Ke</th>
                  <th>Tanggal Transfer</th>
                  <th>Jumlah Transfer</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($konf->order_id)) : ?>
                  <tr>
                    <td colspan="4" align="center"><i>
                        <--- tidak ada data --->
                      </i></td>
                  </tr>
                <?php else : ?>
                  <tr>
                    <td><?= $konf->nama ?></td>
                    <td align="center"><b>No. Rekening : </b> <?= $konf->no_rekening ?><br /> <b>a.n : </b> <?= $konf->atas_nama ?></td>
                    <td align="center"><?= date('d F Y', strtotime($konf->tgl_transfer)) ?></td>
                    <td>Rp. <?= number_format($konf->jml_transfer) ?></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-12 mx-auto">
            <?php if (empty($konf->order_id)) : ?>
              <img class="card-img" src="<?= base_url('assets/img/noimage.png') ?>" alt="">
            <?php else : ?>
              <img class="card-img" src="<?= base_url('assets/upload/konfirmasi/') . $konf->bukti_transfer ?>" alt="" width="50%">
            <?php endif; ?>
          </div>
          <hr class="bg-deta">
          <div class="col-md-12 mx-auto">
            <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- KIRIM -->
<?php foreach ($order as $or) : ?>
  <div class="modal fade" id="Kirim<?= $or->kd_checkout ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-deta">
          <h5 class="modal-title text-white" id="staticBackdropLabel">Pesanan - <?= $or->order_id ?></h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= form_open('Orders/Kirim/' . $or->kd_checkout . '/' . $or->order_id) ?>
          <table class="table" width="100%">
            <tr>
              <th width="25%">Ekspedisi</th>
              <td width="5%">:</td>
              <td><?= $or->ekspedisi ?></td>
            </tr>
            <tr>
              <th width="25%">Paket</th>
              <td width="5%">:</td>
              <td><?= $or->paket ?></td>
            </tr>
            <tr>
              <th width="25%">Ongkir</th>
              <td width="5%">:</td>
              <td>Rp. <?= number_format($or->ongkir) ?></td>
            </tr>
            <tr>
              <th width="25%">No Resi</th>
              <td width="5%">:</td>
              <td><input type="text" class="form-control" name="no_resi" autocomplete="off"></td>
            </tr>
          </table>
          <button type="submit" class="btn btn-danger float-right">Kirim</button>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>