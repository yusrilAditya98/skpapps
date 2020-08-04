var url = $(location).attr("href");
var segments = url.split("/");

$(window).on('load', function () {
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDataRuangan/',
		method: 'get',
		dataType: 'json',
		success: function (dataRuangan) {
			dataRuangan.data.forEach(function (ruangan) {
				$('#ruangan').append(`<option  value="` + ruangan.ruangan + `">` + ruangan.ruangan + `</option>`)
			})
		}
	});
})

$('#table-kegiatan').on('click', '.detail-kegiatan-info', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Akademik/get_kegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.kategori-filter .fil').remove()
			var link_image = window.location.origin + '/' + segments[3] + '/assets/qrcode/kuliah_tamu_' + data['kode_qr'] + '.png';
			$('.kode_qr').attr('src', link_image);
			$('.judul_kegiatan').html(data['nama_event']);
			$('.tanggal_event').html('Tanggal : ' + data['tanggal_event']);
			$('.deskripsi').html('<i class="fas fa-tag mr-2"></i> : ' + data['deskripsi']);
			$('.pemateri').html('<i class="fas fa-user mr-2"></i> : ' + data['pemateri']);
			$('.lokasi').html('<i class="fas fa-map-marker-alt mr-2"></i> : ' + data['lokasi']);
			$('.waktu_kegiatan').html('Waktu Pelaksanaan : ' + data['waktu_mulai'] + " - " + data['waktu_selesai']);

			$('#kuliah-tamu_wrapper').remove()
			$('#detail-kuliah-tamu').append(`<table class="table table-striped table-bordered" id="kuliah-tamu"></table>`)
			if (data['peserta_kegiatan'].length != 0) {
				var i = 0;
				let dataTampung = [];
				for (var j in data['peserta_kegiatan']) {
					let temp = [];
					temp.push(++i)
					temp.push(data['peserta_kegiatan'][j]['nim'])
					temp.push(data['peserta_kegiatan'][j]['nama'])
					temp.push(data['peserta_kegiatan'][j]['nama_prodi'])
					temp.push(data['peserta_kegiatan'][j]['kehadiran_teks'])
					dataTampung[j] = temp;
				}
				$("#kuliah-tamu").DataTable({
					data: dataTampung,
					columns: [{
							title: "No"
						},
						{
							title: "Nama Peserta"
						},
						{
							title: "Nim"
						},
						{
							title: "Prodi"
						},
						{
							title: "Kehadiran"
						}
					],
					aLengthMenu: [
						[10, 50, 100, 200, -1],
						[10, 50, 100, 200, "All"]
					],
					iDisplayLength: 10,
					initComplete: function () {
						var select;
						this.api().columns([3]).every(function () {
							var column = this;
							select = $('<select class="form-control-sm fil"><option value="">--- prodi ---</option></select>')
								.prependTo($('.kategori-filter'))
								.on('change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search(val ? '^' + val + '$' : '', true, false)
										.draw();
								});
							column.data().unique().sort().each(function (d, j) {
								select.append('<option value="' + d + '">' + d + '</option>')
							});
						});
						this.api().columns([4]).every(function () {
							var column = this;
							select = $('<select class="form-control-sm mr-2 fil"><option value="">--- kehadiran ---</option></select>')
								.prependTo($('.kategori-filter'))
								.on('change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search(val ? '^' + val + '$' : '', true, false)
										.draw();
								});
							column.data().unique().sort().each(function (d, j) {
								select.append('<option value="' + d + '">' + d + '</option>')
							});
						});
					},
				});
				$('#kuliah-tamu').attr('style', 0)
			} else {
				$('#detail-kuliah-tamu').append(`<h3 id="kuliah-tamu_wrapper" class="text-center my-2">Tidak ada peserta</h3>
						`)
			}
		}
	});
})

