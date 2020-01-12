var url = $(location).attr("href");
var segments = url.split("/");
$('.d-valid').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Publikasi/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(5)
})

$('.d-valid-rev').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Publikasi/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(5)
})

$('.detail-kegiatan').on('click', function () {
	let tipe_kegiatan = $(this).data('jenis');
	let id_kegiatan = $(this).data('id');
	if (tipe_kegiatan == 'proposal') {
		$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Publikasi/validasiProposal/' + id_kegiatan)
		$('.jenis_validasi').val(5)
	} else {
		$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Publikasi/validasiLpj/' + id_kegiatan)
		$('.jenis_validasi').val(5)
	}
})
