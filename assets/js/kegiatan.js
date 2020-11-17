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
					if (data['status_terlaksana'] == 1) {
						temp.push('<a class="btn btn-success" onclick="valid(' + data['peserta_kegiatan'][j]['nim'] + ',' + id + ',' + 1 + ',' + data['peserta_kegiatan'][j]['kehadiran'] + ')">valid hadir</a>')
					} else {
						temp.push('<a class="btn btn-secondary">valid hadir</a>')
					}
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
						},
						{
							title: "Action"
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
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Akademik/get_kegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			var link_a = window.location.origin + '/' + segments[3] + '/Akademik/editKegiatan/' + id;
			$('form').attr('action', link_a);
			$('#nama_kegiatan_lama').val(data['nama_event']);
			$('#tempat_lama').val(data['lokasi']);
			$('#tgl_plksn_lama').val(data['tanggal_format']);
			$('#status_terlaksana').val(data['status_terlaksana']);

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
			$('#id_kt').val(id)
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
			console.log(data);
			if (data['peserta_kegiatan'].length != 0) {
				$("#id_kuliah_tamu").val(data['id_kuliah_tamu'])
				$("#nm_kgtn").val(data['nama_event'])
				$("#tgl_pelaksanaan").val(data['tanggal_format'])
				$("#tempat_pelaksanaan").val(data['lokasi'])
				$("#kode_qr").val(`kuliah_tamu_` + data['kode_qr'] + `.png`)

				var i = 0;
				let dataTampung = [];
				for (var j in data['peserta_kegiatan']) {
					let temp = [];
					temp.push(++i)
					temp.push(data['peserta_kegiatan'][j]['nim'])
					temp.push(data['peserta_kegiatan'][j]['nama'])
					temp.push(data['peserta_kegiatan'][j]['nama_prodi'])
					temp.push(`<input type="checkbox" name="validasi[]" value="` + data['peserta_kegiatan'][j]['id_peserta_kuliah_tamu'] + `,` + data['peserta_kegiatan'][j]['nim'] + `" checked>`)
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

// mengubah status kehadiran peserta

function valid(nim, id_kegiatan, status, kehadiran) {
	let tombol = event.target
	let hadir = (tombol.parentElement.previousSibling)
	if (kehadiran == 1) {
		alert('Data peserta sudah hadir')
	} else {
		$.ajax({
			url: segments[0] + '/' + segments[3] + '/API_skp/ubahStatusKehadiran',
			data: {
				'nim': nim,
				'id_kegiatan': id_kegiatan,
				'status': status
			},
			method: "post",
			dataType: 'json',
			success: function () {
				hadir.innerHTML = "Hadir"
			}
		})
	}
}

function cekPeserta(params) {
	var x = document.getElementsByName("validasi[]");
	let idPeserta = "";
	let nimPeserta = "";
	let str;
	let peserta;
	for (var i in x) {
		str = [];
		if (x[i].checked) {
			str = x[i].value;
			peserta = str.split(",")
			idPeserta += peserta[0] + ","
			nimPeserta += peserta[1] + ","
		}
	}
	$('#peserta_kt').val(idPeserta)
	$('#peserta_nim').val(nimPeserta)
}
