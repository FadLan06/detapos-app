<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Xendit\Xendit;

require 'vendor/autoload.php';

class Xen extends CI_Controller
{
    private $api_key = 'xnd_development_lrnjGNHx7UGDNWaXoeThDoGPqeQeDj9ueGjvXKsMvkbMvWumx4sbBWsyf9wuP43';
    private $api_key1 = 'xnd_development_CDtabmPc1GMBev5QUQCttBuQhI7jnukt1fSVmytyRC2r1losKqEZVi8jMfzuDlWv';

    public function index()
    {
        $this->load->view('xendit');
    }

    public function cek()
    {
        Xendit::setApiKey($this->api_key);

        $external_id = 'ovo-payment';
        $ewallet_type = 'OVO';
        $getPayments = \Xendit\EWallets::getPaymentStatus($external_id, $ewallet_type);
        var_dump($getPayments);
    }

    public function kirim1()
    {
        Xendit::setApiKey($this->api_key1);

        $ovoParams = [
            'external_id' => $this->input->post('external_id'),
            'amount' => $this->input->post('amount'),
            'phone' => $this->input->post('phone'),
            'ewallet_type' => $this->input->post('ewallet_type')
        ];

        $createOvo = \Xendit\EWallets::create($ovoParams);
        var_dump($createOvo);
    }

    public function kirim()
    {
        Xendit::setApiKey($this->api_key1);

        $params = [
            'external_id' => $this->input->post('external_id'),
            'bank_code' => $this->input->post('bank_code'),
            'name' => $this->input->post('name')
        ];

        $create = \Xendit\VirtualAccounts::create($params);
        var_dump($create);
    }

    public function get()
    {
        Xendit::setApiKey($this->api_key);

        $id = '600a74310d5fc64057876849';
        $getVA = \Xendit\VirtualAccounts::retrieve($id);
        echo '<pre>';
        print_r($getVA);
        echo '</pre>';
    }
}
