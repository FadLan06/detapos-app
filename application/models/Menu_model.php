<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
	public function getSubMenu()
	{
		$query = "SELECT `user_sub_menu`.*, `user_menu`.`menu` FROM `user_sub_menu` JOIN `user_menu` ON `user_sub_menu`.`id_menu` = `user_menu`.`id` ";
		return $this->db->query($query)->result_array();
	}

	function user_status($st)
	{
		if ($st == "true") {
			$this->db
				->set('is_active', "1")
				->where('token', $_POST['id'])
				->update('user');
		} else {
			$this->db
				->set('is_active', "0")
				->where('token', $_POST['id'])
				->update('user');
		}
	}
}
