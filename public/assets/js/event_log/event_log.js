

$(document).ready(function () {
    var tableName = '#eventLogTbl';
    let config = {
        dom: '<"toolbar">Blfrtip',
        order: [[1, "desc"]],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        columnDefs: [
            {
                'targets': [0],
                'className': 'text-center',
            },
            {
                'targets': [2],
                'className': 'text-center',
                'orderable': true,
                'width': '10%'
            },
            {
                'targets': [5],
                'type': 'date'
            },
            {
                targets: '_all',
                defaultContent: '-'
            }],
        columns: [
            {
                data: function data(row) {
                    var data = [{
                        'id': row.id,
                    }];

                    return prepareTemplateRender('#batchSelect', data);
                },
                name: 'select'
            },
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: function data(row) {
                    if(row.subject_type==="App\\Models\\User"){
                        return "Munkavállaló";
                    }
                    if(row.subject_type==="App\\Models\\Candidate"){
                        return "Munkavállaló";
                    }
                    if(row.subject_type==="App\\Models\\Company"){
                        return "Munkáltató";
                    }
                    if(row.subject_type==="App\\Models\\Job"){
                        return "Hirdetés";
                    }
                },
                name: 'subject_type'
            },
            {
                data: 'subject_id',
                name: 'subject_id'
            },
            {
                data: 'causer_user',
                name: 'causer_user'
            },

            {
                data: '_created_at',
                name: 'created_at',
            },
            {
                data: '_updated_at',
                name: 'updated_at'
            }
        ],
        fnInitComplete: function(){
            $('div.toolbar').html(`
                <div class="float-left d-md-flex">
                    <select id="batchAction" class="form-control mr-1">
                        <option disabled selected value="">`+Lang.get('messages.datatable.batch_processes')+`</option>
                        <option value="generate-excel">`+Lang.get('messages.candidates_table.generate_excel')+`</option>
                    </select>
                    <button id="submitBatchAction" class="btn btn-primary mr-5">`+Lang.get('messages.common.batch_submit')+`</button>
                </div>
            `);
        }
    };

    initialiseDatatable($(tableName), emailTemplateUrl, config, Lang.get('messages.log_table.filename'));

    function getSelectedRows() {
        var table = $(tableName).DataTable();
        const selected = table.rows({selected: true}).data();

        var ids = $.map(selected, function (item) {
            return item.id
        });

        return ids;
    }

    $(document).on('click', 'tbody tr', function(){
        if($(this).hasClass('selected')){
            $(this).find('input').prop('checked', 'checked');
        }
        else{
            $(this).find('input').prop('checked', false);
        }
    });

    $(document).on('click', '#datatableSelectAll', function(){
        if($(this).is(':checked')){
            $('.batch-select-input').each(function(){
                if(!$(this).is(':checked')){
                    $(this).trigger('click');
                }
            });
        }
        else{
            $('.batch-select-input').each(function(){
                if($(this).is(':checked')){
                    $(this).trigger('click');
                }
            });
        }
    });

    $(document).on('click', '.batch-select-input', function(){
        var table = $(tableName).DataTable();
        $(this).parent().trigger('click');
        var tr = $(this).closest('tr[role="row"]');

        if(tr.hasClass('selected')){
            var row = table.row(tr).deselect();
        }
        else{
            var row = table.row(tr).select();
        }
    });

    $(document).on('submit', '#eventLogTableForm', function(e){
        e.preventDefault();

        const action = $('#batchAction').val();
        const selectedIds = getSelectedRows();
        if(action !== '' && selectedIds.length > 0) {
            switch (action) {
                case 'generate-excel': {
                    $('.dt-button.buttons-excel').trigger('click');
                    break;
                }
                default: {
                    iziToast.error({
                        title: Lang.get('messages.common.error'),
                        message: Lang.get('messages.datatable.invalid_bulk_action'),
                        position: 'topRight',
                    });
                }
            }
        }

    });
});
