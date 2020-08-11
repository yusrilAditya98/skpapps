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

function rubah(angka) {
	let new_format = 0;
	new_format = new Intl.NumberFormat('de-DE', {
		maximumSignificantDigits: 10
	}).format(angka)
	return new_format
}

function rubah_date(tanggal) {
	let current_datetime = "";
	current_datetime = tanggal;
	let formatted_date = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear()
	return formatted_date;
}

$('table').on('click', '.detail-revisi', function () {
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

// $('#id-beasiswa').on('change', function () {
// 	let beasiswa = $('#id-beasiswa').val()
// 	$.ajax({
// 		url: segments[0] + '/' + segments[3] + '/API_skp/beasiswa/' + beasiswa,
// 		method: 'get',
// 		dataType: 'json',
// 		success: function (data) {
// 			console.log(data)
// 			$('#namaInstansi').val(data.nama_instansi);
// 		}
// 	})
// })

$('table').on('click', '.detail-revisi-rancangan', function () {
	let catatan = $(this).data('catatan')
	$('.d-catatan').html(catatan)
})



$('.table').on('click', '.detail-kegiatan', function (e) {
	let id = $(this).data('id');
	let jenis = $(this).data('jenis');
	let dana = '';
	$('.s-dana').remove()
	$('.k-anggota').remove()
	$('.temp-class').remove()

	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/infoKegiatan/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.f-proposal').html(``)

			$('.k-pengaju').val(data.kegiatan['nama_penanggung_jawab'])
			$('.k-nim').val(data.kegiatan['nama_lembaga'])
			$('.k-notlpn').val(data.kegiatan['no_whatsup'])
			$('.k-dana').val(rubah(data.kegiatan['dana_kegiatan']))
			$('.k-nama_penyelenggara').val(data.kegiatan['nama_penyelenggara'])
			$('.k-url_penyelenggara').val(data.kegiatan['url_penyelenggara'])

			if (jenis == 'proposal') {
				$('.k-dana-cair').val(rubah(data.kegiatan['dana_proposal']))
				$('.k-proposal').attr('href', segments[0] + '/' + segments[3] + '/assets/pdfjs/web/viewer.html?file=../../../file_bukti/proposal/' + data.kegiatan['proposal_kegiatan'])
				$('.k-berita-p').attr('href', segments[0] + '/' + segments[3] + '/assets/pdfjs/web/viewer.html?file=../../../file_bukti/berita_proposal/' + data.kegiatan['berita_proposal'])
				$('.k-gmbr-1').attr('href', segments[0] + '/' + segments[3] + '/file_bukti/foto_proposal/' + data.dokumentasi['d_proposal_1'])
				$('.k-gmbr-2').attr('href', segments[0] + '/' + segments[3] + '/file_bukti/foto_proposal/' + data.dokumentasi['d_proposal_2'])
			} else if (jenis == 'lpj') {
				$('.f-proposal').html(`<label for="danaKegiatanDiterima">Anggran Proposal</label>
				<input type="text" class="form-control k-dana-proposal" id="danaProposal" value="` + rubah(data.kegiatan['dana_proposal']) + `" readonly>`);
				$('.k-dana-cair').val(rubah(data.kegiatan['dana_lpj']))
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
			$('.k-tgl_selesai_kegiatan').val(data.kegiatan['tanggal_selesai_kegiatan'])
			$('.k-tempat').val(data.kegiatan['lokasi_kegiatan'])


			let index = 1;
			if (data.kegiatan['id_lembaga'] == 0 && jenis == 'proposal') {
				$('.th-posisi').hide()
				$('.th-bobot').hide()
			} else {
				$('.th-posisi').show()
				$('.th-bobot').show()
			}
			for (var j in data.tingkat) {
				let keaktifan = "";
				if (data.tingkat[j].keaktifan == 0) {
					keaktifan = "Tidak Aktif"
				} else {
					keaktifan = "Aktif";
				}
				if (data.kegiatan['id_lembaga'] == 0 && jenis == 'proposal') {
					$('.daftar-mhs').append(`
					<tr class="k-anggota">
						<td>` + (index++) + `</td>
						<td>` + data.tingkat[j].nim + `</td>
						<td>` + data.tingkat[j].nama + `</td>
						<td>` + data.tingkat[j].nama_jurusan + `</td>
						<td>` + data.tingkat[j].nama_prodi + `</td>
						<td>` + keaktifan + `</td>
					</tr>
					`)
				} else {
					$('.daftar-mhs').append(`
					<tr class="k-anggota">
						<td>` + (index++) + `</td>
						<td>` + data.tingkat[j].nim + `</td>
						<td>` + data.tingkat[j].nama + `</td>
						<td>` + data.tingkat[j].nama_jurusan + `</td>
						<td>` + data.tingkat[j].nama_prodi + `</td>
						<td>` + data.tingkat[j].nama_prestasi + `</td>
						<td>` + data.tingkat[j].bobot + `</td>
						<td>` + keaktifan + `</td>
					</tr>
					`)
				}
			}
		}
	})

	copyDiv(e)

})




