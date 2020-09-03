var url = $(location).attr("href");
var segments = url.split("/");

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
$('.tingkatKegiatan').on('change', function () {
	$('#jumlahAnggota').val(0);
	let tingkatKegiatan = $('.tingkatKegiatan').val()
	$('.partisipasi').remove();
	$('.d-m').remove()

	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/partisipasiKegiatan/' + tingkatKegiatan,
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

$('.partisipasiKegiatan').on("change", function () {
	let partisipasiKegiatan = $('.partisipasiKegiatan').val()
	$('#bobotKegiatan').val(0);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/bobotKegiatan/' + partisipasiKegiatan,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('#bobotKegiatan').val(data[0].bobot);
		}
	})
})



function detailValidasiSKP(id) {
	let id_skp = id;
	console.log('cek')
	$('table').on('click', '.detailSkp', function (e) {
		$('.temp-class').remove()
		copyDivValidasiSkp(e)
	})
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Kemahasiswaan/detailKegiatan/' + id_skp,
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
			$('.d-tempat').val(data[0].tempat_pelaksanaan)
			$('.d-catatan').val(data[0].catatan)
			$('.d-tgl-selesai').val(data[0].tgl_selesai_pelaksanaan)
			$('.form-revisi').attr('action', segments[0] + '/' + segments[3] + '/Kemahasiswaan/validasiSkp/' + data[0].id_poin_skp)
			// cek format file
			const lastThree = data[0].file_bukti.substr(data[0].file_bukti.length - 3)
			console.log(lastThree)
			if (lastThree == 'pdf') {
				$('.d-file').html('lihat');
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

}

function copyDivValidasiSkp(e) {
	let tombol = e.target
	let valid = (tombol.parentElement.nextElementSibling.nextElementSibling)
	let clnValid = valid.cloneNode(true);
	let cldrnvalid = '';
	cldrnvalid = clnValid.children;
	cldrnvalid[0].classList.add('temp-class')
	$('.t-validasi').append(cldrnvalid[0])
}

$('table').on("click", '.d-revisi', function () {
	let id_skp = $(this).data('skp');

	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Kemahasiswaan/detailKegiatan/' + id_skp,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiSkp/' + data[0].id_poin_skp)
			$('.d-catatan').val(data[0].catatan)
		}
	})
})

$('table').on("click", '.d-valid-km', function () {

	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(3)

})
$('table').on("click", '.d-valid', function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiProposal/' + id_kegiatan)
	$('.jenis_validasi').val(4)
})

$('table').on("click", '.d-valid-km-lpj', function () {

	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(3)

})
$('table').on("click", '.d-valid-lpj', function () {
	let id_kegiatan = $(this).data('kegiatan');
	$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiLpj/' + id_kegiatan)
	$('.jenis_validasi').val(4)
})


$('table').on('click', '.detail-kegiatan', function () {
	let tipe_kegiatan = $(this).data('jenis');
	let id_kegiatan = $(this).data('id');
	let role_id = 0;
	if ($('.role_id').val()) {
		role_id = $('.role_id').val();
	}
	if (tipe_kegiatan == 'proposal') {
		$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiProposal/' + id_kegiatan)
		$('.jenis_validasi').val(role_id)
	} else {
		$('.form-revisi').attr('action', segments[0] + '//' + segments[2] + '/' + segments[3] + '/Kemahasiswaan/validasiLpj/' + id_kegiatan)
		$('.jenis_validasi').val(role_id)
	}
})


$('.tambahAnggaran').on('click', function () {
	$('.d-lembaga').remove()
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/dataLembaga/',
		method: 'get',
		dataType: 'json',
		success: function (data) {
			let j = 1;
			for (var i in data)[
				$('.data-lembaga').append(`
				<tr class="d-lembaga">
					<td>` + (j++) + `</td>
					<td>` + data[i].nama_lembaga + `</td>
					<td><input type="number" class="form-control" name="lembaga_` + data[i].id_lembaga + `" required></td>
				</tr>
				`)
			]
		}
	})
})

$('.edit-anggaran').on('click', function () {
	let id_lembaga = $(this).data('id');
	let tahun = $(this).data('tahun');
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/dataAnggaran/' + id_lembaga + '?tahun=' + tahun,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data)
			$('.nama-lembaga').val(data.nama_lembaga);
			$('.tahun-anggaran').val(data.tahun_pengajuan);
			$('.nominal-anggaran').val(data.anggaran_kemahasiswaan);
			$('.id-lembaga').val(data.id_lembaga);

		}
	})
})

