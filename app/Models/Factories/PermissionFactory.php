<?php


namespace App\Models\Factories;

use App\Models\Permission;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class PermissionFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = Permission::class;
    }

    public function getAll(){
        return Permission::query()->orderBy('name', 'ASC')->get();
    }

    public function getBackOfficePermissions(){
        return Permission::query()->where('is_frontoffice', '=', 0)->orderBy('name', 'ASC')->get()->all();
    }
    public function getFrontOfficePermissions(){
        return Permission::query()->where('is_frontoffice', '=', 1)->orderBy('name', 'ASC')->get()->all();
    }

    public function getBackOfficeAdminPermission(){
        return Permission::query()
            ->where('is_frontoffice', '=', 0)
            ->where('is_admin', '=', 1)
            ->orderBy('name', 'ASC')->first();
    }

    public function getFrontOfficeAdminPermission(){
        return Permission::query()
            ->where('is_frontoffice', '=', 1)
            ->where('is_admin', '=', 1)
            ->orderBy('name', 'ASC')->first();
    }

}
