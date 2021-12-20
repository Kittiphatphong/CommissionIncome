"use strict";
// Class definition

var KTDatatableHtmlTableDemo = function() {
    // Private functions


    // demo initializer
    var demo = function() {

		var datatable = $('#kt_datatable').KTDatatable({


		});



        $('#kt_datatable_search_transaction_id').on('keyup click change', function() {
            datatable.search($(this).val().toLowerCase(), 'TRANSACTION ID');
        });
        $('#kt_datatable_search_phone_no').on('keyup click change', function() {
            datatable.search($(this).val().toLowerCase(), 'PHONE NO');
        });

        $('#kt_datatable_search_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        // $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();

    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            demo();
        },
    };
}();

jQuery(document).ready(function() {
	KTDatatableHtmlTableDemo.init();
});
