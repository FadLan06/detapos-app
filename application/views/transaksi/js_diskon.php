<script type="text/javascript">
  $(document).ready(function() {

    $('#kode1').autocomplete({
      source: "<?php echo site_url('Kasir_Diskon/Auto_kasir'); ?>",

      select: function(event, ui) {
        $('[name="kode_barang"]').val(ui.item.label);
        $('[name="nama_barang"]').val(ui.item.nama);
        $('[name="harga"]').val(ui.item.harga);
        $('[name="harga_beli"]').val(ui.item.harga_beli);
      }
    });

  });

  function isi_otomatis1() {
    var kode = $("#kode1").val();
    $.ajax({
      url: '<?= site_url() . 'Kasir_Diskon/Proses' ?>',
      data: {
        kode: kode
      },
      success: function(data) {
        var json = data,
          obj = JSON.parse(json);
        $('#nama_barang1').val(obj.nama_barang);
        $('#harga1').val(obj.harga);
        $('#harga_beli1').val(obj.harga_beli);
      }
    });
  }

  $(document).ready(function() {

    $('#pelanggan1').autocomplete({
      source: "<?php echo site_url('Kasir_Diskon/Auto_pel'); ?>",

      select: function(event, ui) {
        $('[name="pelanggan"]').val(ui.item.label);
        $('[name="diskon"]').val(ui.item.diskon);

        var pot = $("#diskon").val();
        var total = $("#total1").val();

        var tot_bar = total - ((total * pot) / 100);
        var tot = (total * pot) / 100;
        if (tot_bar > 0) {
          $("#bayartot1").html(to_rupiah(tot_bar));
          $("#bayartotval1").val(tot_bar);
          $("#total1").val(tot_bar);
          $("#pot").val(tot);
        } else {
          $("#bayartot1").html(to_rupiah(0));
          $("#bayartotval1").val();
          $("#total1").val();
          $("#pot").val();
        }
      }
    });

  });

  tampil_data_barang1(); //pemanggilan fungsi tampil barang.

  $('#mydata1');

  //fungsi tampil barang
  function tampil_data_barang1() {
    $.ajax({
      type: 'GET',
      url: '<?php echo base_url() ?>Kasir_Diskon/data_kasir',
      async: true,
      dataType: 'json',
      success: function(data) {
        var html = '';
        var i;
        var tot = 0;
        var no = 1;
        for (i = 0; i < data.length; i++) {
          html += '<tr>' +
            '<td width="5%">' + no++ + '</td>' +
            '<td width="35%">' + data[i].nama_barang + '</td>' +
            '<td width="20%">' + to_rupiah(data[i].harga) + '</td>' +
            '<td width="15%">' + data[i].kty + '</td>' +
            '<td width="20%">' + to_rupiah(data[i].sub_total) + '</td>' +
            '<td style="text-align:center; width:20%">' +
            '<a href="" class="badge badge-danger delete" id="' + data[i].kode_barang + '">Hapus</a>' +
            '</td>' +
            '</tr>';
          tot = parseInt(tot) + parseInt(data[i].sub_total);
        }
        $("#total1").val(tot);
        $("#bayartotval1").val(tot);
        $("#bayartot1").html(to_rupiah(tot));
        $('#list1').html(html);
        $('#kembali1').html(to_rupiah(0));
        $("#tombol1").prop("disabled", true);

        // $("#pelanggan").val('Umum');
      }

    });
  };

  //Simpan Barang
  $('#btn_simpan1').on('click', function() {
    var valid = this.form.checkValidity();
    if (valid) {
      event.preventDefault();
      var kobar = $('#kode1').val();
      var nabar = $('#nama_barang1').val();
      var harga = $('#harga1').val();
      var harga_beli = $('#harga_beli1').val();
      var petugas = $('#petugas1').val();
      var qty = $('#qty1').val();
      var token = $('#token1').val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('Kasir_Diskon/simpan_barang') ?>",
        dataType: "JSON",
        data: {
          kobar: kobar,
          nabar: nabar,
          harga: harga,
          harga_beli: harga_beli,
          petugas: petugas,
          qty: qty,
          token: token
        },
        success: function(data) {

          $('[name="kode_barang"]').val("");
          $('[name="nama_barang"]').val("");
          $('[name="harga"]').val("");
          $('[name="harga_beli"]').val("");
          $('[name="petugas"]').val("");
          $('[name="qty"]').val("");
          $('[name="token"]').val("");
          tampil_data_barang1();
        }
      });
      return false;
    }
  });

  // Hapus
  $(document).on('click', '.delete', function() {
    var id = $(this).attr("id");
    $.ajax({
      url: "<?php echo base_url(); ?>Kasir_Diskon/delete",
      method: "POST",
      data: {
        id: id
      },
      success: function(data) {
        tampil_data_barang();
      }
    });
    return false;
  });

  function to_rupiah(angka) {
    var rev = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2 = '';
    for (var i = 0; i < rev.length; i++) {
      rev2 += rev[i];
      if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
        rev2 += '.';
      }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
  }

  $(document).on('keyup', '#qty1', function() {
    var kode = $('#kode1').val();
    var qty = $('#qty1').val();

    if (qty) {
      $.ajax({
        url: "<?= base_url('Kasir_Diskon/cek_barang') ?>",
        type: 'POST',
        data: {
          kode: kode,
          qty: qty
        },
        success: function(response) {
          //var resp = $.trim(response);
          if (response) {
            $("#btn_simpan1").removeAttr('disabled', 'disabled').html(response);
          }
        }
      });
    }
  });

  $(function() {
    $("#diskon").number(true);

    $("#pelanggan1").keyup(function() {
      var pel = $("#pelanggan1").val();
      if (pel == '') {
        $("#diskon").val(0);
        var pot = $("#diskon1").val();
        var total = $("#total1").val();

        var tot_bar = total - ((total * pot) / 100);
        if (tot_bar > 0) {
          $("#bayartot1").html(to_rupiah(tot_bar));
          $("#bayartotval1").val(tot_bar);
          $("#total1").val(tot_bar);
        } else {
          $("#bayartot1").html(to_rupiah(0));
        }
      }
    });

    $("#diskon1").keyup(function() {
      var pot = $("#diskon1").val();
      var total = $("#total1").val();

      var tot_bar = total - ((total * pot) / 100);
      if (tot_bar > 0) {
        $("#bayartot1").html(to_rupiah(tot_bar));
        $("#bayartotval1").val(tot_bar);
        $("#total1").val(tot_bar);
      } else {
        $("#bayartot1").html(to_rupiah(0));
        $("#bayartotval1").val();
        $("#total1").val();
      }
    });
  });

  $(function() {
    // $("#bayar").val();
    $("#bayar1").number(true);
    $('#bayar1').keyup(function() {
      var bayar = $('#bayar1').val();
      // $("#bayar2").val(parseInt(bayar));
      // var kembali = $('#kembali').html(to_rupiah(0));
      if (bayar == '') {
        $("#span1").prop("hidden", true);
      }

      var total = $("#bayartotval1").val();
      var uang = $("#bayar1").val();

      if (bayar == '') {
        $("#span1").prop("hidden", true);
      } else if (parseInt(bayar) >= parseInt(total)) {
        var kembali = uang - total;
        $("#span1").html('');
        $("#kembali1").html(to_rupiah(kembali));
        $("#tombol1").prop("disabled", false);
      } else {
        $("#span1").html('Jumlah Uang Tidak Cukup');
        $("#kembali1").html(to_rupiah(0));
        $("#tombol1").prop("disabled", true);
      }

    });
  });
</script>