<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Repository\Profile\InterfaceProfileRpository;
use Illuminate\Support\Facades\Request as FacadesRequest;

class ProfileController extends Controller
{
    protected $interfaceProfileRpository;

    public function __construct(InterfaceProfileRpository $interfaceProfileRpository)
    {
        $this->interfaceProfileRpository = $interfaceProfileRpository;
    }

    public function getPRofile()
    {
        try{
            return  new UserResource($this->interfaceProfileRpository->getPRofile());
        }catch(\Exception $errors){
            Log::error("Error *getPRofile ProfileController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function changeInfos(ProfileRequest $profileRequest)
    {
        try{
            $data = $profileRequest->validated();
            return  new UserResource($this->interfaceProfileRpository->changeInfos($data));
        }catch(\Exception $errors){
            Log::error("Error *changeInfos ProfileController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function changeEmail(ProfileRequest $profileRequest)
    {
        try{
            $data   = $profileRequest->validated();
            $result = $this->interfaceProfileRpository->changeEmail($data);
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
            $result = $this->interfaceProfileRpository->changeUsername($data);
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
            $result = $this->interfaceProfileRpository->changePassword($data);
            if($result)
                return  new UserResource($result);
            
            return response()->json(['message' => 'Current password incorrect !'], 422);
        }catch(\Exception $errors){
            Log::error("Error *changePassword ProfileController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

}
