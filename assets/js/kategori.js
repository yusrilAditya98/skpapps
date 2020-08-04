var url = $(location).attr("href");
var segments = url.split("/");

$('.tambahBidang').on('click', function () {
	var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/tambahBidang/';
	$('form').attr('action', link_a);
})

$('.tambahJenis').on('click', function () {
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/bidangKegiatan',
		dataType: 'json',
		type: 'get',
		success: function (dataBidang) {
			// console.log(dataBidang);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/tambahJenis/';
			$('form').attr('action', link_a);
			dataBidang.forEach(function (bidang) {
				$('#bidang_kegiatan_tambah').append(`<option value="` + bidang['id_bidang'] + `">` + bidang['nama_bidang'] + `</option>`)
			})
		}
	});
})

$('.tambahTingkatan').on('click', function () {
	var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/tambahTingkatan/';
	$('form').attr('action', link_a);
})

$('.tambahPrestasi').on('click', function () {
	var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/tambahPrestasi/';
	$('form').attr('action', link_a);
})

$('.tambah-dasar-penilaian').on('click', function () {
	var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/tambahDasarPenilaian/';
	$('form').attr('action', link_a);
})


$('.tambah-detail-tingkatan').on('click', function () {
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/bidangKegiatan',
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/tambahDetailTingkatan/';
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
		url: segments[0] + '/' + segments[3] + '/API_skp/jenisKegiatan/' + a,
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
		url: segments[0] + '/' + segments[3] + '/API_skp/getTingkat/',
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
		url: segments[0] + '/' + segments[3] + '/API_skp/bidangKegiatan',
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/tambahDetailPrestasi/';
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
		url: segments[0] + '/' + segments[3] + '/API_skp/jenisKegiatan/' + a,
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
		url: segments[0] + '/' + segments[3] + '/API_skp/getSemuaTingkatanJenis/' + a,
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
		url: segments[0] + '/' + segments[3] + '/API_skp/getPres/',
		dataType: 'json',
		type: 'get',
		success: function (data) {
			console.log(data);
			data['prestasi'].forEach(function (prestasi) {
				$('.prestasi_tambah_prestasi').append(`<option value="` + prestasi['id_prestasi'] + `">` + prestasi['nama_prestasi'] + `</option>`)
			});
			data['dasar_penilaian'].forEach(function (dasar) {
				$('.dasar_tambah_prestasi').append(`<option value="` + dasar['id_dasar_penilaian'] + `">` + dasar['nama_dasar_penilaian'] + `</option>`)
			});
		}
	});
})


$('.table-kategori').on('click', '.edit-bidang', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getBidangKegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/editBidang/' + id;
			$('form').attr('action', link_a);
			$('#bidang_kegiatan_edit').val(data['nama_bidang']);
		}
	});
})

$('.table-kategori').on('click', '.edit-jenis', function () {
	let id = $(this).data('id');
	// console.log(id);
	$('#bidang_kegiatan_jenis').html(``);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getJenisKegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/editJenis/' + id;
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
		url: segments[0] + '/' + segments[3] + '/API_skp/getTingkatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/editTingkatan/' + id;
			$('form').attr('action', link_a);
			$('#tingkatan_kegiatan_edit').val(data['nama_tingkatan']);
		}
	});
})

$('.table-kategori').on('click', '.edit-prestasi', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getPrestasi/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/editPrestasi/' + id;
			$('form').attr('action', link_a);
			$('#prestasi_kegiatan_edit').val(data['nama_prestasi']);
		}
	});
})

$('.table-kategori').on('click', '.edit-dasar-penilaian', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDasarPenilaian/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/editDasarPenilaian/' + id;
			$('form').attr('action', link_a);
			$('#dasar_penilaian_edit').val(data['nama_dasar_penilaian']);
		}
	});
})

