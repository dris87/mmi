<?php

namespace App\Lib\Position;

use App\Models\Position;

class PositionRepository
{
    public function all()
    {
        return Position::all();
    }
}
