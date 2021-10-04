<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Woo_wa extends CI_Controller
{
    private $key = '57dab02fdb23cc99303b258ff5a42bf8953a267323fe69c5';

    public function send()
    {

        $url = 'http://116.203.191.58/api/send_message';
        $data = array(
            "phone_no" => '082189062042',
            "key"        => $this->key,
            "message"    => 'DEMO AKUN WOOWA. tes woowa api v3.0 mohon di abaikan',
            "skip_link"    => True // This optional for skip snapshot of link in message
        );
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        echo $res = curl_exec($ch);
        curl_close($ch);
    }
}
