<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\SuperAdmin;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(SuperAdmin $superAdmin, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(SuperAdmin $superAdmin, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(SuperAdmin $superAdmin, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(SuperAdmin $superAdmin, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(SuperAdmin $superAdmin, Role $role)
    {
        //
    }
}
