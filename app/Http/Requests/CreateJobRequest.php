<?php

namespace App\Http\Requests;

use App\Models\Job;
use App\Rules\ArrayMinOneItemRequired;
use App\Rules\JobRequirementValidator;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'company_id'             => 'sometimes|required',
            'job_title'              => 'required|max:180',
            'job_position'              => 'required|max:180',
            'job_locations'           => 'required',
            'job_candidate_count'    => 'required|numeric',
            'job_types'            => 'required',
            'job_categories'        => 'required',
            'job_shifts'        => 'required',
            'description'            => 'required',
            'tasks'                  => 'required',
            'perks'                  => 'nullable',
            'advantages'             => 'nullable',
            'job_expiry_date'        => 'required',
            'is_anonym'              => 'nullable',
            'job_release_date'       => 'required',
            'jobRequirements'        => 'required',
            'jobRequirements.drivers_license.*.drivers_license_name' => 'sometimes|required',
            'jobRequirements.education.*.education_name' => 'sometimes|required',
            'jobRequirements.education.*.education_level' => 'sometimes|required|numeric|exists:required_degree_levels,id',
            'jobRequirements.experience.*.experience_position' => 'sometimes|required',
            'jobRequirements.experience.*.experience_years' => 'sometimes|required|numeric',
            'jobRequirements.personal_skill.*.personal_skill_name' => 'sometimes|required',
            'jobRequirements.software_skill.*.software_skill_name' => 'sometimes|required',
            'jobRequirements.software_skill.*.software_skill_level' => 'sometimes|required|numeric|exists:skill_level,id',
            'jobRequirements.it_skill.*.it_skill_name' => 'sometimes|required',
            'jobRequirements.it_skill.*.it_skill_level' => 'sometimes|required|numeric|exists:skill_level,id',
            'jobRequirements.language_skill.*.language_skill_name' => 'sometimes|required|numeric|exists:languages,id',
            'jobRequirements.language_skill.*.language_skill_level' => 'sometimes|required|numeric|exists:language_level,id',

        ];

        return $rules;
    }
}
