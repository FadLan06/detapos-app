<div class="table-responsive">
	<table class="table table-bordered table-hover table-sm">
		<tr>
			<td><b>Nama Akun : <?php echo $cek_akun['nama_akun']; ?></b></td>
			<td><b>Nomor Akun : <?php echo $cek_akun['kode_akun']; ?></b></td>
		</tr>
	</table>
</div>

<div class="anyClass2">
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-sm">
			<tr class="text-white" style="background-color: #008FD4;">
				<td colspan='2' align='center'><b>Transaksi</b></td>
				<td colspan='2' align='center'><b>Saldo</b></td>
			</tr>
			<tr class="text-white" style="background-color: #008FD4;">
				<td align="center" width="20%"><b>Tanggal transaksi</b></td>
				<td align="center" width="50%"><b>Keterangan</b></td>
				<td align="center" width="15%"><b>Debet</b></td>
				<td align="center" width="15%"><b>Kredit</b></td>
			</tr>
			<?php

			$data_akun = $this->db->query("SELECT *, tb_jurnal.id_akun 'idakun' from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.id_akun=tb_akun.id_akun and tb_jurnal.id_akun='$_GET[idakun]' group by tb_jurnal_tmp.tgl_jurnal");
			$j = $data_akun->row_array();


			$total_debet = "0";
			$total_kredit = "0";
			foreach ($data_akun->result_array() as $d) {
				echo "
		<tr>
			<td colspan='6' align='left'>" . longdate_indo($d['tgl_jurnal']) . "</td>
		</tr>
		";


				$akun = $this->db->query("SELECT * from tb_jurnal, tb_akun, tb_jurnal_tmp where tb_jurnal_tmp.no_jurnal=tb_jurnal.no_jurnal AND tb_jurnal.id_akun=tb_akun.id_akun and tb_jurnal.id_akun='$d[idakun]' and tb_jurnal_tmp.tgl_jurnal='$d[tgl_jurnal]' and tb_jurnal_tmp.token='$d[token]' ");
				foreach ($akun->result_array() as $r) {
					if ($r['tipe'] == 'D') {
						$nominal_debet = $r['nominal'];
						$nominal_kredit = "0";
						$total_debet	+=	$nominal_debet;
						$tipe = $r['tipe'];
					} elseif ($r['tipe'] == 'K') {
						$nominal_kredit = $r['nominal'];
						$nominal_debet = "0";
						$total_kredit	+=	$nominal_kredit;
					}

					if ($r['kategori'] == 'HL') {
						$saldo = $total_debet - $total_kredit;
						$posisi = "Debet";
					} elseif ($r['kategori'] == 'HT') {
						$saldo = $total_kredit - $total_debet;
						$posisi = "Kredit";
					}

					echo "
					<tr>
						<td></td>
						<td> <i>" . $r['keterangan'] . "</i><br></td>
						<td align='right'>Rp. " . number_format($nominal_debet, 0, ",", ".") . "</td>
						<td align='right'>Rp. " . number_format($nominal_kredit, 0, ",", ".") . "</td>
					</tr>
				";
				}
			}
			?>
			<tr>
				<td align="center" colspan="2"><b>Total</b></td>
				<td align='right'>Rp. <?php echo number_format($total_debet, 0, ",", "."); ?></td>
				<td align='right'>Rp. <?php echo number_format($total_kredit, 0, ",", "."); ?></td>

			</tr>
			<tr class="text-white" style="background-color: #008FD4;">
				<td align="center" colspan="2"><b>Saldo <?php echo $posisi; ?></b></td>
				<td align='center' colspan="2">Rp. <?php echo number_format($saldo, 0, ",", "."); ?></td>
			</tr>
			<table>
	</div>
</div>