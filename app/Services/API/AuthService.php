<?php
namespace App\Services\API;

use App\Repositories\API\AuthRepository;
use Illuminate\Support\Facades\Auth;

class AuthService{

    protected $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function loginUser($infoUser){

        if (Auth::attempt($infoUser)) {
            $user = Auth::user();
            $success = [
                'token' => $user->createToken('auth_token')->plainTextToken,
                'id_user' => $user->id,
                'name_user' => $user->name,
            ];
            return $success;
        }

    }

}

