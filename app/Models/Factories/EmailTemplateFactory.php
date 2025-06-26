<?php
namespace App\Models\Factories;

use App\Models\Candidate;
use App\Models\CandidateBasicItSkills;
use App\Models\EmailTemplate;

/**
 * BaseFactory
 */
class EmailTemplateFactory extends BaseFactory
{
    /**
     * @param $id
     * @return mixed|EmailTemplate
     */
    public function getById($id)
    {
        return EmailTemplate::where('id', '=', $id)->first();
    }

    /**
     * @param string $template
     * @return mixed|EmailTemplate
     */
    public function getByTemplate(string $template)
    {
        return EmailTemplate::where('template_name', '=', $template)->first();
    }
}
