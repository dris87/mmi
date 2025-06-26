$(document).ready(function () {


    $('.advanced_filters_button').on("click",function (){
        $(".advanced_filters_button").hide();
        $(".advanced_filters").show();
    });

    $('.simple_filters_button').on("click",function (){
        $(".advanced_filters_button").show();
        $(".advanced_filters").hide();
    });


    $('#loginForm').submit(function (e) {
        const formEl = $(this);
        e.preventDefault();

        formEl.find('button.submit-btn').prop('disabled', true);
        formEl.find('button.submit-btn').html('Kérem várjon...');

        $.post(
            '/users/login',
            $(this).serialize(),
            '',
            'json'
        ).done(function (objResponse) {

            if (objResponse.status != 1) {
                swal('Hiba', objResponse.message, 'error');
                formEl.find('button.submit-btn').prop('disabled', false);
                formEl.find('button.submit-btn').html('Bejelentkezés');
                formEl.find('input[name="_token"]').val(objResponse.data.token);
                return;
            }
            iziToast.success({
                title: 'Siker',
                message: 'Ön sikeresen bejelentkezett... Pár másodpercen belül átirányítjuk a kezelőfelületre.',
                position: 'topRight'
            });
            location.replace(objResponse.data.redirectTo);

        }).fail(function (objResponse) {
            formEl.find('button.submit-btn').prop('disabled', false);
            formEl.find('button.submit-btn').html('Bejelentkezés');
            formEl.find('input[name="_token"]').val(objResponse.data.token);
            swal('Hiba', 'A bejelentkezés során hiba lépett fel, kérjük próbálja újra késöbb!', 'error');
        });
    })

    $('#addEmployerNewForm').submit(function (e) {
        const formEl = $(this);
        e.preventDefault();
        if (formEl.valid()) {
            formEl.find('#btnEmployerSave').prop('disabled', true);
            formEl.find('#btnEmployerSave').html('Kérem várjon...');
            $.post(
                '/api/company/register',
                $(this).serialize(),
                '',
                'json'
            ).done(function (objResponse) {

                if (objResponse.status != 1) {
                    swal({html: true, title: 'Hiba', text: objResponse.message, type: 'error'});
                    formEl.find('#btnEmployerSave').prop('disabled', false);
                    formEl.find('#btnEmployerSave').html('Regisztráció');
                    formEl.find('input[name="_token"]').val(objResponse.data.token);
                    return;
                }
                iziToast.success({
                    title: 'Siker',
                    message: objResponse.data.content,
                    position: 'topRight'
                });

                swal({
                    title: objResponse.data.heading,
                    text:objResponse.data.content,
                    type: "success"
                }, function () {
                    location.replace("/munkaadoknak")
                });

            }).fail(function (objResponse) {
                formEl.find('#btnEmployerSave').prop('disabled', false);
                formEl.find('#btnEmployerSave').html('Regisztráció');
                formEl.find('input[name="_token"]').val(objResponse.data.token);
                swal('Hiba', 'A regisztráció során hiba lépett fel, kérjük próbálja újra késöbb!', 'error');
            });
        }
    })

});
