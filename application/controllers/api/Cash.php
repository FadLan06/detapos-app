<?php
header('Access-Control-Allow-Origin: *');

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Cash extends RestController
{

    function __construct()
    {
        parent::__construct();

        // $this->methods['index_get']['limit'] = 500;
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $cod = $this->db->get('tb_cod')->result_array();
        } else {
            $cod = $this->db->get_where('tb_cod', ['id_cod' => $id])->result_array();
        }

        if ($cod) {
            $this->response($cod, 200);
        } else {
            $this->response([
                'status' => FALSE,
                'massage' => 'id not found'
            ], 404);
        }
    }
}
