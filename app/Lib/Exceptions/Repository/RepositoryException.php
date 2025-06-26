<?php

namespace App\Lib\Exceptions\Repository;

class RepositoryException extends \Exception
{
    protected $action = '';

    public function __construct($model, $code = 0, Throwable $previous = null)
    {
        $message = "Repository Exception Could not "
            . $this->action . " " . get_class($model) . "Id: " . $model->id;
        parent::__construct($message, $code, $previous);
    }

}
