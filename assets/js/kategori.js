var url = $(location).attr("href");
var segments = url.split("/");

$('.detail-tingkatan').on('click', function () {
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/getSemuaTingkatanKegiatan',
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			$('.tabel-semua-tingkatan').html('');
			$('.tabel-semua-tingkatan').html(`<div class="table-responsive">
				<table class="table table-striped table-tingkatan">
					<thead>
						<tr class="text-center">
							<th>No</th>
							<th>Tingkatan</th>
							<th>Jenis Kegiatan</th>
							<th>Bidang Kegiatan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody class="body-tabel">
					</tbody>
				</table>
			</div>`);
			var i = 0;
			data.forEach(function (dataA) {
				$('.body-tabel').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama_tingkatan'] + `</td>
					<td>` + dataA['jenis_kegiatan'] + `</td>
					<td>` + dataA['nama_bidang'] + `</td>
					<td class="text-center">
                        <button class="btn btn-success edit-detail-tingkatan text-wrap" data-toggle="modal" data-target=".modalEditDetailTingkatan" data-id="` + dataA['id_semua_tingkatan'] + `">Edit</button>
                        <button class="btn btn-danger hapus-detail-tingkatan text-wrap" data-id="` + dataA['id_semua_tingkatan'] + `">Hapus</button>
                    </td>
				</tr>`)
			})

			$(".table-tingkatan").DataTable({
				"pageLength": 5
			});
		}
	});
})
$('.detail-prestasi').on('click', function () {
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/getSemuaPrestasiKegiatan',
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			$('.tabel-semua-prestasi').html('');
			$('.tabel-semua-prestasi').html(`<div class="table-responsive">
				<table class="table table-striped table-prestasi">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th>Bidang</th>
							<th>Jenis</th>
							<th>Tingkatan</th>
							<th>Prestasi</th>
							<th>Bobot</th>
							<th>Dasar Penilaian</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody class="body-tabel">
					</tbody>
				</table>
			</div>`);
			var i = 0;
			data.forEach(function (dataA) {
				$('.body-tabel').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama_bidang'] + `</td>
					<td>` + dataA['jenis_kegiatan'] + `</td>
					<td>` + dataA['nama_tingkatan'] + `</td>
					<td>` + dataA['nama_prestasi'] + `</td>
					<td>` + dataA['bobot'] + `</td>
					<td>` + dataA['nama_dasar_penilaian'] + `</td>
					<td class="text-center">
                        <button class="btn btn-success edit-detail-prestasi text-wrap" data-toggle="modal" data-target=".modalEditDetailPrestasi" data-id="` + dataA['id_semua_prestasi'] + `">Edit</button>
                        <button class="btn btn-danger hapus-detail-prestasi text-wrap" data-id="` + dataA['id_semua_prestasi'] + `">Hapus</button>
                    </td>
				</tr>`)
			})
			$(".table-prestasi").DataTable({
				"pageLength": 5
			});
		}
	});
})

$('.tambahBidang').on('click', function () {
	var link_a = window.location.origin + '/skpapps/kemahasiswaan/tambahBidang/';
	$('form').attr('action', link_a);
})


$('.tambahJenis').on('click', function () {
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/bidangKegiatan',
		dataType: 'json',
		type: 'get',
		success: function (dataBidang) {
			// console.log(dataBidang);
			var link_a = window.location.origin + '/skpapps/kemahasiswaan/tambahJenis/';
			$('form').attr('action', link_a);
			dataBidang.forEach(function (bidang) {
				$('#bidang_kegiatan_tambah').append(`<option value="` + bidang['id_bidang'] + `">` + bidang['nama_bidang'] + `</option>`)
			})
		}
	});
})

$('.tambahTingkatan').on('click', function () {
	var link_a = window.location.origin + '/skpapps/kemahasiswaan/tambahTingkatan/';
	$('form').attr('action', link_a);
})

$('.tambahPrestasi').on('click', function () {
	var link_a = window.location.origin + '/skpapps/kemahasiswaan/tambahPrestasi/';
	$('form').attr('action', link_a);
})

$('.tambah-detail-tingkatan').on('click', function () {
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/bidangKegiatan',
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/skpapps/kemahasiswaan/tambahDetailTingkatan/';
			$('form').attr('action', link_a);

			$('.bidang_tambah').html(`<option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>`)
			$('.jenis_tambah').html(`<option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>`)
			$('.tingkatan_tambah').html(`<option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>`)
			data.forEach(function (bidang) {
				$('.bidang_tambah').append(`<option value="` + bidang['id_bidang'] + `">` + bidang['nama_bidang'] + `</option>`)
			});
		}
	});
})
$('.bidang_tambah').on('change', function () {
	$('.jenis_tambah').html('<option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>');
	var a = $('.bidang_tambah').val();
	console.log(a);
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/jenisKegiatan/' + a,
		dataType: 'json',
		type: 'get',
		success: function (data) {
			console.log(data);
			data.forEach(function (jenis) {
				$('.jenis_tambah').append(`<option value="` + jenis['id_jenis_kegiatan'] + `">` + jenis['jenis_kegiatan'] + `</option>`)
			});
		}
	});
})
$('.jenis_tambah').on('change', function () {
	$('.tingkatan_tambah').html('<option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>');
	var a = $('.jenis_tambah').val();
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/getTingkat/',
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			data.forEach(function (tingkatan) {
				$('.tingkatan_tambah').append(`<option value="` + tingkatan['id_tingkatan'] + `">` + tingkatan['nama_tingkatan'] + `</option>`)
			});
		}
	});
})



$('.tambah-detail-prestasi').on('click', function () {
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/bidangKegiatan',
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/skpapps/kemahasiswaan/tambahDetailPrestasi/';
			$('form').attr('action', link_a);

			$('.bidang_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Bidang Kegiatan</option>`)
			$('.jenis_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>`)
			$('.tingkatan_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>`)
			$('.prestasi_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Prestasi Kegiatan</option>`)
			$('.dasar_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Dasar Penilaian Kegiatan</option>`)
			data.forEach(function (bidang) {
				$('.bidang_tambah_prestasi').append(`<option value="` + bidang['id_bidang'] + `">` + bidang['nama_bidang'] + `</option>`)
			});
		}
	});
})
$('.bidang_tambah_prestasi').on('change', function () {
	$('.jenis_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>`)
	$('.tingkatan_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>`)
	$('.prestasi_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Prestasi Kegiatan</option>`)
	$('.dasar_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Dasar Penilaian Kegiatan</option>`)
	var a = $('.bidang_tambah_prestasi').val();
	// console.log(a);
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/jenisKegiatan/' + a,
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			data.forEach(function (jenis) {
				$('.jenis_tambah_prestasi').append(`<option value="` + jenis['id_jenis_kegiatan'] + `">` + jenis['jenis_kegiatan'] + `</option>`)
			});
		}
	});
})
$('.jenis_tambah_prestasi').on('change', function () {
	$('.tingkatan_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>`)
	$('.prestasi_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Prestasi Kegiatan</option>`)
	$('.dasar_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Dasar Penilaian Kegiatan</option>`)
	var a = $('.jenis_tambah_prestasi').val();
	// console.log(a);
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/getSemuaTingkatanJenis/' + a,
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			data.forEach(function (tingkatan) {
				$('.tingkatan_tambah_prestasi').append(`<option value="` + tingkatan['id_semua_tingkatan'] + `">` + tingkatan['nama_tingkatan'] + `</option>`)
			});
		}
	});
})
$('.tingkatan_tambah_prestasi').on('change', function () {
	$('.prestasi_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Prestasi Kegiatan</option>`)
	$('.dasar_tambah_prestasi').html(`<option value="0" disabled selected hidden>Pilih Dasar Penilaian Kegiatan</option>`)
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/getPres/',
		dataType: 'json',
		type: 'get',
		success: function (data) {
			console.log(data);
			data['prestasi'].forEach(function (prestasi) {
				$('.prestasi_tambah_prestasi').append(`<option value="` + prestasi['id_semua_prestasi'] + `">` + prestasi['nama_prestasi'] + `</option>`)
			});
			data['dasar_penilaian'].forEach(function (dasar) {
				$('.dasar_tambah_prestasi').append(`<option value="` + dasar['id_dasar_penilaiana'] + `">` + dasar['nama_dasar_penilaian'] + `</option>`)
			});
		}
	});
})


$('.table-kategori').on('click', '.edit-bidang', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/getBidangKegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/skpapps/kemahasiswaan/editBidang/' + id;
			$('form').attr('action', link_a);
			$('#bidang_kegiatan_edit').val(data['nama_bidang']);
		}
	});
})

