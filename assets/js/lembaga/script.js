let totalAnggaran = $('.total-anggaran').html();
$('.t-anggaran').val(totalAnggaran)


var url = $(location).attr("href");
var segments = url.split("/");

$('.d-valid').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kegiatan/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(2)
})

$('.d-valid-rev').on("click", function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kegiatan/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(2)
})



let nominal = $('#danaKegiatan').val() * 0.7
let nominalLpj = $('#danaKegiatanLpj').val() * 0.3
$('#danaKegiatanDiterima').val(nominal)
$('#danaKegiatanDiterimaLpj').val(nominalLpj)
$.ajax({
	url: segments[0] + '/' + segments[3] + '/API_skp/bidangKegiatan',
	method: 'get',
	dataType: 'json',
	success: function (data) {

		let k_bidang = $('.k_bidang').val();
		let bidang = '';
		for (var i in data) {
			if (k_bidang == data[i].id_bidang) {
				bidang += `<option selected class="bidang" value="` + data[i].id_bidang + `">` + data[i].nama_bidang + `</option>`
			} else {
				bidang += `<option class="bidang" value="` + data[i].id_bidang + `">` + data[i].nama_bidang + `</option>`
			}
		}

		$('.bidangKegiatan').append(bidang)

		let bidangKegiatan = $('.bidangKegiatan').val()
		$('.jenis').remove();
		if (bidangKegiatan) {
			$.ajax({
				url: segments[0] + '/' + segments[3] + '/API_skp/jenisKegiatan/' + bidangKegiatan,
				method: 'get',
				dataType: 'json',
				success: function (data) {
					let k_jenis = $('.k_jenis').val();
					let jenis = '';

					for (var i in data) {
						if (k_jenis == data[i].id_jenis_kegiatan) {
							jenis += `<option selected class="jenis" value="` + data[i].id_jenis_kegiatan + `">` + data[i].jenis_kegiatan + `</option>`
						} else {
							jenis += `<option class="jenis" value="` + data[i].id_jenis_kegiatan + `">` + data[i].jenis_kegiatan + `</option>`
						}
					}
					$('.jenisKegiatan').append(jenis)

					let jenisKegiatan = $('.jenisKegiatan').val()
					$('.tingkat').remove();
					$.ajax({
						url: segments[0] + '/' + segments[3] + '/API_skp/tingkatKegiatan/' + jenisKegiatan,
						method: 'get',
						dataType: 'json',
						success: function (data) {
							let k_tingkat = $('.k_tingkat').val();
							let tingkat = '';
							for (var i in data) {
								if (k_tingkat == data[i].id_semua_tingkatan) {
									tingkat += `<option selected class="tingkat" value="` + data[i].id_semua_tingkatan + `">` + data[i].nama_tingkatan + `</option>`
								} else {
									tingkat += `<option class="tingkat" value="` + data[i].id_semua_tingkatan + `">` + data[i].nama_tingkatan + `</option>`
								}

							}
							$('.tingkatKegiatan').append(tingkat)

							let tingkatKegiatan = $('.tingkatKegiatan').val()
							$('.partisipasi').remove();
							$.ajax({
								url: segments[0] + '/' + segments[3] + '/API_skp/partisipasiKegiatan/' + tingkatKegiatan,
								method: 'get',
								dataType: 'json',
								success: function (data) {

									let partisipasi = '';
									let k_partisipasi = $('.k_partisipasi').val();
									for (var i in data) {
										if (k_partisipasi == data[i].id_semua_prestasi) {
											partisipasi += `<option checked class="partisipasi" value="` + data[i].id_semua_prestasi + `">` + data[i].nama_prestasi + `</option>`
										} else {
											partisipasi += `<option class="partisipasi" value="` + data[i].id_semua_prestasi + `">` + data[i].nama_prestasi + `</option>`
										}
									}
									$('.partisipasiKegiatan').append(partisipasi)
								}
							})
						}
					})
				}
			})
		}
	}
})

$('.bidangKegiatan').on("change", function () {
	let bidangKegiatan = $('.bidangKegiatan').val()
	$('.jenis').remove();
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/jenisKegiatan/' + bidangKegiatan,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			let k_jenis = $('.k_jenis').val();
			let jenis = '';
			for (var i in data) {
				if (k_jenis == data[i].id_jenis_kegiatan) {
					jenis += `<option selected class="jenis" value="` + data[i].id_jenis_kegiatan + `">` + data[i].jenis_kegiatan + `</option>`
				} else {
					jenis += `<option class="jenis" value="` + data[i].id_jenis_kegiatan + `">` + data[i].jenis_kegiatan + `</option>`
				}
			}
			$('.jenisKegiatan').append(jenis)
		}
	})
})

