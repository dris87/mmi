<?php


namespace App\Models\Factories;

use App\Models\Candidate;
use App\Models\CandidateStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class CandidateFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = Candidate::class;
    }

    /**
     * @return Candidate[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllFormatted()
    {
        $candidates = Candidate::query()->select(
            "candidates.id",
            "candidates.candidate_status_id",
            DB::raw("CONCAT(users.first_name,' ',users.last_name) AS name"),
            "users.email",
            DB::raw("DATE_FORMAT(users.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
            "users.email as email",
            "users.phone as phone",
        )->leftJoin("users", "users.id", "=", "candidates.user_id")
        ->get();

        $activityLogFactory = new ActivityLogFactory();
        $candidateStatusFactory = new CandidateStatusFactory();
        $candidateFactory = new CandidateFactory();
        foreach($candidates as $candidate){
            $objCandidate = $candidateFactory->getById($candidate->id);
            $objActivity = $activityLogFactory->getLatestByCauserId($candidate->id);
            $objCandidateStatus = $candidateStatusFactory->getById((int)$candidate->candidate_status_id);
            $candidate->latest_activity = $objActivity ? date('Y-m-d', strtotime($objActivity->getCreatedAt())) : '-';
            $candidate->job_status = $objCandidateStatus ? $objCandidateStatus->getName() : '-';
            $candidate->hasResume = $objCandidate->getMedia('resumes')->isNotEmpty();
        }

        return $candidates;
    }


    /**
     * @param User $objUser
     * @return mixed|Candidate
     */
    public function getByUser(User $objUser)
    {
        return $this->model::where("user_id", $objUser->getId())->first();
    }

    /**
     * @param Candidate $objCandidate
     * @param CandidateStatus $objCandidateStatus
     * @return Candidate|false
     */
    public function changeStatus(Candidate $objCandidate, CandidateStatus $objCandidateStatus){

        $objCandidate->candidate_status_id = $objCandidateStatus->getId();
        if(!$objCandidate->save()){
            return false;
        }
        return  $objCandidate;
    }

}


