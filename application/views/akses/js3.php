<script type="text/javascript">
    $('.akses').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        const roleI = $(this).data('rol');
        const userId = $(this).data('user');

        $.ajax({
            url: "<?= base_url('Akses/Change'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId,
                roleI: roleI,
                userId: userId,
            },
            success: function() {
                document.location.href = "<?= base_url('Akses/Change_Member/'); ?>" + roleId;
            }
        });
    });

    $('.tambah').on('click', function() {
        const menuId1 = $(this).data('menu1');
        const roleId1 = $(this).data('role1');
        const roleI1 = $(this).data('rol1');
        const userId1 = $(this).data('user1');

        $.ajax({
            url: "<?= base_url('Akses/Change1'); ?>",
            type: 'post',
            data: {
                menuId1: menuId1,
                roleId1: roleId1,
                roleI1: roleI1,
                userId1: userId1,
            },
            success: function() {
                document.location.href = "<?= base_url('Akses/Change_Member/'); ?>" + roleId1;
            }
        });
    });

    $('.ubah').on('click', function() {
        const menuId2 = $(this).data('menu2');
        const roleId2 = $(this).data('role2');
        const roleI2 = $(this).data('rol2');
        const userId2 = $(this).data('user2');

        $.ajax({
            url: "<?= base_url('Akses/Change2'); ?>",
            type: 'post',
            data: {
                menuId2: menuId2,
                roleId2: roleId2,
                roleI2: roleI2,
                userId2: userId2,
            },
            success: function() {
                document.location.href = "<?= base_url('Akses/Change_Member/'); ?>" + roleId2;
            }
        });
    });

    $('.hapus').on('click', function() {
        const menuId3 = $(this).data('menu3');
        const roleId3 = $(this).data('role3');
        const roleI3 = $(this).data('rol3');
        const userId3 = $(this).data('user3');

        $.ajax({
            url: "<?= base_url('Akses/Change3'); ?>",
            type: 'post',
            data: {
                menuId3: menuId3,
                roleId3: roleId3,
                roleI3: roleI3,
                userId3: userId3,
            },
            success: function() {
                document.location.href = "<?= base_url('Akses/Change_Member/'); ?>" + roleId3;
            }
        });
    });

    $(document).on("click", ".status", function() {
        var ida = $(this).parent().attr('id');
        if ($(this).prop("checked") == true) {
            $.ajax({
                url: '<?= base_url() ?>akses/status/true',
                type: 'post',
                data: 'id=' + ida,
                success: function() {
                    location.reload();
                }
            });
        } else if ($(this).prop("checked") == false) {
            $.ajax({
                url: '<?= base_url() ?>akses/status/false',
                type: 'post',
                data: 'id=' + ida,
                success: function() {
                    location.reload();
                }
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#viewakses').on('show.bs.modal', function(e) {
            var kd = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type: 'post',
                url: '<?= base_url('Akses/view') ?>',
                data: 'id=' + kd,
                success: function(data) {
                    $('.view_akses').html(data); //menampilkan data ke dalam modal
                }
            });
        });
    });
</script>