$('.table-kategori').on('click', '.edit-jenis', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/getJenisKegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			var link_a = window.location.origin + '/skpapps/kemahasiswaan/editJenis/' + id;
			$('form').attr('action', link_a);
			$('#jenis_kegiatan_edit').val(data['jenisKegiatan']['jenis_kegiatan']);
			data['semua_bidang'].forEach(function (bidang) {
				if (bidang['id_bidang'] == data['jenisKegiatan']['id_bidang']) {
					$('#bidang_kegiatan_jenis').append(`<option value="` + bidang['id_bidang'] + `" selected>` + bidang['nama_bidang'] + `</option>`)
				} else {
					$('#bidang_kegiatan_jenis').append(`<option value="` + bidang['id_bidang'] + `">` + bidang['nama_bidang'] + `</option>`)
				}
			})
		}
	});
})

$('.table-kategori').on('click', '.edit-tingkatan', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/getTingkatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			var link_a = window.location.origin + '/skpapps/kemahasiswaan/editTingkatan/' + id;
			$('form').attr('action', link_a);
			$('#tingkatan_edit').val(data['nama_tingkatan']);
		}
	});
})

$('.table-kategori').on('click', '.edit-prestasi', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/getPrestasi/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			var link_a = window.location.origin + '/skpapps/kemahasiswaan/editPrestasi/' + id;
			$('form').attr('action', link_a);
			$('#prestasi_edit').val(data['nama_prestasi']);
		}
	});
})
