<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\EditUserRequest;
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
    protected $UserService;
    protected $filters = [];
    protected $search = null;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->can('viewAny', User::class)) {
            return $this->UserService->handleIndex($request);
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
                return $result;
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
            return $this->UserService->handleAdd($request);
        } else {
            return sendError([], 'Prohibited Access');
        }

    }

    public function edit($user){
        $result  = $this->UserService->handleEdit($user);
        $users = $this->UserService->getById($user);
        if($users){
            if(Auth::user()->can('update',$users)){
                return $result;
            }
            return sendError([],'Prohibited Access');
        }else{
            return sendError('Data User Not exit');
        }
    }

    public function postEdit(EditUserRequest $request,$user)
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
    public function delete($user)
    {
        $result = $this->UserService->handleDelete($user);
        return $result;
    }

}
