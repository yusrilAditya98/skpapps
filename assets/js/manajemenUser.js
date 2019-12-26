var url = $(location).attr("href");
var segments = url.split("/");

if (segments[4] == "Admin") {
	$(window).on('load', function () {
		// $('.dataTables_filter').prepend(`
		// <select class="custom-select col-lg-4 mr-2 filter-status" id="filter-status">
		// </select>`);
		// $.ajax({
		// 	url: segments[0] + '/' + segments[3] + '/Admin/getProfilUser',
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


$('.tambah-user').on('click', function () {
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Admin/getStatusUser/',
		method: 'get',
		dataType: 'json',
		success: function (data) {
			// console.log(data);
			var link_a = window.location.origin + '/' + segments[3] + '/admin/tambahUser';
			$('form').attr('action', link_a);
			data.forEach(function (status) {
				$('#status_user').append(`<option value="` + status['user_profil_kode'] + `">` + status['jenis_user'] + `</option>`)
			})
		}
	});
})

$('#status_user').on('change', function () {
	console.log($('#status_user').val());
	if ($('#status_user').val() == "1") {
		$.ajax({
			url: segments[0] + '/' + segments[3] + '/Admin/getProdi',
			method: 'get',
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$('#prodi-extend').html(``);
				$('#prodi-extend').html(`
                    <label for="prodi" class="col-form-label">Prodi</label>
                        <select class="form-control" id="prodi" name="prodi" placeholder="prodi">
                            <option value="0" disabled selected hidden>Pilih Status User</option>
                        </select>`);
				data.forEach(function (prodi) {
					$('#prodi').append(`<option value="` + prodi['kode_prodi'] + `">` + prodi['nama_prodi'] + `</option>`)
				})
			}
		});
	} else {
		$('#prodi-extend').html(``);
	}

})

$('.table-kategori').on('click', '.edit-user', function () {
	let id = $(this).data('id');
	console.log(id);
	$.ajax({
		url: segments[0] + '/' + segments[3] + '/Admin/getUser/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			console.log(data['status_user']);
			var link_a = window.location.origin + '/' + segments[3] + '/admin/editUser/' + id;
			$('form').attr('action', link_a);
			$('#username_edit').val(data['user']['username']);
			$('#nama_edit').val(data['user']['nama']);
			data['status_user'].forEach(function (dataA) {
				// console.log(dataA['user_profil_kode']);
				// console.log(data['user']['user_profil_kode']);
				if (dataA['user_profil_kode'] == data['user']['user_profil_kode']) {
					$('#status_user_edit').append(`<option value="` + dataA['user_profil_kode'] + `" selected>` + dataA['jenis_user'] + `</option>`)
				} else {
					$('#status_user_edit').append(`<option value="` + dataA['user_profil_kode'] + `">` + dataA['jenis_user'] + `</option>`)
				}
			})
			if (data['user']['is_active'] == "1") {
				$('#status_aktif_edit').append(`<option value="` + data['user']['is_active'] + `" selected>Aktif</option>`)
				$('#status_aktif_edit').append(`<option value="0">Tidak Aktif</option>`)
			} else {
				$('#status_aktif_edit').append(`<option value="1">Aktif</option>`)
				$('#status_aktif_edit').append(`<option value="` + data['user']['is_active'] + `" selected>Tidak Aktif</option>`)
			}
		}
	});
})


$('.table-kategori').on('click', '.hapus-user', function () {
	var id_user = $(this).data('id');
	var nama = $(this).data('nama');
	// console.log(id_user);
	Swal.fire({
		title: 'Anda yakin?',
		text: "User " + nama + " akan dihapus",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#868e96',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/' + segments[3] + '/admin/hapusUser/" + id_user;
		}
	})
});
