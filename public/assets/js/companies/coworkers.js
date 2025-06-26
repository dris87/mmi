$(document).ready(function(){
    var tableName = '#companyCoworkersTbl';

    let config = {
        dom: '<"toolbar">Blfrtip',
        order: [[ 1, "desc" ]],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        columnDefs: [
            {
                orderable: false,
                className: 'batch-select-checkbox-wrapper text-center',
                'targets': [0],
                'width': '2%'
            },
            {
                'targets': [1],
                'className': 'text-center',
                'width': '2%',
                'orderable': true,
            },
            {
                'targets': [2],
                'width': '10%',
            },
            {
                'targets': [5],
                'width': '5%',
            },
            {
                'targets': [6],
                'type': 'date',
                'className': 'text-center'
            },
            {
                'targets': [7],
                'width': '2%'
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
                data: 'contact_name',
                name: 'contact_name'
            },

            {
                data: 'position',
                name: 'position'
            },
            {
                data: function data(row) {

                    var data = [{
                        'email': row.email,
                        'phone': row.phone,
                    }];

                    return prepareTemplateRender('#contactDetails', data);
                },
                name: 'contactDetails',
            },
            {
                data: 'role',
                name: 'role'
            },
            {
                data: 'site',
                name: 'site'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                name: 'actions',
                data: function data(row) {
                    var url = '/admin/coworkers' + '/' + row.id;
                    var data = [{
                        'id': row.id,
                        'url': url + '/edit',
                    }];
                    return prepareTemplateRender('#companyUserActionTemplate', data);
                },
                export: false
            }

        ],
        fnInitComplete: function(){
            $('div.toolbar').html(`
                <div class="float-left d-md-flex">
                    <select id="batchAction" class="form-control mr-1">
                        <option disabled selected value="">`+Lang.get('messages.datatable.batch_processes')+`</option>
                        <option value="update-status">`+Lang.get('messages.candidates_table.update_status')+`</option>
                    </select>
                    <button id="submitBatchAction" class="btn btn-primary mr-5">`+Lang.get('messages.common.batch_submit')+`</button>
                </div>
            `);
        }
    };

    initialiseDatatable($(tableName), getCoworkersUrl, config, Lang.get('messages.company_table.filename'));

    $(document).on('submit', '#statusUpdateForm', function(e){
        e.preventDefault();
        $('#btnBatchStatusUpdate').val(Lang.get('messages.common.processing'));
        $('#btnBatchStatusUpdate').prop('disabled', true);
        $.post(
            '/admin/batch-company-user-status-update',
            {
                status: $('#batchStatus').val(),
                company_users: getSelectedRows(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            '',
            'json'
        ).done(function (objResponse) {

            if (objResponse.status != 1) {
                $('#btnBatchStatusUpdate').val(Lang.get('messages.common.edit'));
                $('#btnBatchStatusUpdate').prop('disabled', false);
                iziToast.error({
                    title: Lang.get('messages.common.error'),
                    message: objResponse.message,
                    position: 'topRight',
                });
                return;
            }
            iziToast.success({
                title: Lang.get('messages.common.success'),
                message: Lang.get('messages.datatable.batch_process_success'),
                position: 'topRight',
            });
            $('#btnBatchStatusUpdate').val(Lang.get('messages.common.edit'));
            $('#btnBatchStatusUpdate').prop('disabled', false);
            $('#statusUpdateModal').modal('hide');
            location.reload();
            // $(tableName).DataTable().clear().destroy();
            // initialiseDatatable($(tableName), getCompaniesUrl, config, Lang.get('messages.candidates_table.filename'));

        }).fail(function () {
            $('#btnBatchStatusUpdate').prop('disabled', false);
            $('#btnBatchStatusUpdate').val(Lang.get('messages.common.edit'));
            iziToast.error({
                title: Lang.get('messages.common.error'),
                message: Lang.get('messages.datatable.batch_process_failed'),
                position: 'topRight',
            });
        });
    });
    $(document).on('submit', '#companyCoworkersTableForm', function(e){
        e.preventDefault();
        const action = $('#batchAction').val();
        const selectedIds = getSelectedRows();
        if(action !== '' && selectedIds.length > 0) {
            switch (action) {
                case 'update-status': {
                    const statusUpdateModal = $('#statusUpdateModal');
                    const selected = $(tableName).DataTable().rows({ selected: true }).data();
                    const items = $.map(selected, function (item) {
                        return item
                    });
                    // statusUpdateModal.find('.table tr').remove();
                    $.each(items, function( index, row ) {
                        statusUpdateModal.find('.table tbody').append(`
                            <tr>
                                <td>`+row.id+`</td>
                                <td>`+row.contact_name+`</td>
                                <td>`+row.status+`</td>
                            </tr>
                        `);
                    });
                    statusUpdateModal.find('.table').append()
                    statusUpdateModal.modal('show');
                    break;
                }
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

    function getSelectedRows(){
        var table = $(tableName).DataTable();
        const selected = table.rows({ selected: true }).data();

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

    $(document).on('click', '.delete-company-user-btn', function(e){
        e.preventDefault();
        const deleteEl = $(this);
        swal({
            title: Lang.get('messages.common.delete') ,
            text: Lang.get('messages.common.are_you_sure_want_to_delete'),
            type: 'warning',
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: false,
            confirmButtonColor: '#6777ef',
            cancelButtonColor: '#d33',
            cancelButtonText: Lang.get('messages.common.no'),
            confirmButtonText: Lang.get('messages.common.yes')
        }, function () {
            $.post(
                '/admin/delete-company-user',
                {
                    'companyUserId': deleteEl.attr('data-id'),
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                '',
                'json'
            ).done(function (objResponse) {

                if (!objResponse.status) {
                    iziToast.error({
                        title: Lang.get('messages.common.error'),
                        message: objResponse.message,
                        position: 'topRight'
                    });

                    console.error('There was an error deleting the company');

                    return;
                }

                location.reload();

            }).fail(function () {
                iziToast.error({
                    title: Lang.get('messages.common.error'),
                    message: Lang.get('messages.common.process_failed'),
                    position: 'topRight'
                });
                console.error('There was an error deleting the company');
            });
        });
        return false;
    });

});
