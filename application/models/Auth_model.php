<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    public function cek_user($username)
    {
        $this->db->where("username = '$username'");
        $query = $this->db->get('user');
        return $query->row_array();
    }

    public function cek_user_pel($email)
    {
        $this->db->where("email = '$email'");
        $query = $this->db->get('tb_pel_shop');
        return $query->row_array();
    }
}
