<?php


namespace App\Models\Factories;

use App\Models\Company;
use App\Models\CompanyAward;
use App\Models\CompanyVideo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * BaseFactory
 */
class CompanyAwardFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = CompanyAward::class;
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
        foreach($arrData as $key => $item){
            if(isset($item['mediaId'])){
                $objMedia = Media::where('id', $item['mediaId'])->first();
                $arrData[$key]['objMedia'] = $objMedia;
            }
        }

        $arrAwards = (new CompanyAwardFactory())->getByCompany($objCompany);

        foreach($arrAwards as $objAward){
            $found = false;
            foreach($arrData as $item){
                if(isset($item['id'])) {
                    if ($item['id'] == $objAward->id) {
                        $found = true;
                    }
                }
            }
            if(!$found){
                $objAward->delete();
            }
        }

        foreach ($arrData as $key => $item){

            if(isset($item['id'])){
                $obj = (new CompanyAwardFactory())->getById($item['id']);
            }
            else {
                $obj = new CompanyAward();
            }
            $obj->setCompanyId($objCompany->getId());
            $obj->setName($item['name']);
            $obj->setDescription($item['description']);

            if (isset($item['image'])){
                $obj->clearMediaCollection(CompanyAward::AWARD_PATH);
                $obj->addMedia($item['image'])
                    ->toMediaCollection(CompanyAward::AWARD_PATH, config('app.media_disc'));
            }

            if(!$obj->save()){
                return false;
            }
        }
        return true;
    }

}
