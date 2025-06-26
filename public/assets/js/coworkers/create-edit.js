$(document).ready(function () {
    setTimeout(function (){
        const form_name = "editCompanyUserForm";
        $('#'+form_name+' input').filter(function() {
            return $.trim($(this).val()) != '';
        }).blur();
        $('#'+form_name+' select').filter(function() {
            return $.trim($(this).val()) != '';
        }).blur();

        $('#'+form_name+' input').removeClass("is-valid");
        $('#'+form_name+' select').removeClass("is-valid")

    }, 2000);
    $('#companySiteId').select2({
        width: '100%',
        language: {
            "noResults": function(){
                return Lang.get('messages.coworker.site_not_found');
            }
        },
        //allowClear: true
    });
    $('#coworkerPositionId').select2({
        width: '100%',
        placeholder: Lang.get('messages.coworker.select_position'),
        language: {
            "noResults": function(){
                return Lang.get('messages.coworker.position_not_found');
            }
        },
    });
    $('#coworkerPermissionId').select2({
        width: '100%',
        placeholder: Lang.get('messages.coworker.select_permission'),
        language: {
            "noResults": function(){
                return Lang.get('messages.coworker.permission_not_found');
            }
        },
    });
    $('#coworkerStatus').select2({
        width: '100%',
    });

    const siteId = $('#companySiteSelectWrapper').attr('data-site-id');
    if(siteId === ''){
        $('#companySiteId').val('');
    }

    $('#deleteCoworker').click(function(){

        swal({
            title: Lang.get('messages.common.delete'),
            text: Lang.get('messages.common.are_you_sure_want_to_delete'),
            type: 'warning',
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#6777ef',
            cancelButtonColor: '#d33',
            cancelButtonText: Lang.get('messages.common.no'),
            confirmButtonText: Lang.get('messages.common.yes')
        }, function () {
            $.post(
                '/admin/delete-company-user',
                {
                    'companyUserId': coworkerId,
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                '',
                'json'
            ).done(function (result) {
                if (result.status) {
                    swal({
                        title: Lang.get('messages.common.deleted'),
                        text: Lang.get('messages.common.has_been_deleted'),
                        type: 'success',
                        confirmButtonColor: '#6777ef',
                        timer: 2000
                    });
                    setTimeout(function(){ location.replace($('#backBtn').attr('href'));}, 2000);
                }else{
                    swal({
                        title: Lang.get('messages.common.error'),
                        text: result.message,
                        type: 'error',
                        timer: 5000
                    });
                }
            })
            .fail(function(data) {
                swal({
                    title: Lang.get('messages.common.error'),
                    text: Lang.get('messages.common.process_failed'),
                    type: 'error',
                    timer: 5000
                });
            });
        });
    });
});

