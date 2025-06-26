<?php

namespace App\Http\Controllers\Select2;

use App\Http\Controllers\AppBaseController;
use App\Services\Select2Service;

class Select2Controller extends AppBaseController
{
    /** @var Select2Service */
    private $select2Service;

    public function __construct(Select2Service $select2Service)
    {
        $this->select2Service = $select2Service;
    }

    public function backofficePositions()
    {
        return $this->select2Service->getBackofficePositions();
    }

    public function backofficeBranchOffices()
    {
        return $this->select2Service->getBackofficeBranchOffices();
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function backofficeSuperiors()
    {
        $excludedId = request()->get('excluded') ? [request()->get('excluded')] : null;
        return $this->select2Service->getBackofficeSuperiors($excludedId);
    }

    public function permissions()
    {
        return $this->select2Service->getPermissions();
    }
}
