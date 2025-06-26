<?php

namespace App\Providers;

use App\Lib\UserPermission\MethodPermissionService;
use App\Lib\UserPermission\PermissionRepository;
use App\Lib\UserPermission\UserPermissionService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class UserPermissionProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserPermissionService::class, function ($app) {
            $UserPermissionService = new UserPermissionService(
                auth()->user(),
                $app->make(PermissionRepository::class),
                $app->make(MethodPermissionService::class),
                Config::get('permission-service')
            );
            view()->share('UserPermissionService', $UserPermissionService);
            return $UserPermissionService;
        });
    }
}
