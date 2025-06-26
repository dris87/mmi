<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property int $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class CoworkerPosition extends Model
{
    use HasFactory;

    public $table = 'coworker_positions';


    protected $fillable = [
        'name',
        'is_default'
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param int $name
     */
    public function setName(int $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Carbon|null
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

}

