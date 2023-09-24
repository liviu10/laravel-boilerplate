<?php

namespace App\Utilities;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ApiCheckPermission
{
    protected $modelName;
    protected $currentRouteName;
    protected $currentAuthUser;
    protected $permissionDetails;
    protected $hasPermission = false;

    /**
     * Handle API permission check for the current user and route.
     * This function checks if the current authenticated user has the required
     * permission for the current route. It sets the 'hasPermission' property to
     * 'true' if the user has the permission, otherwise 'false'.
     * @return bool The result of the permission check:
     * 'true' if the user has permission, 'false' otherwise.
     */
    public function handleApiCheckPermission(): bool
    {
        $this->modelName = new Permission();
        $this->currentRouteName = Route::current()->getName();
        $this->currentAuthUser = Auth::user();
        $this->permissionDetails = $this->modelName->checkPermission(
            $this->currentRouteName,
            $this->currentAuthUser ? $this->currentAuthUser->role_id : null
        );

        if ($this->permissionDetails->isNotEmpty()) {
            return $this->hasPermission = true;
        }

        return $this->hasPermission = false;
    }
}
