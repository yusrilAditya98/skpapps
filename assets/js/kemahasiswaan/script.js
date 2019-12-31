var url = $(location).attr("href");
var segments = url.split("/");

$('.detailSkp').on("click", function () {
	let id_skp = $(this).data('id');
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Kemahasiswaan/detailKegiatan/' + id_skp,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.d-bidang').html(data[0].nama_bidang)
			$('.d-jenis').html(data[0].jenis_kegiatan)
			$('.d-tingkat').html(data[0].nama_tingkatan)
			$('.d-partisipasi').html(data[0].nama_prestasi)
			$('.d-bobot').html(data[0].bobot)
			$('.d-nama').val(data[0].nama_kegiatan)
			$('.d-tgl').val(data[0].tgl_pelaksanaan)
			$('.d-tempat').val(data[0].tempat_pelaksanaan)
			$('.d-catatan').val(data[0].catatan)
			$('.form-revisi').attr('action', segments[0] + '/' + segments[3] + '/Kemahasiswaan/validasiSkp/' + data[0].id_poin_skp)
			$('.d-file').attr('href', segments[0] + '/' + segments[3] + '/assets/pdfjs/web/viewer.html?file=../../../file_bukti/poinskp/' + data[0].file_bukti)
		}
	})
})

$('.d-revisi').on("click", function () {
	let id_skp = $(this).data('skp');

	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Kemahasiswaan/detailKegiatan/' + id_skp,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiSkp/' + data[0].id_poin_skp)
			$('.d-catatan').val(data[0].catatan)
		}
	})
})

$('.d-valid-km').on("click", function () {

	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(3)

})
$('.d-valid').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(4)
})

$('.d-valid-km-lpj').on("click", function () {

	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(3)

})
$('.d-valid-lpj').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(4)
})


$('.detail-kegiatan').on('click', function () {
	let tipe_kegiatan = $(this).data('jenis');
	let id_kegiatan = $(this).data('id');
	let role_id = 0;
	if ($('.role_id').val()) {
		role_id = $('.role_id').val();
	}
	if (tipe_kegiatan == 'proposal') {
		$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiProposal/' + id_kegiatan)
		$('.jenis_validasi').val(role_id)
	} else {
		$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiLpj/' + id_kegiatan)
		$('.jenis_validasi').val(role_id)
	}
})






$('.tambahAnggaran').on('click', function () {
	$('.d-lembaga').remove()
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_Skp/dataLembaga/',
		method: 'get',
		dataType: 'json',
		success: function (data) {

			for (var i in data)[
				$('.data-lembaga').append(`
				<tr class="d-lembaga">
					<td></td>
					<td>` + data[i].nama_lembaga + `</td>
					<td><input type="number" class="form-control" name="lembaga_` + data[i].id_lembaga + `" required></td>
				</tr>
				`)
			]
		}
	})
})

$('.edit-anggaran').on('click', function () {
	let id_lembaga = $(this).data('id');
	let tahun = $(this).data('tahun');
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_Skp/dataAnggaran/' + id_lembaga + '?tahun=' + tahun,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.nama-lembaga').val(data[0]['nama_lembaga']);
			$('.tahun-anggaran').val(data[0]['tahun_kegiatan']);
			$('.nominal-anggaran').val(data[0]['anggaran_kemahasiswaan']);
			$('.id-lembaga').val(data[0]['id_lembaga']);

		}
	})
})

$('a.d-anggaran').on('click', function () {
	let id_lembaga = $(this).data('id')
	let tahun = $(this).data('tahun')
	let kondisi = $(this).data('kondisi')
	$('.temp-anggaran').remove()
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_Skp/dataJumlahKegiatan/' + id_lembaga + '?kondisi=' + kondisi + '&tahun=' + tahun,
		method: 'get',
		dataType: 'json',
		success: function (data) {

			for (var i in data) {
				$('.anggaran-lembaga').append(`
					<tr class="temp-anggaran">
						<td></td>
						<td>` + data[i].nama_proker + `</td>
						<td>` + data[i].anggaran_kegiatan + `</td>
					</tr>
				
				`)
			}
		}
	})
})


// DASHBOARD
// For a pie chart


// akhir Dashboard
