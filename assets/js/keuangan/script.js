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


let nama_lembaga = [];
let dana_pagu = [];
let dana_terserap = [];
let data_lembaga = [];
let data_serapan = [];
let setDataSerapan = [];
let nama_label = ['Dana Pagu', 'Dana Sisa'];
$(document).ready(function () {
	let tahun = $('#tahun_anggran').val()
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/laporanSerapan/' + tahun,
		method: "get",
		dataType: "json",
		startTime: performance.now(),
		beforeSend: function (data) {

		},
		success: function (data) {
			console.log(data);
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
			console.log(nama_lembaga);
			let color = ["#2d98da", "#20bf6b"];
			let count = 0;

			for (var i in nama_label) {
				setDataSerapan.push({
					label: nama_label[i],
					type: "bar",
					backgroundColor: color[i],
					data: data_serapan[i]
				})

			}
			console.log(setDataSerapan);
			const canvasAnggaran = document.querySelector("#laporan-serapan");
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
		},
		error: function (data) {

		}
	});
});
