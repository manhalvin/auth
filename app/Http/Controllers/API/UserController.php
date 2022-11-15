<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Http\Resources\API\userResource;
use App\Models\User;
use App\Services\API\GroupService;
use App\Services\API\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $UserService, $groupService;

    protected $filters,$group_id = [];
    protected $search = null;
    const _PER_PAGE = 2;
    public function __construct(UserService $UserService, GroupService $groupService)
    {
        $this->UserService = $UserService;
        $this->groupService = $groupService;
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->can('viewAny', User::class)) {
            if ($request->has('status')) {
                $status = $request->input('status');
                $this->inputStatus($status);
            }

            if ($request->has('role')){
                $role = $request->input('role');
                $this->inputRole($role);
            }

            if ($request->has('search')) {
                $this->search = $request->input('search');
            }

            $sortBy = $request->input('sort-by');
            $sortType = $request->input('sort-type');
            $sortArr = $this->UserService->handleSort($sortBy,$sortType);

            $user = $this->UserService->getAllUsers($this->filters, $this->search, $sortArr, self::_PER_PAGE,$this->group_id);
            if ($user->count() == 0) {
                return sendError([], 'Data not exist');
            } else {
                $user = UserResource::collection($user);
                return sendSuccess($user, 'Fetch data success');
            }
        }else{
            return sendError([], 'Prohibited Access');
        }

    }


    public function show($user)
    {
        $result = $this->UserService->handleShow($user);
        $users = $this->UserService->getById($user);
        if ($users) {
            if (Auth::user()->can('view', $users)) {
                if ($result) {
                    return $result;
                }
            } else {
                return sendError([], 'Prohibited Access');
            }
        } else {
            return sendError('Data User Not exit');
        }
    }

    public function postAdd(UserRequest $request)
    {
        if (Auth::user()->can('create', User::class)) {
            $data = $request->all();
            $result = $this->UserService->save($data);
            $result = new UserResource($result);
            return sendSuccess($result, 'Inserted Data User Success !');
        } else {
            return sendError([], 'Prohibited Access');
        }

    }

    public function edit($user){
        $result  = $this->UserService->handleEdit($user);
        $users = $this->UserService->getById($user);
        if($users){
            if(Auth::user()->can('update',$users)){
                if($result){
                    return $result;
                }
            }
            return sendError([],'Prohibited Access');
        }else{
            return sendError('Data User Not exit');
        }
    }

    public function postEdit(Request $request,$user)
    {
        $data = $request->all();
        $users = $this->UserService->getById($user);
        if($users){
            if(Auth::user()->can('update',$users)){
                $this->UserService->updateDataUser($data,$user);
                return sendSuccess([], 'Update Data User Success !');
            }
            return sendError([],'Prohibited Access');
        }else{
            return sendError('Data User Not exit');
        }

    }
    public function delete($post)
    {
        $result = $this->UserService->handleDelete($post);
        return $result;
    }

    public function inputStatus($status){
        $status = $status == 'active' ? 1 : 0;
        $this->filters[] = ['users.status', '=', $status];
    }

    public function inputRole($role){
        if(!empty($role)){
            $role = explode(',',$role);
            $this->group_id = $this->groupService->getId($role);
        }
    }
}
