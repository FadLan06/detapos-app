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
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatablee" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead style="text-align:center; ">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Kode</th>
                                        <th width="30%">Nama Barang</th>
                                        <th width="15%">Cover Produk</th>
                                        <th>Produk</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="list_barang">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script>
    window.addEventListener('load', semua);

    function semua() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("list_barang").innerHTML = this.responseText;
                $('#datatablee').DataTable();
            }
        };
        xhttp.open("GET", "<?= base_url('Produk/data_barang') ?>", true);
        xhttp.send();
    }
</script>

<?php foreach ($barang as $data) : ?>
    <div class="modal fade" id="tmbhProduk<?= $data['id'] ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-deta text-white">
                    <h5 class="modal-title" id="exampleModalCenterTitle"><b>Tambah Data Gambar Produk</b></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url('Produk/Aksi') ?>" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">NAMA GAMBAR PRODUK</label>
                                <input type="hidden" class="form-control border-deta" name="id_barang" value="<?= $data['id'] ?>" autocomplete="off" required>
                                <input type="text" class="form-control border-deta" name="nama_produk" autocomplete="off" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputCity">GAMBAR PRODUK</label>
                                <input type="file" class="form-control border-deta" onchange="previeww<?= $data['id'] ?>(this);" name="gambar" autocomplete="off" required>
                                <small>Size = 600 x 600 pixel <br> Filesize = 1 MB (1024 KB)</small>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputCity">PREVIEW GAMBAR PRODUK</label><br>
                                <img src="<?= base_url('assets/images/no-image.png') ?>" width="150px" alt="" id="preview_produk<?= $data['id'] ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-deta" name="simpan"><i class="fas fa-plus-circle"></i> Tambah</button>
                        <button type="button" class="btn btn-warning float-right" data-dismiss="modal">Keluar</button>
                    </form>

                    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
                    <script>
                        window.previeww<?= $data['id'] ?> = function(input) {
                            if (input.files && input.files[0]) {
                                $(input.files).each(function() {
                                    var reader = new FileReader();
                                    reader.readAsDataURL(this);
                                    reader.onload = function(e) {
                                        $("#preview_produk<?= $data['id'] ?>").attr('src', e.target.result);
                                    }
                                });
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($barang as $data) : ?>
    <div class="modal fade" id="hapusProduk<?= $data['id'] ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-deta text-white">
                    <h5 class="modal-title" id="exampleModalCenterTitle"><b>Hapus Data Gambar Produk</b></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr align="center">
                                <th>Nama Produk</th>
                                <th>Gambar Produk</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list<?= $data['id'] ?>">
                        </tbody>
                    </table>

                    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
                    <script>
                        tampil();

                        function tampil() {
                            $(document).on('click', '.hapus_gam', function() {
                                var id = $(this).attr("id");
                                $.ajax({
                                    method: 'POST',
                                    url: '<?php echo base_url() ?>Produk/data_produk',
                                    async: true,
                                    data: {
                                        id: id
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        var html = '';
                                        var i;
                                        for (i = 0; i < data.length; i++) {
                                            // console.log(data[i].id_barang);
                                            html += '<tr>' +
                                                '<td width="30%">' + data[i].nama_produk + '</td>' +
                                                '<td><img src="<?= base_url('assets/upload/barang/') ?>' + data[i].produk + '" width="90px"></td>' +
                                                '<td style="text-align:center; width:20%">' +
                                                '<a href="" class="badge badge-danger hapuss" id="' + data[i].id_produk + '">Hapus</a>' +
                                                '</td>' +
                                                '</tr>';

                                            $('#list' + data[i].id_barang).html(html);
                                        }
                                    }

                                });
                            });
                        };
                        $(document).on('click', '.hapuss', function() {
                            var id = $(this).attr("id");
                            $.ajax({
                                url: "<?php echo base_url(); ?>Produk/delete",
                                method: "POST",
                                data: {
                                    id: id
                                },
                                success: function(data) {
                                    tampil();
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>