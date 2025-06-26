'use strict';

$.extend($.fn.dataTable.defaults, {
    'paging': true,
    'info': true,
    'ordering': true,
    'autoWidth': false,
    'pageLength': 10,
    'language': {
        'search': '',
        'sSearch': 'Search',
    },
    "preDrawCallback": function () {
        customSearch()
    },
    dom: 'lBfrtip',
    tableTools: {
        "sSwfPath": "media/swf/copy_csv_xls_pdf.swf"
    },
    buttons: [
        {
            extend: 'csv',
            title: 'ProjectR Data Export',
            className: 'btn btn-primary'
        },
    ],
});

function customSearch() {
    $('.dataTables_filter input').addClass("form-control");
    $('.dataTables_filter input').attr("placeholder", "Search");
}
