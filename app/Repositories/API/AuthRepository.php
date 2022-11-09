<?php
namespace App\Repositories\API;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

}