$('a.d-anggaran').on('click', function () {
	let id_lembaga = $(this).data('id')
	let tahun = $(this).data('tahun')
	let kondisi = $(this).data('kondisi')
	$('.temp-anggaran').remove()
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/dataJumlahKegiatan/' + id_lembaga + '?kondisi=' + kondisi + '&tahun=' + tahun,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			let index = 1;
			for (var i in data) {
				$('.anggaran-lembaga').append(`
					<tr class="temp-anggaran">
						<td>` + (index++) + `</td>
						<td>` + data[i].nama_proker + `</td>
						<td>Rp. ` + rubah(data[i].anggaran_kegiatan) + `</td>
					</tr>
				
				`)
			}
		}
	})
})

$('.periode-rancangan').on('click', function () {
	let tahun = $(this).data('tahun')
	let id_lembaga = $(this).data('id')
	$('.tahun-rancangan').val(tahun)
	$('.form-tahun-rancangan').attr('action', segments[0] + '/' + segments[3] + '/Kemahasiswaan/editRancanganTahun/' + id_lembaga)

})

$('.revisi-rancangan-proker').on('click', function () {
	let id_daftar_rancangan = $(this).data('id')
	$('.value-valid').val(2);
	$('.form-revisi-rancangan').attr('action', segments[0] + '/' + segments[3] + '/Kemahasiswaan/validasiRancanganProker/' + id_daftar_rancangan)
})

// Validasi Anggota Lembaga

