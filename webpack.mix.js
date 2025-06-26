const mix = require('laravel-mix');
const fs = require('fs');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Segédfüggvény a fájlok létezésének ellenőrzésére
function copyIfExists(source, destination) {
    if (fs.existsSync(source)) {
        mix.copy(source, destination);
    } else {
        console.warn(`File not found: ${source}, skipping...`);
    }
}

// Optimalizációs beállítások
mix.options({
    processCssUrls: false,
    terser: {
        extractComments: false,
        terserOptions: {
            compress: {
                drop_console: mix.inProduction()
            }
        }
    }
});

// Development módban source maps engedélyezése
if (!mix.inProduction()) {
    mix.sourceMaps();
}

// Alap Vue és SASS kompilálás
mix.js('resources/js/app.js', 'public/js').vue();
mix.sass('resources/sass/app.scss', 'public/css');

/* SASS fájlok kompilálása */
mix.sass('resources/assets/sass/custom.scss', 'public/assets/css/custom.css')
    .sass('resources/assets/sass/companies-listing.scss', 'public/assets/css/companies-listing.css')
    .sass('resources/assets/sass/dashboard-widgets.scss', 'public/assets/css/dashboard-widgets.css')
    .sass('resources/assets/sass/web-popular-categories.scss', 'public/assets/css/web-popular-categories.css')
    .sass('resources/assets/sass/candidate-dashboard.scss', 'public/assets/css/candidate-dashboard.css')
    .sass('resources/assets/sass/front-blogs.scss', 'public/assets/css/front-blogs.css')
    .sass('resources/assets/sass/custom-theme.scss', 'public/assets/css/custom-theme.css')
    .sass('resources/assets/sass/infy-loader.scss', 'public/assets/css/infy-loader.css')
    .sass('resources/assets/sass/flex.scss', 'public/assets/css/flex.css')
    .sass('resources/assets/sass/stretchy-navigation.scss', 'public/assets/css/stretchy-navigation.css')
    .version();

/* Könyvtárak másolása */
mix.copyDirectory('resources/assets/img', 'public/assets/img');
mix.copyDirectory('node_modules/summernote/dist/font', 'public/assets/css/font');
mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/assets/webfonts');
mix.copyDirectory('node_modules/intl-tel-input/build/img', 'public/assets/css/inttel/img');

/* CSS fájlok másolása */
const cssFiles = [
    ['node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/assets/css/bootstrap.min.css'],
    ['node_modules/sweetalert/dist/sweetalert.css', 'public/assets/css/sweetalert.css'],
    ['node_modules/izitoast/dist/css/izitoast.min.css', 'public/assets/css/izitoast.min.css'],
    ['node_modules/datatables.net-dt/css/dataTables.dataTables.min.css', 'public/assets/css/jquery.dataTables.min.css'],
    ['node_modules/summernote/dist/summernote.min.css', 'public/assets/css/summernote.min.css'],
    ['node_modules/@fortawesome/fontawesome-free/css/all.min.css', 'public/assets/css/font-awesome.min.css'],
    ['node_modules/select2/dist/css/select2.min.css', 'public/assets/css/select2.min.css'],
    ['node_modules/ion-rangeslider/css/ion.rangeSlider.min.css', 'public/assets/css/ion.rangeSlider.min.css'],
    ['node_modules/intl-tel-input/build/css/intlTelInput.css', 'public/assets/css/inttel/css/intlTelInput.css'],
    ['node_modules/bootstrap-daterangepicker/daterangepicker.css', 'public/assets/css/daterangepicker.css'],
    ['node_modules/timepicker/jquery.timepicker.min.css', 'public/assets/css/jquery.timepicker.min.css']
];

cssFiles.forEach(([source, destination]) => {
    copyIfExists(source, destination);
});

