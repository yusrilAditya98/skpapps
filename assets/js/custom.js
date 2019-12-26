/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */
// cek detai revisian
var url = $(location).attr("href");
var segments = url.split("/");
$('.uang').mask('000.000.000', {
	reverse: true
});
$('.detail-revisi').on('click', function () {
	let id = $(this).data('id');
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/validasiKegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.d-tgl').val(data[0].tanggal_validasi)
			$('.d-reviewer').val(data[0].nama)
			$('.d-catatan').html(data[0].catatan_revisi)
		}
	})

})

$('.detail-kegiatan').on('click', function (e) {
	let id = $(this).data('id');
	let jenis = $(this).data('jenis')
	let dana = '';

	$('.s-dana').remove()
	$('.k-anggota').remove()
	$('.temp-class').remove()

	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/infoKegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.k-pengaju').val(data.kegiatan['nama_penanggung_jawab'])
			$('.k-nim').val(data.kegiatan['nama_lembaga'])
			$('.k-notlpn').val(data.kegiatan['no_whatsup'])
			$('.k-dana').val(data.kegiatan['dana_kegiatan'])
			if (jenis == 'proposal') {
				$('.k-dana-cair').val(data.kegiatan['dana_proposal'])
				$('.k-proposal').attr('href', segments[0] + '/' + segments[3] + '/assets/pdfjs/web/viewer.html?file=../../../file_bukti/proposal/' + data.kegiatan['proposal_kegiatan'])
				$('.k-berita-p').attr('href', segments[0] + '/' + segments[3] + '/assets/pdfjs/web/viewer.html?file=../../../file_bukti/berita_proposal/' + data.kegiatan['berita_proposal'])
				$('.k-gmbr-1').attr('href', segments[0] + '/' + segments[3] + '/file_bukti/foto_proposal/' + data.dokumentasi['d_proposal_1'])
				$('.k-gmbr-2').attr('href', segments[0] + '/' + segments[3] + '/file_bukti/foto_proposal/' + data.dokumentasi['d_proposal_2'])
			} else if (jenis == 'lpj') {
				$('.k-dana-cair').val(data.kegiatan['dana_lpj'])
				$('.k-proposal').attr('href', segments[0] + '/' + segments[3] + '/assets/pdfjs/web/viewer.html?file=../../../file_bukti/lpj/' + data.kegiatan['lpj_kegiatan'])
				$('.k-berita-p').attr('href', segments[0] + '/' + segments[3] + '/assets/pdfjs/web/viewer.html?file=../../../file_bukti/berita_lpj/' + data.kegiatan['berita_pelaporan'])
				$('.k-gmbr-1').attr('href', segments[0] + '/' + segments[3] + '/file_bukti/foto_lpj/' + data.dokumentasi['d_lpj_1'])
				$('.k-gmbr-2').attr('href', segments[0] + '/' + segments[3] + '/file_bukti/foto_lpj/' + data.dokumentasi['d_lpj_2'])
			}

			for (var i in data.dana) {
				dana += `<span class="s-dana">` + data.dana[i].nama_sumber_dana + `</span><br class="s-dana">`
			}
			$('.k-sumber').append(dana);
			$('.k-nama_kegiatan').val(data.kegiatan['nama_kegiatan'])
			$('.k-deskripsi_kegiatan').val(data.kegiatan['deskripsi_kegiatan'])
			$('.k-bidang_kegiatan').val(data.tingkat[0]['nama_bidang'])
			$('.k-jenis_kegiatan').val(data.tingkat[0]['jenis_kegiatan'])
			$('.k-tingkat_kegiatan').val(data.tingkat[0]['nama_tingkatan'])
			$('.k-tgl_kegiatan').val(data.kegiatan['tanggal_kegiatan'])
			$('.k-tempat').val(data.kegiatan['lokasi_kegiatan'])


			let index = 1;
			for (var j in data.tingkat) {
				$('.daftar-mhs').append(`
				<tr class="k-anggota">
					<td>` + (index++) + `</td>
					<td>` + data.tingkat[j].nim + `</td>
					<td>` + data.tingkat[j].nama + `</td>
					<td>` + data.tingkat[j].nama_prestasi + `</td>
				</tr>
				`)
			}
		}
	})
	copyDiv(e)


})

