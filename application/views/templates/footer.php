</div> <!-- content -->

<footer class="footer">
  © <?= date('Y') ?> <a href="https://gammaadvertisa.co.id"><span class="text-danger">Gamma Advertisa</span></a>
</footer>

</div>
<!-- End Right content here -->

</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/js/popper.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/modernizr.min.js"></script>
<script src="<?= base_url() ?>assets/js/detect.js"></script>
<script src="<?= base_url() ?>assets/js/fastclick.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.blockUI.js"></script>
<script src="<?= base_url() ?>assets/js/waves.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?= base_url('assets/') ?>jquery.number.js"></script>
<script src="<?= base_url('assets/') ?>cleave.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>

<!-- Required datatable js -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- App js -->
<script src="<?= base_url() ?>assets/js/app.js"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: '100%',
      height: '100px'
    });
  });

  $(document).ready(function() {
    $('.selectIcon').select2();

    $('#icon').change(function() {
      var icon = $(this).val();
      // console.log(icon);
      document.getElementById("iconView").innerHTML = "<i class='" + icon + "' style='font-size:35px; margin-left:20px'></i>";
    });
  });
</script>
<?php

$token1 = $this->session->userdata('token');
$role1 = $this->session->userdata('role_id');
$user_id1 = $this->session->userdata('id');
$akses4 = $this->db->get_where('user_access_menu', ['role_id' => $token1, 'role' => $role1, 'user_id' => $user_id1, 'menu_id' => 29])->row_array();
?>
<?php if (isset($akses4['menu_id'])) : ?>
  <script>
    setInterval(function() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("jum").innerHTML = this.responseText;
          document.getElementById("jumm").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "<?= base_url('Pesanan/jumlah') ?>", true);
      xhttp.send();
    }, 3000);
  </script>
<?php endif; ?>

<script>
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#datatable').DataTable();
    $('#datatable-menu').DataTable({
      scrollY: '40vh',
      scrollX: 'true',
      scrollCollapse: true,
      scrollXInner: '100%',
      paging: false,
      searching: false
    });
  });

  function zoom() {
    document.body.style.zoom = "90%"
  }
</script>

<?php $this->load->view('akuntansi/ak'); ?>
<?php $this->load->view('templates/js1'); ?>
<?php $this->load->view('transaksi/js_diskon'); ?>

<?php $this->load->view('menu/js2'); ?>
<?php $this->load->view('akses/js3'); ?>
<?php $this->load->view('setting/js4'); ?>

</body>

</html>