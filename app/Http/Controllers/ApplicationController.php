<?php

namespace App\Http\Controllers;


use App\Models\Factories\CompanyFactory;

use App\Queries\ReportedCompanyDataTable;
use App\Repositories\CompanyRepository;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;
use Yajra\DataTables\DataTables;

class ApplicationController extends AppBaseController
{

    /** @var CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepository = $companyRepo;
    }
    /**
     * Display a listing of the Company.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        die("--");
        $data = $this->companyRepository->get();
        $companyFactory = new CompanyFactory();

        if ($request->ajax()) {
            $data = $companyFactory->getAllFormatted();
            return DataTables::of($data)->make(true);
        }

        return view('application.index', compact('data'));
    }
}
