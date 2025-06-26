<?php

namespace App\Repositories\Candidates;

use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\Country;
use App\Models\Factories\PostalCodeFactory;
use App\Models\State;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class CandidateProfileRepository
 */
class CandidateProfileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'experience',
        'industry_id',
        'functional_area_id',
        'current_salary',
        'expected_salary',
        'immediate_available',
        'is_active',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Candidate::class;
    }

    /**
     * @param  array  $input
     *
     * @return mixed
     */
    public function createExperience($input)
    {
        if(!isset($input['country_id'])){
            $input['country_id'] = Country::HUNGARY;
        }
        if(!isset($input['state_id'])){
            $input['state_id'] = State::DEFAULT_STATE;
        }

        if(!isset($input['state_id'])){
            $input['state_id'] = State::DEFAULT_STATE;
        }

        $PostalCodeFactory = new PostalCodeFactory();
        if(isset($input['zipCode']) && !empty($input['zipCode'])){
            $objCity = $PostalCodeFactory->getByPostalCode($input['zipCode']);
            if($objCity){
                $input['city_id'] = $objCity->city_id;
                $input['postcode_id'] = $objCity->id;
            }
        }


        $input['currently_working'] = isset($input['currently_working']) ? 1 : 0;
        if(!isset($input["candidate_id"])){
            $input['candidate_id'] = Auth::user()->owner_id;
        }
        $input['end_date'] = (! empty($input['end_date'])) ? $input['end_date'] : null;

        $candidateExperience = CandidateExperience::create($input);
        $candidateExperience->country = getCountryName($candidateExperience->country_id);

        return $candidateExperience;
    }

    /**
     * @param  array  $input
     *
     * @return Builder|Model|object
     */
    public function createEducation($input)
    {
        if(!isset($input['country_id'])){
            $input['country_id'] = Country::HUNGARY;
        }
        if(!isset($input['state_id'])){
            $input['state_id'] = State::DEFAULT_STATE;
        }

        if(!isset($input['state_id'])){
            $input['state_id'] = State::DEFAULT_STATE;
        }

        $PostalCodeFactory = new PostalCodeFactory();
        if(isset($input['zipCode']) && !empty($input['zipCode'])){
            $objCity = $PostalCodeFactory->getByPostalCode($input['zipCode']);
            if($objCity){
                $input['city_id'] = $objCity->city_id;
                $input['postcode_id'] = $objCity->id;
            }
        }

        if(!isset($input["candidate_id"])){
            $input['candidate_id'] = Auth::user()->owner_id;
        }

        /** @var CandidateEducation $education */
        $education = CandidateEducation::create($input);

        return $this->getEducation($education);
    }

    /**
     * @param  CandidateEducation  $candidateEducation
     *
     * @return Builder|Model|object
     */
    public function getEducation(CandidateEducation $candidateEducation)
    {
        return CandidateEducation::with('degreeLevel')
            ->where('id', $candidateEducation->id)->first();
    }
}
