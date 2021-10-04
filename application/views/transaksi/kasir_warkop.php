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
                    <h4 style="font-size: 20px; margin-bottom: 0; margin-top: 0;"><?= $judul ?></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <?php for ($i = 1; $i <= $setting->jumlah; $i++) { ?>
                <div class="col-md-3 mb-3">
                    <a href="" data-target="#view" data-toggle="modal" data-id="<?= $i ?>">
                        <div class="card">
                            <div class="card-body text-center text-deta">
                                <span style="font-size: 70px;"><b><?= $i ?></b></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>

    </div>
</div>

<div class="modal fade" id="view" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="kasirWarkop"></div>
    </div>
</div>


<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>jquery-ui.js"></script>
<script src="<?= base_url() ?>assets/js/popper.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#view').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Kasir_Warkop/view_warkop') ?>',
                data: 'id=' + id,
                success: function(data) {
                    $('.kasirWarkop').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>