<?php
namespace App\Models\Factories;

use App\Models\Candidate;
use App\Models\CandidateAdvancedItSkills;

/**
 * BaseFactory
 */
class CandidateAdvancedItSkillsFactory extends BaseFactory
{

    /**
     * @param $id
     * @return mixed|CandidateAdvancedItSkills
     */
    public function getById($id)
    {
        return CandidateAdvancedItSkills::where('id', '=', $id)->first();
    }

    /**
     * @param Candidate $objCandidate
     * @return mixed|CandidateAdvancedItSkills
     */
    public function getByUser(Candidate $objCandidate)
    {
        return CandidateAdvancedItSkills::where('candidate_id', '=', $objCandidate->id)->get();
    }

    /**
     * @param Candidate $objCandidate
     * @return void
     */
    public function clearByUser(Candidate $objCandidate){

        $arrCandidateLanguages = $this->getByUser($objCandidate);
        if($arrCandidateLanguages){
            /**
             * @var CandidateAdvancedItSkills $obj
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

            $obj = new CandidateAdvancedItSkills();
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
