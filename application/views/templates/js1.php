<script type="text/javascript">
    $(function() {
        $(".modall").number(true);
        $(".juall").number(true);
        $(".profitt").number(true);

        $("#modal").keyup(function() {
            var muodal = $("#modal").val();
            if (muodal > 0) {
                $("#jual").prop("disabled", false);
                $("#persen").prop("disabled", false);
                $("#profit").prop("disabled", false);

                var profit = $("#profit").val();
                var jual = parseInt(muodal) + parseInt(profit);
                var persen = (parseInt(profit) / parseInt(muodal)) * 100;

                if (jual > 0) {
                    $("#jual").val(parseInt(jual));
                    $("#persen").val(persen);
                }
            } else {
                $("#jual").prop("disabled", true);
                $("#persen").prop("disabled", true);
                $("#profit").prop("disabled", true);
            }
        });

        $("#jual").keyup(function() {
            var modal = $("#modal").val();
            var jual = $("#jual").val();

            var profit = jual - modal;
            var persen = (profit / modal) * 100;

            if (jual > 0) {
                $("#profit").val(profit);
                $("#persen").val(persen);
            } else {
                $("#profit").val("");
                $("#persen").val("");
            }
        });

        $("#persen").keyup(function() {
            var modal = $("#modal").val();
            var persen = $("#persen").val();

            var profit = persen / 100 * modal;
            var jual = parseInt(profit) + parseInt(modal);

            if (persen > 0) {
                $("#jual").val(parseInt(jual));
                $("#profit").val(profit);
            } else {
                $("#jual").val("");
                $("#profit").val("");
            }
        });

        $("#profit").keyup(function() {
            var modal = $("#modal").val();
            var profit = $("#profit").val();

            var jual = parseInt(profit) + parseInt(modal);
            var persen = profit / modal * 100;

            if (profit > 0) {
                $("#jual").val(parseInt(jual));
                $("#persen").val(persen);
            } else {
                $("#jual").val("");
                $("#persen").val("");
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#ubah_supplier').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Supplier/detail') ?>',
                data: 'kd_supplier=' + kd,
                success: function(data) {
                    $('.ubh_sup').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#ModalaAdd').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Barang/detail_ket') ?>',
                data: 'id_kategori=' + kd,
                success: function(data) {
                    $('.ubh_ket').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
    $(document).ready(function() {
        $('#ModalEdit').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Barang/detail_brng') ?>',
                data: 'id=' + kd,
                success: function(data) {
                    $('.ubh_brng').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#ModalPel').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Pelanggan/detail') ?>',
                data: 'kd_pelanggan=' + kd,
                success: function(data) {
                    $('.ubh_pel').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $("#nominal").number(true);
        $("#noominal").number(true);
    });
</script>

<script>
    // Report Barang
    $(document).ready(function() {
        $('#ff-bulan, #ff-tahun, #ff-bulan1, #ff-barang').hide();

        $('#filter').change(function() {
            if ($(this).val() == '2') {
                $('#ff-bulan, #ff-bulan1, #ff-tahun, #ff-barang').show();
                // $('#ff-bulan').hide();
            } else if ($(this).val() == '3') {
                $('#ff-tanggal').hide();
                $('#ff-bulan').hide();
                $('#ff-bulan1').hide();
                $('#ff-barang').hide();
                $('#ff-tahun').show();
            } else if ($(this).val() == '1') {
                $('#ff-bulan1, #ff-tahun, #ff-barang').hide();
                $('#ff-bulan').show();
                $('#ff-tahun').show();
            } else if ($(this).val() == 'semua') {
                $('#ff-bulan, #ff-tahun, #ff-tanggal').hide();
            }

            $('#bulan select, #tahun select').val('');
        })
    })

    $(document).ready(function() {
        $('#f-bulan, #f-tahun, #f-tanggal, #f-range').hide();

        $('#filter').change(function() {
            if ($(this).val() == '2') {
                $('#f-bulan, #f-tahun').show();
                $('#f-tanggal').hide();
                $('#f-range').hide();
            } else if ($(this).val() == '3') {
                $('#f-bulan').hide();
                $('#f-tanggal').hide();
                $('#f-range').hide();
                $('#f-tahun').show();
            } else if ($(this).val() == '1') {
                $('#f-tanggal').show();
                $('#f-bulan').hide();
                $('#f-tahun').hide();
                $('#f-range').hide();
            } else if ($(this).val() == 'semua') {
                $('#f-bulan, #f-tahun, #f-tanggal, #f-range').hide();
            } else if ($(this).val() == '4') {
                $('#f-range').show();
                $('#f-bulan, #f-tahun, #f-tanggal').hide();
            }

            $('#bulan select, #tahun select').val('');
        })
    })
</script>


<script>
    $(document).ready(function() {
        $('#bank, #tunai').hide();

        $('#expedisi').change(function() {
            if ($(this).val() == 'B') {
                $('#bank').show();
                $('#tunai').hide();
            } else if ($(this).val() == 'T') {
                $('#bank').hide();
                $('#tunai').show();
            }

            $('#expedisi select').val('');
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#mRetur').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Barang/retur_barang') ?>',
                data: 'id=' + kd,
                success: function(data) {
                    $('._retur').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>

<script>
    $.ajax({
        type: 'GET',
        url: "<?= base_url('Moota/Bank') ?>",
        async: true,
        dataType: 'json',
        success: function(dr) {
            // console.log(dr);
            var bank_id = dr['data'][0]['bank_id'];

            // console.log(bank_id);
            $.ajax({
                type: "GET",
                url: "<?= base_url('Moota/webhok') ?>",
                data: 'id=' + bank_id,
                success: function(de) {
                    if (de == 'berhasil') {
                        toastr.success('Transaksi Mutasi Otomatis Berhasil Masuk ke-Rekening');
                    }
                }
            });
        }
    });
</script>