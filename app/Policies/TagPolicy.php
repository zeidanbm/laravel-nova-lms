<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
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
    
    public function view(User $user)
    {
        return $user->hasPermissionTo('view tags');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create tags');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('edit tags');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete tags');
    }
}
