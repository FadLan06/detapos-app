<script type="text/javascript">
    $(document).ready(function() {
        $('#user_Ubh').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('User/detail') ?>',
                data: 'id=' + kd,
                success: function(data) {
                    $('.userUbh').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>