$('.table-kategori').on('click', '.edit-detail-tingkatan', function () {
	let id = $(this).data('id');
	// console.log(id);
	$('#bidang_detailT_edit').html(``);
	$('#jenis_detailT_edit').html(``);
	$('#tingkatan_detailT_edit').html(``);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailTingkatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/editDetailTingkatan/' + id;
			$('form').attr('action', link_a);
			data['list_bidang'].forEach(function (bidang) {
				if (bidang['id_bidang'] == data['real']['id_bidang']) {
					$('#bidang_detailT_edit').append(`<option value="` + bidang['id_bidang'] + `" selected>` + bidang['nama_bidang'] + `</option>`)
				} else {
					$('#bidang_detailT_edit').append(`<option value="` + bidang['id_bidang'] + `">` + bidang['nama_bidang'] + `</option>`)
				}
			})
			data['list_jenis'].forEach(function (jenis) {
				if (jenis['id_jenis_kegiatan'] == data['real']['id_jenis_kegiatan']) {
					$('#jenis_detailT_edit').append(`<option value="` + jenis['id_jenis_kegiatan'] + `" selected>` + jenis['jenis_kegiatan'] + `</option>`)
				} else {
					$('#jenis_detailT_edit').append(`<option value="` + jenis['id_jenis_kegiatan'] + `">` + jenis['jenis_kegiatan'] + `</option>`)
				}
			})
			data['list_tingkatan'].forEach(function (tingkatan) {
				if (tingkatan['id_tingkatan'] == data['real']['id_tingkatan']) {
					$('#tingkatan_detailT_edit').append(`<option value="` + tingkatan['id_tingkatan'] + `" selected>` + tingkatan['nama_tingkatan'] + `</option>`)
				} else {
					$('#tingkatan_detailT_edit').append(`<option value="` + tingkatan['id_tingkatan'] + `">` + tingkatan['nama_tingkatan'] + `</option>`)
				}
			})
		}
	});
})
$('.bidang_detailT_edit').on('change', function () {
	$('.jenis_detailT_edit').html('<option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>');
	var a = $('.bidang_detailT_edit').val();
	console.log(a);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/jenisKegiatan/' + a,
		dataType: 'json',
		type: 'get',
		success: function (data) {
			console.log(data);
			data.forEach(function (jenis) {
				$('.jenis_detailT_edit').append(`<option value="` + jenis['id_jenis_kegiatan'] + `">` + jenis['jenis_kegiatan'] + `</option>`)
			});
		}
	});
})
$('.jenis_detailT_edit').on('change', function () {
	// $('.tingkatan_detailT_edit').html('<option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>');
	var a = $('.jenis_detailT_edit').val();
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getTingkat/',
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			data.forEach(function (tingkatan) {
				$('.tingkatan_detailT_edit').append(`<option value="` + tingkatan['id_tingkatan'] + `">` + tingkatan['nama_tingkatan'] + `</option>`)
			});
		}
	});
})

