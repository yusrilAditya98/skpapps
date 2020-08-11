var url = $(location).attr("href");
var segments = url.split("/");


function detailSKP(nim) {
	let id = nim
	console.log(id)
	// Data Mahasiswa
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/get_detail_mahasiswa/' + id,
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
		url: segments[0] + '/' + segments[3] + '/API_skp/get_detail_skp/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			if (data.length != 0) {
				$('.body-skp').html('');
				var i = 0;
				data.forEach(function (dataA) {
					$('.body-skp').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama_kegiatan'] + `</td>
					<td>` + dataA['nama_prestasi'] + `</td>
					<td>` + dataA['nama_tingkatan'] + `</td>
					<td>` + dataA['jenis_kegiatan'] + `</td>
					<td>` + dataA['nama_bidang'] + `</td>
					<td>` + dataA['bobot'] + ` x ` + dataA['nilai_bobot'] + `</td>
					<td>` + (dataA['bobot'] * dataA['nilai_bobot']) + `</td>
                    </tr>`)
				})
			} else {
				$('.body-skp').html('');
				$('.body-skp').html(`
                <tr>
                   <td colspan="7">
                        <h3 class="text-center my-2">Belum ada SKP</h3>
                    </td>
                </tr>`);
			}
		}
	});

}


$(document).ready(function (e) {
	console.log($('#filter_jurusan').val())
	$('#dataTabelPoinSkp').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": segments[0] + '/' + segments[3] + '/kemahasiswaan/get_ajax',
			"type": "POST",
			"data": function (data) {
				data.jurusan = $('#filter_jurusan').val()
				data.prodi = $('#filter_prodi').val()
				data.kategori = $('#filter_kategori').val()
			}
		},
		"columnDefs": [{
			"targets": [0, 7],
			"orderable": false
		}]
	});

	$('#filter_jurusan').on('change', function () { //button filter event click
		console.log($('#filter_jurusan').val())
		$('#dataTabelPoinSkp').DataTable().ajax.reload(); //just reload table
	});
	$('#filter_prodi').on('change', function () { //button filter event click
		console.log($('#filter_prodi').val())
		$('#dataTabelPoinSkp').DataTable().ajax.reload(); //just reload table
	});
	$('#filter_kategori').on('change', function () { //button filter event click
		console.log($('#filter_kategori').val())
		$('#dataTabelPoinSkp').DataTable().ajax.reload(); //just reload table
	});

});

let nama_prestasi = [];
let jumlah_prestasi = [];

$(document).ready(function () {
	var tahun = $('#tahun_temp').val();
	var link = "";
	if (tahun == "") {
		link = segments[0] + '/' + segments[3] + '/Pimpinan/rekapitulasiSKPApi/';
	} else {
		link = segments[0] + '/' + segments[3] + '/Pimpinan/rekapitulasiSKPApi?tahun=' + tahun;
	}

	$.ajax({
		url: link,
		method: "get",
		dataType: "json",
		success: function (data) {

			var dataTampung = [];
			for (var i in data) {
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
			if (canvas) {
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
			}
		},
	});
});


$('.tabel-rekap').on('click', '.detail-rekap-skp', function () {
	let id = $(this).data('id');
	var tahun = $('#tahun_temp').val();
	var link = "";
	if (tahun == "") {
		link = segments[0] + '/' + segments[3] + '/Pimpinan/getRekapitulasiSKP?id_prestasi=' + id;
	} else {
		link = segments[0] + '/' + segments[3] + '/Pimpinan/getRekapitulasiSKP?id_prestasi=' + id + '&tahun=' + tahun;
	}

	$.ajax({
		url: link,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('#table-detail_wrapper').remove()
			$('#rekap-prestasi').append(`<table class="table table-striped table-bordered rekap-skp" id="table-detail">
			</table>`)
			if (data['mahasiswa'].length != 0) {
				console.log(data['mahasiswa'])
				var i = 0;
				let dataTampung = [];
				for (var j in data['mahasiswa']) {
					let temp = [];
					temp.push(++i)
					temp.push(data['mahasiswa'][j].nim)
					temp.push(data['mahasiswa'][j].nama)
					temp.push(data['prestasi']['nama_prestasi'])
					temp.push(data['mahasiswa'][j].nama_kegiatan)
					dataTampung[j] = temp;
				}
				$("#table-detail").DataTable({
					data: dataTampung,
					columns: [{
							title: "No"
						},
						{
							title: "Nim"
						},
						{
							title: "Nama"
						},
						{
							title: "Prestasi"
						},
						{
							title: "Nama Kegiatan"
						}
					]
				});
				$('#table-detail').attr('style', 0)


			} else if (data['mahasiswa'].length == 0) {
				$('#rekap-prestasi').append(`<h3 id="table-detail_wrapper" class="text-center my-2">Data Tidak Ada</h3>
				`)

			}
		}
	});
})

$('.tabel-tingkatan').on('click', '.detail-tingkat-skp', function () {
	let id = $(this).data('id');
	var tahun = $('#tahun_temp').val();
	var link = "";
	if (tahun == "") {
		link = segments[0] + '/' + segments[3] + '/Pimpinan/getRekapTingkatanSKP?id=' + id;
	} else {
		link = segments[0] + '/' + segments[3] + '/Pimpinan/getRekapTingkatanSKP?id=' + id + '&tahun=' + tahun;
	}

	$.ajax({
		url: link,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('#table-detail-rekap_wrapper').remove()
			$('#rekap-tingkatan').append(`<table class="table table-striped table-bordered rekap-skp" id="table-detail-rekap"></table>`)
			if (data.length != 0) {
				var i = 0;
				let dataTampung = [];
				for (var j in data) {
					let temp = [];
					temp.push(++i)
					temp.push(data[j].nim)
					temp.push(data[j].nama)
					temp.push(data[j].nama_tingkatan)
					temp.push(data[j].nama_kegiatan)
					dataTampung[j] = temp;
				}
				$("#table-detail-rekap").DataTable({
					data: dataTampung,
					columns: [{
							title: "No"
						},
						{
							title: "Nim"
						},
						{
							title: "Nama"
						},
						{
							title: "Tingkatan"
						},
						{
							title: "Nama Kegiatan"
						}
					]
				});
				$('#table-detail-rekap').attr('style', 0)


			} else {
				$('#rekap-tingkatan').append(`<h3 id="table-detail-rekap_wrapper" class="text-center my-2">Data Tidak Ada</h3>
				`)

			}
		}
	});
})
