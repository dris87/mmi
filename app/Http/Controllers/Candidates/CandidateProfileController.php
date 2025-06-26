<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateCandidateEducationRequest;
use App\Http\Requests\CreateCandidateExperienceRequest;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\Factories\CandidateFactory;
use App\Models\Factories\PostalCodeFactory;
use App\Repositories\Candidates\CandidateProfileRepository;
use Illuminate\Support\Facades\Auth;

class CandidateProfileController extends AppBaseController
{
    /** @var CandidateProfileRepository */
    private $candidateProfileRepository;

    public function __construct(CandidateProfileRepository $candidateProfileRepo)
    {
        $this->candidateProfileRepository = $candidateProfileRepo;
    }

    /**
     * @param  CreateCandidateExperienceRequest  $request
     *
     * @return mixed
     */
    public function createExperience(CreateCandidateExperienceRequest $request)
    {
        $input = $request->all();
        $input['end_date'] = empty($input['end_date']) ? date('Y-m-d') : $input['end_date'];
        $candidateExperience = $this->candidateProfileRepository->createExperience($input);

        $objCandidate = (new CandidateFactory())->getById($input["candidate_id"]);
        $causer = Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$candidateExperience->id])
            ->log('Munkavállalói tapasztalat hozzáadása')
            ->causer($causer);

        return $this->sendResponse($candidateExperience,  trans('messages.candidate.successfully_saved'));
    }

    /**
     * @param  CandidateExperience  $candidateExperience
     *
     * @return mixed
     */
    public function editExperience(CandidateExperience $candidateExperience)
    {
        $PostalCodeFactory= new PostalCodeFactory();
        $objPostcode = $PostalCodeFactory->getById($candidateExperience->postcode_id);
        if($objPostcode){
            $candidateExperience->zipCode = $objPostcode->postal_code;
        }
        return $this->sendResponse($candidateExperience, trans('messages.candidate.successfully_edited'));
    }

    /**
     * @param  CandidateExperience  $candidateExperience
     * @param  CreateCandidateExperienceRequest  $request
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function updateExperience(
        CandidateExperience $candidateExperience,
        CreateCandidateExperienceRequest $request
    ) {
        $input = $request->all();
        $input['end_date'] = empty($input['end_date']) ? date('Y-m-d') : $input['end_date'];
        $data['id'] = $candidateExperience->id;
        $candidateExperience->delete();

        $objCandidate = (new CandidateFactory())->getById($candidateExperience->candidate_id);
        $causer = Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$candidateExperience->id])
            ->log('Munkavállalói tapasztalat módosítása')
            ->causer($causer);

        $data['candidateExperience'] = $this->candidateProfileRepository->createExperience($input);

        return $this->sendResponse($data, trans('messages.candidate.successfully_edited'));
    }

    /**
     * @param  CandidateExperience  $candidateExperience
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroyExperience(CandidateExperience $candidateExperience)
    {
        $id = $candidateExperience->id;
        $candidateExperience->delete();

        $objCandidate = (new CandidateFactory())->getById($candidateExperience->candidate_id);
        $causer = Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$candidateExperience->id])
            ->log('Munkavállalói tapasztalat törlése')
            ->causer($causer);

        return $this->sendResponse($id, trans('messages.candidate.successfully_deleted'));
    }

    /**
     * @param  CreateCandidateEducationRequest  $request
     *
     * @return mixed
     */
    public function createEducation(CreateCandidateEducationRequest $request)
    {
        $input = $request->all();

        $candidateEducation = $this->candidateProfileRepository->createEducation($input);
        $candidateEducation->country = getCountryName($candidateEducation->country_id);

        $objCandidate = (new CandidateFactory())->getById($input["candidate_id"]);
        $causer = Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$candidateEducation->id])
            ->log('Munkavállalói tanulmány hozzáadása')
            ->causer($causer);

        return $this->sendResponse($candidateEducation, trans('messages.candidate.successfully_saved'));
    }

    /**
     * @param  CandidateEducation  $candidateEducation
     *
     * @return mixed
     */
    public function editEducation(CandidateEducation $candidateEducation)
    {
        $PostalCodeFactory= new PostalCodeFactory();
        /** @var CandidateEducation $education */
        $education = $this->candidateProfileRepository->getEducation($candidateEducation);
        $objPostcode = $PostalCodeFactory->getById($candidateEducation->postcode_id);
        if($objPostcode){
            $education->zipCode = $objPostcode->postal_code;
        }

        return $this->sendResponse($education, trans('messages.candidate.successfully_updated'));
    }

    /**
     * @param  CandidateEducation  $candidateEducation
     * @param  CreateCandidateEducationRequest  $request
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function updateEducation(CandidateEducation $candidateEducation, CreateCandidateEducationRequest $request)
    {
        $input = $request->all();
        $data['id'] = $candidateEducation->id;
        $candidateEducation->delete();

        $data['candidateEducation'] = $this->candidateProfileRepository->createEducation($input);
        $data['candidateEducation']->country = getCountryName($data['candidateEducation']->country_id);

        $objCandidate = (new CandidateFactory())->getById($candidateEducation->candidate_id);
        $causer = Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$candidateEducation->id])
            ->log('Munkavállalói tanulmány módosítása')
            ->causer($causer);

        return $this->sendResponse($data, trans('messages.candidate.successfully_updated'));
    }

    /**
     * @param  CandidateEducation  $candidateEducation
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function destroyEducation(CandidateEducation $candidateEducation)
    {
        $id = $candidateEducation->id;
        $candidateEducation->delete();

        $objCandidate = (new CandidateFactory())->getById($candidateEducation->candidate_id);
        $causer = Auth::user();
        activity()
            ->inLog("custom")
            ->performedOn($objCandidate)
            ->withProperties([$candidateEducation->id])
            ->log('Munkavállalói tanulmány törlése')
            ->causer($causer);

        return $this->sendResponse($id, trans('messages.candidate.successfully_deleted'));
    }
}
