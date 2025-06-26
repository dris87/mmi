<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{
    public $fillable = [
        'id',
        'name'
    ];
    use HasFactory;
}
