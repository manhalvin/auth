<?php
namespace App\Services\API;

use App\Models\Role;
use App\Repositories\API\RoleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class RoleService{

    protected $roleRepository;
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function searchRole($search){
        return $this->roleRepository->searchRole($search);
    }

    public function handleAdd($name,$description,$permission_id){
        try {
            DB::beginTransaction();

            $dataRole = [
                'name' => $name,
                'description' => $description,
            ];
            $role = $this->roleRepository->addRole($dataRole);
            // $role = Role::find(23);
            $role->permissions()->attach($permission_id);
            // thêm role ( cột name ) : Master có id = 23 vào bảng roles
            // Dựa vào role có id = 23 -> thêm hàng loạt các giá trị permision_id từ input user nhập vào  => vào bảng trung gian role_permissions
            // VD: role_id = 23 , permission_id = 1
            // VD: role_id = 23 , permission_id = 2
            // Pivot tables về cơ bản là một bảng trung gian giữa 2 bảng chính trong mối quan hệ n-n
            // attach() - thêm 1 or nhiều records trong bảng Pivot (role_permissions).



            DB::commit();

            return sendSuccess([],'Add Role Success');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function getId($role){
        return $this->roleRepository->getId($role);
    }

    public function handleUpdate($role,$name,$description,$permission_id){
        try {
            DB::beginTransaction();

            $this->roleRepository->updateRole($role,$name,$description);
            $role = $this->roleRepository->getId($role);

            $role->permissions()->sync($permission_id);

            DB::commit();

            return sendSuccess([],'Update Role Success');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($role){
        return $this->roleRepository->delete($role);
    }
}

