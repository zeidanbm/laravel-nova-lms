<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
    
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view users');
    }
    
    public function view(User $user)
    {
        return $user->hasPermissionTo('view users');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create users');
    }

    public function update(User $user, $model)
    {
        if ($user->hasPermissionTo('edit own users')) {
            return $user->id === $model->id;
        }
        
        return $user->hasPermissionTo('edit users');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete users');
    }
}
