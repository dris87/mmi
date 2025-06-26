<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BackofficeUser;

class BackofficeUserSeeder extends Seeder
{
    const ADMIN_USER_DATA = [
        'user_id'           => 1,
        'first_name'        => 'Mumi',
        'last_name'         => 'Admin',
        'email'             => 'admin@mumi.hu',
        'dob'               => '1993-10-10',
        'phone'             => '7878454512',
        'notified_name'     => 'RandomName',
        'notified_phone'    => '7878454512',
        'branch_office_id'  => 1,
        'position_id'       => 1,
        'main_permission_id' => 1,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BackofficeUser::create(self::ADMIN_USER_DATA);
    }
}
