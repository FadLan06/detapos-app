<script type="text/javascript">
    var room = 1;

    function tambahbaris() {
        room++;
        var objTo = document.getElementById('tambahbaris')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "removeclass" + room);
        var rdiv = 'removeclass' + room;
        divtest.innerHTML =
            `
        <div class="row">
            <div class="form-group col-md-3">
                <select name="id_akunD[]" class="form-control border-deta" required>
                    <option value="">Pilih Akun</option>
                    <?php foreach ($akunn as $ak) : ?>
                        <option value="<?= $ak->id_akun ?>"><?= $ak->nama_akun ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- <div class="form-group col-md-3">
                <select name="id_akunK[]" class="form-control border-deta" required>
                    <option value="">Pilih Akun</option>
                    <?php foreach ($akunn as $ak) : ?>
                        <option value="<?= $ak->id_akun ?>"><?= $ak->nama_akun ?></option>
                    <?php endforeach; ?>
                </select>
            </div> -->
            <div class="form-group col-md-3">
                <select name="tipe[]" id="tipe" class="form-control border-deta" required>
                    <option>Pilih Posisi</option>
                    <option value="D">Debet</option>
                    <option value="K">Kredit</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-deta bg-deta text-white" id="basic-addon1"><b>Rp</b></span>
                    </div>
                    <input type="text" class="form-control border-deta nominal` + room + `" id="nominal" name="nominal[]" placeholder="Nominal" autocomplete="off" required>
                </div>
            </div>
            <div class="form-group col-sm-2">
                <button class="btn btn-danger" type="button" onclick="remove_tambahbaris(` + room + `);"> <i class="fa fa-minus"></i> </button>
            </div>
        </div>
        `;
        objTo.appendChild(divtest);
        var cleave = new Cleave('.nominal' + room, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    }

    function remove_tambahbaris(rid) {
        $('.removeclass' + rid).remove();
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#UbahAkun').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Akun/dt_akun') ?>',
                data: 'id_akun=' + kd,
                success: function(data) {
                    $('._akun').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
    $(document).ready(function() {
        $('#ubahJurnal').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Jurnal_umum/dt_jurnal') ?>',
                data: 'no_jurnal=' + kd,
                success: function(data) {
                    $('._jurnal').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>

<script>
    function detail_akun(idakun) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 1 || xhttp.readyState == 2 || xhttp.readyState == 3) {
                document.getElementById("detail_akun").innerHTML = "Memuat data...";
            }

            if (xhttp.readyState == 4) {
                document.getElementById("detail_akun").innerHTML = xhttp.responseText;
            }

        };
        xhttp.open("GET", "<?= base_url('buku_besar/detail_akun') ?>?idakun=" + idakun, true);
        xhttp.send();
    }
</script>