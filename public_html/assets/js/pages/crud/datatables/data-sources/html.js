"use strict";

function filterColumn ( i ) {
    $('#kt_datatable').DataTable().column( i ).search(
        $('#col'+i+'_filter').val(),
    ).draw();
}




var KTDatatablesDataSourceHtml = function() {


	var initTable1 = function() {


        $('input.column_filter').on( 'keyup click change', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );

        $('input.column_select').on( 'keyup click change', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );

		var table = $('#kt_datatable');

        $('#select7').on( 'change', function () {
            table.DataTable()
                .columns(7)
                .search( this.value )
                .draw();

        } );

		$('#select6').on( 'change', function () {
                table.DataTable()
                    .columns(6)
                    .search( this.value )
                    .draw();

            } );
        $('#select5').on( 'change', function () {
            table.DataTable()
                .columns(5)
                .search( this.value )
                .draw();

        } );
		// begin first table
		table.DataTable({
            class: 'border',
            dom:'<"d-flex justify-content-between border m-0 p-3 rounded" flB>t<"d-flex justify-content-between" ip>',
            "pagingType": "full_numbers",
            "order": [[ 0, "desc" ]],
            buttons: [

                {
                    text:'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">\n' +
                        '  <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>\n' +
                        '  <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>\n' +
                        '</svg> '+' Export',
                    extend: 'excel',
                    className:'btn btn-outline-link'

                },

            ],
			responsive: true,

		});


        $('#kt_datepicker').datepicker({
            todayHighlight: true,
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>',
            },
        });


        $('#kt_search').on('click', function(e) {
            e.preventDefault();
            var params = {};
            $('.datatable-input').each(function() {
                var i = $(this).data('col-index');
                if (params[i]) {
                    params[i] += '|' + $(this).val();
                }
                else {
                    params[i] = $(this).val();
                }
            });
            $.each(params, function(i, val) {
                // apply search params to datatable
                table.DataTable().column(i).search(val ? val : '', false, false);
            });
            table.DataTable().table().draw();
        });

        $('#kt_reset').on('click', function(e) {
            e.preventDefault();
            $('.datatable-input').each(function() {
                $(this).val('');
                table.DataTable().column($(this).data('col-index')).search('', false, false);
            });
            table.DataTable().table().draw();
        });

	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();


		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceHtml.init();
});
