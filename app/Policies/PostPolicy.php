<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Posts;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    use HandlesAuthorization;
    protected $roleArr = [];

    public function __construct()
    {
        $user = Auth::user();
        foreach (RolePermission::all () as $v){
            foreach (Role::all() as $role){
                if($role->name == $user->role->name){
                    if($v->role_id == $user->role->id){
                        foreach (Permission::all() as $permission){
                            if($v->permission_id == $permission->id){
                                if($permission->group_permission_id == 4){
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

    protected $roleArr = [];

    public function __construct()
    {
        $user = Auth::user();
        foreach (RolePermission::all () as $v){
            foreach (Role::all() as $role){
                if($role->name == $user->role->name){
                    if($v->role_id == $user->role->id){
                        foreach (Permission::all() as $permission){
                            if($v->permission_id == $permission->id){
                                if($permission->group_permission_id == 4){
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

    protected $roleArr = [];

    public function __construct()
    {
        $user = Auth::user();
        foreach (RolePermission::all () as $v){
            foreach (Role::all() as $role){
                if($role->name == $user->role->name){
                    if($v->role_id == $user->role->id){
                        foreach (Permission::all() as $permission){
                            if($v->permission_id == $permission->id){
                                if($permission->group_permission_id == 4){
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

    protected $roleArr = [];

    public function __construct()
    {
        $user = Auth::user();
        foreach (RolePermission::all () as $v){
            foreach (Role::all() as $role){
                if($role->name == $user->role->name){
                    if($v->role_id == $user->role->id){
                        foreach (Permission::all() as $permission){
                            if($v->permission_id == $permission->id){
                                if($permission->group_permission_id == 4){
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

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
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
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Posts $posts)
    {
        $roleArr = $this->roleArr;
        if (!empty($roleArr)) {
            $check = isRole($roleArr, '1', 'view');
            if ($check && $user->id === $posts->user_id) {
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
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Posts $posts)
    {
        $roleArr = $this->roleArr;
        if (!empty($roleArr)) {
            $check = isRole($roleArr, '1', 'update');
            if ($check && $user->id === $posts->user_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Posts $posts)
    {
        $roleArr = $this->roleArr;
        if (!empty($roleArr)) {
            $check = isRole($roleArr, '1', 'delete');
            if ($check && $user->id === $posts->user_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */


    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */

}
