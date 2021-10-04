<?php
header('Access-Control-Allow-Origin: *');

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class User extends RestController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function index_get()
    {
        $token = $this->get('token');
        $id = $this->get('id');
        if ($token) {
            // $user = $this->db->get_where('user', ['token' => $token, 'id' => $id])->result_array();
            $user = $this->db->query("SELECT nama, username, email FROM user WHERE token='$token' AND id='$id'")->result_array();
        }

        if ($user) {
            $this->response([
                'status' => TRUE,
                'data' => $user
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }

    public function index_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');

        $user = $this->Auth_model->cek_user($username);

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'token' => $user['token'],
                        'username' => $user['username'],
                        'role_id' => $user['role_id'],
                        'id' => $user['id']
                    ];
                    $this->response([
                        'status' => TRUE,
                        'data' => $data
                    ], 200);
                } else {
                    $this->response(array('status' => 'fail', 502));
                }
            } else {
                $this->response(array('status' => 'fail', 502));
            }
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    public function edit_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        $nama = $this->post('nama');
        $email = $this->post('email');
        $id = $this->post('id');

        $data = [
            'nama' => htmlspecialchars($nama),
            'username' => htmlspecialchars($username),
            'email' => htmlspecialchars($email),
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        $this->db->where('id', $id);
        $user = $this->db->update('user', $data);

        if ($user) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
