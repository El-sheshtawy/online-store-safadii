<?php

namespace App\Policies;

use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class RolePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        $user = Auth::guard('admin')->user();
        if ($user->super_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasAbility('roles.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Role $role): bool
    {
        return $user->hasAbility('roles.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasAbility('roles.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Role $role): bool
    {
        return $user->hasAbility('roles.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Role $role): bool
    {
        return $user->hasAbility('roles.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Role $role): bool
    {
        return $user->hasAbility('roles.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Role $role): bool
    {
        return $user->hasAbility('roles.force-delete');
    }
}
