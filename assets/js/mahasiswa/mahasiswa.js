var url = $(location).attr("href");
var segments = url.split("/");

$.ajax({
	url: segments[0] + '/skpapps/mahasiswa/bidangKegiatan',
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
				url: segments[0] + '/skpapps/mahasiswa/jenisKegiatan/' + bidangKegiatan,
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
						url: segments[0] + '/skpapps/mahasiswa/tingkatKegiatan/' + jenisKegiatan,
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
								url: segments[0] + '/skpapps/mahasiswa/partisipasiKegiatan/' + tingkatKegiatan,
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
		url: segments[0] + '/skpapps/mahasiswa/jenisKegiatan/' + bidangKegiatan,
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
		url: segments[0] + '/skpapps/mahasiswa/tingkatKegiatan/' + jenisKegiatan,
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

$('#tingkatKegiatan').on("change", function () {
	let tingkatKegiatan = $('.tingkatKegiatan').val()
	$('.partisipasi').remove();
	$('.d-m').remove()

	$.ajax({
		url: segments[0] + '/skpapps/mahasiswa/partisipasiKegiatan/' + tingkatKegiatan,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			let partisipasi = '';
			let poin = '';
			for (var i in data) {
				partisipasi += `<option class="partisipasi" value="` + data[i].id_semua_prestasi + `">` + data[i].nama_prestasi + `</option>`
			}
			$('.partisipasiKegiatan').append(partisipasi)
		}
	})
})

$('#partisipasiKegiatan').on("change", function () {
	let partisipasiKegiatan = $('.partisipasiKegiatan').val()
	$('#bobotKegiatan').val(0);
	$.ajax({
		url: segments[0] + '/skpapps/mahasiswa/bobotkegiatan/' + partisipasiKegiatan,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('#bobotKegiatan').val(data[0].bobot);
		}
	})
})

$('.detailSkp').on("click", function () {
	let id_skp = $(this).data('id');

	$.ajax({
		url: segments[0] + '/skpapps/mahasiswa/detailKegiatan/' + id_skp,
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
			$('.d-file').attr('href', segments[0] + '/skpapps/assets/pdfjs/web/viewer.html?file=../../../file_bukti/' + data[0].file_bukti)

		}
	})
})

$('.d-revisi').on('click', function () {
	let id_skp = $(this).data('id');
	$.ajax({
		url: segments[0] + '/skpapps/mahasiswa/detailKegiatan/' + id_skp,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.d-catatan').html(data[0].catatan)
		}
	})
})


// Menampilkan daftar selurh mahasiswa
$('.submit-mhs').on('click', function () {
	$('.d-m').remove()
	let nim = []
	let nama = []
	let posisi = []
	let valPosisi = []
	let check = []
	let oMhs = []
	let aMhs = []
	$.ajax({
		url: segments[0] + '/skpapps/mahasiswa/daftarMahasiswa',
		method: 'get',
		dataType: 'json',
		success: function (data) {
			for (var i in data) {
				nim.push($('.t-anggota#id-' + data[i].nim + ' .t-nim').text());
				nama.push($('.t-anggota#id-' + data[i].nim + ' .t-nama').text());
				posisi.push($('.t-anggota#id-' + data[i].nim + ' .t-prestasi .partisipasiKegiatan option:selected').text());
				valPosisi.push($('.t-anggota#id-' + data[i].nim + ' .t-prestasi .partisipasiKegiatan option:selected').val());
				check.push($('.t-anggota#id-' + data[i].nim + ' .cek').is(":checked"));
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
			let index = 1;
			let id = 1;
			for (var k in aMhs) {
				$('.daftar-mhs').append(`
					<tr class="d-m">
						<td>` + (index++) + `</td>
						<td>` + aMhs[k][0] + `
							<input  type="hidden" name="nim_` + id + `" value="` + aMhs[k][0] + `" id="nim_` + id + `" >
						</td>
						<td>` + aMhs[k][1] + `</td>
						<td>` + aMhs[k][2] + `
							<input  type="hidden" name="prestasi_` + id + `" value="` + aMhs[k][3] + `" id="nim_` + id + `" >
						</td>
					</tr>
				`)
				id++
			}
			$('#jumlahAnggota').val(id - 1);
		}
	})
})

// Mengenerarat anggaran yang ditermi
$('#danaKegiatan').keyup(function () {
	let nominal = $('#danaKegiatan').val() * 0.7
	$('#danaKegiatanDiterima').val(nominal)
})


$('#id-beasiswa').on('change', function () {
	let beasiswa = $('#id-beasiswa').val()
	$.ajax({
		url: segments[0] + '/skpapps/API_skp/beasiswa/' + beasiswa,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data)
			$('#namaInstansi').val(data.nama_instansi);
		}
	})
})
