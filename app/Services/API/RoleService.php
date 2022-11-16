<?php
namespace App\Services\API;

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
            $role->permissions()->attach($permission_id);

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

