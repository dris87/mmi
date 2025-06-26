(function(a){function d(e){0<e.clientY||(b&&clearTimeout(b),0>=a.exitIntent.settings.sensitivity?a.event.trigger("exitintent"):b=setTimeout(function(){b=null;a.event.trigger("exitintent")},a.exitIntent.settings.sensitivity))}function c(){b&&(clearTimeout(b),b=null)}var b;a.exitIntent=function(b,f){a.exitIntent.settings=a.extend(a.exitIntent.settings,f);if("enable"==b)a(window).mouseleave(d),a(window).mouseenter(c);else if("disable"==b)c(),a(window).unbind("mouseleave",d),a(window).unbind("mouseenter",
    c);else throw"Invalid parameter to jQuery.exitIntent -- should be 'enable'/'disable'";};a.exitIntent.settings={sensitivity:300}})(jQuery);
$.exitIntent('enable');


function resetJsValidation(form_name){
    setTimeout(function (){
        $('#'+form_name+' input').filter(function() {
            return $.trim($(this).val()) != '';
        }).blur();
        $('#'+form_name+' select').filter(function() {
            return $.trim($(this).val()) != '';
        }).blur();
        console.log("111");

        $('#'+form_name+' input').removeClass("is-valid");
        $('#'+form_name+' select').removeClass("is-valid")

    }, 2000);
}

$(document).ready(function () {

    $("select").on("select2:close", function (e) {
        $(this).valid();
    });

    $(document).on('change', '#expected_salary_to', function(){


        var timeoutID = setTimeout(function (){

            var validator = $( "#update-candidate-profile" ).validate();
            validator.resetElements( $("#expected_salary") )
            validator.resetElements( $("#expected_salary_to") )


        }, 100);


    })

    $(document).on('change', '#expected_salary_to', function(){
        var timeoutID = setTimeout(function (){

            var validator = $( "#update-candidate-profile" ).validate();
            validator.resetElements( $("#expected_salary") )
            validator.resetElements( $("#expected_salary_to") )


        }, 100);


    })

    $(document).on('click', '.delete-requirement-item', function(e){
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
            deleteEl.parent().parent().parent().remove();
            if($('#jobRequirements').find('.job-requirement-item').length <= 0){
                $('#jobRequirementPlaceholder').show();
            }
        });
        return false;
    })
    function isValidImage(imageInput){
        const fileSize = this.files[0].size / 1024 / 1024 + "MiB";
    }
    $(document).on('change', '.image-uploader', function () {
        if ($(this).valid() === true ) {
            displayPhoto(this, $(this).parent().parent().parent().find('.thumbnail-preview'));
        }
        else{
            $(this).wrap('<form>').closest('form').get(0).reset();
            $(this).unwrap();
        }
    });
    function toggleMailingAddressWrapper(){
        if($('#diffMailingAddress').length > 0) {
            if ($('#diffMailingAddress').is(':checked')) {
                $('#mailingAddressWrapper').addClass('d-flex').stop().fadeIn();
            } else {
                $('#mailingAddressWrapper').removeClass('d-flex').stop().fadeOut();
            }
        }
    }

    toggleMailingAddressWrapper();

    $('#diffMailingAddress').change(function(){
        toggleMailingAddressWrapper();
    })

    $('#addJobRequirement').click(function(e){
        e.preventDefault();

        const jobRequirementSelectEl = $('#jobRequirementTypeSelect');
        const jobRequirementPlaceholder = $('#jobRequirementPlaceholder');
        const jobRequirements = $('#jobRequirements');

        const requirementTypeElGroup = $('.form-group[data-type='+jobRequirementSelectEl.val()+']');

        let iterator = 0;

        if(jobRequirementSelectEl.length > 0){
            console.log(requirementTypeElGroup);
            if(requirementTypeElGroup.length > 0) {
                requirementTypeElGroup.each(function () {
                    if ($(this).attr('data-iterator').length > 0) {
                        const i = parseInt($(this).attr('data-iterator'));
                        if (i > iterator) {
                            iterator = i;
                        }
                    }
                })
                iterator++;
            }

            $.post(
                '/api/job/get-requirement-layout',
                {
                    'type': jobRequirementSelectEl.val(),
                    'iterator': iterator
                },
                '',
                'json'
            ).done(function (objResponse) {

                if (!objResponse.status) {
                    iziToast.error({
                        title: Lang.get('messages.common.error'),
                        message: Lang.get('messages.common.process_failed'),
                        position: 'topRight'
                    });
                    console.error('There was an error getting the requirement layout');
                }
                if(jobRequirementPlaceholder.is(':visible')){
                    jobRequirementPlaceholder.fadeOut(600, function(){
                        jobRequirements.append(objResponse.data.view);
                    });
                }
                else{
                    jobRequirements.append(objResponse.data.view);
                }
            }).fail(function () {
                iziToast.error({
                    title: Lang.get('messages.common.error'),
                    message: Lang.get('messages.common.process_failed'),
                    position: 'topRight'
                });
                console.error('There was an error getting the requirement layout');
            });
        }
        else{
            console.error('Requirement type selector not found');
        }
    });

    function checkPhoneValidation(){
        const phoneEl = $('#phone');
        console.log(phoneEl.val().length)
        if (phoneEl.val().length < 6) {
            console.log('should skip');
            phoneEl.removeClass('is-valid');
            phoneEl.removeClass('is-invalid');
            phoneEl.addClass('no-validate');
            phoneEl.parent().find('.invalid-feedback').remove();
        }
        else{
            console.log('check');
            phoneEl.removeClass('no-validate');
        }
    }
    $('#phone').on('keyup',function(){
       checkPhoneValidation();
    });

    $('#phone').on('change, focusout', function(){
        console.log('change');
        console.log($('#phone'));
        $('#phone').removeClass('no-validate');
        $('#phone').valid();
    });

    function getCityByPostCode(postCodeEl, cityEl){
        const postcode = $(postCodeEl).val();

        if (postcode.length !== 4) {
            console.log("less then 4");
            cityEl.prop('readonly', false);
            cityEl.val('');
            cityEl.removeClass('is-valid');
            $(this).removeClass('is-valid');
            return;
        }

        // $(this).removeClass('is-valid');
        cityEl.removeClass('is-valid');

        $.post(
            '/api/get-city',
            {'postcode': postcode},
            '',
            'json'
        ).done(function (objResponse) {

            if (!objResponse.success) {
                cityEl.val('');
                cityEl.prop('readonly', false);
            }

            postCodeEl.removeClass('is-invalid').addClass('is-valid');
            cityEl.val(objResponse.data.city);
            cityEl.valid();
            cityEl.prop('readonly', true);

        }).fail(function () {
            cityEl.val('');
            cityEl.prop('readonly', false);
        });
    }
    $(document).on("keyup", "input", function () {

        if ($(this).attr("id") === "zipCode" || $(this).attr("id") === "mailingZipCode") {

            let cityEl = $(this).parent().parent().find("#city");
            if(cityEl.length <= 0){
                cityEl = $(this).parent().parent().find("#mailingCity");
            }
            const postCodeEl = $(this);
            getCityByPostCode(postCodeEl, cityEl);
        }
        else if($(this).hasClass('company-postcode-input')){
            let postCodeEl = $(this);
            let cityEl = $(this).parent().parent().find('.company-city-input');
            getCityByPostCode(postCodeEl, cityEl);
        }
    })

});