$('#table-kegiatan').on('click', '.edit-kegiatan', function () {
	let id = $(this).data('id');
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Akademik/get_kegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/Akademik/editKegiatan/' + id;
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

$('#table-kegiatan').on('click', '.hapus-kegiatan', function () {
	let id_kuliah_tamu = $(this).data('id');
	// console.log(id_kuliah_tamu);
	Swal.fire({
		title: 'Anda yakin?',
		text: "Kegiatan akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/" + segments[3] + "/Akademik/hapusKegiatan/" + id_kuliah_tamu;
		}
	})
});

$('#table-kegiatan').on('click', '.validasi-kegiatan-akademik', function () {
	let id = $(this).data('id');
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Akademik/get_kegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.kategori-filter-valid .fil-validasi').remove()
			var link_image = window.location.origin + '/' + segments[3] + '/assets/qrcode/kuliah_tamu_' + data['kode_qr'] + '.png';
			$('.kode_qr_validasi').attr('src', link_image);
			$('.judul_kegiatan_validasi').html(data['nama_event']);
			$('.tanggal_event_validasi').html('Tanggal : ' + data['tanggal_event']);
			$('.deskripsi_validasi').html('<i class="fas fa-tag mr-2"></i> : ' + data['deskripsi']);
			$('.pemateri_validasi').html('<i class="fas fa-user mr-2"></i> : ' + data['pemateri']);
			$('.lokasi_validasi').html('<i class="fas fa-map-marker-alt mr-2"></i> : ' + data['lokasi']);
			$('.waktu_kegiatan_validasi').html('Waktu Pelaksanaan : ' + data['waktu_mulai'] + " - " + data['waktu_selesai']);


			$('#kuliah-tamu-valid_wrapper').remove()
			$('#validasi-kuliah-tamu').append(`<table class="table table-striped table-bordered" id="kuliah-tamu-valid"></table>`)
			if (data['peserta_kegiatan'].length != 0) {
				var i = 0;
				let dataTampung = [];
				for (var j in data['peserta_kegiatan']) {
					let temp = [];
					temp.push(++i)
					temp.push(data['peserta_kegiatan'][j]['nim'])
					temp.push(data['peserta_kegiatan'][j]['nama'])
					temp.push(data['peserta_kegiatan'][j]['nama_prodi'])
					temp.push(`<input type="checkbox" name="validasi[]" value="` + data['peserta_kegiatan'][j]['id_peserta_kuliah_tamu'] + `" checked> <input type="hidden" id="id_kuliah_tamu" name="id_kuliah_tamu" value="` + data['id_kuliah_tamu'] + `">
					<input type="hidden" id="nama_kegiatan" name="nama_kegiatan" value="` + data['nama_event'] + `">
					<input type="hidden" id="tgl_pelaksanaan" name="tgl_pelaksanaan" value="` + data['tanggal_format'] + `">
					<input type="hidden" id="tempat_pelaksanaan" name="tempat_pelaksanaan" value="` + data['lokasi'] + `">
					<input type="hidden" id="kode_qr" name="kode_qr" value="kuliah_tamu_` + data['kode_qr'] + `.png">`)
					dataTampung[j] = temp;
				}
				$("#kuliah-tamu-valid").DataTable({
					data: dataTampung,
					columns: [{
							title: "No"
						},
						{
							title: "Nama Peserta"
						},
						{
							title: "Nim"
						},
						{
							title: "Prodi"
						},
						{
							title: "Kehadiran"
						}
					],
					aLengthMenu: [
						[25, 50, 100, 200, -1],
						[25, 50, 100, 200, "All"]
					],
					iDisplayLength: -1

				});
				$('#kuliah-tamu-valid').attr('style', 0)
			} else {
				$('#validasi-kuliah-tamu').append(`<tr id="kuliah-tamu-valid_wrapper" ><input type="hidden" id="id_kuliah_tamu" name="id_kuliah_tamu" value="` + data['id_kuliah_tamu'] + `"><td colspan="5"><h3 class="text-center">Belum ada peserta</h3></td></tr>`)
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
