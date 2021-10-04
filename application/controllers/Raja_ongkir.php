<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Raja_ongkir extends CI_Controller
{
	private $api_key = '739f0fb277b8be3c8eb812b552467ea0';

	public function provinsi()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: $this->api_key"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			// echo $response;
			$array = json_decode($response, true);
			// echo '<pre>';
			// print_r($array['rajaongkir']['results']);
			// echo '</pre>';
			$data_pro = $array['rajaongkir']['results'];
			echo '<option value=""><-- Pilih Provinsi --></option>';
			foreach ($data_pro as $key => $value) {
				echo "<option value='" . $value['province_id'] . "' id_provinsi='" . $value['province_id'] . "'>" . $value['province'] . "</option>";
			}
		}
	}

	public function kota()
	{
		$id_provinsi = $this->input->post('id_provinsi');
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=" . $id_provinsi,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: $this->api_key"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$array = json_decode($response, true);
			$data_kot = $array['rajaongkir']['results'];
			echo '<option value=""><-- Pilih Kota --></option>';
			foreach ($data_kot as $key => $value) {
				echo "<option value='" . $value['city_id'] . "' id_kota='" . $value['city_id'] . "'>" . $value['city_name'] . "</option>";
			}
		}
	}

	public function kecamatan()
	{
		$id_kota = $this->input->post('id_kota');
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=" . $id_kota,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: $this->api_key"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$array = json_decode($response, true);
			$data_kec = $array['rajaongkir']['results'];
			echo '<option value=""><-- Pilih Kecamatan --></option>';
			foreach ($data_kec as $key => $value) {
				echo "<option value='" . $value['subdistrict_name'] . "' id_kec='" . $value['subdistrict_id'] . "'>" . $value['subdistrict_name'] . "</option>";
			}
		}
	}

	public function ekspedisi()
	{
		echo '<option value=""><-- Pilih Expedisi --></option>';
		echo '<option value="pos">POS Indonesia (POS)</option>';
		echo '<option value="sicepat">SiCepat Express (SICEPAT)</option>';
		echo '<option value="jne">Jalur Nugraha Ekakurir (JNE)</option>';
		echo '<option value="tiki">Citra Van Titipan Kilat (TIKI)</option>';
		echo '<option value="jnt">J&T Express (J&T)</option>';
	}

	public function paket()
	{
		$ekspedisi = $this->input->post('ekspedisi');
		$id_kota = $this->input->post('id_kota');
		$berat = $this->input->post('berat');
		$kota_asal = $this->input->post('kota_asal');

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
			// CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			// CURLOPT_POSTFIELDS => "origin=" . $kota_asal . "&destination=" . $id_kota . "&weight=" . $berat . "&courier=" . $ekspedisi,
			// CURLOPT_POSTFIELDS => "origin=" . $kota_asal . "&originType=city&destination=" . $id_kota . "&destinationType=subdistrict&weight=" . $berat . "&courier=" . $ekspedisi . "",
			CURLOPT_POSTFIELDS => "origin=" . $kota_asal . "&originType=city&destination=" . $id_kota . "&destinationType=city&weight=" . $berat . "&courier=" . $ekspedisi . "",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: $this->api_key"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$array = json_decode($response, true);
			$data_pak = $array['rajaongkir']['results'][0]['costs'];
			echo '<option value=""><-- Pilih Paket --></option>';
			foreach ($data_pak as $key => $value) {
				echo "<option value='" . $value['service'] . "' ongkir='" . $value['cost'][0]['value'] . "' estimasi='" . $value['cost'][0]['etd'] . " Hari'>";
				echo $value['service'] . " | Rp. " . $value['cost'][0]['value'] . " | " . $value['cost'][0]['etd'] . " Hari";
				echo "</option>";
			}
		}
	}

	public function lacak()
	{
		$waybill = $this->input->post('waybill');
		$courier = $this->input->post('courier');

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "waybill=" . $waybill . "&courier=" . $courier . "",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: $this->api_key"
			),
		));
		// JP1584718788
		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			// echo $response;

			$array = json_decode($response, true);
			$data = $array['rajaongkir']['result']['manifest'];
			foreach ($data as $lacak) {
				echo '
				<div class="vertical-timeline-item vertical-timeline-element">
					<div> <span class="vertical-timeline-element-icon bounce-in"> <i class="badge badge-dot badge-dot-xl badge-deta"> </i> </span>
						<div class="vertical-timeline-element-content bounce-in">
							<p>' . $lacak['city_name'] . ' <b class="text-danger">' . $lacak['manifest_date'] . '</b></p>
							<p>' . $lacak['manifest_description'] . '</p> <span class="vertical-timeline-element-date">' . $lacak['manifest_time'] . '</span>
						</div>
					</div>
				</div>
				';
			}
		}
	}
}
