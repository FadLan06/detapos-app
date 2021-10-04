<nav aria-label="breadcrumb" class="" style="margin-top: 90px">
    <ol class="breadcrumb bg-danger text-white" style="font-size: 20px">
        <div class="pela">Home >> Data Master >> Kategori Barang >> <b>Ubah Kategori Barang</b></div>
    </ol>
</nav>

<div class="card mt-4 bg-default  mb-5 border-danger">
    <div class="card-body">
        <!-- <a href="" class="btn btn-danger" data-toggle="modal" data-target="#ModalaAdd"><i class="fas fa-plus-circle"></i> Tambah</a> -->
        <div class="row">
            <div class="col-md-8 mx-auto">
                <form method="post" action="<?= base_url('Ket_Barang/Aksi') ?>">
                    <div class="form-group">
                        <label for="inputEmail4">Kode Kategori</label>
                        <input type="hidden" name="id_kat" class="form-control" autocomplete="off" autofocus value="<?= $data->id_kategori ?>">
                        <input type="text" name="kd_kat" class="form-control border-danger" autocomplete="off" autofocus value="<?= $data->kode_kategori ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control border-danger" autocomplete="off" value="<?= $data->nama_kategori ?>">
                    </div>
                    <button type="submit" name="ubah_ket" class="btn btn-danger float-right">Simpan Perubahan</button>
                    <a class="btn btn-warning float-right mr-3" href="<?= base_url('Barang/Kategori') ?>">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>