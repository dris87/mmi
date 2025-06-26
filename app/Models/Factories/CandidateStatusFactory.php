<?php


namespace App\Models\Factories;

use App\Models\Candidate;
use App\Models\CandidateStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class CandidateStatusFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = CandidateStatus::class;
    }

}


