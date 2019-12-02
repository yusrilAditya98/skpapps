var url = $(location).attr("href");
var segments = url.split("/");

$('.detailSkp').on("click", function () {
	let id_skp = $(this).data('id');
	$.ajax({
		url: segments[0] + '/skpapps/Kemahasiswaan/detailKegiatan/' + id_skp,
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
			$('.form-revisi').attr('action', segments[0] + '/skpapps/Kemahasiswaan/validasiSkp/' + data[0].id_poin_skp)
			$('.d-file').attr('href', segments[0] + '/skpapps/assets/pdfjs/web/viewer.html?file=../../../file_bukti/' + data[0].file_bukti)
		}
	})
})

$('.d-revisi').on("click", function () {
	let id_skp = $(this).data('skp');

	$.ajax({
		url: segments[0] + '/skpapps/Kemahasiswaan/detailKegiatan/' + id_skp,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/skpapps/Kemahasiswaan/validasiSkp/' + data[0].id_poin_skp)
			$('.d-catatan').val(data[0].catatan)
		}
	})
})

$('.d-valid-km').on("click", function () {

	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/skpapps/Kemahasiswaan/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(3)

})
$('.d-valid').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/skpapps/Kemahasiswaan/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(4)
})

$('.d-valid-km-lpj').on("click", function () {

	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/skpapps/Kemahasiswaan/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(3)

})
$('.d-valid-lpj').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/skpapps/Kemahasiswaan/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(4)
})

$('.tambahAnggaran').on('click', function () {
	$('.d-lembaga').remove()
	$.ajax({
		url: segments[0] + '/skpapps/API_Skp/dataLembaga/',
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
