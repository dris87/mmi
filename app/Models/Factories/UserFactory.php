<?php

namespace App\Models\Factories;

use App\Models\User;

/**
 * BaseFactory
 */
Class UserFactory extends BaseFactory {

    /**
     *
     */
    public function __construct()
    {
        $this->model = User::class;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|mixed|User
     */
    public function getById($id)
    {
        return User::where('id', '=', $id)->first();
    }


    /**
     * @param $user_id
     * @param $token
     * @return \Illuminate\Database\Eloquent\Model|mixed|User
     */
    public function getUserByIdAndToken($user_id, $token)
    {
        return User::where('id', '=', $user_id)->where("password","=",base64_decode($token))->first();
    }
    /**
     * @param $companyId
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByCompanyId($companyId){
        return User::query()->join('companies', 'companies.user_id', '=', 'users.id')
            ->where('companies.id', '=', $companyId)->select('users.*')->first();
    }

    /**
     * @param User $objUser
     * @param $status
     * @return User|false
     */
    public function changeStatus(User $objUser, $status){

        $objUser->setIsActive((bool)$status);
        if(!$objUser->save()){
            return false;
        }
        return  $objUser;
    }


    /**
     * @param User $objUser
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $phone
     * @return User|false
     */
    public function updateBasicInfo(User $objUser, $first_name, $last_name, $email, $phone = null)
    {
        $objUser->setFirstName($first_name);
        $objUser->setLastName($last_name);
        $objUser->setEmail($email);
        if($phone) {
            $objUser->setPhone($phone);
        }

        if(!$objUser->save()){
            return false;
        }

        return  $objUser;
    }
}
