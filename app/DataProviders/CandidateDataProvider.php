<?php
namespace App\DataProviders;

use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\Factories\ActivityLogFactory;
use App\Models\Factories\CandidateAdvancedItSkillsFactory;
use App\Models\Factories\CandidateBasicItSkillsFactory;
use App\Models\Factories\CandidateExtraQualificationsFactory;
use App\Models\Factories\CandidateLanguageFactory;
use App\Models\Factories\CandidateSoftwareSkillsFactory;
use App\Models\Factories\CandidateStatusFactory;
use App\Models\Factories\CityFactory;
use App\Models\Factories\LanguageFactory;
use App\Models\Factories\PostalCodeFactory;
use App\Models\Factories\UserFactory;
use App\Models\User;
use App\Repositories\Candidates\CandidateRepository;

class CandidateDataProvider{

    public function getCandidateData(User $user){

        $candidate = $user->candidate;
        $candidateRepository = new CandidateRepository();
        $LanguageFactory = new LanguageFactory();
        $CandidateStatusFactory = new CandidateStatusFactory();
        $CityFactory = new CityFactory();
        $PostalCodeFactory = new PostalCodeFactory();

        $arrCandidateStatuses = $CandidateStatusFactory->collectionToIndexedArray($CandidateStatusFactory->getAll());
        $arrLanguages = $LanguageFactory->collectionToIndexedArray($LanguageFactory->getAll());
        $jsonLanguages = json_encode($arrLanguages);
        $objLastActivity = (new ActivityLogFactory())->getLastByCauser($user);
        $data = $candidateRepository->prepareData();
        $candidateSkills = $user->candidateSkill()->pluck('skill_id')->toArray();
        $candidateJobCategories = $candidate->candidateJobCategories()->pluck('job_category_id')->toArray();
        $candidateJobShifts = $candidate->candidateJobShift()->pluck('job_shift_id')->toArray();
        $candidateJobType = $candidate->candidateJobType()->pluck('job_type_id')->toArray();
        $candidateAbleToTravel = $candidate->candidateAbleToTravelCity()->pluck('city_id')->toArray();
        $candidateAbleToMove = $candidate->candidateAbleToMoveCity()->pluck('city_id')->toArray();
        $candidateCircumstances = $candidate->candidateCircumstances()->pluck('circumstances_id')->toArray();
        $candidateExtraRequirements = $candidate->candidateExtraRequirements()->pluck('requirement_id')->toArray();
        $candidateDrivingLicences = $candidate->candidateDrivingLicence()->pluck('driving_licence_id')->toArray();
        $objCandidateExtraQualifications = (new CandidateExtraQualificationsFactory())->getByCandidate($candidate);
        $candidateLanguage = (new CandidateLanguageFactory())->getByUser($user)->toArray();
        $candidateBasicSkills = (new CandidateBasicItSkillsFactory())->getByUser($candidate)->toArray();
        $candidateAdvancedSkills = (new CandidateAdvancedItSkillsFactory())->getByUser($candidate)->toArray();
        $candidateSoftwareSkills = (new CandidateSoftwareSkillsFactory())->getByUser($candidate)->toArray();

        $objCity = $CityFactory->getById($candidate->city_id);
        $objPostCode = $PostalCodeFactory->getById($candidate->postcode_id);

        $data['user'] = $user;
        $data['candidateExperiences'] = CandidateExperience::where(
            'candidate_id',
            $user->owner_id
        )->orderByDesc('id')->get();

        foreach ($data['candidateExperiences'] as $experience) {
            $experience->country = getCountryName($experience->country_id);
        }
        $data['candidateEducations'] = CandidateEducation::with('degreeLevel')->where(
            'candidate_id',
            $user->owner_id
        )->orderByDesc('id')->get();
        foreach ($data['candidateEducations'] as $education) {
            $education->country = getCountryName($education->country_id);
        }

        $data["jsonLanguages"]=$jsonLanguages;
        $data["arrCandidateStatuses"]=$arrCandidateStatuses;
        $data["objLastActivity"]=$objLastActivity;
        $data["candidateBasicSkills"]=$candidateBasicSkills;
        $data["candidateAdvancedSkills"]=$candidateAdvancedSkills;
        $data["candidateDrivingLicences"]=$candidateDrivingLicences;
        $data["candidateSoftwareSkills"]=$candidateSoftwareSkills;
        $data["candidateAbleToTravel"]=$candidateAbleToTravel;
        $data["candidateCircumstances"]=$candidateCircumstances;
        $data["candidateAbleToMove"]=$candidateAbleToMove;
        $data["objCandidateExtraQualifications"]=$objCandidateExtraQualifications;
        $data["candidateExtraRequirements"]=$candidateExtraRequirements;
        $data["objCity"]=$objCity;
        $data["objPostCode"]=$objPostCode;
        $data["candidate"]=$candidate;
        $data["user"]=$user;
        $data["candidateSkills"]=$candidateSkills;
        $data["candidateLanguage"]=$candidateLanguage;
        $data["candidateJobCategories"]=$candidateJobCategories;
        $data["candidateJobShifts"]=$candidateJobShifts;
        $data["candidateJobType"]=$candidateJobType;

        $imgPath = public_path() . "/assets/img/";

        if (!empty($user->media[0])) {
            $path = $user->media[0]->getPath();
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $dataContent = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64, ' . base64_encode($dataContent);
            $data["photo"] = $base64;
        } else {
            $defaultUserPhoto = $imgPath . "default_user_image.png";
            $data["photo"] = "data:image/png;base64, " . base64_encode(file_get_contents($defaultUserPhoto));
        }

        $logo       = $imgPath . "main-logo.png";
        $iconInfo   = $imgPath . "icon_info.png";
        $iconMail   = $imgPath . "icon_mail.png";
        $iconMobile = $imgPath . "icon_mobile.png";
        $iconPin    = $imgPath . "icon_pin.png";

        $data['img_logo'] = "data:image/png;base64, " . base64_encode(file_get_contents($logo));
        $data['icons']['info'] = "data:image/png;base64, " . base64_encode(file_get_contents($iconInfo));
        $data['icons']['mail'] = "data:image/png;base64, " . base64_encode(file_get_contents($iconMail));
        $data['icons']['mobile'] = "data:image/png;base64, " . base64_encode(file_get_contents($iconMobile));
        $data['icons']['pin'] = "data:image/png;base64, " . base64_encode(file_get_contents($iconPin));

        return $data;
    }

}
