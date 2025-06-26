<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\Plan;

class PageController extends AppBaseController
{
    public function getCompanyPage(){
        $data['plans'] = Plan::with('salaryCurrency')->get()->sortBy('amount', SORT_DESC, true);
        $data['planValidYears'] = Plan::VALID_YEARS;

        return view('web.munkaltatoknak.munkaltatoknak')->with($data);
    }
}
