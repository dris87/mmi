<?php
namespace App\Models\Factories;

use App\Models\Candidate;
use App\Models\CandidateAdvancedItSkills;
use App\Models\CandidateSoftwareSkills;

/**
 * BaseFactory
 */
class CandidateSoftwareSkillsFactory extends BaseFactory
{
    /**
     * @param $id
     * @return mixed|CandidateSoftwareSkills
     */
    public function getById($id)
    {
        return CandidateSoftwareSkills::where('id', '=', $id)->first();
    }

    /**
     * @param Candidate $objCandidate
     * @return mixed|CandidateSoftwareSkills
     */
    public function getByUser(Candidate $objCandidate)
    {
        return CandidateSoftwareSkills::where('candidate_id', '=', $objCandidate->id)->get();
    }

    /**
     * @param Candidate $objCandidate
     * @return void
     */
    public function clearByUser(Candidate $objCandidate){

        $arrCandidateLanguages = $this->getByUser($objCandidate);
        if($arrCandidateLanguages){
            /**
             * @var CandidateSoftwareSkills $obj
             */
            foreach ($arrCandidateLanguages as $key => $obj){
                $obj->delete();
            }
        }
    }

    /**
     * @param Candidate $objCandidate
     * @param array $arrSkill
     * @param array $arrLevelIds
     * @return bool
     */
    public function createOrUpdate(Candidate $objCandidate ,array $arrSkill, array $arrLevelIds): bool
    {
        $this->clearByUser($objCandidate);

        foreach ($arrSkill as $key => $id){

            if($key===0){
                continue;
            }

            if( empty($id || empty($arrLevelIds[$key])) ){
                continue;
            }

            $obj = new CandidateSoftwareSkills();
            $obj->setCandidateId($objCandidate->getId());
            $obj->setSkill($id);
            $obj->setSkillLevelId($arrLevelIds[$key]);
            if(!$obj->save()){
                return false;
            }

        }
        return true;
    }

}
