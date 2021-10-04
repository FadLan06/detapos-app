<?php if ($data->row() > null) : ?>
    <?php $no = 1;
    $ts_debet = "0";
    $ts_kredit = "0";
    foreach ($data->result_array() as $d) : ?>
        <?php if ($d['tipe'] == 'K') : ?>
            <?php $total_debet = "0";
            $total_kredit = "0";
            $saldo_debet = "0";
            $saldo_kredit = "0"; ?>
            <?php
            $token = $this->session->userdata('token');
            if ($_POST['filter'] == 'semua') {
                $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
            } elseif ($_POST['filter'] == '1') {
                $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$_POST[tanggal]' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
            } elseif ($_POST['filter'] == '2') {
                $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
            } elseif ($_POST['filter'] == '3') {
                $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
            }
            ?>
            <?php foreach ($neraca->result_array() as $n) : ?>
                <?php
                if ($n['tipe'] == 'D') {
                    $debet = $n['nominal'];
                    $kredit = "0";
                } elseif ($n['tipe'] == 'K') {
                    $kredit = $n['nominal'];
                    $debet = "0";
                }
                $total_debet += $debet;
                $total_kredit += $kredit;

                if ($n['kategori'] == 'HL') {
                    $saldo_debet = $total_debet - $total_kredit;
                    $posisi = "Debet";
                } elseif ($n['kategori'] == 'HT') {
                    $saldo_kredit = $total_kredit - $total_debet;
                    $posisi = "Kredit";
                }
                ?>
            <?php endforeach; ?>
            <tr>
                <td align="center"><?= $no++ ?></td>
                <td align="center"><?= $d['kode_akun'] ?></td>
                <td><?= $d['nama_akun'] ?></td>
                <td width="3%" align="center">Rp. </td>
                <td align="right"><?= number_format($saldo_kredit, 0, ",", ".") ?></td>
            </tr>
            <?php $ts_kredit = abs($saldo_kredit - $ts_kredit); ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" align="Center"><b>Laba Kotor </b></td>
        <td align="center" width="3%">Rp.</td>
        <td align="right"><b><?= number_format($ts_kredit, 0, ",", ".") ?></b></td>
    </tr>
    <?php foreach ($data->result_array() as $d) : ?>
        <?php if ($d['tipe'] == 'D') : ?>
            <?php $total_debet = "0";
            $total_kredit = "0";
            $saldo_debet = "0";
            $saldo_kredit = "0"; ?>
            <?php
            $token = $this->session->userdata('token');
            if ($_POST['filter'] == 'semua') {
                $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun where tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
            } elseif ($_POST['filter'] == '1') {
                $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal_tmp.tgl_jurnal='$_POST[tanggal]' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
            } elseif ($_POST['filter'] == '2') {
                $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND month(tb_jurnal_tmp.tgl_jurnal)='$_POST[bulan]' AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
            } elseif ($_POST['filter'] == '3') {
                $neraca = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND year(tb_jurnal_tmp.tgl_jurnal)='$_POST[tahun]' AND tb_jurnal.id_akun=tb_akun.id_akun AND (tb_akun.token='$token') and tb_akun.nama_akun='$d[nama_akun]'");
            }
            ?>
            <?php foreach ($neraca->result_array() as $n) : ?>
                <?php
                if ($n['tipe'] == 'D') {
                    $debet = $n['nominal'];
                    $kredit = "0";
                } elseif ($n['tipe'] == 'K') {
                    $kredit = $n['nominal'];
                    $debet = "0";
                }
                $total_debet += $debet;
                $total_kredit += $kredit;

                if ($n['kategori'] == 'HL') {
                    $saldo_debet = $total_debet - $total_kredit;
                    $posisi = "Debet";
                } elseif ($n['kategori'] == 'HT') {
                    $saldo_kredit = $total_kredit - $total_debet;
                    $posisi = "Kredit";
                }
                ?>
            <?php endforeach; ?>
            <tr>
                <td align="center"><?= $no++ ?></td>
                <td align="center"><?= $d['kode_akun'] ?></td>
                <td><?= $d['nama_akun'] ?></td>
                <td width="3%" align="center">Rp. </td>
                <td align="right"><?= number_format($saldo_debet, 0, ",", ".") ?></td>
            </tr>
            <?php $ts_debet += $saldo_debet ?>
        <?php endif; ?>
        <?php $bersih = $ts_kredit - $ts_debet ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" align="Center"><b>Beban Operasional </b></td>
        <td align="center" width="3%">Rp.</td>
        <td align="right"><b><?= number_format($ts_debet, 0, ",", ".") ?></b></td>
    </tr>
    <tr>
        <td colspan="3" align="Center">
            <?php if ($ts_kredit > $ts_debet) : ?>
                <b class="text-success">Laba Bersih</b>
            <?php elseif ($ts_kredit < $ts_debet) : ?>
                <b class="text-danger">Rugi</b>
            <?php else : ?>
                <b>BALANCE</b>
            <?php endif; ?>
        </td>
        <td align="center" width="3%">Rp.</td>
        <td align="right"><b><?= number_format($bersih, 0, ",", ".") ?></b></td>
    </tr>
<?php else : ?>
    <tr>
        <td colspan="5">
            <i>
                <center>
                    -----------
                    Tidak Ada Data Laba Rugi
                    -----------
                </center>
            </i>
        </td>
    </tr>
<?php endif; ?>