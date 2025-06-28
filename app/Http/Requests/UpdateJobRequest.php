<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id' => 'sometimes|required',
            'job_title' => 'required|max:180',
            'job_position' => 'required|max:180',
            'job_locations' => 'required|array',
            'job_locations.*' => 'required|exists:cities,id',
            'job_candidate_count' => 'required|numeric|min:1',
            'job_types' => 'required|array',
            'job_types.*' => 'required|exists:job_types,id',
            'job_categories' => 'required|array',
            'job_categories.*' => 'required|exists:job_categories,id',
            'job_shifts' => 'required|array',
            'job_shifts.*' => 'required|exists:job_shifts,id',
            'description' => 'required',
            'tasks' => 'required',
            'perks' => 'nullable',
            'advantages' => 'nullable',
            'job_expiry_date' => 'required|date|after:today',
            'job_release_date' => 'required|date',
            'is_anonym' => 'nullable|boolean',

            // Követelmények - javított mezőnevek
            'jobRequirements.drivers_license.*.drivers_license_id' => 'sometimes|required|exists:driving_licences,id',
            'jobRequirements.education.*.education_name' => 'sometimes|required|string',
            'jobRequirements.education.*.education_level' => 'sometimes|required|exists:required_degree_levels,id',
            'jobRequirements.experience.*.experience_position' => 'sometimes|required|string',
            'jobRequirements.experience.*.experience_years' => 'sometimes|required|numeric|min:0',
            'jobRequirements.personal_skill.*.personal_skill_name' => 'sometimes|required|string',
            'jobRequirements.software_skill.*.software_skill_name' => 'sometimes|required|string',
            'jobRequirements.software_skill.*.software_skill_level' => 'sometimes|required|exists:skill_level,id',
            'jobRequirements.it_skill.*.it_skill_name' => 'sometimes|required|string',
            'jobRequirements.it_skill.*.it_skill_level' => 'sometimes|required|exists:skill_level,id',
            'jobRequirements.language_skill.*.language_skill_id' => 'sometimes|required|exists:languages,id',
            'jobRequirements.language_skill.*.language_skill_level' => 'sometimes|required|exists:language_level,id',
        ];
    }

    public function messages()
    {
        return $messages = [
            'state_id.required' => 'The state field is required.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
    }
}
