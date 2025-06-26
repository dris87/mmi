<?php

namespace App\Lib\Exceptions\Repository;

class RepositoryUpdateException extends RepositoryException
{
    protected $action = 'update';
}
