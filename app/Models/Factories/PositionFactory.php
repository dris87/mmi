<?php


namespace App\Models\Factories;

use App\Models\Position;
use Illuminate\Support\Facades\DB;

/**
 * BaseFactory
 */
class PositionFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = Position::class;
    }

    public function getAll(){
        return Position::query()->orderBy('name', 'ASC')->get();
    }


}
