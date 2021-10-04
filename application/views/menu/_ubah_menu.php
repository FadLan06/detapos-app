<form method="POST" action="<?= base_url('Menu/Aksi') ?>">
	<div class="form-group">
		<label for="menu">Nama Menu</label>
		<input type="hidden" name="id" class="form-control" id="id" autocomplete="off" value="<?= $data->id ?>">
		<input type="text" name="menu" class="form-control" id="menu" autocomplete="off" value="<?= $data->menu ?>">
		<?= form_error('menu', '<small class="text-danger pl-3">', '</small>') ?>
	</div>
	<button type="submit" name="ubah_menu" class="btn float-right" style="background-color: #008FD4; border-color: #008FD4; color: white">Ubah</button>
</form>