$(document).ready(function (e) {

	$('#table-user').DataTable({
		initComplete: function () {
			var select;
			this.api().columns([3, 4]).every(function () {
				var column = this;
				select = $('<select class="form-control-sm" ><option value="">pilih</option></select>')
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

$(document).ready(function (e) {
	$('#dataTabelKegiatan').DataTable({
		aLengthMenu: [
			[10, 50, 100, 200, -1],
			[10, 50, 100, 200, "All"]
		],
		initComplete: function () {
			var select;
			this.api().columns([3]).every(function () {
				var column = this;
				select = $('<select class="form-control-sm"><option value="">--- status ---</option></select>')
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
	$('.tahun-serapan').html(tahun)

	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/laporanSerapan/' + tahun,
		method: "get",
		dataType: "json",
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
			if (canvasAnggaran) {
				const grafikAnggaran = canvasAnggaran.getContext("2d");
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
									max: 100000000,
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

$(document).ready(function () {
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/penyebaranSkp/',
		method: "get",
		dataType: "json",
		startTime: performance.now(),
		success: function (data) {
			let skp = data['poin_skp'];
			var data = {
				datasets: [{
					data: [skp['kurang'][0].jumlah, skp['cukup'][0].jumlah, skp['baik'][0].jumlah, skp['sangat_baik'][0].jumlah, skp['dengan_pujian'][0].jumlah],
					backgroundColor: [
						"#fc544b",
						"#f9ca24",
						"#2d98da",
						"#20bf6b",
						"#e056fd",
					],

				}],
				// These labels appear in the legend and in the tooltips when hovering different arcs
				labels: [
					'Kurang',
					'Cukup',
					'Baik',
					'Sangat Baik',
					'Dengan Pujian'
				],

			};

			const canvas_kmhs = document.querySelector("#sebaran-skp");
			if (canvas_kmhs) {
				const ctx = canvas_kmhs.getContext("2d");
				new Chart(ctx, {
					type: 'doughnut',
					data: data,
					options: {
						legend: {
							position: "bottom",

							display: true
						},
					}

				});
			}

		}
	})


})

$(document).ready(function () {
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/kegiatanAkademik/',
		method: "get",
		dataType: "json",
		startTime: performance.now(),
		success: function (data) {
			let ka = data['kegiatan_akademik'];
			var data = {
				datasets: [{
					data: [ka['belum_terlaksana'][0].jumlah, ka['sedang_terlaksana'][0].jumlah, ka['sudah_terlaksana'][0].jumlah],
					backgroundColor: [
						"#fc544b",
						"#f9ca24",
						"#2d98da",
					],
				}],
				// These labels appear in the legend and in the tooltips when hovering different arcs
				labels: [
					'Belum Terlaksana',
					'Sedang Terlaksana',
					'Sudah Terlaksana',
				],
			};
			const canvas_kmhs = document.querySelector("#kegiatan-akademik");
			if (canvas_kmhs) {
				const ctx = canvas_kmhs.getContext("2d");
				new Chart(ctx, {
					type: 'doughnut',
					data: data,
					options: {
						legend: {
							position: "bottom",

							display: true
						},
					}

				});
			}
		}
	})
})

$(document).ready(function () {
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/pesertaKegiatanAkademik/',
		method: "get",
		dataType: "json",
		startTime: performance.now(),
		success: function (data) {
			let ka = data['peserta_kegiatan_akademik'];
			var data = {
				datasets: [{
					data: [ka['tidak_hadir'][0].jumlah, ka['hadir'][0].jumlah],
					backgroundColor: [
						"#fc544b",
						"#2d98da",
					],
				}],
				// These labels appear in the legend and in the tooltips when hovering different arcs
				labels: [
					'Peserta Tidak Hadir',
					'Peserta Hadir',
				],
			};
			const canvas_kmhs = document.querySelector("#peserta-kegiatan-akademik");
			if (canvas_kmhs) {
				const ctx = canvas_kmhs.getContext("2d");
				new Chart(ctx, {
					type: 'doughnut',
					data: data,
					options: {
						legend: {
							position: "bottom",

							display: true
						},
					}

				});
			}
		}
	})
})

$(document).ready(function () {
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/rekapUser/',
		method: "get",
		dataType: "json",
		startTime: performance.now(),
		success: function (data) {
			let ru = data['rekap_user'];
			var data = {
				datasets: [{
					data: [ru['mahasiswa'][0].jumlah, ru['lembaga'][0].jumlah, ru['pimpinan'][0].jumlah, ru['karyawan'][0].jumlah],
					backgroundColor: [
						"#fc544b",
						"#f9ca24",
						"#2d98da",
						"#20bf6b"
					],
				}],
				// These labels appear in the legend and in the tooltips when hovering different arcs
				labels: [
					'Mahasiswa',
					'Lembaga',
					'Pimpinan',
					'Karyawan (Kemahasiswaan & Akademik & Keuangan & PSIK & Admin)',
				],
			};
			const canvas_kmhs = document.querySelector("#rekap-user");
			if (canvas_kmhs) {
				const ctx = canvas_kmhs.getContext("2d");
				new Chart(ctx, {
					type: 'doughnut',
					data: data,
					options: {
						legend: {
							position: "bottom",

							display: true
						},
					}

				});
			}
		}
	})
})


$('table').on('click', '.laporan-serapan', function () {
	const id_lembaga = $(this).data('id')
	const tahun = $(this).data('tahun')

	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/detaillaporanSerapan/?id_lembaga=' + id_lembaga + '&&tahun=' + tahun,
		method: "get",
		dataType: "json",
		beforeSend: function () {
			$('.table-detail-serapan').append(` <div class="loader">
			<img src="` + segments[0] + '/' + segments[3] + `/assets/img/loader.gif" alt="">
			</div>`)
		},
		success: function (data) {
			$('.loader').remove();
			$('.table-detail-serapan').html('')
			$('.total-anggaran').html('')
			$('.total-terserap').html('')
			let rowTahun = ""
			let trSerapan = ''
			let tdSerapan = ''
			let indek = 1;
			data['kegiatan'].forEach(element => {
				trSerapan += `<tr id="tr-` + element.nama_kegiatan + `">`
				tdSerapan = '';
				rowTahun = ""
				for (let index = 1; index < 13; index++) {
					rowTahun += "<td>" + rubah(data['laporan'][element.id_kegiatan][index]) + "</td>"
				}
				tdSerapan = `<td>` + (indek++) + `</td><td>` + element.nama_kegiatan + `</td>` + rowTahun + `<td>` + rubah(data['laporan'][element.id_kegiatan]['anggaran_kegiatan']) + `</td><td>` + rubah(data['laporan'][element.id_kegiatan]['dana_terserap']) + `</td>`
				trSerapan += tdSerapan
				trSerapan += "</tr>"
			});
			$('.table-detail-serapan').html(trSerapan)
			$('.total-anggaran').html(rubah(data['total']['total']['anggaran_kegiatan']))
			$('.total-terserap').html(rubah(data['total']['total']['dana_terserap']))

		}
	})


})
const id_lembaga_d = 0
const tahun_d = $('#tahun_anggran').val()
$.ajax({
	url: segments[0] + '/' + segments[3] + '/API_skp/detaillaporanSerapan/?id_lembaga=' + id_lembaga_d + '&&tahun=' + tahun_d,
	method: "get",
	dataType: "json",
	beforeSend: function () {
		$('.table-detail-delegasi').append(` <div class="loader">
		<img src="` + segments[0] + '/' + segments[3] + `/assets/img/loader.gif" alt="">
		</div>`)
	},
	success: function (data) {
		$('.loader').remove();
		$('.table-detail-delegasi').html('')
		$('.total-anggaran-delegasi').html('')
		$('.total-terserap-delegeasi').html('')
		let rowTahun = ""
		let trSerapan = ''
		let tdSerapan = ''
		let indek = 1;
		data['kegiatan'].forEach(element => {
			trSerapan += `<tr id="tr-` + element.nama_kegiatan + `">`
			tdSerapan = '';
			rowTahun = ""
			for (let index = 1; index < 13; index++) {
				rowTahun += "<td>" + rubah(data['laporan'][element.id_kegiatan][index]) + "</td>"
			}
			tdSerapan = `<td>` + (indek++) + `</td><td>` + element.nama_kegiatan + `</td>` + rowTahun + `<td>` + rubah(data['laporan'][element.id_kegiatan]['anggaran_kegiatan']) + `</td><td>` + rubah(data['laporan'][element.id_kegiatan]['dana_terserap']) + `</td>`
			trSerapan += tdSerapan
			trSerapan += "</tr>"
		});
		$('.table-detail-delegasi').html(trSerapan)
		$('.total-anggaran-delegasi').html(rubah(data['total']['total']['anggaran_kegiatan']))
		$('.total-terserap-delegasi').html(rubah(data['total']['total']['dana_terserap']))

	}
})


$('table').on('click', '.edit-file', function () {
	let id = $(this).data('id')
	let nama = $(this).data('nama')
	let dir = $(this).data('dir')
	let status = $(this).data('status')
	let lihat = $(this).data('lihat')
	$('#id_file_edit').val(id)
	$('#nama_file_edit').val(nama)
	$('#file_edit').attr('href', segments[0] + '/' + segments[3] + '/file_bukti/file_download/' + dir)
	$('#dir_lama').val(dir)
	if (status == 'panduan') {
		$('#status_file_edit').html(`
		<option selected value="panduan">panduan</option>
		<option value="template">template</option>`)
	} else {
		$('#status_file_edit').html(`
		<option value="panduan">panduan</option>
		<option selected value="template">template</option>`)
	}

	if (lihat == 'all') {
		$('#dilihat_oleh_edit').html(`  <option selected value="all">semua</option>
		<option value="mahasiswa">mahasiswa</option>
		<option value="lembaga">lembaga</option>
		<option value="bem">bem</option>
		<option value="kemahasiswaan">kemahasiswaan</option>
		<option value="psik">psik</option>
		<option value="keuangan">keuangan</option>`)
	} else if (lihat == 'mahasiswa') {
		$('#dilihat_oleh_edit').html(`  <option  value="all">semua</option>
		<option selected value="mahasiswa">mahasiswa</option>
		<option value="lembaga">lembaga</option>
		<option value="bem">bem</option>
		<option value="kemahasiswaan">kemahasiswaan</option>
		<option value="psik">psik</option>
		<option value="keuangan">keuangan</option>`)
	} else if (lihat == 'lembaga') {
		$('#dilihat_oleh_edit').html(`  <option  value="all">semua</option>
		<option value="mahasiswa">mahasiswa</option>
		<option selected value="lembaga">lembaga</option>
		<option value="bem">bem</option>
		<option value="kemahasiswaan">kemahasiswaan</option>
		<option value="psik">psik</option>
		<option value="keuangan">keuangan</option>`)
	} else if (lihat == 'bem') {
		$('#dilihat_oleh_edit').html(`  <option  value="all">semua</option>
		<option value="mahasiswa">mahasiswa</option>
		<option value="lembaga">lembaga</option>
		<option selected value="bem">bem</option>
		<option value="kemahasiswaan">kemahasiswaan</option>
		<option value="psik">psik</option>
		<option value="keuangan">keuangan</option>`)
	} else if (lihat == 'kemahasiswaan') {
		$('#dilihat_oleh_edit').html(`  <option  value="all">semua</option>
		<option value="mahasiswa">mahasiswa</option>
		<option value="lembaga">lembaga</option>
		<option value="bem">bem</option>
		<option selected value="kemahasiswaan">kemahasiswaan</option>
		<option value="psik">psik</option>
		<option value="keuangan">keuangan</option>`)
	} else if (lihat == 'psik') {
		$('#dilihat_oleh_edit').html(`  <option  value="all">semua</option>
		<option value="mahasiswa">mahasiswa</option>
		<option value="lembaga">lembaga</option>
		<option value="bem">bem</option>
		<option value="kemahasiswaan">kemahasiswaan</option>
		<option selected value="psik">psik</option>
		<option value="keuangan">keuangan</option>`)
	} else if (lihat == 'keuangan') {
		$('#dilihat_oleh_edit').html(`  <option  value="all">semua</option>
		<option  value="mahasiswa">mahasiswa</option>
		<option value="lembaga">lembaga</option>
		<option value="bem">bem</option>
		<option value="kemahasiswaan">kemahasiswaan</option>
		<option value="psik">psik</option>
		<option selected value="keuangan">keuangan</option>`)
	} else {
		$('#dilihat_oleh_edit').html(`  <option  value="all">semua</option>
		<option  value="mahasiswa">mahasiswa</option>
		<option value="lembaga">lembaga</option>
		<option value="bem">bem</option>
		<option value="kemahasiswaan">kemahasiswaan</option>
		<option value="psik">psik</option>
		<option value="keuangan">keuangan</option>`)
	}
})


"use strict";
