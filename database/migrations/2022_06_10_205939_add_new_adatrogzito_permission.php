<?php

use App\Models\MethodPermission;
use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class AddNewAdatrogzitoPermission extends Migration
{
    const PERMISSION_NAME = 'Adatrögzítő';

    protected $permissionData = [
        ['sidebar',	'dashboard',],
        ['sidebar',	'candidates',],
        ['sidebar',	'candidates.index',],
        ['sidebar',	'candidates.create',],
        ['App\Http\Controllers\UserController', 'changePassword'],
        ['App\Http\Controllers\EventLogController', 'getCandidateData'],
        ['App\Http\Controllers\DashboardController', 'index'],
        ['App\Http\Controllers\Candidates\CandidateProfileController', 'createExperience'],
        ['App\Http\Controllers\Candidates\CandidateProfileController', 'createEducation'],
        ['App\Http\Controllers\Candidates\CandidateProfileController', 'editEducation'],
        ['App\Http\Controllers\Candidates\CandidateProfileController', 'updateEducation'],
        ['App\Http\Controllers\Candidates\CandidateProfileController', 'destroyEducation'],
        ['App\Http\Controllers\Candidates\CandidateProfileController', 'editExperience'],
        ['App\Http\Controllers\Candidates\CandidateProfileController', 'updateExperience'],
        ['App\Http\Controllers\Candidates\CandidateProfileController', 'destroyExperience'],
        ['App\Http\Controllers\Candidates\CandidateController', 'updateProfile'],
        ['App\Http\Controllers\Candidates\CandidateController', 'getCVTemplate'],
        ['App\Http\Controllers\Candidates\CandidateController', 'getAllCVData'],
        ['App\Http\Controllers\Candidates\CandidateController', 'previewCV'],
        ['App\Http\Controllers\Candidates\CandidateController', 'getCandidateApplicationData'],
        ['App\Http\Controllers\Candidates\CandidateController', 'getAllDocumentsData'],
        ['App\Http\Controllers\Candidates\CandidateController', 'uploadDocuments'],
        ['App\Http\Controllers\Candidates\CandidateController', 'deletedDocument'],
        ['App\Http\Controllers\Candidates\CandidateController', 'generateCV'],
        ['App\Http\Controllers\Candidates\CandidateController', 'uploadResume'],
        ['App\Http\Controllers\Candidates\CandidateController', 'resumeStatusToggle'],
        ['App\Http\Controllers\Candidates\CandidateController', 'getCandidateCvs'],
        ['App\Http\Controllers\CandidateController', 'index'],
        ['App\Http\Controllers\CandidateController', 'getCandidateData'],
        ['App\Http\Controllers\CandidateController', 'create'],
        ['App\Http\Controllers\CandidateController', 'store'],
        ['App\Http\Controllers\CandidateController', 'store'],
        ['App\Http\Controllers\CandidateController', 'edit'],
        ['App\Http\Controllers\CandidateController', 'downloadResume'],
        ['App\Http\Controllers\Backoffice\BackofficeUserController', 'editProfile'],
        ['App\Http\Controllers\Backoffice\BackofficeUserController', 'updateProfile'],
        ['App\Http\Controllers\Candidates\CandidateController','batchStatusUpdate'],
        ['App\Http\Controllers\Candidates\CandidateController','generateCVBulk']
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $adatrogzitoPermission = Permission::create([
            'name' => self::PERMISSION_NAME,
            'guard_name' => 'web',
            'is_frontoffice' => false,
            'is_admin' => false,
        ]);

        foreach ($this->permissionData as $permissionData) {
            MethodPermission::create([
                'permission_id' => $adatrogzitoPermission->id,
                'controller_name' => $permissionData[0],
                'method_name' => $permissionData[1],
                'enabled' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
