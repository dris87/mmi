<?php

namespace App\Services;

use App\Models\BackofficePosition;
use App\Models\BackofficeUser;
use App\Models\BranchOffice;
use App\Models\Factories\BackofficeUserFactory;
use App\Models\Factories\PermissionFactory;
use App\Models\Permission;

class Select2Service
{
    public function getPermissions()
    {
        return $this->select2Values(Permission::query()->where('is_frontoffice', '=', 0)->orderBy('name', 'ASC')->get(), 'name');
    }

    public function getBackofficePositions()
    {
        return $this->select2Values(BackofficePosition::all(), 'name');
    }

    public function getBackofficeBranchOffices()
    {
        return $this->select2Values(BranchOffice::all(), 'name');
    }

    public function getBackofficeSuperiors($excludedId = null)
    {
        $backOfficeUserFactory = new BackofficeUserFactory();
        $data = $backOfficeUserFactory->getAllActive($excludedId)->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->first_name . ' ' . $user->last_name,
            ];
        });

        return $data;
    }

    private function select2Values($collection, $text, $id = 'id')
    {
        return $collection->map(function ($item) use ($text, $id) {
            return [
                'id' => $item->$id,
                'text' => $item->$text,
            ];
        });
    }
}
