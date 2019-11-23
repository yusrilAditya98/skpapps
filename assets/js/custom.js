/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */
// cek detai revisian
$('.detail-revisi').on('click', function () {
	let id = $(this).data('id');
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/validasiKegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.d-tgl').val(data[0].tanggal_validasi)
			$('.d-reviewer').val(data[0].nama)
			$('.d-catatan').html(data[0].catatan_revisi)
		}
	})

})

$('.detail-kegiatan').on('click', function () {
	let id = $(this).data('id');
	$('.s-dana').remove()
	$('.k-anggota').remove()
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/infoKegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data)
			$('.k-pengaju').val(data.kegiatan['nama_kegiatan'])
			$('.k-nim').val(data.kegiatan['id_penanggung_jawab'])
			$('.k-notlpn').val(data.kegiatan['no_whatsup'])
			$('.k-dana').val(data.kegiatan['dana_kegiatan'])
			let dana = '';
			for (var i in data.dana) {
				dana += `<span class="s-dana">` + data.dana[i].nama_sumber_dana + `</span><br>`
			}
			$('.k-sumber').append(dana);
			$('.k-nama_kegiatan').val(data.kegiatan['nama_kegiatan'])
			$('.k-deskripsi_kegiatan').val(data.kegiatan['deskripsi_kegiatan'])
			$('.k-bidang_kegiatan').val(data.tingkat[0]['nama_bidang'])
			$('.k-jenis_kegiatan').val(data.tingkat[0]['jenis_kegiatan'])
			$('.k-tingkat_kegiatan').val(data.tingkat[0]['nama_tingkatan'])
			$('.k-tgl_kegiatan').val(data.kegiatan['tanggal_kegiatan'])
			$('.k-tempat').val(data.kegiatan['lokasi_kegiatan'])
			$('.k-proposal').attr('href', segments[0] + '/skpapps/assets/pdfjs/web/viewer.html?file=../../../file_bukti/proposal/' + data.kegiatan['proposal_kegiatan'])
			$('.k-berita-p').attr('href', segments[0] + '/skpapps/assets/pdfjs/web/viewer.html?file=../../../file_bukti/berita_proposal/' + data.kegiatan['berita_proposal'])
			$('.k-gmbr-1').attr('href', segments[0] + '/skpapps/file_bukti/foto_proposal/' + data.dokumentasi['d_proposal_1'])
			$('.k-gmbr-2').attr('href', segments[0] + '/skpapps/file_bukti/foto_proposal/' + data.dokumentasi['d_proposal_2'])

			for (var j in data.tingkat) {
				$('.daftar-mhs').append(`
				<tr class="k-anggota">
					<td>` + (j) + `</td>
					<td>` + data.tingkat[j].nim + `</td>
					<td>` + data.tingkat[j].nama + `</td>
					<td>` + data.tingkat[j].nama_prestasi + `</td>
				</tr>
				`)
			}
		}
	})
})

"use strict";
