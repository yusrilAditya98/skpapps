// $('.logout').on('click', function () {
// 	Swal.fire({
// 		title: 'Are you sure?',
// 		text: "",
// 		type: 'warning',
// 		showCancelButton: true,
// 		confirmButtonColor: '#3085d6',
// 		cancelButtonColor: '#d33',
// 		confirmButtonText: 'Logout'
// 	}).then(function (result) {
// 		if (result.value) {
// 			window.location = window.location.origin + "/SiUjian/auth/logout";
// 		}
// 	})
// });

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