$('.jenisKegiatan').on("change", function () {
	let jenisKegiatan = $('.jenisKegiatan').val()
	$('.tingkat').remove();
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/tingkatKegiatan/' + jenisKegiatan,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			let k_tingkat = $('.k_tingkat').val();
			let tingkat = '';
			for (var i in data) {
				if (k_tingkat == data[i].id_semua_tingkatan) {
					tingkat += `<option selected class="tingkat" value="` + data[i].id_semua_tingkatan + `">` + data[i].nama_tingkatan + `</option>`
				} else {
					tingkat += `<option class="tingkat" value="` + data[i].id_semua_tingkatan + `">` + data[i].nama_tingkatan + `</option>`
				}

			}
			$('.tingkatKegiatan').append(tingkat)
		}
	})
})

var cek = [];
$('.tingkatKegiatan').on('change', function () {
	$('.dataTables_wrapper').remove()
})
$('.daftarMahasiswa').on("click", function () {
	let tingkatKegiatan = $('.tingkatKegiatan').val()
	cek = tingkatKegiatan;
	$('.dataTables_wrapper').remove()
	$('.partisipasi').remove()
	if (tingkatKegiatan != 0) {
		$('.notice-mhs').remove()
		$('.table-mhs').append(`<table class="table table-striped table-mahasiswa"></table>`)
		$.ajax({
			url: segments[0] + '/' + segments[3] + '/API_skp/partisipasiKegiatan/' + tingkatKegiatan,
			method: 'get',
			dataType: 'json',
			success: function (data) {
				let partisipasi = "";
				partisipasi += `<select class="custom-select partisipasiKegiatan" name="partisipasiKegiatan" id="partisipasiKegiatan" required>`
				for (var i in data) {
					partisipasi += `<option class="partisipasi" value="` + data[i].id_semua_prestasi + `">` + data[i].nama_prestasi + `</option>`
				}
				partisipasi += `</select>`;
				let id_kegiatan;
				if (segments[6]) {
					id_kegiatan = segments[6]
				}
				$.ajax({
					url: segments[0] + '/' + segments[3] + '/API_skp/dataMahasiswa/?id=' + id_kegiatan,
					method: 'get',
					dataType: 'json',
					beforeSend: function () {
						$('.table-mhs').append(` <div class="loader">
                        <img src="` + segments[0] + '/' + segments[3] + `/assets/img/loader.gif" alt="">
                        </div>`)
					},
					success: function (data) {
						$('.loader').remove()
						let dataTampung = [];
						let index = 1;
						let dataMhs = data['mhs']
						let mhs = data['mhs_kegiatan']
						let bkn_anggota = data['bkn_mhs_kegiatan'];
						for (var k in mhs) {
							for (var j in dataMhs) {
								if (mhs[k].nim == dataMhs[j].nim) {
									let temp = [];
									temp.push(index++)
									temp.push(`<span id="t-nim-` + dataMhs[j].nim + `">` + dataMhs[j].nim + `</span>`)
									temp.push(`<span id="t-nama-` + dataMhs[j].nim + `">` + dataMhs[j].nama + `</span>`)
									temp.push(`<span id="t-prestasi-` + dataMhs[j].nim + `">` + partisipasi + `</span>`)
									temp.push(`<span id="t-cek-` + dataMhs[j].nim + `"><input checked type="checkbox" class="cek" id="checkbox` + dataMhs[j].nim + `"></span>`)
									dataTampung.push(temp);
								}
							}
						}
						for (var j in bkn_anggota) {
							let temp = [];
							temp.push(index++)
							temp.push(`<span id="t-nim-` + bkn_anggota[j].nim + `">` + bkn_anggota[j].nim + `</span>`)
							temp.push(`<span id="t-nama-` + bkn_anggota[j].nim + `">` + bkn_anggota[j].nama + `</span>`)
							temp.push(`<span id="t-prestasi-` + bkn_anggota[j].nim + `">` + partisipasi + `</span>`)
							temp.push(`<span id="t-cek-` + bkn_anggota[j].nim + `"><input type="checkbox" class="cek" id="checkbox` + bkn_anggota[j].nim + `"></span>`)
							dataTampung.push(temp);
						}
						$('.table-mahasiswa').DataTable({
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
									title: "Action"
								}
							]
						})
					}
				})
			}
		})
	} else {
		$('.table-mhs').append(`<h2 class="notice-mhs">Anda Belum Memilih Tingkat Kegiatan !</h2>`)
	}
})

$('#partisipasiKegiatan').on("change", function () {
	let partisipasiKegiatan = $('.partisipasiKegiatan').val()
	$('#bobotKegiatan').val(0);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/bobotkegiatan/' + partisipasiKegiatan,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('#bobotKegiatan').val(data[0].bobot);
		}
	})
})


$('.d-revisi').on('click', function () {
	let id_skp = $(this).data('id');
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/detailKegiatan/' + id_skp,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.d-catatan').html(data[0].catatan)
		}
	})
})


