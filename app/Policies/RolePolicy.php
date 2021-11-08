<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view roles');
    }
    
    public function view(User $user)
    {
        return $user->hasPermissionTo('view roles');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create roles');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('edit roles');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete roles');
    }
}
