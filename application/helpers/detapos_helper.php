<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('Login');
    } else {
        $role_id = $ci->session->userdata('token');
        $role = $ci->session->userdata('role_id');
        $user_id = $ci->session->userdata('id');
        $menu = $ci->uri->segment(1);

        $query = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $query['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id,
            'role' => $role,
            'user_id' => $user_id,
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('Login/Blocked');
        }
    }
}

function is_logged_in_pel()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {

        $ci->session->set_flashdata('message', '<div class="alert alert-danger text-dark alert-dismissible fade show" role="alert">Anda Belum Login!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Shop/Login');
    }
}

function check($role_id, $menu_id, $role, $user_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $ci->db->where('role', $role);
    $ci->db->where('user_id', $user_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked";
    }
}

function tambah($role_id, $menu_id, $role, $user_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $ci->db->where('role', $role);
    $ci->db->where('user_id', $user_id);
    $ci->db->where('tambah', 1);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked";
    }
}

function ubah($role_id, $menu_id, $role, $user_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $ci->db->where('role', $role);
    $ci->db->where('user_id', $user_id);
    $ci->db->where('ubah', 1);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked";
    }
}

function hapus($role_id, $menu_id, $role, $user_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $ci->db->where('role', $role);
    $ci->db->where('user_id', $user_id);
    $ci->db->where('hapus', 1);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked";
    }
}

function check1($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function chek($id)
{
    $CI = get_instance();
    $result = $CI->db->get_where('user_sub_menu', ['id' => $id])->row_array();
    return $result['title'];
}

function aktif($token)
{
    $ci = get_instance();

    $ci->db->where('token', $token);
    $ci->db->where('aktif', 1);
    $result = $ci->db->get('tb_rekening');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function aktif1($token)
{
    $ci = get_instance();

    $ci->db->where('token', $token);
    $ci->db->where('is_active', 1);
    $result = $ci->db->get('tb_moota');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
