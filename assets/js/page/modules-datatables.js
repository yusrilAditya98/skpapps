"use strict";

$("[data-checkboxes]").each(function () {
	var me = $(this),
		group = me.data('checkboxes'),
		role = me.data('checkbox-role');

	me.change(function () {
		var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
			checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
			dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
			total = all.length,
			checked_length = checked.length;

		if (role == 'dad') {
			if (me.is(':checked')) {
				all.prop('checked', true);
			} else {
				all.prop('checked', false);
			}
		} else {
			if (checked_length >= total) {
				dad.prop('checked', true);
			} else {
				dad.prop('checked', false);
			}
		}
	});
});


$("#table-1").DataTable({
	"columnDefs": [{
		"sortable": false,
		"targets": []
	}],
	aLengthMenu: [
		[10, 50, 100, 200, -1],
		[10, 50, 100, 200, "All"]
	],

});

$('#dataTabelProposal').DataTable({
	aLengthMenu: [
		[10, 50, 100, 200, -1],
		[10, 50, 100, 200, "All"]
	],
	initComplete: function () {
		var select;
		this.api().columns([2]).every(function () {
			var column = this;
			select = $('<select class="form-control-sm" ><option value="">Pilih Pengaju</option></select>')
				.prependTo($('.kategori-filter'))
				.on('change', function () {
					var val = $.fn.dataTable.util.escapeRegex(
						$(this).val()
					);
					column
						.search(val ? '^' + val + '$' : '', true, false)
						.draw();
				});
			column.data().unique().sort().each(function (d, j) {
				select.append('<option value="' + d + '">' + d + '</option>')
			});
		});
		this.api().columns([4]).every(function () {
			var column = this;
			select = $('<select class="form-control-sm mr-2" ><option value="">Pilih Status</option></select>')
				.prependTo($('.kategori-filter'))
				.on('change', function () {
					var val = $.fn.dataTable.util.escapeRegex(
						$(this).val()
					);
					column
						.search(val ? '^' + val + '$' : '', true, false)
						.draw();
				});
			column.data().unique().sort().each(function (d, j) {
				select.append('<option value="' + d + '">' + d + '</option>')
			});
		});
	}
});








$("#table-2").DataTable({
	"columnDefs": [{
		"sortable": false,
		"targets": [0, 2, 3]
	}]
});

$(".table-kategori").DataTable({
	"pageLength": 5
});
$(".table-anggota-lembaga").DataTable({
	aLengthMenu: [
		[10, 50, 100, 200, -1],
		[10, 50, 100, 200, "All"]
	]
});

$("#table-kegiatan").DataTable({
	"pageLength": 5,
	"columnDefs": [{
		"sortable": false,
		"targets": [0, 1, 2, 3]
	}],
	initComplete: function () {
		this.api().columns([4]).every(function () {
			var column = this;
			var select = $('<select class="custom-select col-lg-4 mr-2" ><option value="">Pilih Status Kegiatan</option></select>')
				.prependTo($('.dataTables_filter'))
				.on('change', function () {
					var val = $.fn.dataTable.util.escapeRegex(
						$(this).val()
					);

					column
						.search(val ? '^' + val + '$' : '', true, false)
						.draw();
				});
			console.log(select);

			column.data().unique().sort().each(function (d, j) {
				select.append('<option value="' + d + '">' + d + '</option>')
			});
		});
	}
});
