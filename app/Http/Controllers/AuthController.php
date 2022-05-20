<?php

namespace App\Http\Controllers;

use App\Http\Requests\Authentications\RegisterRequest;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Repository\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as requestFacades;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(AuthRequest $authRequest)
    {
        try{
            $data   = $authRequest->validated();
            $result = $this->authRepository->login($data);
            if($result){
                return Response()->json(['data' => $result], 200);
            }else{
                return response()->json(['message' => 'This email or pasword incorrect !'], 422);
            }
        }catch(\Exception $errors){
            Log::error("Error *Login AuthController*, IP: " . requestFacades::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function logout()
    {
        if(Auth::user()){
            Auth::user()->tokens()->delete();
            return response()->json(['data' => 'Logged out'], 200);
        }
        return response()->json(['message' => 'something wrong !!'], 422);
    }
}