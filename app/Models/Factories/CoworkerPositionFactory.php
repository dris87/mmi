<?php


namespace App\Models\Factories;

use App\Models\CoworkerPosition;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class CoworkerPositionFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = CoworkerPosition::class;
    }

    public function getAll(){
        return CoworkerPosition::query()->orderBy('name', 'ASC')->get();
    }

    public function getDefaultPosition(){
        return CoworkerPosition::query()->where('is_default', '=', true)->first();
    }


}
