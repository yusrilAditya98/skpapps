$('.logout').on('click', function () {
	Swal.fire({
		title: 'Anda yakin?',
		text: "",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Logout'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/skpapps/auth/logout";
		}
	})
});

$('.table-kategori').on('click', '.hapus-kegiatan', function () {
	let id_kuliah_tamu = $(this).data('id');
	// console.log(id_kuliah_tamu);
	Swal.fire({
		title: 'Anda yakin?',
		text: "Kegiatan akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/skpapps/akademik/hapusKegiatan/" + id_kuliah_tamu;
		}
	})
});

$('.table-kategori').on('click', '.hapus-bidang', function () {
	var id_bidang = $(this).data('id');
	// console.log(a);
	Swal.fire({
		title: 'Anda yakin?',
		text: "Bidang akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/skpapps/kemahasiswaan/hapusBidang/" + id_bidang;
		}
	})
});

$('.table-kategori').on('click', '.hapus-jenis', function () {
	var id_jenis = $(this).data('id');
	console.log(id_jenis);
	Swal.fire({
		title: 'Anda yakin?',
		text: "Jenis akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/skpapps/kemahasiswaan/hapusJenis/" + id_jenis;
		}
	})
});


$('.table-kategori').on('click', '.hapus-tingkatan', function () {
	var id_tingkatan = $(this).data('id');
	// console.log(a);
	Swal.fire({
		title: 'Anda yakin?',
		text: "Tingkatan akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/skpapps/kemahasiswaan/hapusTingkatan/" + id_tingkatan;
		}
	})
});

$('.table-kategori').on('click', '.hapus-prestasi', function () {
	var id_prestasi = $(this).data('id');
	// console.log(a);
	Swal.fire({
		title: 'Anda yakin?',
		text: "Prestasi akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/skpapps/kemahasiswaan/hapusPrestasi/" + id_prestasi;
		}
	})
});

$('.table-kategori').on('click', '.hapus-detail-tingkatan', function () {
	var id_semua_tingkatan = $(this).data('id');
	console.log(id_semua_tingkatan);
	Swal.fire({
		title: 'Anda yakin?',
		text: "Detail tingkatan akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/skpapps/kemahasiswaan/hapusDetailTingkatan/" + id_semua_tingkatan;
		}
	})
});

$('.table-kategori').on('click', '.hapus-detail-prestasi', function () {
	$('.modalDetailTingkatan').modal('hide');
	var id_semua_prestasi = $(this).data('id');
	console.log(id_semua_prestasi);
	Swal.fire({
		title: 'Anda yakin?',
		text: "Detail prestasi akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/skpapps/kemahasiswaan/hapusDetailPrestasi/" + id_semua_prestasi;
		}
	})
});

$('.table-kategori').on('click', '.hapus-dasar-penilaian', function () {
	var id_dasar_penilaian = $(this).data('id');
	console.log(id_dasar_penilaian);
	Swal.fire({
		title: 'Anda yakin?',
		text: "Dasar penilaian akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/skpapps/kemahasiswaan/hapusDasarPenilaian/" + id_dasar_penilaian;
		}
	})
});
