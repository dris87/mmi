<?php


namespace App\Models\Factories;

use App\Models\Language;

/**
 * LanguageFactory
 */
class LanguageFactory extends BaseFactory
{
    /**
     * @return \Illuminate\Database\Eloquent\Model[]|mixed
     */
    public function getAll()
    {
        return Language::get();
    }
}


