window.displayCoverPhoto = function (input, selector) {
    var displayPreview = true;

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(selector).css('background-image', 'url('+e.target.result+')');
        };
        if (displayPreview) {
            reader.readAsDataURL(input.files[0]);
        }
    }
};
$(document).on('change', '.cover-photo-uploader', function () {
    if ($(this).valid() === true ) {
        displayCoverPhoto(this, $('.cover-photo'));
    }
    else{
        $('.cover-photo').css('background-image', 'url(/assets/img/placeholder.png)');
        $(this).wrap('<form>').closest('form').get(0).reset();
        $(this).unwrap();
    }
});
$(document).on('change', '.company-logo-uploader', function () {
    if ($(this).valid() === true ) {
        displayCoverPhoto(this, $('.company-logo'));
    }
    else{
        $('.cover-photo').css('background-image', 'url(/assets/img/placeholder.png)');
        $(this).wrap('<form>').closest('form').get(0).reset();
        $(this).unwrap();
    }
});
function setVideoAccordionTitle(inputEl){
    const videoItemWrapper = inputEl.parents('.company-video');
    if(inputEl.val().length > 0){
        videoItemWrapper.find('.video-item-title').html(inputEl.val());
    }
    else{
        videoItemWrapper.find('.video-item-title').html(Lang.get('messages.common.video') + '#'+$('#companyVideos').find('.company-video').length+1);
    }
}
$(document).on('change, blur, keyup, keydown, input', '.video-title-input', function(e){
    setVideoAccordionTitle($(this));
});

$(document).on('click', '.addVideoBtn', function(e){
    e.preventDefault();
    const videoItemWrapper = $(this).parent().parent().parent().parent();
    const videoInputEl = videoItemWrapper.find('.video-input');

    if(videoInputEl.val().length !== 0 && videoInputEl.valid() === true){
        $.post(
            '/api/video/get-video-details',
            {
                'url': videoInputEl.val()
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

                console.error('There was an error getting the video details');

                videoItemWrapper.find('.video-title-input').val('').trigger("change");
                videoItemWrapper.find('.video-description-input').val('');
                setVideoAccordionTitle(videoItemWrapper.find('.video-title-input'));
                videoItemWrapper.find('.thumbnail-preview').attr('src', '/assets/img/placeholder.png');
                videoItemWrapper.find('iframe').attr('src', '');

                return;
            }

            videoItemWrapper.find('.video-title-input').val(objResponse.data.title);
            setVideoAccordionTitle(videoItemWrapper.find('.video-title-input'));
            videoItemWrapper.find('.video-description-input').val(objResponse.data.description);
            videoItemWrapper.find('.thumbnail-preview').attr('src', objResponse.data.thumbnail);

            videoItemWrapper.find('.video-title-input').validate();
            videoItemWrapper.find('.video-description-input');
            videoItemWrapper.find('.thumbnail-preview');
            videoItemWrapper.find('iframe').attr('src', objResponse.data.embed_video);

            const validator = $( "#editCompanyForm" ).validate();
            validator.resetElements( videoItemWrapper.find('.video-title-input'));
            validator.resetElements(videoItemWrapper.find('.video-description-input'));

        }).fail(function () {
            iziToast.error({
                title: Lang.get('messages.common.error'),
                message: Lang.get('messages.common.process_failed'),
                position: 'topRight'
            });
            console.error('There was an error getting the video details');
        });
    }
});

$(document).on('click', '.delete-site-item', function(e){
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
        if($('#companySites').find('.company-site').length <= 0){
            $('#companySites').hide();
            $('#companySitePlaceholder').show();
        }
    });
    return false;
})

$(document).on('click', '.delete-award-item', function(e){
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
        if($('#companyAwards').find('.company-award').length <= 0){
            $('#companyAwards').hide();
            $('#companyAwardPlaceholder').show();
        }
    });
    return false;
})

$(document).on('click', '.delete-video-item', function(e){
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
        deleteEl.parent().parent().parent().parent().parent().remove();
        if($('#companyVideos').find('.company-video').length <= 0){
            $('#companyVideos').hide();
            $('#companyVideoPlaceholder').show();
        }
    });
    return false;
})
$(document).on('click', '.delete-gallery-item', function(e){
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
        if($('#companyGalleries').find('.company-gallery').length <= 0){
            $('#companyGalleries').hide();
            $('#companyGalleryPlaceholder').show();
        }
    });
    return false;
})
$(document).on('change', '.video-thumbnail-uploader', function () {
    if ($(this).valid() === true ) {
        displayPhoto(this, $(this).parent().parent().find('.thumbnail-preview'));
    }
    else{
        $(this).parent().parent().find('.thumbnail-preview').attr('src', '/assets/img/placeholder.png');
        $(this).wrap('<form>').closest('form').get(0).reset();
        $(this).unwrap();
    }
});

