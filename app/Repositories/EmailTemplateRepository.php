<?php

namespace App\Repositories;

use App\Models\EmailTemplate;

/**
 * Class EmailTemplateRepository
 */
class EmailTemplateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'template_name',
        'subject',
        'body',
        'variables',
    ];

    public function getByName($template_name){
        return EmailTemplate::whereTemplateName($template_name)->first();
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return EmailTemplate::class;
    }
}
