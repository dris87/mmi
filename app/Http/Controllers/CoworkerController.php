<?php

namespace App\Http\Controllers;

use App\Models\Factories\ActivityLogFactory;
use App\Models\Factories\CompanyFactory;
use App\Models\Factories\CompanyUserFactory;
use App\Repositories\EmailTemplateRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * Class CoworkerController
 */
class CoworkerController extends Controller
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

    public function getCoworkerData(Request $request, $company_id)
    {
        $companyFactory = new CompanyFactory();
        $objCompany = $companyFactory->getById($company_id);
        $companyUserFactory = new CompanyUserFactory();
        $data = $companyUserFactory->getByCompanyFormatted($objCompany);
        return DataTables::of($data)->make(true);
    }

}