/* JavaScript fájlok babel transzformációval */
const babelFiles = [
    ['node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/assets/js/bootstrap.min.js'],
    ['node_modules/jquery/dist/jquery.min.js', 'public/assets/js/jquery.min.js'],
    ['node_modules/popper.js/dist/umd/popper.min.js', 'public/assets/js/popper.min.js'],
    ['node_modules/sweetalert/dist/sweetalert.min.js', 'public/assets/js/sweetalert.min.js'],
    ['node_modules/moment/min/moment.min.js', 'public/assets/js/moment.min.js'],
    ['node_modules/chart.js/dist/Chart.min.js', 'public/assets/js/chart.min.js'],
    ['node_modules/bootstrap-daterangepicker/daterangepicker.js', 'public/assets/js/daterangepicker.js'],
    ['node_modules/izitoast/dist/js/iziToast.min.js', 'public/assets/js/iziToast.min.js'],
    ['node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/assets/js/jquery.dataTables.min.js'],
    ['node_modules/summernote/dist/summernote.min.js', 'public/assets/js/summernote.min.js'],
    ['node_modules/jquery.nicescroll/dist/jquery.nicescroll.js', 'public/assets/js/jquery.nicescroll.js'],
    ['node_modules/select2/dist/js/select2.min.js', 'public/assets/js/select2.min.js'],
    ['node_modules/ion-rangeslider/js/ion.rangeSlider.min.js', 'public/assets/js/ion.rangeSlider.min.js'],
    ['node_modules/intl-tel-input/build/js/intlTelInput.js', 'public/assets/js/inttel/js/intlTelInput.min.js'],
    ['node_modules/intl-tel-input/build/js/utils.js', 'public/assets/js/inttel/js/utils.min.js'],
    ['node_modules/autonumeric/dist/autoNumeric.min.js', 'public/assets/js/autonumeric/autoNumeric.min.js'],
    ['node_modules/handlebars/dist/handlebars.js', 'public/assets/js/handlebars.js'],
    ['node_modules/timepicker/jquery.timepicker.min.js', 'public/assets/js/jquery.timepicker.min.js']
];

babelFiles.forEach(([source, destination]) => {
    copyIfExists(source, destination);
});

/* Egyéb JavaScript fájlok */
mix.copy('resources/assets/js/currency.js', 'public/js/currency.js');

