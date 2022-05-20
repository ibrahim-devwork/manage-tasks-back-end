<?php

namespace App\Repository;

use App\Helpers\Helper;
use App\Repository\RepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($data){

        $user = $this->user->where('email', $data['username'])->orWhere('username', $data['username'])->first();
        if(!$user || !Hash::check($data['password'], $user->password)){
            return false;
        }
        // $user->tokens()->delete();
        $token = $user->createToken($data['username'])->plainTextToken;
        return [
                'first_name'   => $user->first_name,
                'last_name'    => $user->last_name,
                'username'     => $user->username,
                'email'        => $user->email,
                'id_role'      => $user->id_role,
                'role'         => $user->role->role ?? null,
                'token'        => $token
        ];
    }
}