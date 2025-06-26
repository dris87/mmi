<?php

namespace App\Models\Factories;

use App\Models\Language;
use App\Models\PostalCode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * BaseFactory
 */
class BaseFactory
{
    /** @var $model Model */
    public $model = null;

    /**
     * @param Collection $collection
     * @return array
     */
    public function collectionToIndexedArray(Collection $collection): array
    {
        $returnArray = [];
        $array = $collection->toArray();
        foreach ($array as $key => $value) {
            if (!isset($value["id"])) {
                Log::error("Tried to convert collection to array by ID where there is no ID field");
                return false;
            }
            $returnArray[$value["id"]] = $value;
        }
        return $returnArray;
    }

    /**
     * @param $id
     * @return mixed|Model|PostalCode
     */
    public function getById($id)
    {
        return $this->model::where('id', '=', $id)->first();
    }

    /**
     * @return mixed|Model[]
     */
    public function getAll()
    {
        return $this->model::get();
    }

}
