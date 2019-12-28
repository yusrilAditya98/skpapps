$('.d-valid').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Keuangan/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(6)
})

$('.d-valid-rev').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Keuangan/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(6)
})

$('.detail-kegiatan').on("click", function () {
	console.log('cek')
	let tipe_kegiatan = $(this).data('jenis');
	let id_kegiatan = $(this).data('id');
	if (tipe_kegiatan == 'proposal') {
		$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Keuangan/validasiProposal/' + id_kegiatan)
		$('.jenis_validasi').val(6)
	} else {
		$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Keuangan/validasiLpj/' + id_kegiatan)
		$('.jenis_validasi').val(6)
	}
})
