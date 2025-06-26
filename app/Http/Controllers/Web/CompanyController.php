<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CompanyRegisterRequest;
use App\Models\Company;
use App\Models\Industry;
use App\Repositories\CompanyRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CompanyController extends AppBaseController
{
    /** @var CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepository = $companyRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // redirect to jobs listing page
    }

    /**
     * @param $uniqueId
     *
     * @return Application|Factory|View
     */
    public function getCompaniesDetails($uniqueId)
    {
        $company = Company::whereUniqueId($uniqueId)->first();

        $data = $this->companyRepository->getCompanyDetail($company->id);

        return view('web.company.company_details')->with($data);
    }

    /**
     * @param  Request  $request
     *
     * @return Application|Factory|View
     */
    public function getCompaniesLists(Request $request)
    {
        return view('web.company.index');
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function saveFavouriteCompany(Request $request)
    {
        $input = $request->all();
        $favouriteJob = $this->companyRepository->storeFavouriteJobs($input);
        if ($favouriteJob) {
            return $this->sendResponse($favouriteJob, 'Follow Company successfully.');
        }

        return $this->sendResponse($favouriteJob, 'Unfollow Company successfully.');
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResource
     */
    public function reportToCompany(Request $request)
    {
        $input = $request->all();
        $this->companyRepository->storeReportToCompany($input);

        return $this->sendSuccess('Report to company successfully.');
    }

    public function register(CompanyRegisterRequest $request){

        try {
            if($this->companyRepository->store($request->all())) {
                $this->ajaxresponse('success', '', [
                    'heading' => trans('messages.company_reg.success_heading'),
                    'content' => trans('messages.company_reg.success_message'),
                ]);
            }
            else{
                session()->regenerate();
                $this->ajaxresponse('error', trans('messages.company_reg.error_message'), ['token' => csrf_token()]);
            }
         }
         catch (\Illuminate\Validation\ValidationException $e ) {

             session()->regenerate();
             $errorHtml = '';

             foreach($e->errors() as $error){
               $errorHtml.=$error[0].'<br/>';
             }
             $this->ajaxresponse('error', $errorHtml, ['token' => csrf_token()]);
        }
        catch(Exception $e) {
            var_dump($e->getMessage());
            session()->regenerate();
            $this->ajaxresponse('error', 'A regisztráció során hiba lépett fel kérjük próbálja újra késöbb.', ['token' => csrf_token()]);
        }
    }
}
