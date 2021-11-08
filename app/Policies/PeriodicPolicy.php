<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Periodic;
use Illuminate\Auth\Access\HandlesAuthorization;

class PeriodicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function view(User $user, Periodic $periodic)
    {
        if ($user->hasPermissionTo('view own catalogs')) {
            return $user->id === $periodic->user_id;
        }

        return $user->hasPermissionTo('view catalogs');
    }

    public function create(User $user)
    {
        return $user->hasAnyPermission(['create catalogs', 'create own catalogs']);
    }

    public function update(User $user, Periodic $periodic)
    {
        if ($user->hasPermissionTo('edit own catalogs')) {
            return $user->id == $periodic->user_id;
        }
        return $user->hasPermissionTo('edit catalogs');
    }

    public function delete(User $user, Periodic $periodic)
    {
        if ($user->hasPermissionTo('delete own catalogs')) {
            return $user->id === $periodic->user_id;
        }

        return $user->hasPermissionTo('delete catalogs');
    }
}