let jumlahAnggota = $('#jumlahAnggota').val();
// Menampilkan daftar selurh mahasiswa
$('.submit-mhs').on('click', function () {

	let nim = []
	let nama = []
	let posisi = []
	let valPosisi = []
	let check = []
	let oMhs = []
	let aMhs = []
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/daftarMahasiswa',
		method: 'get',
		dataType: 'json',
		success: function (data) {
			for (var i in data) {

				nim.push($('#t-nim-' + data[i].nim).text());
				nama.push($('#t-nama-' + data[i].nim).text());
				posisi.push($('#t-prestasi-' + data[i].nim + ' .partisipasiKegiatan option:selected').text());
				valPosisi.push($('#t-prestasi-' + data[i].nim + ' .partisipasiKegiatan option:selected').val());
				check.push($('#checkbox' + data[i].nim).is(":checked"));
			}
			for (var j in data) {
				if (check[j] == true && valPosisi[j] != 0) {
					oMhs = [];
					oMhs.push(nim[j]);
					oMhs.push(nama[j]);
					oMhs.push(posisi[j]);
					oMhs.push(valPosisi[j]);
					aMhs.push(oMhs);
				}
			}

			let id = 1;
			if (jumlahAnggota != 0) {
				id = parseInt(jumlahAnggota) + 1;
			}
			for (var k in aMhs) {
				$('.d-m#data-' + aMhs[k][0] + '').remove()
				$('.daftar-mhs').append(`
					<tr class="d-m" id="data-` + aMhs[k][0] + `">
						<td>` + (id) + `</td>
						<td>` + aMhs[k][0] + `
							<input  type="hidden" name="nim_` + aMhs[k][0] + `" value="` + aMhs[k][0] + `" id="nim_` + aMhs[k][0] + `" >
						</td>
						<td>` + aMhs[k][1] + `</td>
						<td>` + aMhs[k][2] + `
							<input  type="hidden" name="prestasi_` + aMhs[k][0] + `" value="` + aMhs[k][3] + `" id="nim_` + aMhs[k][0] + `" >
						</td>
						<td> <button onclick="myFunction(` + aMhs[k][0] + `)" type="button" data-id="` + aMhs[k][0] + `" class="btn btn-danger hps-mhs-1"><i class="fas fa-trash-alt"></i></></td>
					</tr>
				`)
				id++
			}
			jumlahAnggota = cekJumlahAnggota();
			$('#jumlahAnggota').val(jumlahAnggota);

		}
	})
})


function cekJumlahAnggota() {
	let jumlah = document.querySelectorAll(".d-m")
	return jumlah.length;
}

function myFunction(nim) {
	$('.d-m#data-' + nim + '').remove()
	$('#jumlahAnggota').val(jumlahAnggota - 1);
	jumlahAnggota = $('#jumlahAnggota').val();
}

