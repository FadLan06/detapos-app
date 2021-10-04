<?php
$tgl = date('Y-m-d H-i-s');
header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=$judul $tgl.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>

<center>
    <h4 style="padding-bottom:0;margin-bottom:0; font-family: sans-serif; letter-spacing: 0px;">
        DATA BARANG
    </h4>
</center>
<br>
<table border="1" cellspacing="0" width="70%">
    <thead style="text-align:center; ">
        <tr>
            <th width="5%">#</th>
            <th width="15%">Kode</th>
            <th width="30%">Nama Barang</th>
            <th>Harga Modal</th>
            <th>Harga Jual</th>
            <th width="10%">Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $token = $this->session->userdata('token');
        $this->db->select('*, tb_barang.kode_barang as kode');
        $this->db->from('tb_barang');
        $this->db->where('tb_barang.token', $token);
        $this->db->group_by('tb_barang.kode_barang');
        // $this->db->limit(2000);
        $query = $this->db->get()->result();

        $no = 1;
        foreach ($query as $data) {
            $kode = $data->kode;
            $token = $this->session->userdata('token');

            $query = $this->db->query("SELECT * FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'");
            if ($query->num_rows() <= 1) {
                $harga = number_format($query->row()->harga_jual);
            } else {
                $min = $this->db->query("SELECT min(harga_jual) as harga FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'")->row();
                $max = $this->db->query("SELECT max(harga_jual) as harga FROM tb_barang_harga WHERE token='$token' AND id_barang='$kode'")->row();
                $harga = number_format($min->harga) . ' s/d ' . number_format($max->harga);
            }
            echo '
                <tr>
                    <td align="center">' . $no++ . '</td>
                    <td>' . $data->kode . '</td>
                    <td>' . $data->nama_barang . '</td>
                    <td align="center">' . number_format($data->harga_beli) . '</td>
                    <td align="center">' . $harga . '</td>
                    <td align="center">' . number_format($data->jml_stok) . '</td>
                </tr>
            ';
        }
        ?>
    </tbody>
</table>