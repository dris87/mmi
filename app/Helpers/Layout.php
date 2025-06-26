<?php
namespace App\Helpers;
use App\Http\Livewire\DegreeLevel;
use App\Models\CandidateStatus;
use App\Models\City;
use App\Models\DrivingLicences;
use App\Models\Language;
use App\Models\LanguageLevel;
use App\Models\RequiredDegreeLevel;
use App\Models\SalaryCurrency;
use App\Models\SkillLevel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layout
{
    public static function getJobRequirementItemHtml($objJobRequirementType, $iterator, $arrData = null){

        $data = [];
        $defaults = [];

        $data['iterator'] = $iterator;

        $data['type']   = $objJobRequirementType->getId();

        $view = $objJobRequirementType->getViewKey();
        $viewPath = 'employer/jobs/partials/'.$view.'_field';

        $data['key']   = $view;

        if (view()->exists($viewPath)) {
            switch($view){
                case 'education':{
                    $data['skillLevels'] = RequiredDegreeLevel::toBase()->pluck('name', 'id');

                    if(isset($arrData[$view.'_name'])){
                        $arrData['name'] = $arrData[$view.'_name'];
                        $arrData['degree_level_id'] = $arrData[$view.'_level'];
                    }

                    $defaults[$view.'_name']  = $arrData['name'] ?? null;
                    $defaults[$view.'_level']  = $arrData['degree_level_id'] ?? null;

                    break;
                }
                case 'experience':{

                    if(isset($arrData[$view.'_position'])){
                        $arrData['position'] = $arrData[$view.'_position'];
                        $arrData['years'] = $arrData[$view.'_years'];
                    }

                    $defaults[$view.'_position']  = $arrData['position'] ?? null;
                    $defaults[$view.'_years']  = $arrData['years'] ?? null;
                    break;
                }
                case 'drivers_license':{

                    if(isset($arrData[$view.'_id'])){
                        $arrData['driving_license_id'] = $arrData[$view.'_id'];
                    }

                    $data['driversLicense'] = DrivingLicences::toBase()->pluck('name', 'id');
                    $defaults[$view.'_id']  = $arrData['driving_license_id'] ?? null;
                    break;
                }
                case 'personal_skill':{
                    if(isset($arrData[$view.'_name'])){
                        $arrData['name'] = $arrData[$view.'_name'];
                    }
                    $defaults[$view.'_name']  = $arrData['name'] ?? null;
                    break;
                }
                case 'it_skill':
                case 'software_skill':{
                    if(isset($arrData[$view.'_name'])){
                        $arrData['name'] = $arrData[$view.'_name'];
                        $arrData['skill_level_id'] = $arrData[$view.'_level'];
                    }
                    $data['skillLevels'] = SkillLevel::toBase()->pluck('name', 'id');
                    $defaults[$view.'_name']  = $arrData['name'] ?? null;
                    $defaults[$view.'_level']  = $arrData['skill_level_id'] ?? null;
                    break;
                }
                case 'language_skill':{
                    if(isset($arrData[$view.'_id'])){
                        $arrData['language_id'] = $arrData[$view.'_id'];
                        $arrData['language_level_id'] = $arrData[$view.'_level'];
                    }
                    $data['languageSkills'] = Language::toBase()->pluck('language', 'id');
                    $data['skillLevels'] = LanguageLevel::toBase()->pluck('name', 'id');
                    $defaults[$view.'_id']  = $arrData['language_id'] ?? null;
                    $defaults[$view.'_level']  = $arrData['language_level_id'] ?? null;
                    break;
                }
                default: {
                    break;
                }
            }

            $data['defaults'] = $defaults;

            return view('employer/jobs/partials/base_field', ['layout' => view($viewPath, compact('data'))->render()])->render();
        }

        return null;
    }

    public static function getJobRequirementFrontendHtml($jobRequirements){

        $requirementData = [];

        foreach($jobRequirements as $view => $requirements){

            $viewPath = 'web/jobs/partials/'.$view.'_requirement';

            if (view()->exists($viewPath)) {
                if($requirements instanceof HasMany){
                    $requirements = $requirements->get()->toArray();
                }
                foreach($requirements as $arrData) {
                    $data = [];
                    switch ($view) {
                        case 'education':
                        {
                            if (isset($arrData[$view . '_name'])) {
                                $arrData['name'] = $arrData[$view . '_name'];
                                $arrData['degree_level_id'] = $arrData[$view . '_level'];
                            }

                            $data['skill_level'] = null;
                            $data['name'] = $arrData['name'];

                            if($arrData['degree_level_id']) {
                                $skillLevel = RequiredDegreeLevel::query()->where('id', '=', $arrData['degree_level_id'])->first();
                                if($skillLevel){
                                    $data['skill_level'] = $skillLevel->name;
                                }
                            }

                            break;
                        }
                        case 'experience':
                        {

                            if (isset($arrData[$view . '_position'])) {
                                $arrData['position'] = $arrData[$view . '_position'];
                                $arrData['years'] = $arrData[$view . '_years'];
                            }

                            $data['position'] = $arrData['position'];
                            $data['years'] = $arrData['years'];

                            break;
                        }
                        case 'drivers_license':
                        {

                            if (isset($arrData[$view . '_id'])) {
                                $arrData['driving_license_id'] = $arrData[$view . '_id'];
                            }

                            $data['driving_license'] = null;

                            if($arrData['driving_license_id']) {
                                /** @var DrivingLicences $objDriversLicense */
                                $objDriversLicense = DrivingLicences::query()->where('id', '=', $arrData['driving_license_id'])->first();
                                if($objDriversLicense){

                                    $data['driving_license'] = $objDriversLicense->getName();
                                }
                            }
                            break;
                        }
                        case 'personal_skill':
                        {
                            if (isset($arrData[$view . '_name'])) {
                                $arrData['name'] = $arrData[$view . '_name'];
                            }

                            $data['name'] = $arrData['name'];
                            break;
                        }
                        case 'it_skill':
                        case 'software_skill':
                        {
                            if (isset($arrData[$view . '_name'])) {
                                $arrData['name'] = $arrData[$view . '_name'];
                                $arrData['skill_level_id'] = $arrData[$view . '_level'];
                            }

                            $data['skill_level'] = null;
                            $data['name'] = $arrData['name'];

                            if($arrData['skill_level_id']) {
                                $skillLevel = SkillLevel::query()->where('id', '=', $arrData['skill_level_id'])->first();
                                if($skillLevel){
                                    $data['skill_level'] = $skillLevel->name;
                                }
                            }

                            break;
                        }
                        case 'language_skill':
                        {
                            if (isset($arrData[$view . '_id'])) {
                                $arrData['language_id'] = $arrData[$view . '_id'];
                                $arrData['language_level_id'] = $arrData[$view . '_level'];
                            }

                            $data['name'] = null;
                            $data['skill_level'] = null;

                            if($arrData['language_id']) {
                                $objLanguage = Language::query()->where('id', '=', $arrData['language_id'])->first();
                                if($objLanguage){
                                    $data['name'] = $objLanguage->language;
                                }
                            }
                            if($arrData['language_level_id']) {
                                $skillLevel = LanguageLevel::query()->where('id', '=', $arrData['language_level_id'])->first();
                                if($skillLevel){
                                    $data['skill_level'] = $skillLevel->name;
                                }
                            }
                            break;
                        }
                        default:
                        {
                            break;
                        }
                    }
                    if(!empty($data)) {
                        $requirementData[$view][] = $data;
                    }
                }
            }
        }

        return view('web/jobs/requirements', ['requirements' => $requirementData])->render();

    }
}