$('.hps-mhs').on('click', function () {
	let nim = $(this).data('id')
	console.log('hapus')
	$('.d-m#data-' + nim + '').remove()
	$('#jumlahAnggota').val(jumlahAnggota - 1);
	jumlahAnggota = $('#jumlahAnggota').val();
})
// Anggota Lembaga
$('.daftarMahasiswaLembaga').on("click", function () {
	let tingkatKegiatan = $('#jenis_lembaga').val();
	console.log(tingkatKegiatan);
	cek = tingkatKegiatan;
	$('.dataTables_wrapper').remove()
	$('.partisipasi').remove()
	if (tingkatKegiatan != 0) {
		$('.notice-mhs').remove()
		$('.table-mhs').append(`<table class="table table-striped table-mahasiswa"></table>`)
		$.ajax({
			url: segments[0] + '/' + segments[3] + '/API_skp/partisipasiKegiatan/' + tingkatKegiatan,
			method: 'get',
			dataType: 'json',
			success: function (data) {
				let partisipasi = "";
				partisipasi += `<select class="custom-select partisipasiKegiatan" name="partisipasiKegiatan" id="partisipasiKegiatan" required>`
				for (var i in data) {
					partisipasi += `<option class="partisipasi" value="` + data[i].id_semua_prestasi + `">` + data[i].nama_prestasi + `</option>`
				}
				partisipasi += `</select>`;
				let id_kegiatan;
				if (segments[6]) {
					id_kegiatan = segments[6]
				}
				$.ajax({
					url: segments[0] + '/' + segments[3] + '/API_skp/dataMahasiswa/?id=' + id_kegiatan,
					method: 'get',
					dataType: 'json',
					beforeSend: function () {
						$('.table-mhs').append(` <div class="loader">
                        <img src="` + segments[0] + '/' + segments[3] + `/assets/img/loader.gif" alt="">
                        </div>`)
					},
					success: function (data) {
						let dataTampung = [];
						let index = 1;
						let dataMhs = data['mhs']
						let mhs = data['mhs_kegiatan']
						let bkn_anggota = data['bkn_mhs_kegiatan'];
						for (var k in mhs) {
							for (var j in dataMhs) {
								if (mhs[k].nim == dataMhs[j].nim) {
									let temp = [];
									temp.push(index++)
									temp.push(`<span id="t-nim-` + dataMhs[j].nim + `">` + dataMhs[j].nim + `</span>`)
									temp.push(`<span id="t-nama-` + dataMhs[j].nim + `">` + dataMhs[j].nama + `</span>`)
									temp.push(`<span id="t-prestasi-` + dataMhs[j].nim + `">` + partisipasi + `</span>`)
									temp.push(`<span id="t-cek-` + dataMhs[j].nim + `"><input checked type="checkbox" class="cek" id="checkbox` + dataMhs[j].nim + `"></span>`)
									dataTampung.push(temp);
								}
							}
						}
						for (var j in bkn_anggota) {
							let temp = [];
							temp.push(index++)
							temp.push(`<span id="t-nim-` + bkn_anggota[j].nim + `">` + bkn_anggota[j].nim + `</span>`)
							temp.push(`<span id="t-nama-` + bkn_anggota[j].nim + `">` + bkn_anggota[j].nama + `</span>`)
							temp.push(`<span id="t-prestasi-` + bkn_anggota[j].nim + `">` + partisipasi + `</span>`)
							temp.push(`<span id="t-cek-` + bkn_anggota[j].nim + `"><input type="checkbox" class="cek" id="checkbox` + bkn_anggota[j].nim + `"></span>`)
							dataTampung.push(temp);
						}
						$('.table-mahasiswa').DataTable({
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
									title: "Action"
								}
							]
						})
					}
				})
			}
		})
	} else {
		$('.table-mhs').append(`<h2 class="notice-mhs">Anda Belum Memilih Tingkat Kegiatan !</h2>`)
	}
})

$('.submit-mhs-lembaga').on('click', function () {

	let nim = []
	let nama = []
	let posisi = []
	let valPosisi = []
	let check = []
	let oMhs = []
	let aMhs = []
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/daftarMahasiswa',
		method: 'get',
		dataType: 'json',
		success: function (data) {
			for (var i in data) {

				nim.push($('#t-nim-' + data[i].nim).text());
				nama.push($('#t-nama-' + data[i].nim).text());
				posisi.push($('#t-prestasi-' + data[i].nim + ' .partisipasiKegiatan option:selected').text());
				valPosisi.push($('#t-prestasi-' + data[i].nim + ' .partisipasiKegiatan option:selected').val());
				check.push($('#checkbox' + data[i].nim).is(":checked"));
			}
			for (var j in data) {
				if (check[j] == true && valPosisi[j] != 0) {
					oMhs = [];
					oMhs.push(nim[j]);
					oMhs.push(nama[j]);
					oMhs.push(posisi[j]);
					oMhs.push(valPosisi[j]);
					aMhs.push(oMhs);
				}
			}

			let id = 1;
			if (jumlahAnggota != 0) {
				id = parseInt(jumlahAnggota) + 1;
			}
			for (var k in aMhs) {
				$('.d-m#data-' + aMhs[k][0] + '').remove()
				$('.daftar-mhs').append(`
					<tr class="d-m" id="data-` + aMhs[k][0] + `">
						<td>` + (id) + `</td>
						<td>` + aMhs[k][0] + `
							<input  type="hidden" name="nim_` + aMhs[k][0] + `" value="` + aMhs[k][0] + `" id="nim_` + aMhs[k][0] + `" >
						</td>
						<td>` + aMhs[k][1] + `</td>
						<td>` + aMhs[k][2] + `
							<input  type="hidden" name="prestasi_` + aMhs[k][0] + `" value="` + aMhs[k][3] + `" id="nim_` + aMhs[k][0] + `" >
						</td>
						<td> <button onclick="myFunction(` + aMhs[k][0] + `)" type="button" data-id="` + aMhs[k][0] + `" class="btn btn-danger hps-mhs-1"><i class="fas fa-trash-alt"></i></></td>
					</tr>
				`)
				id++
			}
			jumlahAnggota = cekJumlahAnggota();
			$('#jumlahAnggota').val(jumlahAnggota);

		}
	})
})

function aktifSemua() {
	let id_pengajuan = $('#pengajuanId').val();
	let tahun = $('#tahun').val();
	console.log(id_pengajuan);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/daftarAnggotaLembaga?id=' + id_pengajuan,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data);
			for (let i = 0; i < data.length; i++) {
				var a = 'keaktifan_' + data[i]['nim'];
				$("input[name='" + a + "'][value='1']").prop("checked", true);
			}
		}
	})
}
