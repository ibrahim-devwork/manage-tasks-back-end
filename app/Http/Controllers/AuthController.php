<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Repository\Auth\InterfaceAuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as requestFacades;

class AuthController extends Controller
{
    protected $interfaceAuthRepository;

    public function __construct(InterfaceAuthRepository $interfaceAuthRepository)
    {
        $this->interfaceAuthRepository = $interfaceAuthRepository;
    }

    public function login(AuthRequest $authRequest)
    {
        try{
            $data   = $authRequest->validated();
            $result = $this->interfaceAuthRepository->login($data);
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