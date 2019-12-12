var url = $(location).attr("href");
var segments = url.split("/");

if (segments[4] == "Pimpinan") {
	$(window).on('load', function () {
		// $('.dataTables_filter').prepend(`
		// <select class="custom-select col-lg-4 mr-2 filter-status" id="filter-status">

		// </select>`);
		// $.ajax({
		// 	url: segments[0] + '/skpapps/Admin/getProfilUser',
		// 	dataType: 'json',
		// 	type: 'get',
		// 	success: function (profil) {
		// 		console.log(profil);
		// 		profil.forEach(function (profilu) {
		// 			$('#filter-status').append(`<option value="` + profilu['jenis_user'] + `">` + profilu['jenis_user'] + `</option>`)
		// 		})
		// 	}
		// });
	})
}

$('#table-1').on('click', '.detail-SKP', function () {
	let id = $(this).data('id');

	// Data Mahasiswa
	$.ajax({
		url: segments[0] + '/skpapps/pimpinan/get_detail_mahasiswa/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.nama_mahasiswa').html("Nama : " + data['nama']);
			$('.nim_mahasiswa').html("NIM   : " + data['nim']);
			$('.prodi_mahasiswa').html("Prodi   : " + data['nama_prodi']);
		}
	});

	// Data SKP
	// console.log(id);
	$.ajax({
		url: segments[0] + '/skpapps/pimpinan/get_detail_skp/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			if (data.length != 0) {
				$('.body-skp').html('');
				var i = 0;
				data.forEach(function (dataA) {
					$('.body-skp').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama_prestasi'] + `</td>
					<td>` + dataA['nama_tingkatan'] + `</td>
					<td>` + dataA['jenis_kegiatan'] + `</td>
					<td>` + dataA['nama_bidang'] + `</td>
					<td>` + dataA['bobot'] + `</td>
                    </tr>`)
				})
			} else {
				$('.body-skp').html('');
				$('.body-skp').html(`
                <tr>
                   <td colspan="6">
                        <h3 class="text-center my-2">Belum ada SKP</h3>
                    </td>
                </tr>`);
			}
		}
	});

})

$('.tabel-rekap').on('click', '.detail-rekap-skp', function () {
	let id = $(this).data('id');

	$.ajax({
		url: segments[0] + '/skpapps/pimpinan/getRekapitulasiSKP/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			if (data['mahasiswa'].length != 0) {
				$('.body-rekap-skp').html('');
				var i = 0;
				data['mahasiswa'].forEach(function (dataA) {
					$('.body-rekap-skp').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nim'] + `</td>
					<td>` + dataA['nama'] + `</td>
					<td>` + data['prestasi']['nama_prestasi'] + `</td>
					<td>` + dataA['nama_kegiatan'] + `</td>
                    </tr>`)
				})
			} else {
				$('.body-rekap-skp').html('');
				$('.body-rekap-skp').html(`
                <tr>
                   <td colspan="6">
                        <h3 class="text-center my-2">Tidak Ada</h3>
                    </td>
                </tr>`);
			}
		}
	});

})

let nama_prestasi = [];
let jumlah_prestasi = [];


$(document).ready(function () {
	$.ajax({
		url: segments[0] + '/skpapps/pimpinan/rekapitulasiSKPApi/',
		method: "get",
		dataType: "json",
		success: function (data) {
			// console.log(data);
			for (var i in data) {
				var dataTampung = [];
				nama_prestasi.push(data[i].nama_prestasi);
				jumlah_prestasi.push(data[i].jumlah);
			}

			dataTampung.push({
				label: "Juara",
				type: "bar",
				borderColor: "#FF0606",
				data: jumlah_prestasi,
				borderDashOffset: 1,
				fill: false,
				spanGaps: true,
				backgroundColor: "#e74c3c"
			});

			const canvas = document.querySelector("#rekap-skp-chart");
			const ctx = canvas.getContext("2d");
			new Chart(ctx, {
				type: "bar",
				data: {
					labels: nama_prestasi,
					datasets: dataTampung
				},
				options: {
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
								max: 10,
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
					annotation: {
						annotations: [{
								type: "box",
								yScaleID: "y-axis-0",
								yMin: 0,
								yMax: 4,
								borderColor: "rgba(255, 51, 51, 0.1",
								borderWidth: 2,
								backgroundColor: "rgba(255, 51, 51, 0.1)"
							},
							{
								type: "box",
								yScaleID: "y-axis-0",
								yMin: 4,
								yMax: 7,
								borderColor: "rgba(255, 255, 0, 0.1)",
								borderWidth: 1,
								backgroundColor: "rgba(255, 255, 0, 0.1)"
							},
							{
								type: "box",
								yScaleID: "y-axis-0",
								yMin: 7,
								yMax: 10,
								borderColor: "rgba(0, 204, 0, 0.1)",
								borderWidth: 1,
								backgroundColor: "rgba(0, 204, 0, 0.1)"
							}
						]
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
	});
});
