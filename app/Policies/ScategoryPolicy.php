<?php

namespace App\Policies;

use App\Models\User;
use App\Models\scategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\scategory  $scategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, scategory $scategory)
    {
        //
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
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\scategory  $scategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, scategory $scategory)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\scategory  $scategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, scategory $scategory)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\scategory  $scategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, scategory $scategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\scategory  $scategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, scategory $scategory)
    {
        //
    }
}
