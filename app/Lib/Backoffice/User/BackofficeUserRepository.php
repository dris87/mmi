<?php

namespace App\Lib\Backoffice\User;

use App\Lib\Exceptions\Repository\RepositoryUpdateException;
use App\Models\BackofficeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackofficeUserRepository
{
    private $model;

    public function __construct(
        BackofficeUser $model
    )
    {
        $this->model = $model;
    }

    public function getModel(){
        return $this->model;
    }

    public function findByEmail(string $email)
    {
        return BackofficeUser::firstWhere('email', $email);
    }

    public function findByUserId(int $userId)
    {
        return BackofficeUser::firstWhere('user_id', $userId);
    }

    public function all($filters = [], $admin = false)
    {
        $query = BackofficeUser::query()->select(
            "backoffice_users.id",
            "backoffice_users.email",
            "backoffice_users.phone",
            DB::raw("concat(backoffice_users.first_name, ' ', backoffice_users.last_name) as name"),
            DB::raw("backoffice_positions.name as position"),
            DB::raw("concat(bf_users2.first_name, ' ', bf_users2.last_name) as superior_name"),
            DB::raw("bf_positions2.name as superior_position"),
            DB::raw("branch_offices.name as branch_office"),
            DB::raw("users.is_active as is_active"),
            DB::raw("permissions.name as main_permission"),
            DB::raw("(
                SELECT GROUP_CONCAT(p.name)
                FROM permissions as p
                left join backoffice_user_extra_permissions as extrap on p.id = extrap.permission_id
                where extrap.backoffice_user_id = backoffice_users.id
            ) as extra_permissions"),
        )
            ->leftJoin("users", "users.id", "=", "backoffice_users.user_id")
            ->leftJoin("backoffice_positions", "backoffice_users.position_id", "=", "backoffice_positions.id")
            ->leftJoin("branch_offices", "branch_offices.id", "=", "backoffice_users.branch_office_id")
            ->leftJoin("backoffice_users as bf_users2", "bf_users2.id", "=", "backoffice_users.superior_id")
            ->leftJoin("backoffice_positions as bf_positions2", "bf_users2.position_id", "=", "bf_positions2.id")
            ->leftJoin("permissions", "backoffice_users.main_permission_id", "=", "permissions.id");

        if (!$admin) {
            $query->where('users.is_active', true);
            $query->where('users.is_verified', true);
        }

        if (isset($filters['superior_ids'])) {
            $query->whereIn('backoffice_users.superior_id', $filters['superior_ids']);
        }
        if (isset($filters['position_ids'])) {
            $query->whereIn('backoffice_users.position_id', $filters['position_ids']);
        }
        if (isset($filters['branch_office_ids'])) {
            $query->whereIn('backoffice_users.branch_office_id', $filters['branch_office_ids']);
        }
        if (isset($filters['permission_ids'])) {
            $query->whereIn('backoffice_users.main_permission_id', $filters['permission_ids']);
        }

        return $query->get();
    }

    public function getSuperiorQuery()
    {
        return BackofficeUser::query()->select([
            'users.*',
            DB::raw("concat(backoffice_users.first_name, ' ', backoffice_users.last_name) as name")
        ])
            ->leftJoin('users', 'users.id', 'backoffice_users.user_id')
            ->leftJoin('positions', 'positions.id', 'backoffice_users.position_id')
            //->where('users.positions.name', 'vezeto pozicio')
            ->where('users.is_active', true);
    }

    public function createFromRequest(
        User    $userModel,
        Request $request
    ) {
        $data = array_filter($request->only($this->model->getFillable()));
        $data['user_id'] = $userModel->getId();

        return BackofficeUser::create($data);
    }

    /**
     * @throws RepositoryUpdateException
     */
    public function updateFromRequest(
        BackofficeUser $backofficeUser,
        Request        $request): BackofficeUser
    {
        $data = array_filter($request->only($this->model->getFillable()));

        if (!$backofficeUser->update($data)) {
            throw new RepositoryUpdateException($backofficeUser);
        }

        return $backofficeUser;
    }
}