$(document).ready(function (e) {
	$('#dataTabelProposal').DataTable({
		initComplete: function () {
			var select;
			this.api().columns([2, 4]).every(function () {
				var column = this;
				select = $('<select class="form-control-sm selectric" ><option value="">pilih</option></select>')
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
		}
	});

});

$(document).ready(function (e) {
	$('#dataTabelKegiatan').DataTable({
		initComplete: function () {
			this.api().columns([3]).every(function () {
				var column = this;
				var select = $('<select class="form-control-sm selectric" tabindex="-1"><option value="">--pilih status--</option></select>')
					.appendTo($(column.footer()).empty())
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
		}
	});

});

function copyDiv(e) {

	let tombol = e.target
	let valid = (tombol.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling)

	let clnValid = valid.cloneNode(true);
	let cldrnvalid = clnValid.children;
	let tombolValid = cldrnvalid[0];


	if (tombolValid.textContent != 'Selesai' && tombolValid.textContent != 'Tidak bisa validasi' && tombolValid.textContent != 'Belum bisa validasi') {

		for (var i = 0; i < cldrnvalid.length; i++) {
			cldrnvalid[0].classList.add('temp-class')
			cldrnvalid[1].classList.add('temp-class')
			cldrnvalid[1].classList.add('cek-validasi')
			$('.t-validasi').append(cldrnvalid[0], cldrnvalid[1])
		}
	}
}


$(document).ready(function (e) {
	$('#dataTabelPoinSkp').DataTable({
		initComplete: function () {
			this.api().columns([3, 4, 6]).every(function () {
				var column = this;
				var select = $('<select class="form-control-sm" ><option value=""></option></select>')
					.appendTo($(column.footer()).empty())
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
		}
	});

});

let nama_lembaga = [];
let dana_pagu = [];
let dana_terserap = [];
let dana_sisa = [];
let data_lembaga = [];
let data_serapan = [];
let setDataSerapan = [];
let nama_label = ['Dana Pagu', 'Dana Terserap', 'Dana Sisa'];
$(document).ready(function () {
	let tahun = $('#tahun_anggran').val()
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/laporanSerapan/' + tahun,
		method: "get",
		dataType: "json",
		startTime: performance.now(),
		beforeSend: function (data) {

		},
		success: function (data) {

			let temp_pagu = [];
			let temp_sisa = [];

			for (var i in data) {
				nama_lembaga.push(data[i].nama_lembaga);
				dana_pagu.push(data[i].dana_pagu);

			}
			data_serapan[0] = dana_pagu;

			let anggaran = []
			for (var i in data) {
				dana_terserap.push(data[i].dana_terserap);

			}
			data_serapan[1] = dana_terserap;

			for (var i in data) {
				dana_sisa.push(data[i].dana_sisa);

			}
			data_serapan[2] = dana_sisa;


			let color = ["#2d98da", "#20bf6b", "#fd9644"];
			let count = 0;

			for (var i in nama_label) {
				setDataSerapan.push({
					label: nama_label[i],
					type: "bar",
					backgroundColor: color[i],
					data: data_serapan[i]
				})

			}

			const canvasAnggaran = document.querySelector("#laporan-serapan");
			const grafikAnggaran = canvasAnggaran.getContext("2d");
			if (canvasAnggaran) {
				new Chart(grafikAnggaran, {
					type: "bar",
					data: {
						labels: nama_lembaga,
						datasets: setDataSerapan
					},
					options: {
						responsive: false,
						maintainAspectRatio: false,
						layout: {
							padding: {
								left: 0,
								right: 0,
								top: 10,
								bottom: 0
							}
						},
						scales: {
							xAxes: [{
								time: {
									unit: "year"
								},
								gridLines: {
									display: true,
									drawBorder: false
								},
								ticks: {
									min: 2,
									max: 0,
									maxTicksLimit: 7
								},
								maxBarThickness: 70
							}],
							yAxes: [{
								ticks: {
									min: 0,
									max: 5000000,
									maxTicksLimit: 20,
									padding: 30
									// Include a dollar sign in the ticks
								},
								gridLines: {
									color: "rgb(220, 221, 225)",
									zeroLineColor: "rgb(234, 236, 244)",
									drawBorder: false,
									borderDash: [5, 5],
									zeroLineBorderDash: [2]
								}
							}]
						},
						legend: {
							display: true
						},
						tooltips: {
							titleMarginBottom: 10,
							titleFontColor: "#6e707e",
							titleFontSize: 14,
							backgroundColor: "rgb(255,255,255)",
							bodyFontColor: "#858796",
							borderColor: "#dddfeb",
							borderWidth: 1,
							xPadding: 1,
							yPadding: 6,
							displayColors: false,
							caretPadding: 10
						}
					}
				});
			}
		},
		error: function (data) {

		}
	});
});

"use strict";
