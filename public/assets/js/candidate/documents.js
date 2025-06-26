$(document).ready(function(){
    console.log("--");
    var tableName = '#candidateDocumentTbl';

    let config = {
        dom: '<"toolbar">Blfrtip',
        order: [[ 0, "desc" ]],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        columnDefs: [
            {
                className: 'batch-select-checkbox-wrapper text-center',
                'targets': [0],
                'width': '2%',
                'orderable': true
            },
            {
                'targets': [1],
                'className': 'text-left',
                'width': '40%'
            },
            {
                'targets': [2],
                'className': 'text-center',
            },
            {
                'targets': [3],
                'type': 'date',
                'orderable': false
            },
            {
                targets: '_all',
                defaultContent: '-'
            }],
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: function data(row) {
                    return row.custom_properties.title
                },
                name: 'name',
            },
            {
                data: '_created_at',
                name: '_created_at',
            },

            {
                name: 'actions',
                data: function data(row) {
                    var downloadUrl = resumeDownloadUrl + '/' + row.id;
                    var data = [{
                        'id': row.id,
                        'downloadUrl':downloadUrl
                    }];
                    return prepareTemplateRender('#candidateDocumentActionTemplate', data);
                },
                export: false
            }
        ]
    };

    initialiseDatatable($(tableName), documentsListUrl, config, Lang.get('messages.candidates_table.filename'));

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

});
