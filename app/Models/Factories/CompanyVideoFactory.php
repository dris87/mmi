<?php


namespace App\Models\Factories;

use App\Helpers\Video;
use App\Models\Company;
use App\Models\CompanyVideo;

/**
 * BaseFactory
 */
class CompanyVideoFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = CompanyVideo::class;
    }


    /**
     * @param Company $objCompany
     * @return mixed
     */
    public function getByCompany(Company $objCompany)
    {
        return $this->model::where('company_id', '=', $objCompany->id)->get();
    }

    /**
     * @param Company $objCompany
     * @return void
     */
    public function clearByCompany(Company $objCompany){

        $arrItems = $this->getByCompany($objCompany);
        if($arrItems){
            foreach ($arrItems as $key => $obj){
                $obj->delete();
            }
        }
    }

    /**
     * @param Company $objCompany
     * @param array $arrData
     * @return bool
     */
    public function createOrUpdate(Company $objCompany, array $arrData): bool
    {
        $this->clearByCompany($objCompany);

        foreach ($arrData as $key => $item){

            $obj = new CompanyVideo();

            $videoData = Video::getVideoDetails($item['url']);

            $obj->setCompanyId($objCompany->getId());
            $obj->setTitle($item['title']);
            $obj->setDescription($item['description']);
            $obj->setVideoUrl($item['url']);
            $obj->setEmbedUrl($videoData['embed_video']);

            if(isset($item['thumbnail'])){
                $obj->clearMediaCollection(CompanyVideo::VIDEO_THUMBNAIL);
                $obj->addMedia($item['thumbnail'])
                    ->toMediaCollection(CompanyVideo::VIDEO_THUMBNAIL, config('app.media_disc'));
            }
            else{
                if(!$obj->getFirstMediaUrl(CompanyVideo::VIDEO_THUMBNAIL)) {
                    if ($videoData) {
                        $obj->clearMediaCollection(CompanyVideo::VIDEO_THUMBNAIL);
                        $obj->addMediaFromUrl($videoData['thumbnail'])
                            ->toMediaCollection(CompanyVideo::VIDEO_THUMBNAIL, config('app.media_disc'));
                    }
                }
            }

            if(!$obj->save()){
                return false;
            }
        }
        return true;
    }

}
