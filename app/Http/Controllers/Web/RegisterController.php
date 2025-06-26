<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CompanyRegisterRequest;
use App\Http\Requests\WebRegisterRequest;
use App\Models\Factories\PositionFactory;
use App\Models\Position;
use App\Repositories\WebRegisterRepository;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class RegisterController extends AppBaseController
{
    /** @var WebRegisterRepository */
    private $webRegisterRepository;

    public function __construct(WebRegisterRepository $webRegisterRepository)
    {
        $this->webRegisterRepository = $webRegisterRepository;
    }

    /**
     * @return Factory|View
     */
    public function candidateRegister()
    {
        $isGoogleReCaptchaEnabled = $this->webRegisterRepository->getSettingForReCaptcha();

        return view('web.auth.candidate_register', compact('isGoogleReCaptchaEnabled'));
    }

    /**
     * @return Factory|View
     */
    public function employerRegister()
    {
        $isGoogleReCaptchaEnabled = $this->webRegisterRepository->getSettingForReCaptcha();

        $arrPositions = Position::toBase()->orderBy('name', 'asc')->pluck('name', 'id');

        return view('web.auth.employer_register', compact('isGoogleReCaptchaEnabled', 'arrPositions'));
    }

    /**
     * @param  WebRegisterRequest  $request
     *
     * @throws \Throwable
     *
     * @return JsonResource
     */
    public function register(WebRegisterRequest $request)
    {
        $input = $request->all();
        $this->webRegisterRepository->store($input);
        $userType = ($input['type'] == 1) ? 'Candidate' : 'Employer';
        Flash::success(__('messages.successfully_pre_registered'));

        return $this->sendSuccess(__('messages.successfully_pre_registered'));
    }

    public function validateEmployerRegister(CompanyRegisterRequest $request){
    }
}
