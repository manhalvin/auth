<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\userResource;
use App\Models\User;
use App\Services\API\GroupService;
use App\Services\API\UerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $uerService, $groupService;
    const _PER_PAGE = 3;
    public function __construct(UerService $uerService, GroupService $groupService)
    {
        $this->uerService = $uerService;
        $this->groupService = $groupService;
    }
    public function index(Request $request)
    {

        $user = Auth::user();
        if ($user->can('viewAny', User::class)) {
            $filters = [];
            $keywords = null;
            if ($request->has('status')) {
                $status = $request->input('status');
                $status = $status == 'active' ? 1 : 0;
                $filters[] = ['users.status', '=', $status];
            }

            if ($request->has('group_id')) {
                $groupId = $request->input('group_id');
                $filters[] = ['users.group_id', '=', $groupId];
            }

            if ($request->has('keywords')) {
                $keywords = $request->input('keywords');
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

            $user = $this->uerService->getAllUsers($filters, $keywords, $sortArr, self::_PER_PAGE);

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
}
