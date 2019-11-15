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
			$('.d-file').attr('href', segments[0] + '/skpapps/file_bukti/poinskp/' + data[0].file_bukti)
			$('.form-revisi').attr('action', segments[0] + '/skpapps/Kemahasiswaan/validasiSkp/' + data[0].id_poin_skp)
			$('.d-file').html(data[0].file_bukti)
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

// pdf
pdfjsLib.getDocument(segments[0] + '/skpapps/file_bukti/berita_proposal/cek2.pdf').then(doc => {
	console.log('this file has' + doc._pdfInfo.numPages + " pages");
	doc.getPage(1).then(page => {
		var myCanvas = document.getElementById('file_proposal');
		var context = myCanvas.getContext("2d");

		var viewPort = page.getViewport(1);
		myCanvas.width = viewPort.width;
		myCanvas.height = viewPort.height;

		page.render({
			canvasContext: context,
			viewPort: viewport
		})
	})
})
