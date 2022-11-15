<?php

namespace App\Policies;

use App\Models\GroupPermission;
use App\Models\Permission;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    const _Group_Permission_ID =  4;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $role = $user->role;
        // $arr[] = $role->permissions;
        foreach (Permission::all() as $permission) {
            // $arr[] = $permission;
            if($role->permissions->contains('name',$permission->name)){
                if($permission->group_permission_id == self::_Group_Permission_ID){
                    $roleArr[$permission->groupPermission->name][] = $permission->name;
                }
            }
        }
        // dd(json_encode($arr));
        if (!empty($roleArr)) {
            $check = isRole($roleArr, 'Posts', 'viewAny');
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
        $role = $user->role;

        foreach (Permission::all() as $permission) {
            if($role->permissions->contains('name',$permission->name)){
                if($permission->group_permission_id == self::_Group_Permission_ID){
                    $roleArr[$permission->groupPermission->name][] = $permission->name;
                }
            }
        }

        if (!empty($roleArr)) {
            $check = isRole($roleArr, 'Posts', 'view');
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
        $role = $user->role;
        foreach (Permission::all() as $permission) {
            if($role->permissions->contains('name',$permission->name)){
                if($permission->group_permission_id == self::_Group_Permission_ID){
                    $roleArr[$permission->groupPermission->name][] = $permission->name;
                }
            }
        }

        if (!empty($roleArr)) {
            $check = isRole($roleArr, 'Posts', 'create');
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
        $role = $user->role;

        foreach (Permission::all() as $permission) {
            if($role->permissions->contains('name',$permission->name)){
                if($permission->group_permission_id == self::_Group_Permission_ID){
                    $roleArr[$permission->groupPermission->name][] = $permission->name;
                }
            }
        }

        if (!empty($roleArr)) {
            $check = isRole($roleArr, 'Posts', 'update');
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
        $role = $user->role;
        foreach (Permission::all() as $permission) {
            if($role->permissions->contains('name',$permission->name)){
                if($permission->group_permission_id == self::_Group_Permission_ID){
                    $roleArr[$permission->groupPermission->name][] = $permission->name;
                }
            }
        }
        if (!empty($roleArr)) {
            $check = isRole($roleArr, 'Posts', 'delete');
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
    public function restore(User $user, Posts $posts)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Posts $posts)
    {
        //
    }
}
