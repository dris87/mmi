
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
                'orderable': true,

            },
            {
                'targets': [1],
                'className': 'text-left',
                'width': "25%",
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
                'type': 'date',
                'className': 'text-center',
                'orderable': false
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
            },
            {
                'targets': [8],
                'className': 'text-center',
                'width': "100px",
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
                data: 'city',
                name: 'city'
            },
            {
                data: function (row){
                    return row.first_name +" "+row.last_name+" ("+row.user_id+")";
                },
                name: 'status'
            },
            {
                data: '_created_at',
                name: '_created_at'
            },
            {
                data: function (row){
                    return "Direkt jelentkezés";
                },
                name: '-'
            },

            {
                data: 'job_stage_name',
                name: 'job_stage_name'
            },
            {
                data: 'site_name',
                name: 'site_name'
            },
            {
                name: 'actions',
                data: function data(row) {

                    var downloadUrl = resumeDownloadUrl + '/' + row.id;
                    var data = [{
                        'id': row.id,
                        'job_id': row.job_hash,
                        'frontJobDetail':frontJobDetail,
                        'resume_id':row.resume_id,
                    }];
                    return prepareTemplateRender('#companyApplicatonOptions', data);
                },
                export: false
            }
        ]
    };

    initialiseDatatable($(tableName), companyApplicationsUrl, config, Lang.get('messages.candidates_table.filename'));

    $(document).on('click', "#triggerLoadJobApplicantsResumes",function (e) {

        var job_application_id = $(this).attr("data-job-application-id");
        var url = appliedApplicantResumesUrl.replace('slug', job_application_id);
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'GET',
            success : function (objResponse) {
                console.log(objResponse)
                if (!objResponse.status) {
                    displayErrorMessage(objResponse.message);
                }
                $('#appliedResumesBody').html(objResponse.data.html);
            },
            error: function error(result) {
                displayErrorMessage(result.responseJSON.message);
            }
        });
    });

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
