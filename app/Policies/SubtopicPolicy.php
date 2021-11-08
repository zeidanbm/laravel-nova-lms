<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubtopicPolicy
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
        return $user->hasPermissionTo('view topics/subtopics');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create topics/subtopics');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('edit topics/subtopics');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete topics/subtopics');
    }
}
