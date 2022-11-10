<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Http\Resources\API\userResource;
use App\Http\Resources\userResoure;
use App\Models\User;
use App\Services\API\GroupService;
use App\Services\API\UerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $uerService, $groupService;

    protected $filters,$groupIds = [];
    protected $keywords = null;
    const _PER_PAGE = 10;
    public function __construct(UerService $uerService, GroupService $groupService)
    {
        $this->uerService = $uerService;
        $this->groupService = $groupService;
    }
    public function index(Request $request)
    {
        // DB::enableQueryLog();
        $user = Auth::user();
        if ($user->can('viewAny', User::class)) {
            if ($request->has('status')) {
                $status = $request->input('status');
                $status = $status == 'active' ? 1 : 0;
                $this->filters[] = ['users.status', '=', $status];
            }

            if ($request->has('role')){
                $role = $request->input('role');
                if(!empty($role)){
                    $role = explode(',',$role);
                    $this->groupIds = $this->groupService->getId($role);
                }
            }

            if ($request->has('keywords')) {
                $this->keywords = $request->input('keywords');
            }

            // Hanle logic sort
            $sortBy = $request->input('sort-by');
            $sortType = $request->input('sort-type');
            $allowSort = ['asc', 'desc'];
            if (!empty($sortType) && in_array($sortType, $allowSort)) {
                $sortType = $sortType == 'desc' ? 'asc' : 'desc';
            } else {
                $sortType = 'asc';
            }

            $sortArr = [
                'sortBy' => $sortBy,
                'sortType' => $sortType,
            ];

            $user = $this->uerService->getAllUsers($this->filters, $this->keywords, $sortArr, self::_PER_PAGE,$this->groupIds);
            // dd(DB::getQueryLog());
            if ($user->count() == 0) {
                return sendError([], 'Data not exist');
            } else {
                $user = userResource::collection($user);
                return sendSuccess($user, 'Fetch data success');
            }
        }else{
            return sendError([], 'Prohibited Access');
        }

    }

    public function show($user)
    {
        $result = $this->uerService->handleShow($user);
        $users = $this->uerService->getById($user);
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
            $result = $this->uerService->save($data);
            $result = new userResoure($result);
            return sendSuccess($result, 'Inserted Data User Success !');
        } else {
            return sendError([], 'Prohibited Access');
        }

    }

    public function edit($user){
        $result  = $this->uerService->handleEdit($user);
        $users = $this->uerService->getById($user);
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
        $users = $this->uerService->getById($user);
        if($users){
            if(Auth::user()->can('update',$users)){
                $result = $this->uerService->updateDataUser($data,$user);
                return sendSuccess([], 'Update Data User Success !');
            }
            return sendError([],'Prohibited Access');
        }else{
            return sendError('Data User Not exit');
        }

    }
    public function delete($post)
    {
        $result = $this->uerService->handleDelete($post);
        return $result;
    }
}
