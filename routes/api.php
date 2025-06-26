<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Auth\Front\LoginController;
use App\Http\Controllers\Web\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users/login', [LoginController::class, 'login'])->name('ajax.login')->middleware('verified.user');
Route::post('company/register', [CompanyController::class, 'register'])->name('ajax.register_company')->middleware('verified.user');
Route::post('get-city', [ApiController::class, 'getCity'])->name('api.get_city');
Route::post('job/get-requirement-layout', [ApiController::class, 'getRequirementLayout'])->name('api.get_requirement_layout');
Route::post('job/get-requirements', [ApiController::class, 'getJobRequirements'])->name('api.get-requirements');
Route::post('company/get-video-layout', [ApiController::class, 'getVideoLayout'])->name('api.company.video_layout');
Route::post('video/get-video-details', [ApiController::class, 'getVideoDetails'])->name('api.video.video_details');
Route::post('company/get-company-site-layout', [ApiController::class, 'getCompanySiteLayout'])->name('api.company.site_layout');
Route::post('company/get-company-award-layout', [ApiController::class, 'getCompanyAwardLayout'])->name('api.company.award_layout');
Route::post('company/get-company-gallery-layout', [ApiController::class, 'getCompanyGalleryLayout'])->name('api.company.gallery_layout');
