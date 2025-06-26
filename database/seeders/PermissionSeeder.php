<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
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
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::PERMISSIONS as $permissionName) {
            Permission::create([
                'name' => $permissionName,
                'guard_name' => 'web',
                'is_admin'  => $permissionName == 'Admin'
            ]);
        }
        foreach (self::FRONTOFFICE_PERMISSIONS as $permissionName) {
            Permission::create([
                'name' => $permissionName,
                'guard_name' => 'web',
                'is_frontoffice' => true,
                'is_admin'  => $permissionName == 'Kapcsolattartó'
            ]);
        }
    }
}
