var url = $(location).attr("href");
var segments = url.split("/");

$('#status_user').on('change', function () {
	$('.prodi').remove()
	if ($('#status_user').val() == "1") {
		$.ajax({
			url: segments[0] + `/` + segments[3] + `/Admin/getProdi`,
			method: 'get',
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$('#prodi-extend').html(``);
				$('#jenis-lembaga-extend').html(``);
				$('#ketua-lembaga-extend').html(``);
				$('#hp-lembaga-extend').html(``);
				$('#prodi-extend').html(`
                    <label for="prodi" class="col-form-label">Prodi</label>
					<select class="form-control" id="prodi" name="prodi" placeholder="prodi">
						<option value="0" disabled selected hidden>Pilih Status User</option>
					</select>`);
				data.forEach(function (prodi) {
					$('#prodi').append(`<option class="prodi" value="` + prodi['kode_prodi'] + `">` + prodi['nama_prodi'] + `</option>`)
				})
			}
		});
	} else if ($('#status_user').val() == "2" || $('#status_user').val() == "3") {
		$('#prodi-extend').html(``);
		$('#jenis-lembaga-extend').html(``);
		$('#ketua-lembaga-extend').html(``);
		$('#hp-lembaga-extend').html(``);
		$('#jenis-lembaga-extend').append(`
		<label for="jenis_lembaga" class="col-form-label">Jenis Lembaga</label>
		<select class="form-control" id="jenis_lembaga" name="jenis_lembaga" placeholder="Jenis Lembaga" required>
			<option value="semi otonom" >semi otonom</option>
			<option value="otonom" >otonom</option>
		</select>`)
		$('#ketua-lembaga-extend').append(`
		<label for="ketua_lembaga" class="col-form-label">Ketua Lembaga</label>
		<select class="form-control" name="ketua_lembaga" id="ketua_lembaga" required>
			<option value="" hidden selected>Pilih Mahasiswa</option>
		</select>
		`);
		$('#hp-lembaga-extend').append(`
		<label for="no_hp" class="col-form-label">No Hp</label>
		<input class="form-control" name="no_hp" id="no_hp" required></input>
		`);

		$.ajax({
			url: segments[0] + `/` + segments[3] + `/Admin/getMahasiswa`,
			method: 'get',
			dataType: 'json',
			success: function (data) {
				data.forEach(function (mahasiswa) {
					$('#ketua_lembaga').append(`<option value="` + mahasiswa['username'] + `">` + mahasiswa['nama'] + `</option>`)
				});
			}
		});
	} else {
		$('#prodi-extend').html(``);
		$('#jenis-lembaga-extend').html(``);
		$('#ketua-lembaga-extend').html(``);
		$('#hp-lembaga-extend').html(``);
	}

})

$('.table-kategori').on('click', '.edit-user', function () {
	let id = $(this).data('id');
	console.log(id);
	$.ajax({
		url: segments[0] + `/` + segments[3] + `/Admin/getUser/` + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			var link_a = window.location.origin + `/` + segments[3] + `/Admin/editUser/` + id;
			$('form').attr('action', link_a);
			$('#username_edit').val(data['user']['username']);
			$('#nama_edit').val(data['user']['nama']);
			data['status_user'].forEach(function (dataA) {

				if (dataA['user_profil_kode'] == data['user']['user_profil_kode']) {
					$('#status_user_edit').append(`<option value="` + dataA['user_profil_kode'] + `" selected>` + dataA['jenis_user'] + `</option>`)
				} else {
					$('#status_user_edit').append(`<option value="` + dataA['user_profil_kode'] + `">` + dataA['jenis_user'] + `</option>`)
				}
			})
			if (data['user']['is_active'] == "1") {
				$('#status_aktif_edit').append(`<option class="aktived" value="` + data['user']['is_active'] + `" selected>Aktif</option>`)
				$('#status_aktif_edit').append(`<option  class="aktived" value="0">Tidak Aktif</option>`)
			} else {
				$('#status_aktif_edit').append(`<option  class="aktived" value="1">Aktif</option>`)
				$('#status_aktif_edit').append(`<option  class="aktived" value="` + data['user']['is_active'] + `" selected>Tidak Aktif</option>`)
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
			window.location = window.location.origin + `/` + segments[3] + `/Admin/hapusUser/` + id_user;
		}
	})
});
