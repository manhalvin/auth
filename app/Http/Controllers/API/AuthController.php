<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\loginRequest;
use App\Services\API\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(loginRequest $request)
    {
        $infoUser = [ 'email' => $request->input('email'), 'password' => $request->input('password')];
        $result = $this->authService->loginUser($infoUser);
        if($result){
            return sendSuccess($result, 'Login Success !',200);
        }
        return sendError('Login Failed !');
    }
}
