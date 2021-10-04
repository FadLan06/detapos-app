<form method="POST" action="<?= base_url('Menu/Aksi') ?>">
    <div class="form-group">
        <label for="">Nama Menu</label>
        <input type="hidden" class="form-control" id="id" name="id" value="<?= $data->id ?>" autocomplete="off">
        <input type="text" class="form-control" id="title" name="title" value="<?= $data->title ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="">User Menu</label>
        <select name="menu_id" id="menu_id" class="form-control" autocomplete="off">
            <option value="">Pilih Menu</option>
            <?php foreach ($menu as $m) : ?>
                <option value="<?= $m['id'] ?>" <?= $data->id_menu == $m['id'] ? 'selected' : '' ?>><?= $m['menu'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Link Menu</label>
        <input type="text" class="form-control" id="url" name="url" value="<?= $data->url ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="">Icon Menu</label>
        <input type="text" class="form-control" id="icon" name="icon" value="<?= $data->icon ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="">Sub Menu</label>
        <select name="sub_menu" id="sub_menu" class="form-control" autocomplete="off">
            <option value="0">Menu Utama</option>
            <?php foreach ($sub_menu as $m) : ?>
                <option value="<?= $m['id'] ?>" <?= $data->sub_menu == $m['id'] ? 'selected' : '' ?>><?= $m['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Is Active</label>
        <select name="is_active" id="is_active" class="form-control" autocomplete="off">
            <option value="0" <?= $data->is_active == '0' ? 'selected' : '' ?>>Not Aktiv</option>
            <option value="1" <?= $data->is_active == '1' ? 'selected' : '' ?>>Aktiv</option>
        </select>
    </div>
    <button type="submit" name="ubah_sub" class="btn float-right" style="background-color: #008FD4; border-color: #008FD4; color: white">Ubah</button>
</form>