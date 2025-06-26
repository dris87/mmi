<?php

namespace App\Http\Middleware;

use App\Models\MethodPermission;
use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Lib\UserPermission\UserPermissionService;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PermissionMiddleware
{
    protected $userPermissionService;

    protected $controller;

    protected $controllerMethod;



    public function __construct(
        UserPermissionService $userPermissionService
    )
    {
        $this->userPermissionService = $userPermissionService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $this->init($request);

        if ($this->userPermissionService->isActive()) {
            if (!$this->userHasPermission()) {

            }
        }

        return $next($request);
    }

    private function init($request)
    {
        $currentAction = $request->route()->getAction('controller');
        if (Str::contains($currentAction, '@')) {
            $currentAction = explode('@', $currentAction);
            $this->controller = $currentAction[0];
            $this->controllerMethod = $currentAction[1];
        }
    }

    private function userHasPermission(): bool
    {
        return $this->userPermissionService->handlePermission(
            $this->controller,
            $this->controllerMethod
        );
    }
}
