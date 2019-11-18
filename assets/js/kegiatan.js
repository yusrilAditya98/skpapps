var url = $(location).attr("href");
var segments = url.split("/");

$(window).on('load', function () {
	$.ajax({
		url: segments[0] + '/SiUjian/agendaDosen/getRuangan',
		dataType: 'json',
		type: 'get',
		success: function (dataRuangan) {
			console.log(dataRuangan);
			dataRuangan.forEach(function (ruangan) {
				$('#ruangan').append(`<option value="` + ruangan + `">` + ruangan + `</option>`)
			})
		}
	});
})


$('.detail-kegiatan').on('click', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/skpapps/akademik/get_kegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_image = window.location.origin + '/skpapps/assets/qrcode/kuliah_tamu_' + data['kode_qr'] + '.png';
			$('.kode_qr').attr('src', link_image);
			$('.judul_kegiatan').html(data['nama_event']);
			$('.tanggal_event').html('Tanggal : ' + data['tanggal_event']);
			$('.deskripsi').html(data['deskripsi']);
			$('.pemateri').html('Oleh : ' + data['pemateri']);
			$('.waktu_kegiatan').html('Waktu Pelaksanaan : ' + data['waktu_mulai'] + " - " + data['waktu_selesai']);

			if (data['peserta_kegiatan'].length != 0) {
				$('.tabel-peserta').html('');
				$('.tabel-peserta').html(`<div class="table-responsive">
				<table class="table table-striped" id="table-1">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th>Nama Peserta</th>
							<th>NIM</th>
							<th>Prodi</th>
						</tr>
					</thead>
					<tbody class="body-tabel">
					</tbody>
				</table>
			</div>`);
				var i = 0;
				data['peserta_kegiatan'].forEach(function (dataA) {
					$('.body-tabel').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama'] + `</td>
					<td>` + dataA['nim'] + `</td>
					<td>T` + dataA['nama_prodi'] + `</td>
				</tr>`)
				})
			} else {
				$('.tabel-peserta').html('');
				$('.tabel-peserta').html(`<div class="table-responsive">
				<table class="table table-striped" id="table-1">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th>Nama Peserta</th>
							<th>NIM</th>
							<th>Prodi</th>
						</tr>
					</thead>
					<tbody class="body-tabel">
						<tr>
							<td colspan="4"><h3 class="text-center">Belum ada peserta</h3></td>
						</tr>
					</tbody>
				</table>
			</div>`);
			}
		}
	});
})

$('.edit-kegiatan').on('click', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/skpapps/akademik/get_kegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/skpapps/akademik/editKegiatan/' + id;
			$('form').attr('action', link_a);
			$('#nama_kegiatan').val(data['nama_event']);
			$('#tanggal_kegiatan').val(data['tanggal_format']);
			$('#deskripsi_kegiatan').val(data['deskripsi']);
			$('#ruangan').val(data['lokasi']);
			$('#pemateri').val(data['pemateri']);
			$('#waktu_kegiatan_mulai').val(data['waktu_mulai']);
			$('#waktu_kegiatan_selesai').val(data['waktu_selesai']);
			// $('.waktu_kegiatan').html('Waktu Pelaksanaan : ' + data['waktu_mulai'] + " - " + data['waktu_selesai']);
		}
	});
})
