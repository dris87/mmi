<?php


namespace App\Models\Factories;

use App\Models\ActivityLog;
use App\Models\Candidate;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * BaseFactory
 */
class MediaFactory extends BaseFactory
{
    public function getById($id)
    {
        return Media::where('id', '=', $id)->first();
    }

    public function changeToValue(Media $objMedia, $value)
    {
        $objCustomProperties = $objMedia->custom_properties;
        $objCustomProperties["active"]=$value==1?true:false;
        $objMedia->custom_properties = $objCustomProperties;
        if(!$objMedia->save()){
            return false;
        }
        return $objMedia;
    }

    public function getCandidateAllFormatted($class,Candidate $objCandidate)
    {
        return Media::query()->select(
            "media.id",
            "media.name",
            "media.collection_name",
            "media.file_name",
            "media.custom_properties",
            DB::raw("DATE_FORMAT(media.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
            DB::raw("DATE_FORMAT(media.updated_at, '%Y-%m-%d %H:%i:%s') AS _updated_at"),
        )->where("media.model_type", "=", $class)
            ->where("media.model_id", "=", $objCandidate->getId())
            ->where("media.collection_name", "=", "resumes")
            ->orderBy("id","asc")
            ->get();
    }


    public function getCandidateAllDocumentsFormatted($class,Candidate $objCandidate)
    {
        return Media::query()->select(
            "media.id",
            "media.name",
            "media.collection_name",
            "media.file_name",
            "media.custom_properties",
            DB::raw("DATE_FORMAT(media.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
            DB::raw("DATE_FORMAT(media.updated_at, '%Y-%m-%d %H:%i:%s') AS _updated_at"),
        )->where("media.model_type", "=", $class)
            ->where("media.model_id", "=", $objCandidate->getId())
            ->where("media.collection_name", "=", "documents")
            ->orderBy("id","asc")
            ->get();
    }

    public function getCVs(Candidate $objCandidate)
    {
        return Media::query()->select(
            "media.id",
            "media.name",
            "media.collection_name",
            "media.file_name",
            "media.custom_properties",
            DB::raw("DATE_FORMAT(media.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
            DB::raw("DATE_FORMAT(media.updated_at, '%Y-%m-%d %H:%i:%s') AS _updated_at"),
        )->where("media.model_type", "=", Candidate::class)
            ->where("media.model_id", "=", $objCandidate->getId())
            ->where("media.collection_name", "=", "resumes")
            ->orderBy("id","asc")
            ->get();
    }

    public function clearCandidateLanguageCurrentFlags($class,Candidate $objCandidate){

        $arrMedia = $this->getCandidateAllFormatted($class, $objCandidate);

        if($arrMedia){
            /**
             * @var int $key
             * @var Media $arrMediaRow
             */
            foreach ($arrMedia as $key =>$arrMediaRow){
                $objCustomProperties = $arrMediaRow["custom_properties"];
                if(isset($objCustomProperties["is_default"]) && $objCustomProperties["is_default"]==true){
                    $objCustomProperties["is_default"]=false;
                }
                $arrMediaRow->custom_properties= $objCustomProperties;
                $arrMediaRow->save();
            }

        }
    }

    public function findActiveCandidateCVs(Media $media, Candidate $objCandidate){
        return Media::query()->select(
            "media.id",
            "media.name",
            "media.collection_name",
            "media.file_name",
            "media.custom_properties",
            DB::raw("DATE_FORMAT(media.created_at, '%Y-%m-%d %H:%i:%s') AS _created_at"),
            DB::raw("DATE_FORMAT(media.updated_at, '%Y-%m-%d %H:%i:%s') AS _updated_at"),
        )->where("media.model_type", "=", Candidate::class)
            ->where("media.model_id", "=", $objCandidate->getId())
            ->where("media.collection_name", "=", "resumes")
            ->where("media.id", "<>", $media->id)
            ->whereRaw("custom_properties like '%\"active\":true%'")
            ->count();
    }
}


