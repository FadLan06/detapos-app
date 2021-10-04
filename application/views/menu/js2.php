<script type="text/javascript">
	$(document).ready(function() {
        $('#ubh_menu').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Menu/detail_menu') ?>',
                data: 'id=' + kd,
                success: function(data) {
                    $('.ubh_menu').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });

    $(document).ready(function() {
        $('#ubh_sub').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Menu/detail_sub') ?>',
                data: 'id=' + kd,
                success: function(data) {
                    $('.ubh_sub').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>