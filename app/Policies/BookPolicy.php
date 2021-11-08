<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
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
    
    public function view(User $user, Book $book)
    {
        if ($user->hasPermissionTo('view own catalogs')) {
            return $user->id === $book->user_id;
        }

        return $user->hasPermissionTo('view catalogs');
    }

    public function create(User $user)
    {
        return $user->hasAnyPermission(['create catalogs', 'create own catalogs']);
    }

    public function update(User $user, Book $book)
    {
        if ($user->hasPermissionTo('edit own catalogs')) {
            return $user->id == $book->user_id;
        }
        return $user->hasPermissionTo('edit catalogs');
    }

    public function delete(User $user, Book $book)
    {
        if ($user->hasPermissionTo('delete own catalogs')) {
            return $user->id === $book->user_id;
        }

        return $user->hasPermissionTo('delete catalogs');
    }
}
