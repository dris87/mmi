<?php


namespace App\Models\Factories;

use App\Models\Candidate;
use App\Models\CandidateExtraQualifications;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class CandidateExtraQualificationsFactory extends BaseFactory
{

    /**
     * @param $id
     * @return \App\Models\PostalCode|\Illuminate\Database\Eloquent\Model|mixed|CandidateExtraQualifications
     */
    public function getById($id)
    {
        return CandidateExtraQualifications::where('id', '=', $id)->first();
    }

    /**
     * @param Candidate $objCandidate
     * @return mixed|CandidateExtraQualifications
     */
    public function getByCandidate(Candidate $objCandidate)
    {
        return CandidateExtraQualifications::where('candidate_id', '=', $objCandidate->id)->first();
    }


    /**
     * @param Candidate $objCandidate
     * @param $driving_licence
     * @param $basic_it_skills
     * @param $advanced_it_skills
     * @param $hobbies
     * @param $other_comments
     * @return CandidateExtraQualifications|false
     */
    public function createOrUpdate(Candidate $objCandidate, $hobbies, $other_comments){

        $objCandidateExtraQualifications = $this->getByCandidate($objCandidate);
        if($objCandidateExtraQualifications){
            $objCandidateExtraQualifications->delete();
        }

        $objCandidateExtraQualifications = new CandidateExtraQualifications;
        $objCandidateExtraQualifications->setCandidateId($objCandidate->id);
        if($hobbies) $objCandidateExtraQualifications->setHobbies($hobbies);
        if($other_comments) $objCandidateExtraQualifications->setOtherComments($other_comments);

        if(!$objCandidateExtraQualifications->save()){
            return false;
        }

        return $objCandidateExtraQualifications;
    }

}


