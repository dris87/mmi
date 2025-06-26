<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmailTemplate
 *
 * @property int $id
 * @property string $template_name
 * @property string $subject
 * @property string $body
 * @property string $variables
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|EmailTemplate newModelQuery()
 * @method static Builder|EmailTemplate newQuery()
 * @method static Builder|EmailTemplate query()
 * @method static Builder|EmailTemplate whereBody($value)
 * @method static Builder|EmailTemplate whereCreatedAt($value)
 * @method static Builder|EmailTemplate whereId($value)
 * @method static Builder|EmailTemplate whereSubject($value)
 * @method static Builder|EmailTemplate whereTemplateName($value)
 * @method static Builder|EmailTemplate whereUpdatedAt($value)
 * @method static Builder|EmailTemplate whereVariables($value)
 * @mixin \Eloquent
 */
class EmailTemplate extends Model
{

    const Account_Verification="Account Verification";
    const Company_Verification="Company Verification Email";
    const Company_Verified="Company Verified";
    const Password_Updated="Password Updated";
    const Password_Reset="Password Reset Email";

    const Candidate_Verification="Verify Email";
    const Candidate_Verified="Email Verified";

    const Job_Application_Candidate="Job Application Candidate";
    const Job_Application_Employer="Job Application Employer";

    const Company_Company_Review="Job Company Review";
    const Candidate_Delete_Verified="Candidate Delete Verified";

    const BackofficeUserNewPassword="Backoffice user new password";

    /**
     * @var string
     */
    public $table = 'email_templates';

    /**
     * @var array
     */
    public $fillable = [
        'template_name',
        'subject',
        'body',
        'variables',
    ];

    protected $casts = [
        'body' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subject' => 'required|max:150',
        'body'    => 'required',
    ];
}
