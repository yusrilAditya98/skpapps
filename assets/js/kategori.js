var url = $(location).attr("href");
var segments = url.split("/");

// $(window).on('load', function () {
// 	$.ajax({
// 		url: segments[0] + '/SiUjian/agendaDosen/getRuangan',
// 		dataType: 'json',
// 		type: 'get',
// 		success: function (dataRuangan) {
// 			console.log(dataRuangan);
// 			dataRuangan.forEach(function (ruangan) {
// 				$('#ruangan').append(`<option value="` + ruangan + `">` + ruangan + `</option>`)
// 			})
// 		}
// 	});
// })


$('.tambahJenis').on('click', function () {
	$.ajax({
		url: segments[0] + '/skpapps/akademik/getBidangKegiatan',
		dataType: 'json',
		type: 'get',
		success: function (dataBidang) {
			console.log(dataBidang);
			dataBidang.forEach(function (bidang) {
				$('#bidang_kegiatan').append(`<option value="` + bidang + `">` + bidang + `</option>`)
			})
		}
	});
})

// $('.edit-kegiatan').on('click', function () {
// 	let id = $(this).data('id');
// 	// console.log(id);
// 	$.ajax({
// 		url: segments[0] + '/skpapps/akademik/get_kegiatan/' + id,
// 		method: 'get',
// 		dataType: 'json',
// 		success: function (data) {
// 			// console.log(data);
// 			var link_a = window.location.origin + '/skpapps/akademik/editKegiatan/' + id;
// 			$('form').attr('action', link_a);
// 			$('#nama_kegiatan').val(data['nama_event']);
// 			$('#tanggal_kegiatan').val(data['tanggal_format']);
// 			$('#deskripsi_kegiatan').val(data['deskripsi']);
// 			$('#ruangan').val(data['lokasi']);
// 			$('#pemateri').val(data['pemateri']);
// 			$('#waktu_kegiatan_mulai').val(data['waktu_mulai']);
// 			$('#waktu_kegiatan_selesai').val(data['waktu_selesai']);
// 			// $('.waktu_kegiatan').html('Waktu Pelaksanaan : ' + data['waktu_mulai'] + " - " + data['waktu_selesai']);
// 		}
// 	});
// })
