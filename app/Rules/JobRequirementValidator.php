<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class JobRequirementValidator implements Rule
{
    public $messages;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach($value as $type => $requirement){

            $rules = [];
            switch($type){
                case 'education':{
                    $rules = [
                        'education_name' => 'required',
                        'education_level' => 'required|numeric|exists:required_degree_levels,id',
                    ];
                    break;
                }
                case 'experience':{
                    $rules = [
                        'experience_position' => 'required',
                        'experience_years' => 'required',
                    ];
                    break;
                }
                case 'personal_skill':{
                    $rules = [
                        'personal_skill_name' => 'required',
                    ];
                    break;
                }
                case 'drivers_license':{
                    $rules = [
                        'drivers_license_name' => 'required|exists:skill_level,id',
                    ];
                    break;
                }
                case 'software_skill':{
                    $rules = [
                        'software_skill_name' => 'required',
                        'software_skill_level' => 'required|numeric|exists:skill_level,id',
                    ];
                    break;
                }
                case 'it_skill':{
                    $rules = [
                        'it_skill_name' => 'required',
                        'it_skill_level' => 'required|numeric|exists:skill_level,id',
                    ];
                    break;
                }
                case 'language_skill':{
                    $rules = [
                        'language_skill_name' => 'required|numeric|exists:languages,id',
                        'language_skill_level' => 'required|numeric|exists:language_level,id',
                    ];
                    break;
                }
                default:{
                    break;
                }
            }
            foreach($requirement as $data) {
                $validator = Validator::make($data, $rules);

                if ($validator->fails()) {
                    $this->messages = $validator->getMessageBag()->getMessages();
                    return false;
                    break;
                }
            }

            return true;

        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        foreach($this->messages as $message){
            return $message[0];
        }
    }
}