/* Custom JavaScript fájlok kompilálása */
const jsFiles = [
    ['custom/custom.js', 'custom/custom.js'],
    ['custom/custom-datatable.js', 'custom/custom-datatable.js'],
    ['job_categories/job_categories.js', 'job_categories/job_categories.js'],
    ['settings/settings.js', 'settings/settings.js'],
    ['company_sizes/company_sizes.js', 'company_sizes/company_sizes.js'],
    ['marital_status/marital_status.js', 'marital_status/marital_status.js'],
    ['salary_periods/salary_periods.js', 'salary_periods/salary_periods.js'],
    ['job_shifts/job_shifts.js', 'job_shifts/job_shifts.js'],
    ['industries/industries.js', 'industries/industries.js'],
    ['job_tags/job_tags.js', 'job_tags/job_tags.js'],
    ['job_types/job_types.js', 'job_types/job_types.js'],
    ['ownership_types/ownership_types.js', 'ownership_types/ownership_types.js'],
    ['companies/companies.js', 'companies/companies.js'],
    ['companies/create-edit.js', 'companies/create-edit.js'],
    ['languages/languages.js', 'languages/languages.js'],
    ['required_degree_levels/required_degree_levels.js', 'required_degree_levels/required_degree_levels.js'],
    ['functional_areas/functional_areas.js', 'functional_areas/functional_areas.js'],
    ['career_levels/career_levels.js', 'career_levels/career_levels.js'],
    ['user_profile/user_profile.js', 'user_profile/user_profile.js'],
    ['employer_profile/employer_profile.js', 'employer_profile/employer_profile.js'],
    ['salary_currencies/salary_currencies.js', 'salary_currencies/salary_currencies.js'],
    ['jobs/create-edit.js', 'jobs/create-edit.js'],
    ['jobs/jobs.js', 'jobs/jobs.js'],
    ['jobs/job_datatable_admin.js', 'jobs/job_datatable_admin.js'],
    ['jobs/front/job_search.js', 'jobs/front/job_search.js'],
    ['candidate/create-edit.js', 'candidate/create-edit.js'],
    ['custom/input_price_format.js', 'custom/input_price_format.js'],
    ['custom/state_country.js', 'custom/state_country.js'],
    ['candidates/candidate-profile/candidate-resume.js', 'candidate-profile/candidate-resume.js'],
    ['candidates/candidate-profile/candidate-education-experience.js', 'candidate-profile/candidate-education-experience.js'],
    ['candidates/candidate-profile/cv-builder.js', 'candidate-profile/cv-builder.js'],
    ['candidate/candidate-list.js', 'candidate/candidate-list.js'],
    ['jobs/front/apply_job.js', 'jobs/front/apply_job.js'],
    ['job_applications/job_applications.js', 'job_applications/job_applications.js'],
    ['custom/currency.js', 'custom/currency.js'],
    ['jobs/front/job_details.js', 'jobs/front/job_details.js'],
    ['candidates/candidate-profile/candidate_career_informations.js', 'candidate-profile/candidate_career_informations.js'],
    ['candidates/candidate-profile/candidate-general.js', 'candidate-profile/candidate-general.js'],
    ['testimonial/testimonial.js', 'testimonial/testimonial.js'],
    ['candidate/favourite_jobs.js', 'candidate/favourite_jobs.js'],
    ['jobs/reported_jobs.js', 'jobs/reported_jobs.js'],
    ['companies/front/company-details.js', 'companies/front/company-details.js'],
    ['candidate/favourite_company.js', 'candidate/favourite_company.js'],
    ['companies/front/reported_companies.js', 'companies/front/reported_companies.js'],
    ['companies/front/companies.js', 'companies/front/companies.js'],
    ['candidate_profile/candidate_profile.js', 'candidate_profile/candidate_profile.js'],
    ['front_register/front_register.js', 'front_register/front_register.js'],
    ['candidate/applied-jobs.js', 'candidate/applied-jobs.js'],
    ['skills/skills.js', 'skills/skills.js'],
    ['web/js/news_letter/news_letter.js', 'web/js/news_letter/news_letter.js'],
    ['noticeboards/noticeboards.js', 'noticeboards/noticeboards.js'],
    ['subscribers/subscribers.js', 'subscribers/subscribers.js'],
    ['faqs/faqs.js', 'faqs/faqs.js'],
    ['blog_categories/blog_categories.js', 'blog_categories/blog_categories.js'],
    ['blogs/blogs.js', 'blogs/blogs.js'],
    ['blogs/create-edit.js', 'blogs/create-edit.js'],
    ['inquires/inquires.js', 'inquires/inquires.js'],
    ['sidebar_menu_search/sidebar_menu_search.js', 'sidebar_menu_search/sidebar_menu_search.js'],
    ['candidate/reported_candidates.js', 'candidate/reported_candidates.js'],
    ['candidate/front/candidate-details.js', 'candidate/front/candidate-details.js'],
    ['plans/plans.js', 'plans/plans.js'],
    ['subscription/subscription.js', 'subscription/subscription.js'],
    ['transactions/transactions.js', 'transactions/transactions.js'],
    ['jobs/jobs_stripe_payment.js', 'jobs/jobs_stripe_payment.js'],
    ['companies/companies_stripe_payment.js', 'companies/companies_stripe_payment.js'],
    ['custom/phone-number-country-code.js', 'custom/phone-number-country-code.js'],
    ['employer_transactions/transactions.js', 'employer_transactions/transactions.js'],
    ['image_slider/image_slider.js', 'image_slider/image_slider.js'],
    ['header_sliders/header_sliders.js', 'header_sliders/header_sliders.js'],
    ['privacy_policy/privacy_policy.js', 'privacy_policy/privacy_policy.js'],
    ['branding_sliders/branding_sliders.js', 'branding_sliders/branding_sliders.js'],
    ['home/home.js', 'home/home.js'],
    ['front_register/google-recaptcha.js', 'front_register/google-recaptcha.js'],
    ['employer/dashboard.js', 'employer/dashboard.js'],
    ['countries/countries.js', 'countries/countries.js'],
    ['states/states.js', 'states/states.js'],
    ['cities/cities.js', 'cities/cities.js'],
    ['jobs/job_notification.js', 'jobs/job_notification.js'],
    ['language_translate/language_translate.js', 'language_translate/language_translate.js'],
    ['candidate/resumes.js', 'candidate/resumes.js'],
    ['web/front_settings/front_settings.js', 'web/front_settings/front_settings.js'],
    ['dashboard/admin-dashboard.js', 'dashboard/admin-dashboard.js'],
    ['email_templates/email_templates.js', 'email_templates/email_templates.js'],
    ['email_templates/create-edit.js', 'email_templates/create-edit.js'],
    ['web/js/blog/blog_comments.js', 'web/js/blog/blog_comments.js'],
    ['selected_candidate/selected_candidate.js', 'selected_candidate/selected_candidate.js'],
    ['job_stages/job_stages.js', 'job_stages/job_stages.js'],
    ['job_applications/job_slots.js', 'job_applications/job_slots.js'],
    ['job_expired/job_expired.js', 'job_expired/job_expired.js'],
    ['post_comments/post_comments.js', 'post_comments/post_comments.js'],
    ['front_cms/front_cms_setting.js', 'front_cms/front_cms_setting.js']
];

jsFiles.forEach(([source, destination]) => {
    mix.js(
        `resources/assets/js/${source}`,
        `public/assets/js/${destination}`
    );
});

/* JSValidation fájlok másolása */
mix.copy('vendor/proengsoft/laravel-jsvalidation/resources/views', 'public/resources/views/vendor/jsvalidation')
   .copy('vendor/proengsoft/laravel-jsvalidation/public', 'public/vendor/jsvalidation');

// Végső verziózás
mix.version();