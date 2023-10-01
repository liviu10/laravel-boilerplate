<?php

namespace App\Utilities;

use Exception;
use App\Models\Role;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use App\Traits\LogApiError;

class ApiResourcePermission
{
    use LogApiError;

    protected $roles;
    protected $permissions;

    /**
     * Create a new instance of the service class.
     * This constructor initializes the service with the necessary dependencies.
     */
    public function __construct()
    {
        $this->roles = new Role();
        $this->permissions = new Permission();
    }

    /**
     * Handle the creation of resource permissions for multiple roles.
     * This function takes an array of resource names and an array of role IDs
     * and creates resource permissions for each combination of resource and role.
     * @param array $resources An array of resource names.
     * @param array $roleIds An array of role IDs.
     * @return bool Returns true if the resource permissions are created successfully,
     * otherwise returns false if there is an exception.
     */
    public function handleApiCreateResourcePermission(array $resources): bool
    {
        $payload = [];
        $availableRoles = $this->roles->fetchUserRoles();

        if ($availableRoles && is_array($availableRoles) && count($availableRoles)) {
            foreach ($availableRoles as $role) {
                foreach ($resources as $resource) {
                    $payload[] = [
                        'name'               => $resource,
                        'description'        => null,
                        'is_active'          => $role['id'] === 1 ? true : false,
                        'need_approval'      => $role['id'] === 1 ? true : false,
                        'reports_to_role_id' => 0,
                        'created_at'         => Carbon::now(),
                        'updated_at'         => Carbon::now(),
                        'role_id'            => $role['id'],
                    ];
                }
            }

            try {
                $this->permissions->insertOrIgnore($payload);

                return true;
            } catch (Exception $exception) {
                $this->LogApiError($exception);

                return false;
            } catch (QueryException $exception) {
                $this->LogApiError($exception);

                return false;
            }
        } else {
            return false;
        }
    }
}
