/******/
(() => { // webpackBootstrap
    /******/
    "use strict";
    var __webpack_exports__ = {};
    /*!******************************************************************************!*\
      !*** ./resources/assets/js/candidates/candidate-profile/candidate-resume.js ***!
      \******************************************************************************/


    $(document).ready(function () {

        $(document).on('click', '.uploadDocumentsModal', function () {
            $('#uploadModal').appendTo('body').modal('show');
        });

        $(document).on("change",".changeResumeActiveFlag", function () {

            console.log("1--");

            let elem = $(this);
            let mediaId = $(this).attr("data-id");
            let change_to = $(this).attr("change-to");
            let invert_value = 1;
            if(change_to==1){
                invert_value = 0;
            }

            $.ajax({
                url: setResumeStatusUrl + "/" + mediaId + "/" + change_to,
                type: 'post',
                data: null,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function success(result) {
                    if (result.success) {
                        displaySuccessMessage(result.message);
                        $(".changeResumeActiveFlag[data-id="+mediaId+"]").attr("change-to",invert_value);
                    }
                },
                error: function error(result) {

                    if(change_to==1){
                        $(elem).prop("checked", false);
                    }else{
                        $(elem).prop("checked", true);
                    }

                    displayErrorMessage(result.responseJSON.message);
                    setTimeout(function () {
                        processingBtn('#addNewForm', '#btnUploadSave', 'reset');
                    }, 1000);
                },
                complete: function complete() {
                    setTimeout(function () {
                        processingBtn('#addNewForm', '#btnUploadSave');
                    }, 1000);
                }
            });
        });

        $(document).on('click', '#btnUploadSave', function (e) {

            let myForm = document.getElementById('addNewDocumentForm');

            e.preventDefault();
            processingBtn('#addNewDocumentForm', '#btnUploadSave', 'loading');
            $.ajax({
                url: documentUploadUrl,
                type: 'post',
                data: new FormData(myForm),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function success(result) {
                    if (result.success) {
                        displaySuccessMessage(result.message);
                        $('#uploadModal').modal('hide');
                        setTimeout(function () {
                            processingBtn('#addNewForm', '#btnUploadSave', 'reset');
                        }, 1000);
                        location.reload();
                    }
                },
                error: function error(result) {
                    displayErrorMessage(result.responseJSON.message);
                    setTimeout(function () {
                        processingBtn('#addNewForm', '#btnUploadSave', 'reset');
                    }, 1000);
                },
                complete: function complete() {
                    setTimeout(function () {
                        processingBtn('#addNewForm', '#btnUploadSave');
                    }, 1000);
                }
            });


        });

        $(document).on('change', '#customFile', function () {
            var extension = isValidDocument($(this), '#validationErrorsBox');

            if (!isEmpty(extension) && extension != false) {
                $('#validationErrorsBox').html('').hide();
            }
        });

        window.isValidDocument = function (inputSelector, validationMessageSelector) {
            var ext = $(inputSelector).val().split('.').pop().toLowerCase();

            if ($.inArray(ext, ['jpg', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
                $(inputSelector).val('');
                $(validationMessageSelector).removeClass('d-none');
                $(validationMessageSelector).html('The document must be a file of type: jpeg, jpg, pdf, doc, docx.').show();
                $(validationMessageSelector).delay(5000).slideUp(300);
                return false;
            }

            $(validationMessageSelector).hide();
            return ext;
        };

        $('.custom-file-input').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
        });


        $(document).on('click', '.delete-resume', function (event) {

            var resumeId = $(event.currentTarget).attr('data-id');
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
                $.ajax({
                    url: documentUploadUrl + '/' + resumeId,
                    type: 'DELETE',
                    success: function success(result) {
                        if (result.success) {
                            swal({
                                title: Lang.get('messages.common.deleted'),
                                text: Lang.get('messages.common.has_been_deleted'),
                                type: 'success',
                                confirmButtonColor: '#6777ef',
                                timer: 2000
                            });

                            setTimeout(location.reload(), 2000);
                        }else{
                            swal({
                                title: 'Hiba',
                                text: "Váratlan hiba lépett fel",
                                type: 'error',
                                timer: 5000
                            });
                        }


                    },
                    error: function error(data) {
                        swal({
                            title: '',
                            text: data.responseJSON.message,
                            type: 'error',
                        });
                    }
                });
            });
        });
    });
    $('#uploadModal').on('hidden.bs.modal', function () {
        $('#customFile').siblings('.custom-file-label').addClass('selected').html('Choose file');
        resetModalForm('#addNewForm', '#validationErrorsBox');
    });
    /******/
})()
;
