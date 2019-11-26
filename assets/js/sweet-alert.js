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

$('.hapus-kegiatan').on('click', function () {
	var id_kuliah_tamu = $('.hapus-kegiatan').attr('value');
	// console.log(a);
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
			window.location = window.location.origin + "/SiUjian/akademik/hapusKegiatan/" + id_kuliah_tamu;
		}
	})
});

$('.hapus-bidang').on('click', function () {
	var id_bidang = $('.hapus-bidang').attr('value');
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
			window.location = window.location.origin + "/SiUjian/kemahasiswaan/hapusBidang/" + id_bidang;
		}
	})
});

$('.hapus-jenis').on('click', function () {
	var id_jenis = $('.hapus-jenis').attr('value');
	// console.log(a);
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
			window.location = window.location.origin + "/SiUjian/kemahasiswaan/hapusJenis/" + id_jenis;
		}
	})
});


$('.hapus-tingkatan').on('click', function () {
	var id_tingkatan = $('.hapus-tingkatan').attr('value');
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
			window.location = window.location.origin + "/SiUjian/kemahasiswaan/hapusTingkatan/" + id_tingkatan;
		}
	})
});

$('.hapus-prestasi').on('click', function () {
	var id_prestasi = $('.hapus-prestasi').attr('value');
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
			window.location = window.location.origin + "/SiUjian/kemahasiswaan/hapusPrestasi/" + id_prestasi;
		}
	})
});
