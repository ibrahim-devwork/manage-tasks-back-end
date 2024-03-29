<?php

namespace App\Repository\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DbAuthRepository implements InterfaceAuthRepository
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
                'image'        => asset('images/users/' . $user->image),
                'email'        => $user->email,
                'id_role'      => $user->id_role,
                'role'         => $user->role->role ?? null,
                'token'        => $token
        ];
    }
}