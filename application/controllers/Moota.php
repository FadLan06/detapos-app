<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Moota extends CI_Controller
{

    // private $api_key = 'Wioudplby2rFH1GBz12PRX2Os1DGhHVryWGCPNw760GKjq53fR';

    public function index()
    {
        $curl = curl_init();
        $moota = $this->db->get_where('tb_moota', ['token' => $this->session->userdata('token')])->row();
        if ($moota->is_active == 1) {
            $key = $moota->apikey;
        } else {
            $key = 'xxxxxxxxxxxxxxxxxxxxxxxxxx';
        }

        // curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/profile');
        // curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/balance');
        // curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank');
        // curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank/KXajeKvQkGo');
        // curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank/KXajeKvQkGo/mutation/');
        // curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank/KXajeKvQkGo/mutation/search/100000');
        curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank/KXajeKvQkGo/mutation/recent');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Authorization: Bearer $key"
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
            $array = json_decode($response, true);
            // $data_pro = $array[];
            // echo '<option value=""><-- Pilih Provinsi --></option>';
            // foreach ($array as $key => $value) {
            //     echo "<option value='' id_provinsi=''>" . $value['amount'] . "</option>";
            // }
            echo '<pre>';
            print_r($array['amount']);
            echo '</pre>';
        }
    }

    public function bank1()
    {
        $moota = $this->db->get_where('tb_moota', ['token' => $this->session->userdata('token')]);
        $row = $moota->row();
        if (!empty($row)) {
            if ($row->is_active == 1) {
                $key = $row->apikey;
            } else {
                $key = '';
            }
            $curl = curl_init();
            // $api_key = $moota->apikey;
            curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                "Accept: application/json",
                "Authorization: Bearer $key"
            ]);

            $response = curl_exec($curl);

            // echo $response;
            $array = json_decode($response, true);
            if (!empty($array['data'])) {
                $data_pro = $array['data'];
                foreach ($data_pro as $bank) {
                    // echo $bank['atas_nama'] . '<br>' . $bank['account_number'];
                    echo '<div class="col-md-4 mb-3">
                    <div class="card mx-auto">
                        <img src="' . base_url('assets/img/') . 'bank-' . $bank['bank_type'] . '.png" class="card-img-top mx-auto mt-3" alt="...">
                        <div class="card-body">
                            <table class="table" width="100%">
                                <tr align="center">
                                    <td>No. Rekening : <b>' . $bank['account_number'] . '</b></td>
                                </tr>
                                <tr align="center">
                                    <td>a.n : <b>' . $bank['atas_nama'] . '</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>';
                }
            } else {
                echo '';
            }
        } else {
            echo 'Silahkan melakukan pendaftaran Api Key Moota Anda!';
        }
    }

    public function bank()
    {
        $moota = $this->db->get_where('tb_moota', ['token' => $this->session->userdata('token')]);
        $row = $moota->row();
        if (!empty($row)) {
            if ($row->is_active == 1) {
                $key = $row->apikey;
            } else {
                $key = '';
            }
            $curl = curl_init();
            // $api_key = $moota->apikey;
            curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                "Accept: application/json",
                "Authorization: Bearer $key"
            ]);

            $response = curl_exec($curl);

            // echo $response;
            $array = json_decode($response, true);
            if (!empty($array['data'])) {
                $data_pro = $array['data'];
                echo '<div class="row">';
                foreach ($data_pro as $bank) {
                    echo '<div class="col-md-4 mb-3">
                        <div class="card mx-auto">
                            <img src="' . base_url('assets/img/') . 'bank-' . $bank['bank_type'] . '.png" class="card-img-top mx-auto mt-3">
                            <div class="card-body">
                                <table class="table" width="100%">
                                    <tr align="center">
                                        <td>No. Rekening : <b>' . $bank['account_number'] . '</b></td>
                                    </tr>
                                    <tr align="center">
                                        <td>a.n : <b>' . $bank['atas_nama'] . '</b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>';
                }
                echo '</div>';
            } else {
                echo '';
            }
        } else {
            echo 'Silahkan melakukan pendaftaran Api Key Moota Anda!';
        }
    }

    public function webhok()
    {
        $moota = $this->db->get_where('tb_moota', ['token' => $this->session->userdata('token')]);
        $row = $moota->row();
        if (!empty($row)) {
            if ($row->is_active == 1) {
                $key = $row->apikey;
            } else {
                $key = '';
            }
            $curl = curl_init();
            $id = $this->input->get('id');

            curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank/' . $id . '/mutation/recent');
            // curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank/' . $id . '/mutation/search/100000');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                "Accept: application/json",
                "Authorization: Bearer $key"
            ]);

            $response = curl_exec($curl);

            $array = json_decode($response, true);
            // print_r($array[0]['amount']);

            $ch = $this->db->get_where('tb_checkout', ['token' => $this->session->userdata('token')])->result();
            foreach ($ch as $vh) {
                foreach ($array as $key => $value) {
                    // print_r($vh->gran_total);
                    if ($vh->gran_total == $value['amount']) {
                        if ($vh->status_bayar == 0) {
                            $this->db->set('status_bayar', 1);
                            $this->db->where('gran_total', $value['amount']);
                            $this->db->where('token', $this->session->userdata('token'));
                            $this->db->update('tb_checkout');
                            print_r('berhasil');
                        }
                        // echo 'berhasil';
                    }
                }
            }

            $shop = $this->db->get_where('tb_shop_detail', ['token' => $this->session->userdata('token')])->result();
            foreach ($shop as $sh) {
                foreach ($array as $key => $value) {
                    if ($sh->total_bayar == $value['amount']) {
                        $nom = $this->db->get_where('tb_shop_detail', ['total_bayar' => $value['amount'], 'token' => $this->session->userdata('token')])->row();
                        if ($sh->status_bayar == 0) {
                            $this->db->set('status_bayar', 1);
                            $this->db->where('total_bayar', $value['amount']);
                            $this->db->where('token', $this->session->userdata('token'));
                            $this->db->update('tb_shop_detail');

                            $this->db->set('status_bayar', '1');
                            $this->db->where('order_id', $nom->order_id);
                            $this->db->update('tb_shop');

                            // KURANG STOK
                            $token = $this->session->userdata('token');
                            $id = $nom->order_id;
                            $sql = $this->db->query("SELECT a.*, b.nama_barang, b.satuan  FROM tb_shop_detail a LEFT JOIN tb_barang b ON a.id_barang = b.id WHERE a.order_id = '$id' AND a.token='$token' AND a.status_bayar='1'")->result_array();

                            foreach ($sql as $row) {
                                $this->db->query("UPDATE tb_barang SET jml_stok = jml_stok - '$row[qty]' WHERE id = '$row[id_barang]' AND token = '$row[token]'");
                            }
                            print_r('berhasil');
                        }
                    }
                }
            }
        }
    }
}
