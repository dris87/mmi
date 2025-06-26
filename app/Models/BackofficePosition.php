<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackofficePosition extends Model
{
    public $fillable = [
        'id',
        'name'
    ];
    use HasFactory;
}
