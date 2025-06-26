<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEMailTemplateRequest;
use App\Models\EmailTemplate;
use App\Models\Factories\ActivityLogFactory;
use App\Models\Factories\CandidateFactory;
use App\Models\Factories\CompanyFactory;
use App\Queries\EmailTemplateDataTable;
use App\Repositories\EmailTemplateRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Yajra\DataTables\DataTables;

/**
 * Class EmailTemplateController
 */
class EventLogController extends AppBaseController
{
    /**
     * @var EmailTemplateRepository
     */
    public $emailTemplateRepository;

    /**
     * EmailTemplateController constructor.
     * @param EmailTemplateRepository $emailTemplateRepository
     */
    public function __construct(EmailTemplateRepository $emailTemplateRepository)
    {
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     * @param Request $request
     *
     * @return Factory|View|Application
     * @throws Exception
     *
     */
    public function index(Request $request)
    {
        $ActivityLogFactory = new ActivityLogFactory();
        if ($request->ajax()) {
            $data = $ActivityLogFactory->getAllFormatted();
            return DataTables::of($data)->make(true);
        }

        return view('event_log.index');
    }

    /**
     * @param Request $request
     *
     * @return Factory|View|Application
     * @throws Exception
     *
     */
    public function getCandidateData(Request $request, $candidate_id)
    {
        $CandidateFactory = new CandidateFactory();
        $objCandidate = $CandidateFactory->getById($candidate_id);
        $ActivityLogFactory = new ActivityLogFactory();
        $data = $ActivityLogFactory->getAllByCandidateFormatted($objCandidate);
        return DataTables::of($data)->make(true);
    }

    public function getCompanyActivityView(){
        return view('employer.activity.index');
    }
    /**
     * @param Request $request
     *
     * @return Factory|View|Application
     * @throws Exception
     *
     */
    public function getCompanyData(Request $request, $company_id=null)
    {
        $companyFactory = new CompanyFactory();
        if(empty($company_id)){
            $this->isCompany();
            $objCompany = $this->getCompany();
        }else{
            $objCompany = $companyFactory->getById($company_id);
        }

        $ActivityLogFactory = new ActivityLogFactory();
        $data = $ActivityLogFactory->getAllByCompanyFormatted($objCompany);
        return DataTables::of($data)->make(true);
    }

}
