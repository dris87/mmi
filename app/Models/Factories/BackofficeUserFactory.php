<?php


namespace App\Models\Factories;

use App\Models\BackofficeUser;
use App\Models\Candidate;
use App\Models\CandidateStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class BackofficeUserFactory extends BaseFactory
{

    /**
     * @param $id
     * @return \App\Models\PostalCode|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function getById($id)
    {
        return BackofficeUser::where('id', '=', $id)->first();
    }

    /**
     * @param $excludedIds
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllActive($excludedIds = array()){
        $objBuilder = BackofficeUser::query()->select('backoffice_users.*')
            ->leftJoin('users', 'users.id', '=', 'backoffice_users.user_id')
            ->where('users.is_active', '=', 1);

        if($excludedIds){
            $objBuilder->whereNotIn('backoffice_users.id', $excludedIds);
        }

        return $objBuilder->get();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getByUserId($user_id)
    {
        return BackofficeUser::where('user_id', '=', $user_id)->first();
    }
}