$('#addVideo').click(function(e){
    e.preventDefault();

    const companyVideoEl = $('#companyVideos');
    const companyVideoPlaceholder = $('#companyVideoPlaceholder');
    const iterator = companyVideoEl.find('.company-video').length;

    $.post(
        '/api/company/get-video-layout',
        {
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
            console.error('There was an error getting the video layout');
        }
        if(companyVideoPlaceholder.is(':visible')){
            companyVideoPlaceholder.fadeOut(600, function(){
                companyVideoEl.append(objResponse.data.view).fadeIn();
            });
        }
        else{
            companyVideoEl.append(objResponse.data.view);
        }
    }).fail(function () {
        iziToast.error({
            title: Lang.get('messages.common.error'),
            message: Lang.get('messages.common.process_failed'),
            position: 'topRight'
        });
        console.error('There was an error getting the video layout');
    });
});
$(document).ready(function(){
    // $("#companyGalleries").sortable({
    //     items:'.company-gallery',
    //     cursor: 'move',
    //     opacity: 0.5,
    //     containment: '#companyGalleries',
    //     connectWith: "#companyGalleries",
    //     distance: 10,
    //     tolerance: 'pointer'
    // });
});
$('#addSite').click(function(e){
    e.preventDefault();

    const companySiteEl = $('#companySites');
    const companySitePlaceholder = $('#companySitePlaceholder');
    const iterator = companySiteEl.find('.company-site').length;

    $.post(
        '/api/company/get-company-site-layout',
        {
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
            console.error('There was an error getting the site layout');
        }
        if(companySitePlaceholder.is(':visible')){
            companySitePlaceholder.fadeOut(600, function(){
                companySiteEl.append(objResponse.data.view).fadeIn();
            });
        }
        else{
            companySiteEl.append(objResponse.data.view);
        }
    }).fail(function () {
        iziToast.error({
            title: Lang.get('messages.common.error'),
            message: Lang.get('messages.common.process_failed'),
            position: 'topRight'
        });
        console.error('There was an error getting the site layout');
    });
});
$('#addGallery').click(function(e){
    e.preventDefault();

    const companyGalleryEl = $('#companyGalleries');
    const companyGalleryPlaceholder = $('#companyGalleryPlaceholder');
    const iterator = companyGalleryEl.find('.company-gallery').length;

    $.post(
        '/api/company/get-company-gallery-layout',
        {
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
            console.error('There was an error getting the Gallery layout');
        }
        if(companyGalleryPlaceholder.is(':visible')){
            companyGalleryPlaceholder.fadeOut(600, function(){
                companyGalleryEl.append(objResponse.data.view).fadeIn();
                companyGalleryEl.sortable( "refresh" );
            });

        }
        else{
            companyGalleryEl.append(objResponse.data.view);
            companyGalleryEl.sortable( "refresh" );
        }
    }).fail(function () {
        iziToast.error({
            title: Lang.get('messages.common.error'),
            message: Lang.get('messages.common.process_failed'),
            position: 'topRight'
        });
        console.error('There was an error getting the Gallery layout');
    });
});
$('#addAward').click(function(e){
    e.preventDefault();

    const companyAwardEl = $('#companyAwards');
    const companyAwardPlaceholder = $('#companyAwardPlaceholder');
    const iterator = companyAwardEl.find('.company-award').length;

    $.post(
        '/api/company/get-company-award-layout',
        {
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
            console.error('There was an error getting the award layout');
        }
        if(companyAwardPlaceholder.is(':visible')){
            companyAwardPlaceholder.fadeOut(600, function(){
                companyAwardEl.append(objResponse.data.view).fadeIn();
            });
        }
        else{
            companyAwardEl.append(objResponse.data.view);
        }
    }).fail(function () {
        iziToast.error({
            title: Lang.get('messages.common.error'),
            message: Lang.get('messages.common.process_failed'),
            position: 'topRight'
        });
        console.error('There was an error getting the award layout');
    });
});
// $(document).on('change, keyup, keydown, input', '#companyName', function(){
//    if($(this).valid() === true){
//        $('.company-name-title').find('h2').html($(this).val());
//    }
//    else{
//        $('.company-name-title').find('h2').html('');
//    }
// });
