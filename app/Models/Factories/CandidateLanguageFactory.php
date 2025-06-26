<?php


namespace App\Models\Factories;

use App\Models\Candidate;
use App\Models\CandidateExtraQualifications;
use App\Models\CandidateLanguage;
use App\Models\CandidateStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class CandidateLanguageFactory extends BaseFactory
{

    /**
     * @param $id
     * @return \App\Models\PostalCode|\Illuminate\Database\Eloquent\Model|mixed|CandidateLanguage
     */
    public function getById($id)
    {
        return CandidateLanguage::where('id', '=', $id)->first();
    }

    /**
     * @param Candidate $objCandidate
     * @return mixed|CandidateLanguage
     */
    public function getByUser(User $objCandidate)
    {
        return CandidateLanguage::where('user_id', '=', $objCandidate->id)->get();
    }

    /**
     * @param Candidate $objCandidate
     * @return void
     */
    public function clearByUser(User $objCandidate){

        $arrCandidateLanguages = $this->getByUser($objCandidate);
        if($arrCandidateLanguages){
            /**
             * @var CandidateLanguage  $obj
             */
            foreach ($arrCandidateLanguages as $key => $obj){
                $obj->delete();
            }
        }
    }

    /**
     * @param User $objUser
     * @param array $arrLanguageIds
     * @param array $arrLevelIds
     * @return bool
     */
    public function createOrUpdate(User  $objUser ,array $arrLanguageIds, array $arrLevelIds): bool
    {

        $this->clearByUser($objUser);

        foreach ($arrLanguageIds as $key => $id){

            if($key===0){
                continue;
            }

            if( empty($id || empty($arrLevelIds[$key])) ){
                continue;
            }

            $obj = new CandidateLanguage();
            $obj->setUserId($objUser->getId());
            $obj->setLanguageId($id);
            $obj->setLanguageLevelId($arrLevelIds[$key]);
            if(!$obj->save()){
                return false;
            }
        }
        return true;
    }

}
