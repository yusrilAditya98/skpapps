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