$('.table-kategori').on('click', '.edit-detail-prestasi', function () {
	let id = $(this).data('id');
	// console.log(id);
	$('#bidang_detailP_edit').html(``);
	$('#jenis_detailP_edit').html(``);
	$('#tingkatan_detailP_edit').html(``);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailPrestasi/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/editDetailPrestasi/' + id;
			$('form').attr('action', link_a);
			data['list_bidang'].forEach(function (bidang) {
				if (bidang['id_bidang'] == data['real']['id_bidang']) {
					$('#bidang_detailP_edit').append(`<option value="` + bidang['id_bidang'] + `" selected>` + bidang['nama_bidang'] + `</option>`)
				} else {
					$('#bidang_detailP_edit').append(`<option value="` + bidang['id_bidang'] + `">` + bidang['nama_bidang'] + `</option>`)
				}
			})
			data['list_jenis'].forEach(function (jenis) {
				if (jenis['id_jenis_kegiatan'] == data['real']['id_jenis_kegiatan']) {
					$('#jenis_detailP_edit').append(`<option value="` + jenis['id_jenis_kegiatan'] + `" selected>` + jenis['jenis_kegiatan'] + `</option>`)
				} else {
					$('#jenis_detailP_edit').append(`<option value="` + jenis['id_jenis_kegiatan'] + `">` + jenis['jenis_kegiatan'] + `</option>`)
				}
			})
			data['list_tingkatan'].forEach(function (tingkatan) {
				if (tingkatan['id_semua_tingkatan'] == data['real']['id_semua_tingkatan']) {
					$('#tingkatan_detailP_edit').append(`<option value="` + tingkatan['id_semua_tingkatan'] + `" selected>` + tingkatan['nama_tingkatan'] + `</option>`)
				} else {
					$('#tingkatan_detailP_edit').append(`<option value="` + tingkatan['id_semua_tingkatan'] + `">` + tingkatan['nama_tingkatan'] + `</option>`)
				}
			})
			data['list_prestasi'].forEach(function (prestasi) {
				if (prestasi['id_prestasi'] == data['real']['id_prestasi']) {
					$('#prestasi_detailP_edit').append(`<option value="` + prestasi['id_prestasi'] + `" selected>` + prestasi['nama_prestasi'] + `</option>`)
				} else {
					$('#prestasi_detailP_edit').append(`<option value="` + prestasi['id_prestasi'] + `">` + prestasi['nama_prestasi'] + `</option>`)
				}
			})
			data['list_dasar'].forEach(function (dasar) {
				if (dasar['id_dasar_penilaian'] == data['real']['id_dasar_penilaian']) {
					$('#dasar_detailP_edit').append(`<option value="` + dasar['id_dasar_penilaian'] + `" selected>` + dasar['nama_dasar_penilaian'] + `</option>`)
				} else {
					$('#dasar_detailP_edit').append(`<option value="` + dasar['id_dasar_penilaian'] + `">` + dasar['nama_dasar_penilaian'] + `</option>`)
				}
			})
			$('#bobot_detailP_edit').val(data['real']['bobot']);
		}
	});
})
$('.bidang_detailP_edit').on('change', function () {
	$('.jenis_detailP_edit').html('<option value="0" disabled selected hidden>Pilih Jenis Kegiatan</option>');
	$('.tingkatan_detailP_edit').html('<option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>');
	var a = $('.bidang_detailP_edit').val();
	console.log(a);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/jenisKegiatan/' + a,
		dataType: 'json',
		type: 'get',
		success: function (data) {
			console.log(data);
			data.forEach(function (jenis) {
				$('.jenis_detailP_edit').append(`<option value="` + jenis['id_jenis_kegiatan'] + `">` + jenis['jenis_kegiatan'] + `</option>`)
			});
		}
	});
})
$('.jenis_detailP_edit').on('change', function () {
	$('.tingkatan_detailP_edit').html('<option value="0" disabled selected hidden>Pilih Tingkatan Kegiatan</option>');
	var a = $('.jenis_detailP_edit').val();
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getSemuaTingkatanJenis/' + a,
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			data.forEach(function (tingkatan) {
				$('.tingkatan_detailP_edit').append(`<option value="` + tingkatan['id_semua_tingkatan'] + `">` + tingkatan['nama_tingkatan'] + `</option>`)
			});
		}
	});
})
$('.tingkatan_detailP_edit').on('change', function () {
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getPres/',
		dataType: 'json',
		type: 'get',
		success: function (data) {
			console.log(data);
			data['prestasi'].forEach(function (prestasi) {
				$('.prestasi_detailP_edit').append(`<option value="` + prestasi['id_prestasi'] + `">` + prestasi['nama_prestasi'] + `</option>`)
			});
			data['dasar_penilaian'].forEach(function (dasar) {
				$('.dasar_detailP_edit').append(`<option value="` + dasar['id_dasar_penilaian'] + `">` + dasar['nama_dasar_penilaian'] + `</option>`)
			});
		}
	});
})


function ubahStatus(id_kat, type_kat) {

	let type = type_kat;
	let id = id_kat;
	let status = 0;

	if (type == 'bidang') {
		status = $('#status_bidang' + id).val();
	} else if (type == 'jenis') {
		status = $('#status_jenis' + id).val();
	} else if (type == 'tingkatan') {
		status = $('#status_tingkatan' + id).val();
	} else if (type == 'semua tingkatan') {
		status = $('#status_semua_tingkatan' + id).val();
	} else if (type == 'semua prestasi') {
		status = $('#status_semua_prestasi' + id).val();
	} else {
		status = $('#status_prestasi' + id).val();
	}
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/ubahStatusKategori',
		data: {
			'id': id,
			'type': type,
			'status': status
		},
		method: "post",
		dataType: 'json',
		success: function (result) {
			console.log(result)
			switch (type) {
				case 'bidang':
					$('#bidang_' + id).html(result['status'])
					$('#status_bidang' + id).val(result['nilai']);
					break;
				case 'jenis':
					$('#jenis_' + id).html(result['status'])
					$('#status_jenis' + id).val(result['nilai']);
					break;
				case 'tingkatan':
					console.log('cek')
					$('#tingkatan_' + id).html(result['status'])
					$('#status_tingkatan' + id).val(result['nilai']);
					break;
				case 'semua tingkatan':
					$('#semua_tingkatan_' + id).html(result['status'])
					$('#status_semua_tingkatan' + id).val(result['nilai']);
					break;
				case 'semua prestasi':
					$('#semua_prestasi_' + id).html(result['status'])
					$('#status_semua_prestasi' + id).val(result['nilai']);
					break;
				case 'prestasi':
					$('#prestasi_' + id).html(result['status'])
					$('#status_prestasi' + id).val(result['nilai']);
					break;
				default:
					break;
			}
		}
	});
}
