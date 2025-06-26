<?php

namespace App\Lib\Backoffice\BranchOffice;

use App\Models\BranchOffice;

class BranchOfficeRepository
{
    public function all()
    {
        return BranchOffice::all();
    }
}
