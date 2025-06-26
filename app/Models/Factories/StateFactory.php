<?php

namespace App\Models\Factories;

use App\Models\State;
use App\Models\User;

/**
 * BaseFactory
 */
Class StateFactory extends BaseFactory {

    public function __construct()
    {
        $this->model = State::class;
    }
}
