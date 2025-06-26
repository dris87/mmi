<?php


namespace App\Models\Factories;

use App\Models\Company;
use App\Models\CompanySite;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class CompanySiteFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = CompanySite::class;
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

            $obj = new CompanySite();

            $obj->setCompanyId($objCompany->getId());
            $obj->setPostcodeId($item['postcode_id']);
            $obj->setCityId($item['city_id']);
            $obj->setStreet($item['street']);
            $obj->setAddress($item['address']);
            $obj->setFloor($item['floor']);
            $obj->setDoor($item['door']);

            if(!$obj->save()){
                return false;
            }
        }
        return true;
    }

    public function getByCompanyFormatted(Company $objCompany)
    {
        return $this->model::query()->select([
            'company_sites.id as id',
            DB::raw("CONCAT(postal_codes.postal_code,' ',cities.name,' ', company_sites.street,' ', company_sites.address,' ', company_sites.floor,' ', company_sites.door) AS site"),
        ])
        ->leftJoin("cities", "company_sites.city_id", "=", "cities.id")
        ->leftJoin("postal_codes", "company_sites.postcode_id", "=", "postal_codes.id")
        ->where('company_id', '=', $objCompany->id)->get();
    }

}
