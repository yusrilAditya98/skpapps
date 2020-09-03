var url = $(location).attr("href");
var segments = url.split("/");

$.ajax({
	url: segments[0] + '/' + segments[3] + '/Mahasiswa/bidangKegiatan',
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
				url: segments[0] + '/' + segments[3] + '/Mahasiswa/jenisKegiatan/' + bidangKegiatan,
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
						url: segments[0] + '/' + segments[3] + '/Mahasiswa/tingkatKegiatan/' + jenisKegiatan,
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
								url: segments[0] + '/' + segments[3] + '/Mahasiswa/partisipasiKegiatan/' + tingkatKegiatan,
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
		url: segments[0] + '/' + segments[3] + '/Mahasiswa/jenisKegiatan/' + bidangKegiatan,
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
		url: segments[0] + '/' + segments[3] + '/Mahasiswa/tingkatKegiatan/' + jenisKegiatan,
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

$('#tingkatKegiatan').on("change", function () {
	$('#jumlahAnggota').val(0);
	let tingkatKegiatan = $('.tingkatKegiatan').val()
	$('.partisipasi').remove();
	$('.d-m').remove()

	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Mahasiswa/partisipasiKegiatan/' + tingkatKegiatan,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data)
			$('#id_semua_prestasi_mhs').val(data[0].id_semua_prestasi)
			let partisipasi = '';
			let poin = '';
			for (var i in data) {
				partisipasi += `<option class="partisipasi" value="` + data[i].id_semua_prestasi + `">` + data[i].nama_prestasi + `</option>`
			}
			$('.partisipasiKegiatan').append(partisipasi)
		}
	})
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
				console.log(data)
				let partisipasi = "";
				// partisipasi += `<select class="custom-select partisipasiKegiatan" name="partisipasiKegiatan" id="partisipasiKegiatan" required>`

				partisipasi = data[0].id_semua_prestasi
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
									temp.push(`<span id="t-jurusan-` + dataMhs[j].nim + `">` + dataMhs[j].nama_jurusan + `</span>`)
									temp.push(`<span id="t-prodi-` + dataMhs[j].nim + `">` + dataMhs[j].nama_prodi + `</span>`)
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
							temp.push(`<span id="t-jurusan-` + bkn_anggota[j].nim + `">` + bkn_anggota[j].nama_jurusan + `</span>`)
							temp.push(`<span id="t-prodi-` + bkn_anggota[j].nim + `">` + bkn_anggota[j].nama_prodi + `</span>`)
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
									title: "Jurusan"
								},
								{
									title: "Prodi"
								},
								{
									title: "Aksi"
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

$('.partisipasiKegiatan').on("change", function () {
	let partisipasiKegiatan = $('.partisipasiKegiatan').val()
	$('#bobotKegiatan').val(0);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Mahasiswa/bobotkegiatan/' + partisipasiKegiatan,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log('cel')
			$('#bobotKegiatan').val(data[0].bobot);
		}
	})
})

$('#table-1').on("click", '.detailSkp', function () {
	let id_skp = $(this).data('id');

	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Mahasiswa/detailKegiatan/' + id_skp,
		method: 'get',
		dataType: 'json',
		success: function (data) {

			$('.d-bidang').html(data[0].nama_bidang)
			$('.d-jenis').html(data[0].jenis_kegiatan)
			$('.d-tingkat').html(data[0].nama_tingkatan)
			$('.d-partisipasi').html(data[0].nama_prestasi)
			$('.d-bobot').html((data[0].bobot * data[0].nilai_bobot))
			$('.d-nama').val(data[0].nama_kegiatan)
			$('.d-tgl').val(data[0].tgl_pelaksanaan)
			$('.d-tgl-selesai').val(data[0].tgl_selesai_pelaksanaan)
			$('.d-tempat').val(data[0].tempat_pelaksanaan)
			$('.d-catatan').val(data[0].catatan)

			// cek format file
			const lastThree = data[0].file_bukti.substr(data[0].file_bukti.length - 3)

			if (lastThree == 'pdf') {
				$('.d-file').html('	lihat');
				$('.d-file').attr('href', segments[0] + '/' + segments[3] + '/assets/pdfjs/web/viewer.html?file=../../../file_bukti/' + data[0].file_bukti)
			} else if (lastThree == 'jpg' || lastThree == 'jpeg' || lastThree == 'png') {
				$('.d-file').html('lihat');
				$('.d-file').attr('href', segments[0] + '/' + segments[3] + '/file_bukti/' + data[0].file_bukti)
			} else {
				$('.d-file').removeAttr('href');
				$('.d-file').addClass('text-white');
				$('.d-file').html('Tidak ada');

			}

		}
	})
})

$('table').on('click', '.d-revisi', function () {
	let id_skp = $(this).data('id');
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Mahasiswa/detailKegiatan/' + id_skp,
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
	let jurusan = []
	let prodi = []
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
				jurusan.push($('#t-jurusan-' + data[i].nim).text());
				prodi.push($('#t-prodi-' + data[i].nim).text());
				valPosisi.push($('#t-prestasi-' + data[i].nim + ' .partisipasiKegiatan').val());
				check.push($('#checkbox' + data[i].nim).is(":checked"));
			}
			for (var j in data) {
				if (check[j] == true && valPosisi[j] != 0) {
					oMhs = [];
					oMhs.push(nim[j]);
					oMhs.push(nama[j]);
					oMhs.push(jurusan[j]);
					oMhs.push(prodi[j]);
					oMhs.push(valPosisi[j]);
					aMhs.push(oMhs);
				}
			}

			let id = 1;
			if (jumlahAnggota != 0) {
				id = parseInt(jumlahAnggota) + 1;
			}
			console.log(aMhs)
			for (var k in aMhs) {
				$('.d-m#data-' + aMhs[k][0] + '').remove()
				$('.daftar-mhs').append(`
					<tr class="d-m" id="data-` + aMhs[k][0] + `">
						<td><i class="fas fa-user-alt"></i></td>
						<td>` + aMhs[k][0] + `
							<input  type="hidden" name="nim_` + aMhs[k][0] + `" value="` + aMhs[k][0] + `" id="nim_` + aMhs[k][0] + `" >
						</td>
						<td>` + aMhs[k][1] + `</td>
						<td>` + aMhs[k][2] + `</td>
						<td>` + aMhs[k][3] + `</td>
						<td> <button onclick="myFunction(` + aMhs[k][0] + `)" type="button" data-id="` + aMhs[k][0] + `" class="btn btn-danger hps-mhs-1"><i class="fas fa-trash-alt"></i></h2></td>
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
	$('.d-m#data-' + nim + '').remove()
	$('#jumlahAnggota').val(jumlahAnggota - 1);
	jumlahAnggota = $('#jumlahAnggota').val();
})

// Mengenerarat anggaran yang ditermi
$('#danaKegiatan').keyup(function () {
	let nominal = $('#danaKegiatan').val() * 0.7
	$('#danaKegiatanDiterima').val(nominal)
})
