<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;
    protected $roleArr = [];

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function __construct()
    {
        $user = Auth::user();
        foreach (RolePermission::all () as $v){
            foreach (Role::all() as $role){
                if($role->name == $user->role->name){
                    if($v->role_id == $user->role->id){
                        foreach (Permission::all() as $permission){
                            if($v->permission_id == $permission->id){
                                if($permission->group_permission_id == 7){
                                    $this->roleArr[$v->role_id][] = $permission->name;
                                }
                            }
                        }
                    }

                }
            }
        }
        return $this->roleArr;
    }

    public function viewAny(User $user)
    {
        $roleArr = $this->roleArr;
        if (!empty($roleArr)) {
            $check = isRole($roleArr, '1', 'viewAny');
            if ($check) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        $roleArr = $this->roleArr;
        if (!empty($roleArr)) {
            $check = isRole($roleArr, '1', 'view');
            if ($check && $user->id === $model->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $roleArr = $this->roleArr;
        if (!empty($roleArr)) {
            $check = isRole($roleArr, '1', 'create');
            if ($check) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        $roleArr = $this->roleArr;
        if (!empty($roleArr)) {
            $check = isRole($roleArr, '1', 'edit');
            if ($check && $user->id === $model->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        $roleArr = $this->roleArr;
        if (!empty($roleArr)) {
            $check = isRole($roleArr, '1', 'delete');
            if ($check && $user->id === $model->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
