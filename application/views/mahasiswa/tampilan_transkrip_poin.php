<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Transkip skp - <?= $this->session->userdata('username') ?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style type="text/css" media="print">
		/* @page {size:landscape}  */

		.main-content {
			position: relative;
			top: 20px;
		}

		body {
			font-family: sans-serif;
		}

		p {
			font-size: 14px
		}
	</style>
</head>
<?php
function tanggal_indonesia($tanggal)
{
	$bulan = array(
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);

	$pecahkan = explode('-', $tanggal);

	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun

	return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

<body>
	<div class="kop-surat mt-2 pb-1" style="border-bottom: 3px solid black;">
		<div class="row">
			<div class="col-12">
				<img src="<?= base_url('/assets/img/kop/kop.png') ?>" alt="" srcset="">
			</div>
		</div>
	</div>
	<div class="judul text-center mt-5 mb-5">
		<h1 style="font-family: 'Times New Roman', Times, serif;"><b><u>TRANSKRIP PRESTASI MAHASISWA</u></b></h1>
	</div>
	<div class="row mt-5">
		<div class="col-6">
			<form action="">
				<div class="form-group row">
					<h4 for="staticEmail" class="col-sm-4">NAMA</h4>
					<div class="col-sm-1">:</div>
					<div class="col-sm-7">
						<h4><?= $mahasiswa[0]['nama'] ?></h4>
					</div>
				</div>
				<div class="form-group row">
					<h4 for="staticEmail" class="col-sm-4">NOMOR INDUK</h4>
					<div class="col-sm-1">:</div>
					<div class="col-sm-7">
						<h4><?= $mahasiswa[0]['nim'] ?></h4>
					</div>
				</div>
				<div class="form-group row">
					<h4 for="staticEmail" class="col-sm-4">JENJANG PENDIDIKAN</h4>
					<div class="col-sm-1">:</div>
					<div class="col-sm-7">
						<h4>Sarjana</h4>
					</div>
				</div>
			</form>
		</div>
		<div class="col-6">
			<form action="" style="margin-right: 5em;">
				<div class="form-group row">
					<h4 for="staticEmail" class="col-sm-5">FAKULTAS</h4>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6">
						<h4>Ekonomi dan Bisnis</h4>
					</div>
				</div>
				<div class="form-group  row">
					<h4 for="staticEmail" class="col-sm-5">PROGRAM STUDI</h4>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6">
						<h4><?= $mahasiswa[0]['nama_prodi'] ?></h4>
					</div>
				</div>
				<div class="form-group row">
					<h4 for="staticEmail" class="col-sm-5">JURUSAN</h4>
					<div class="col-sm-1">:</div>
					<div class="col-sm-6">
						<h4><?= $mahasiswa[0]['nama_jurusan'] ?></h4>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="row mt-3">
		<?php $alfa = ['A', 'B', 'C', 'D', 'E', 'F', 'G'] ?>
		<?php $j = 0 ?>
		<?php foreach ($bidang as $b) :  ?>
			<div class="organisasi col-lg-12">
				<h5><?= $alfa[$j++] . ". " ?>Bidang <span><?= $b['nama_bidang'] ?></span></h5>
				<div class="table-responsive-sm">
					<table class="table table-bordered table-sm">
						<thead>
							<tr>
								<th style="width: 5%">No</th>
								<th style="width: 26.66%">Nama Kegiatan</th>
								<th style="width: 16.66%">Jabatan/Prestasi</th>
								<th style="width: 16.66%">Tanggal Pelaksanaan</th>
								<th style="width: 16.66%">Tingkat</th>
								<th style="width: 16.66%">Point</th>
							</tr>
						</thead>
						<tbody>
							<?php $index = 1; ?>
							<?php foreach ($poinskp as $p) : ?>
								<?php if ($p['validasi_prestasi'] == 1) : ?>
									<?php if ($p['id_bidang'] == $b['id_bidang']) : ?>
										<tr>
											<td style="width: 5%"><?= $index++; ?></td>
											<td style="width: 26.66%"><?= $p['nama_kegiatan'] ?></td>
											<td style="width: 16.66%"><?= $p['nama_prestasi'] ?></td>
											<td style="width: 16.66%"><?= tanggal_indonesia($p['tgl_pelaksanaan']) ?></td>
											<td style="width: 16.66%"><?= $p['nama_tingkatan'] ?></td>
											<td style="width: 16.66%"><?= ($p['bobot'] * $p['nilai_bobot']) ?></td>
											<!-- date("d-m-Y", strtotime($p['tgl_pelaksanaan']))  -->
										</tr>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php endforeach; ?>

	</div>

	<div class="row mt-3">
		<div class="col-8">

			<table class="table table-sm table-borderless mt-3">
				<thead>
					<tr>
						<th style="width: 10%" scope="col">Total Poin</th>
						<th style="width: 60%" scope="col">: <?= $mahasiswa[0]['total_poin_skp'] ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th style="width: 10%" scope="row">Predikat</th>
						<td style="width: 60%">:<?php if ($mahasiswa[0]['total_poin_skp'] >= 100 && $mahasiswa[0]['total_poin_skp'] <= 150) : ?>
							Cukup
						<?php elseif ($mahasiswa[0]['total_poin_skp'] >= 151 && $mahasiswa[0]['total_poin_skp'] <= 200) : ?>
							Baik
						<?php elseif ($mahasiswa[0]['total_poin_skp'] >= 201 && $mahasiswa[0]['total_poin_skp'] <= 300) : ?>
							Sangat Baik
						<?php elseif ($mahasiswa[0]['total_poin_skp'] > 300) : ?>
							Dengan Pujian
						<?php else : ?>
							Kurang
						<?php endif; ?></td>
					</tr>

				</tbody>
			</table>

			<table class="table table-sm table-borderless mt-5">

				<tbody>
					<tr>
						<th style="width: 10%" scope="row">Dengan Pujian</th>
						<td style="width: 60%"> 300</td>
					</tr>
					<tr>
						<th style="width: 10%" scope="row">Sangat Baik</th>
						<td style="width: 60%">201 - 300</td>
					</tr>
					<tr>
						<th style="width: 10%" scope="row">Baik</th>
						<td style="width: 60%">151 - 200</td>
					</tr>
					<tr>
						<th style="width: 10%" scope="row">Cukup</th>
						<td style="width: 60%">100 - 150</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="col-4">
			<?= tanggal_indonesia(date('Y-m-d')) ?> <br>
			a.n Dekan <br>
			<?= $pimpinan[5]['jabatan'] ?>,<br>
			<img height="200" src="<?= base_url('assets/qrcode/bukti_skp_' . $mahasiswa[0]['nim'] . '.png') ?>" alt="qrcode">
			<p style="margin-top:10px;"><?= $pimpinan[5]['nama'] ?> <br> NIP. <?= $pimpinan[5]['nip'] ?></p>
		</div>

	</div>

	<script>
		window.print()
	</script>
</body>

</html>