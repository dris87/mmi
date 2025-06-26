$(document).ready(function(){
    var tableName = '#candidateTbl';

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
                'width': '5%'
            },
            {
                'targets': [1],
                'orderable': true,
            },
            {
                'targets': [5],
                'type': 'date'
            },
            {
                'targets': [6],
                'className': 'text-center'
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
                data: function data(row) {

                    var data = [{
                        'name': row.name,
                        'id': row.id,
                    }];

                    return prepareTemplateRender('#candidateLinklink', data);
                },
                name: 'candidateLinklink',
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
                data: 'latest_activity',
                name: 'latest_activity',
            },
            {
                data: 'job_status',
                name: 'job_status',
            },

            {
                name: 'actions',
                data: function data(row) {
                    var url = candidateUrl + '/' + row.id;
                    var data = [{
                        'id': row.id,
                        'url': url + '/edit',
                        'hasResume': row.hasResume
                    }];
                    return prepareTemplateRender('#candidateActionTemplate', data);
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
                        <option value="generate-pdf">`+Lang.get('messages.candidates_table.generate_pdf')+`</option>
                        <option value="assign-campaign">`+Lang.get('messages.candidates_table.assign_campaign')+`</option>
                        <option value="assign-job">`+Lang.get('messages.candidates_table.assign_job')+`</option>
                    </select>
                    <button id="submitBatchAction" class="btn btn-primary mr-5">`+Lang.get('messages.common.batch_submit')+`</button>
                </div>
            `);
        }
    };

    initialiseDatatable($(tableName), candidateAjaxUrl, config, Lang.get('messages.candidates_table.filename'));

    $(document).on('click', '.download-cv', function(e){
        $.post(
            '/admin/candidate/get-cv',
            {candidate: $(this).attr('data-id')},
            '',
            'json'
        ).done(function (objResponse) {
            const cvModal = $('#cvModal');
            if (objResponse.status != 1) {
                iziToast.error({
                    title: Lang.get('messages.common.error'),
                    message: Lang.get('messages.datatable.batch_process_failed'),
                    position: 'topRight',
                });
                return;
            }

            const resumeCount = objResponse.data.resumes.length

            if(resumeCount === 1){
                location.replace('/admin/media/'+objResponse.data.resumes[0].id);
            }
            else{
                cvModal.find('.table tr').remove();
                $.each(objResponse.data.resumes, function( index, row ) {
                    cvModal.find('.table').append(`
                            <tr>
                                <td><a href="/admin/media/`+row.id+`">`+row.name+`</a></td>
                            </tr>
                        `);
                });
                cvModal.modal('show');
            }


        }).fail(function () {
            iziToast.error({
                title: Lang.get('messages.common.error'),
                message: Lang.get('messages.common.process_failed'),
                position: 'topRight',
            });
        });
    });

    $(document).on('submit', '#generatePdfForm', function(e){
        e.preventDefault();
        $('#btnGeneratePdfModal').val(Lang.get('messages.common.processing'));
        $('#btnGeneratePdfModal').prop('disabled', true);

        $.ajax({
            type: "POST",
            url: '/admin/generate-candidate-cv-bulk',
            data: {status: $('#batchStatus').val(), candidates: getSelectedRows()},
            xhrFields: {
                responseType: 'blob' // to avoid binary data being mangled on charset conversion
            },
            success: function(blob, status, xhr) {
                // check for a filename
                var filename = "";
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                }

                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);

                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");
                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location.href = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                        }
                    } else {
                        window.location.href = downloadUrl;
                    }
                    $('#btnGeneratePdfModal').val(Lang.get('messages.candidates_table.do_batch_pdf_generate'));
                    $('#btnGeneratePdfModal').prop('disabled', false);
                    $('#generatePdfModal').modal('hide');

                    setTimeout(function () { URL.revokeObjectURL(downloadUrl); }, 100); // cleanup
                }
            }
        });
    });

    $(document).on('submit', '#statusUpdateForm', function(e){
        e.preventDefault();
        $('#btnBatchStatusUpdate').val(Lang.get('messages.common.processing'));
        $('#btnBatchStatusUpdate').prop('disabled', true);
        $.post(
            '/admin/batch-candidate-status-update',
            {status: $('#batchStatus').val(), candidates: getSelectedRows()},
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
            // initialiseDatatable($(tableName), candidateUrl, config, Lang.get('messages.candidates_table.filename'));

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
    $(document).on('submit', '#candidateTableForm', function(e){
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
                    statusUpdateModal.find('.table tr').remove();
                    $.each(items, function( index, row ) {
                        statusUpdateModal.find('.table').append(`
                            <tr>
                                <td>`+row.id+`</td>
                                <td>`+row.name+`</td>
                                <td>`+row.job_status+`</td>
                            </tr>
                        `);
                    });
                    statusUpdateModal.find('.table').append()
                    statusUpdateModal.modal('show');
                    break;
                }
                case 'generate-pdf': {
                    const generatePdfModal = $('#generatePdfModal');
                    const selected = $(tableName).DataTable().rows({ selected: true }).data();
                    const items = $.map(selected, function (item) {
                        return item
                    });
                    generatePdfModal.find('#items_count').html(items.length);
                    generatePdfModal.modal('show');
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
