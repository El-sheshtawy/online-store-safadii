<?php

namespace App\Traits;

use App\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->morphToMany(Role::class, 'authorizable', 'role_user');
    }

    public function hasAbility($ability)
    {
        $deniedRoles = $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)->where('type', '=', 'deny');
        })->exists();

        if ($deniedRoles) {
            return false;
        }

        return $this->roles()->whereHas('abilities', function ($query) use ($ability) {
           $query->where('ability', $ability)->where('type', '=', 'allow');
        })->exists();
    }
}
