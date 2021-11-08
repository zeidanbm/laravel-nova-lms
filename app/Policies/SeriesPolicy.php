<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Series;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeriesPolicy
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
    
    public function view(User $user, Series $series)
    {
        if ($user->hasPermissionTo('view own catalogs')) {
            return $user->id === $series->user_id;
        }

        return $user->hasPermissionTo('view catalogs');
    }

    public function create(User $user)
    {
        return $user->hasAnyPermission(['create catalogs', 'create own catalogs']);
    }

    public function update(User $user, Series $series)
    {
        if ($user->hasPermissionTo('edit own catalogs')) {
            return $user->id == $series->user_id;
        }
        return $user->hasPermissionTo('edit catalogs');
    }

    public function delete(User $user, Series $series)
    {
        if ($user->hasPermissionTo('delete own catalogs')) {
            return $user->id === $series->user_id;
        }

        return $user->hasPermissionTo('delete catalogs');
    }
}
