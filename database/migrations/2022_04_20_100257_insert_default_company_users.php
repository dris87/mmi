<?php

use App\Models\BackofficePosition;
use App\Models\BackofficeUser;
use App\Models\BranchOffice;
use App\Models\CompanyUser;
use App\Models\Factories\CompanyFactory;
use App\Models\Factories\CoworkerPositionFactory;
use App\Models\Factories\PermissionFactory;
use App\Models\Permission;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class InsertDefaultCompanyUsers extends Migration
{

    const ADMIN_USER_DATA = [
        'user_id' => 1,
        'first_name' => 'Mumi',
        'last_name' => 'Admin',
        'email' => 'admin@mumi.hu',
        'dob' => '1993-10-10',
        'phone' => '7878454512',
        'notified_name' => 'RandomName',
        'notified_phone' => '7878454512',
        'branch_office_id' => 1,
        'position_id' => 1,
        'main_permission_id' => 1,
    ];

    const BRANCH_OFFICES = [
        'Központi Iroda',
        'Központi Raktár',
        'Debreceni Iroda',
    ];

    const BACKOFFICE_POSITIONS = [
        'IT',
        'Könyvelő',
        'Backoffice vezető',
    ];

    const PERMISSIONS = [
        'Admin',
        'Ügyfélszolgálat',
        'Marketing',
        'Értékesítés',
        'Pénzügy',
        'Dev',
        'IT',
        'Management',
        'Látványtervező ',
    ];

    const FRONTOFFICE_PERMISSIONS = [
        'Kapcsolattartó',
        'HR Manager',
        'Könyvelő',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $input = [
            'first_name'        => 'Mumi',
            'last_name'         => 'Admin',
            'email'             => 'admin@mumi.hu',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('123456'),
            'phone'             => '7878454512',
        ];
        $user = User::create($input);

        $i = 1;
        foreach (self::BRANCH_OFFICES as $branchOfficeName) {
            $line = [
                'id'=>$i,
                'name' => $branchOfficeName
            ];
            BranchOffice::create($line);
            $i++;
        }

        $i = 1;
        foreach (self::BACKOFFICE_POSITIONS as $backofficePosition) {
            BackofficePosition::create([
                'id'=>$i,
                'name' => $backofficePosition
            ]);
            $i++;
        }

        $i = 1;
        foreach (self::PERMISSIONS as $permissionName) {
            Permission::create([
                'id'=>$i,
                'name' => $permissionName,
                'guard_name' => 'web',
                'is_admin' => $permissionName == 'Admin'
            ]);
            $i++;
        }

        $i = 10;
        foreach (self::FRONTOFFICE_PERMISSIONS as $permissionName) {
            Permission::create([
                'id'=>$i,
                'name' => $permissionName,
                'guard_name' => 'web',
                'is_frontoffice' => true,
                'is_admin' => $permissionName == 'Kapcsolattartó'
            ]);
            $i++;
        }

        BackofficeUser::create(self::ADMIN_USER_DATA);

        $arrCompanies = (new CompanyFactory())->getAll();
        $objPermission = (new PermissionFactory())->getFrontOfficeAdminPermission();
        $userRepository = new UserRepository();
        $objPosition = (new CoworkerPositionFactory())->getDefaultPosition();


        foreach ($arrCompanies as $objCompany) {
            $objUser = $userRepository->getById($objCompany->getUserId());
            $objCompanyUser = new CompanyUser();
            $objCompanyUser->setPhone($objUser->getPhone());
            $objCompanyUser->setUserId($objUser->getId());
            $objCompanyUser->setCoworkerPositionId($objPosition->getId());
            $objCompanyUser->setCompanyId($objCompany->getId());
            $objCompanyUser->setPermissionId($objPermission->getId());
            $objCompanyUser->setCreatedBy(1);

            if (!$objCompanyUser->save()) {
                DB::rollback();
                throw new \Exception('Failed to insert user');
            }
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
