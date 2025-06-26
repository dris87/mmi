<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Rules\YoutubeOrVimeoUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * @throws ValidationException
     */
    public function prepareForValidation()
    {
    }

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
        $rules = [

            //Basic company data
            'companyName'    => 'required',
            'representative' => 'required',
            'companyNumber' => 'nullable',
            'company_size'    => 'required',
            'established_in'    => 'required',
            'industry_id'    => 'required|exists:industries,id',
            'is_paper_invoice'    => 'nullable',
            'display_name'    => 'nullable',

            //Textareas
            'introduction'    => 'required',
            'mission'    => 'required',
            'why_work_with_us'    => 'required',

            //Headquarters
            'zipCode' => 'required|numeric|exists:postal_codes,postal_code',
            'city'    => 'required|exists:cities,name',
            'houseNumber'    => 'required',
            'street'    => 'required',
            'floor'    => 'nullable',
            'door'    => 'nullable',

            //Socials
            'website'    => 'nullable|url',
            'facebook_url'    => 'nullable|url',
            'linkedin_url'    => 'nullable|url',
            'google_plus_url'    => 'nullable|url',

            //Mailing Address
            'mailing_zipCode' => 'sometimes|required|numeric|exists:postal_codes,postal_code',
            'mailing_city'    => 'sometimes|required|exists:cities,name',
            'mailing_houseNumber'    => 'sometimes|required',
            'mailing_street'    => 'sometimes|required',
            'mailing_floor'    => 'nullable',
            'mailing_door'    => 'nullable',

            //Files
            'logo'  => 'nullable|max:10240|mimes:jpeg,jpg,png,tif',
            'cover_photo'  => 'nullable|image',
            'workplace_img'    => 'nullable|max:10240|mimes:jpeg,jpg,png,tif',

            //Repeaters

            'videos.*.url' => ['sometimes', 'required', new YoutubeOrVimeoUrl()],
            'videos.*.title' => 'sometimes|required',
            'videos.*.description' => 'sometimes|nullable',
            'videos.*.thumbnail' => 'sometimes|nullable|max:10240|mimes:jpeg,jpg,png,tif',

            'companySites.*.zip_code' => 'sometimes|required|numeric|exists:postal_codes,postal_code',
            'companySites.*.city' => 'sometimes|required|exists:cities,name',
            'companySites.*.address' => 'sometimes|required',
            'companySites.*.street' => 'sometimes|required',
            'companySites.*.floor' => 'sometimes|nullable',
            'companySites.*.door' => 'sometimes|nullable',

            'companyAwards.*.name' => 'sometimes|required',
            'companyAwards.*.description' => 'sometimes|nullable',
            'companyAwards.*.award_image' => 'sometimes|required|max:10240|mimes:jpeg,jpg,png,tif',

            'companyGallery.*.image' => 'nullable|mimes:jpeg,jpg,png,tif',
        ];

        if(!empty($this->route('company'))) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $company = $this->route('company');
            $rules['vatNumber'] = 'required|unique:companies,vatNumber,'.$company->id;
        }
        else{
            $rules['vatNumber'] = 'required|unique:companies,vatNumber';
        }

        return $rules;
    }
    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'vatNumber.unique' => 'Az adószámot már regisztrálták. Amennyiben nem Ön regisztrálta a céget, kérjük vegye fel velünk a kapcsolatot.',
        ];
    }
}