$('#table-1').on('click', '.validasiAnggota', function () {
	let id = $(this).data('id');
	let lembaga = $(this).data('lembaga');
	var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/validasiAnggotaLembaga/' + id;
	$('.detailValidasiAnggota').attr('href', link_a);
	// console.log(lembaga);

	// Data Lembaga
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailLembaga/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.nama_lembaga').html("Nama Lembaga : " + data['nama_lembaga']);
			$('.jenis_lembaga').html("Jenis Lembaga   : " + data['jenis_lembaga']);
			$('.periode').html("Periode Keanggotaan   : " + data['periode']);
		}
	});

	// Data SKP
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailAnggotaLembaga/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			if (data.length != 0) {
				$('.body-validasi-anggota').html('');
				var i = 0;
				data.forEach(function (dataA) {
					$('.body-validasi-anggota').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama'] + `</td>
					<td>` + dataA['nim'] + `</td>
					<td>` + dataA['nama_jurusan'] + `</td>
					<td>` + dataA['nama_prodi'] + `</td>
					<td>` + dataA['nama_prestasi'] + `</td>
                    </tr>`)
				})
			} else {
				$('.body-validasi-anggota').html('');
				$('.body-validasi-anggota').html(`
                <tr>
                   <td colspan="6">
                        <h3 class="text-center my-2">Belum ada Anggota</h3>
                    </td>
                </tr>`);
			}
		}
	});

})


$('#table-1').on('click', '.validasiAnggotaFix', function () {
	let id = $(this).data('id');
	let lembaga = $(this).data('lembaga');
	// console.log(lembaga);
	var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/unvalidasiAnggotaLembaga/' + id;
	$('.detailValidasiAnggotaFix').attr('href', link_a);

	// Data Lembaga
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailLembaga/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.nama_lembaga_fix').html("Nama Lembaga : " + data['nama_lembaga']);
			$('.jenis_lembaga_fix').html("Jenis Lembaga   : " + data['jenis_lembaga']);
			$('.periode_fix').html("Periode Keanggotaan   : " + data['periode']);
		}
	});

	// Data SKP
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailAnggotaLembaga/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			if (data.length != 0) {
				$('.body-validasi-anggota-fix').html('');
				var i = 0;
				data.forEach(function (dataA) {
					$('.body-validasi-anggota-fix').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama'] + `</td>
					<td>` + dataA['nim'] + `</td>
					<td>` + dataA['nama_jurusan'] + `</td>
					<td>` + dataA['nama_prodi'] + `</td>
					<td>` + dataA['nama_prestasi'] + `</td>
                    </tr>`)
				})
			} else {
				$('.body-validasi-anggota-fix').html('');
				$('.body-validasi-anggota-fix').html(`
                <tr>
                   <td colspan="6">
                        <h3 class="text-center my-2">Belum ada Anggota</h3>
                    </td>
                </tr>`);
			}
		}
	});

})

$('#table-1').on('click', '.keaktifanAnggota', function () {
	let id = $(this).data('id');
	let lembaga = $(this).data('lembaga');
	var link_a = window.location.origin + '/' + segments[3] + '/Kemahasiswaan/validasiKeaktifanAnggota/' + id;
	$('.detailKeaktifanAnggota').attr('href', link_a);
	// console.log(lembaga);

	// Data Lembaga
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailLembaga/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.nama_lembaga_aktif').html("Nama Lembaga : " + data['nama_lembaga']);
			$('.jenis_lembaga_aktif').html("Jenis Lembaga   : " + data['jenis_lembaga']);
			$('.periode_aktif').html("Periode Keanggotaan   : " + data['periode']);
		}
	});

	// Data SKP
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailAnggotaLembaga/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			if (data.length != 0) {
				$('.body-keaktifan-anggota').html('');
				var i = 0;
				data.forEach(function (dataA) {
					$('.body-keaktifan-anggota').append(`<tr class="keaktifan_anggota_` + dataA['nim'] + `">
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama'] + `</td>
					<td>` + dataA['nim'] + `</td>
					<td>` + dataA['nama_jurusan'] + `</td>
					<td>` + dataA['nama_prodi'] + `</td>
					<td>` + dataA['nama_prestasi'] + `</td>
					<td>` + dataA['bobot'] + `</td>
					<td>` + dataA['status_aktif'] + `</td>
					</tr>`);
					// var classA = '.keaktifan_anggota_' + dataA['nim'];
					// if (dataA['status_aktif'] == 1) {
					// 	$(classA).append(`<td class="text-success">Aktif</td>`)
					// } else {
					// 	$(classA).append(`<td class="text-danger">Tidak Aktif</td>`)
					// }
				})
			} else {
				$('.body-keaktifan-anggota').html('');
				$('.body-keaktifan-anggota').html(`
                <tr>
                   <td colspan="6">
                        <h3 class="text-center my-2">Belum ada Anggota</h3>
                    </td>
                </tr>`);
			}
		}
	});

})

$('#table-1').on('click', '.keaktifanAnggotaFix', function () {
	let id = $(this).data('id');
	let lembaga = $(this).data('lembaga');
	// console.log(lembaga);

	// Data Lembaga
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailLembaga/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.nama_lembaga_aktif_fix').html("Nama Lembaga : " + data['nama_lembaga']);
			$('.jenis_lembaga_aktif_fix').html("Jenis Lembaga   : " + data['jenis_lembaga']);
			$('.periode_aktif_fix').html("Periode Keanggotaan   : " + data['periode']);
		}
	});

	// Data SKP
	// console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/API_skp/getDetailAnggotaLembaga/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			if (data.length != 0) {
				$('.body-keaktifan-anggota-fix').html('');
				var i = 0;
				data.forEach(function (dataA) {
					$('.body-keaktifan-anggota-fix').append(`<tr class="keaktifan_anggota_` + dataA['nim'] + `">
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama'] + `</td>
					<td>` + dataA['nim'] + `</td>
					<td>` + dataA['nama_jurusan'] + `</td>
					<td>` + dataA['nama_prodi'] + `</td>
					<td>` + dataA['nama_prestasi'] + `</td>
					<td>` + dataA['bobot'] + `</td>
					<td>` + dataA['status_aktif'] + `</td>
					</tr>`);
					// var classA = '.keaktifan_anggota_' + dataA['nim'];
					// if (dataA['status_aktif'] == 1) {
					// 	$(classA).append(`<td class="text-success">Aktif</td>`)
					// } else {
					// 	$(classA).append(`<td class="text-danger">Tidak Aktif</td>`)
					// }
				})
			} else {
				$('.body-keaktifan-anggota-fix').html('');
				$('.body-keaktifan-anggota-fix').html(`
                <tr>
                   <td colspan="6">
                        <h3 class="text-center my-2">Belum ada Anggota</h3>
                    </td>
                </tr>`);
			}
		}
	});

})
