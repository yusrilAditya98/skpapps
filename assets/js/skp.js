var url = $(location).attr("href");
var segments = url.split("/");

$('.detail-SKP').on('click', function () {
	let id = $(this).data('id');

	// Data Mahasiswa
	$.ajax({
		url: segments[0] + '/skpapps/pimpinan/get_detail_mahasiswa/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			$('.nama_mahasiswa').html("Nama : " + data['nama']);
			$('.nim_mahasiswa').html("NIM   : " + data['nim']);
			$('.prodi_mahasiswa').html("Prodi   : " + data['nama_prodi']);
		}
	});

	// Data SKP
	$.ajax({
		url: segments[0] + '/skpapps/pimpinan/get_detail_skp/' + id,
		method: 'get',
		dataType: 'json',
		success: function (data) {
			if (data.length != 0) {
				$('.body-skp').html('');
				var i = 0;
				data.forEach(function (dataA) {
					$('.body-skp').append(`<tr>
					<td class="text-center">` + (++i) + `</td>
					<td>` + dataA['nama_prestasi'] + `</td>
					<td>` + dataA['nama_tingkatan'] + `</td>
					<td>` + dataA['jenis_kegiatan'] + `</td>
					<td>` + dataA['nama_bidang'] + `</td>
					<td>` + dataA['bobot'] + `</td>
                    </tr>`)
				})
			} else {
				$('.body-skp').html('');
				$('.body-skp').html(`
                <tr>
                   <td colspan="6">
                        <h3 class="text-center my-2">Belum ada SKP</h3>
                    </td>
                </tr>`);
			}
		}
	});

})
