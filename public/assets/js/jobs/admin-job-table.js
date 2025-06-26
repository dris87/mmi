$(document).ready(function () {
    var tableName = '#jobsTbl';

    let config = {
        dom: '<"toolbar">Blfrtip',
        order: [[1, "desc"]],
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
                'className': 'text-left',
                'orderable': true,
            },
            {
                'targets': [2],
                'className': 'text-center',
            },
            {
                'targets': [3],
                'className': 'text-center',
            },
            {
                'targets': [4],
                'className': 'text-center',
            },
            {
                'targets': [5],
                'className': 'text-center',
            },
            {
                'targets': [6],
                'className': 'text-center',
            },
            {
                'targets': [7],
                'className': 'text-center',
                "type":"date-eu"
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
                data: 'company.name',
                name: 'company.name'
            },
            {
                data: 'job_title',
                name: 'job_title'
            },
            {
                data: function (row) {
                    if (row.number_of_cities > 1) {
                        let more = (row.number_of_cities)/1;
                        return row.city_name + "...<br><div class=\"form-tooltip\">további "+(more-1)+" település</div>";
                    }
                    return row.city_name;
                },
                name: 'status'
            },
            {
                data: function (row) {
                    return row.job_release_date + "<br>" + row.job_expiry_date;
                },
                name: 'job_expiry_date'
            },
            {
                data: function (row) {
                    if (row.job_applications) {
                        return row.job_applications.length;
                    }
                    return "-";
                },
                name: 'job_expiry_date'
            },
            {
                data: function (row){

                    if (row.status==1){
                        return "<span class=\"badge badge-warning\" style='    padding: 8px 8px;'><i class=\"fas fa-bell\"></i></span><br>"+Lang.get('messages.job_status.'+array_job_status[row.status]);
                    }
                    return Lang.get('messages.job_status.'+array_job_status[row.status]);
                },
                name: 'status'
            },
            {
                data: '_created_at',
                name: '_created_at'
            },
            {
                name: 'actions',
                data: function data(row) {
                    var url = "test" + '/' + row.id;

                    edit_url = JobsEdit.replace('slug', row.id);

                    var data = [{
                        'id': row.id,
                        'url': url + '/edit',
                        'job_id':row.job_id,
                        'frontJobDetail':frontJobDetail,
                        'edit_url':edit_url
                    }];
                    return prepareTemplateRender('#jobActionTemplate', data);
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
                        <option value="generate-excel">`+Lang.get('messages.candidates_table.generate_excel')+`</option>
                    </select>
                    <button id="submitBatchAction" class="btn btn-primary mr-5">`+Lang.get('messages.common.batch_submit')+`</button>
                </div>
            `);
        }
    };

    initialiseDatatable($(tableName), JobsListUrl, config, Lang.get('messages.jobs_table.filename'));

    $(document).on('click', "#triggerLoadJobApplicants",function (e) {

        var job_id = $(this).attr("data-job-id");
        var url = appliedApplicantsUrl.replace('slug', job_id);
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'GET',
            success : function (objResponse) {
                console.log(objResponse)
                if (!objResponse.status) {
                    displayErrorMessage(objResponse.message);
                }
                $('#appliedApplicantsBody').html(objResponse.data.html);
            },
            error: function error(result) {
                displayErrorMessage(result.responseJSON.message);
            }
        });
    });

    $(document).on('submit', '#statusUpdateForm', function(e){
        e.preventDefault();
        $('#btnBatchStatusUpdate').val(Lang.get('messages.common.processing'));
        $('#btnBatchStatusUpdate').prop('disabled', true);
        $.post(
            '/admin/batch-job-status-update',
            {status: $('#batchStatus').val(), jobs: getSelectedRows()},
            '',
            'json'
        ).done(function (objResponse) {

            if (objResponse.status != 1) {
                iziToast.error({
                    title: Lang.get('messages.common.error'),
                    message: Lang.get('messages.datatable.batch_process_failed'),
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
    $(document).on('submit', '#companyTableForm', function(e){
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
                                <td>`+row.job_title+`</td>
                                <td>`+Lang.get('messages.job_status.'+array_job_status[row.status])+`</td>
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

});

