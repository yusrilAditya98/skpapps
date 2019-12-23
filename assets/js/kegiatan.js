var url = $(location).attr("href");
var segments = url.split("/");

if (segments[4] == "Akademik") {
	$(window).on('load', function () {
		$.ajax({
			url: segments[0] + '/siruas-api/api/ruangan',
			dataType: 'json',
			type: 'get',
			success: function (dataRuangan) {
				console.log(segments[0] + '/siruas-api/api/ruangan');
				dataRuangan.data.forEach(function (ruangan) {
					$('#ruangan').append(`<option value="` + ruangan.ruangan + `">` + ruangan.ruangan + `</option>`)
				})
			}
		});
		$('.dataTables_filter').prepend(`
		<select class="custom-select col-lg-4 mr-2 filter-status" id="filter-status" onchange="myFunctionKegiatan()">
			<option value="">Pilih Status</option>
			<option>Belum Terlaksana</option>
			<option>Sudah Terlaksana</option>
			<option>Sedang Berlangsung</option>
		</select>`);
	})
}

function myFunctionKegiatan() {
	// Declare variables
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("filter-status");
	filter = input.value.toUpperCase();
	// console.log(filter);
	table = document.getElementById("tabel-kegiatan");
	tr = table.getElementsByTagName("tr");

	// Loop through all table rows, and hide those who don't match the search query
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[4];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}

$('.detail-kegiatan-info').on('click', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/akademik/get_kegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_image = window.location.origin + '/' + segments[3] + '/assets/qrcode/kuliah_tamu_' + data['kode_qr'] + '.png';
			$('.kode_qr').attr('src', link_image);
			$('.judul_kegiatan').html(data['nama_event']);
			$('.tanggal_event').html('Tanggal : ' + data['tanggal_event']);
			$('.deskripsi').html(data['deskripsi']);
			$('.pemateri').html('Oleh : ' + data['pemateri']);
			$('.lokasi').html('Lokasi : ' + data['lokasi']);
			$('.waktu_kegiatan').html('Waktu Pelaksanaan : ' + data['waktu_mulai'] + " - " + data['waktu_selesai']);

			$('.tabel-peserta').html('');
			$('.tabel-peserta').html(`<div class="table-responsive">
			<table class="table table-striped" id="table-1">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Nama Peserta</th>
						<th>NIM</th>
						<th>Prodi</th>
						<th>Kehadiran</th>
					</tr>
				</thead>
				<tbody class="body-tabel">
				</tbody>
			</table>
		</div>`);
			if (data['peserta_kegiatan'].length != 0) {
				var i = 0;
				data['peserta_kegiatan'].forEach(function (dataA) {
					$('.body-tabel').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama'] + `</td>
					<td>` + dataA['nim'] + `</td>
					<td>` + dataA['nama_prodi'] + `</td>
					<td>` + dataA['kehadiran_teks'] + `</td>
				</tr>`)
				})
			} else {
				$('.body-tabel').append(`
					<tr>
						<td colspan="5"><h3 class="text-center">Belum ada peserta</h3></td>
					</tr>`)
			}
		}
	});
})

$('.table-kategori').on('click', '.edit-kegiatan', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/akademik/get_kegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/akademik/editKegiatan/' + id;
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

$('.table-kategori').on('click', '.validasi-kegiatan-akademik', function () {
	let id = $(this).data('id');
	console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/akademik/get_kegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			var link_image = window.location.origin + '/' + segments[3] + '/assets/qrcode/kuliah_tamu_' + data['kode_qr'] + '.png';
			$('.kode_qr_validasi').attr('src', link_image);
			$('.judul_kegiatan_validasi').html(data['nama_event']);
			$('.tanggal_event_validasi').html('Tanggal : ' + data['tanggal_event']);
			$('.deskripsi_validasi').html(data['deskripsi']);
			$('.pemateri_validasi').html('Oleh : ' + data['pemateri']);
			$('.lokasi_validasi').html('Lokasi : ' + data['lokasi']);
			$('.waktu_kegiatan_validasi').html('Waktu Pelaksanaan : ' + data['waktu_mulai'] + " - " + data['waktu_selesai']);

			if (data['peserta_kegiatan'].length != 0) {
				$('.tabel-peserta_validasi').html('');
				$('.tabel-peserta_validasi').html(`<div class="table-responsive">
				<table class="table table-striped" id="table-1">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th>Nama Peserta</th>
							<th>NIM</th>
							<th>Prodi</th>
							<th>Kehadiran</th>
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
					<td>` + dataA['nama_prodi'] + `</td>
					<td><input type="checkbox" name="validasi[]" value="` + dataA['id_peserta_kuliah_tamu'] + `"></td>
					<input type="hidden" id="id_kuliah_tamu" name="id_kuliah_tamu" value="` + data['id_kuliah_tamu'] + `">
					<input type="hidden" id="nama_kegiatan" name="nama_kegiatan" value="` + data['nama_event'] + `">
					<input type="hidden" id="tgl_pelaksanaan" name="tgl_pelaksanaan" value="` + data['tanggal_format'] + `">
					<input type="hidden" id="tempat_pelaksanaan" name="tempat_pelaksanaan" value="` + data['lokasi'] + `">
				</tr>`)
				})
			} else {
				$('.tabel-peserta_validasi').html('');
				$('.tabel-peserta_validasi').html(`<div class="table-responsive">
				<table class="table table-striped" id="table-1">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th>Nama Peserta</th>
							<th>NIM</th>
							<th>Prodi</th>
							<th>Kehadiran</th>
						</tr>
					</thead>
					<tbody class="body-tabel">
						<tr>
							<td colspan="5"><h3 class="text-center">Belum ada peserta</h3></td>
						</tr>
					</tbody>
				</table>
			</div>`);
			}
		}
	});
})

function eventCheckBox() {
	let checkboxs = document.getElementsByTagName("input");
	// let selectAll = document.getElementById("selectall");
	for (let i = 1; i < checkboxs.length; i++) {
		checkboxs[i].checked = !checkboxs[i].checked;
	}
	// selectAll[i].checked = !selectAll[i].checked;
}
