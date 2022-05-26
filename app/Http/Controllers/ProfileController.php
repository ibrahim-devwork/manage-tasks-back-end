<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Repository\ProfileRepository;
use Illuminate\Support\Facades\Request as FacadesRequest;

class ProfileController extends Controller
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function changeInfos(ProfileRequest $profileRequest)
    {
        try{
            $data = $profileRequest->validated();
            return  new UserResource($this->profileRepository->changeInfos($data));
        }catch(\Exception $errors){
            Log::error("Error *changeInfos ProfileController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function changeEmail(ProfileRequest $profileRequest)
    {
        try{
            $data   = $profileRequest->validated();
            $result = $this->profileRepository->changeEmail($data);
            if($result)
                return  new UserResource($result);
            
            return response()->json(['message' => 'Password incorrect !'], 422);
        }catch(\Exception $errors){
            Log::error("Error *changeEmail ProfileController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function changeUsername(ProfileRequest $profileRequest)
    {
        try{
            $data   = $profileRequest->validated();
            $result = $this->profileRepository->changeUsername($data);
            if($result)
                return  new UserResource($result);
            
            return response()->json(['message' => 'Password incorrect !'], 422);
        }catch(\Exception $errors){
            Log::error("Error *changeUsername ProfileController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function changePassword(ProfileRequest $profileRequest)
    {
        try{
            $data   = $profileRequest->validated();
            $result = $this->profileRepository->changePassword($data);
            if($result)
                return  new UserResource($result);
            
            return response()->json(['message' => 'Current password incorrect !'], 422);
        }catch(\Exception $errors){
            Log::error("Error *changePassword ProfileController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

}
