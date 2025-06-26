<?php

namespace App\Helpers;

use App\Models\Company;
use App\Models\Factories\CompanyFactory;
use App\Models\Factories\CompanyUserFactory;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserHelper
{
    /**
     * Returns the logged-in user
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public static function getCurrentUser(){
        return Auth::user();
    }

    /** Returns the company the user currently has access to (for CompanyUser and Employer)
     * @return Company $objCompany
     * @throws Exception
     */
    public static function getCompany(){
        $objUser = self::getCurrentUser();
        if(self::isEmployer()){
            return $objUser->company()->get();
        }
        else if(self::isCompanyUser()){

            $companyId = Session::get('company_id');

            if(!$companyId){
                throw new Exception('There was an error retrieving the company');
            }

            $companyFactory = new CompanyFactory();
            $companyUserFactory = new CompanyUserFactory();

            $objCompany = $companyFactory->getById($companyId);

            if(!$companyUserFactory->getByUserAndCompany($objUser, $objCompany)){
                throw new Exception('The company user does not have access to the specified company');
            }

            return $objCompany;
        }

        throw new Exception('The user does not have access any companies');

    }

    /** Returns if the user is an Employer if no $objUser is specified the logged-in user is used
     * @param $objUser
     * @return mixed
     */
    public static function isEmployer($objUser = null){

        if(!$objUser){
            $objUser = self::getCurrentUser();
        }

        return $objUser->company()->exists();

    }

    /** Returns if the user is a CompanyUser if no $objUser is specified the logged-in user is used
     * @param $objUser
     * @return mixed
     */
    public static function isCompanyUser($objUser = null){

        if(!$objUser){
            $objUser = self::getCurrentUser();
        }

        return $objUser->companyUser()->exists();

    }
}
