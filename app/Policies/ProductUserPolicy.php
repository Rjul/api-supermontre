<?php

namespace App\Policies;

use App\Models\ProductUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductUserPolicy
{
    use HandlesAuthorization;

    /**
     * Before any other policy is called, this method is called.
     * @param User $user
     * @return true|void
     */
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductUser  $productUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProductUser $productUser)
    {
        return $user->id === $productUser->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductUser  $productUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ProductUser $productUser)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductUser  $productUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ProductUser $productUser)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductUser  $productUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ProductUser $productUser)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductUser  $productUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ProductUser $productUser)
    {
        //
    }
}
