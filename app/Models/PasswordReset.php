<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class OwnerShipType
 *
 * @version June 22, 2020, 9:47 am UTC
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OwnerShipType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OwnerShipType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OwnerShipType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OwnerShipType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OwnerShipType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OwnerShipType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OwnerShipType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OwnerShipType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PasswordReset extends Model
{
    const UPDATED_AT = null;

    public $table = 'password_resets';

    protected $primaryKey = 'token';

    public $incrementing = false;

    public $fillable = [
        'email',
        'token',
        'created_at',
    ];

    public function getToken()
    {
        return $this->token;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}
