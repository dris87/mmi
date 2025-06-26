
$(document).ready(function(){
    var tableName = '#applicationCandidateLogTbl';

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
                'className': 'text-center',
            },
            {
                'targets': [4],
                'className': 'text-center',
            },
            {
                'targets': [5],
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
                data: 'job_title',
                name: 'job_title'
            },
            {
                data: 'company_name',
                name: 'company_name'
            },
            {
                data: function (row){
                    return Lang.get('messages.job_status.'+array_job_status[row.status]);
                },
                name: 'status'
            },
            {
                data: '',
                name: ''
            },
            {
                data: 'job_stage_name',
                name: 'job_stage_name'
            },


            {
                data: '_created_at',
                name: '_created_at'
            },
            {
                data: '',
                name: ''
            },
            // {
            //     data: function data(row) {
            //         return row.custom_properties.title
            //     },
            //     name: 'name',
            // },
            // {
            //     data: function data(row) {
            //         if( row.custom_properties.language !== undefined){
            //             return  languages[row.custom_properties.language]["language"];
            //         }else{
            //             return "-";
            //         }
            //     },
            //     name: 'language',
            // },
            // {
            //     data: function data(row) {
            //         if( row.custom_properties.active==true){
            //             invertedValue = 0;
            //             // return  "<span style='color:green;'><b>Aktív</b></span>";
            //         }else{
            //             invertedValue = 1;
            //             // return "<span style='color:#c5c5c5'>Inaktív</span>";
            //         }
            //
            //         let investValue = 0;
            //
            //         var setResumeStatusUrl = setResumeStatusUrl + '/' + row.id+'/'+invertedValue;
            //         var data = [{
            //             'change_to':invertedValue,
            //             'id':row.id,
            //             'current_status':row.custom_properties.active,
            //             'setResumeStatusUrl':setResumeStatusUrl
            //         }];
            //         return prepareTemplateRender('#candidateCVActiveSwitcher', data);
            //
            //
            //     },
            //     name: 'is_default',
            // },
            // {
            //     data: '_created_at',
            //     name: '_created_at',
            // },
            //

        ]
    };

    initialiseDatatable($(tableName), candidateApplicationsUrl, config, Lang.get('messages.candidates_table.filename'));

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
