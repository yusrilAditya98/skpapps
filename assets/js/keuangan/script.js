var url = $(location).attr("href");
var segments = url.split("/");
$('.d-valid').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/skpapps/Keuangan/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(6)
})

$('.d-valid-rev').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/skpapps/Keuangan/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(6)
})
