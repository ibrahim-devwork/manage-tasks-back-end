<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Repository\Users\InterfaceUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;

class UserController extends Controller
{
    protected $interfaceUserRepository;

    public function __construct(InterfaceUserRepository $interfaceUserRepository)
    {
        $this->interfaceUserRepository = $interfaceUserRepository;
    }

    public function index(UserRequest $userRequest)
    {
        try{
            $filter = $userRequest->validated();
            return UserResource::collection($this->interfaceUserRepository->getByFilter($filter));
        }catch(\Exception $errors){
            Log::error("Error *getByFilter UserController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function show($id, UserRequest $userRequest)
    {
        try{
            return new UserResource($this->interfaceUserRepository->getById($id));
        }catch(\Exception $errors){
            Log::error("Error *show UserController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function store(UserRequest $userRequest)
    {
        try{
            $data = $userRequest->validated();
            return new UserResource($this->interfaceUserRepository->create($data));
        }catch(\Exception $errors){
            Log::error("Error *store UserController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function update($id, UserRequest $userRequest)
    {
        try{
            $data = $userRequest->validated();
            return new UserResource($this->interfaceUserRepository->update($id, $data));
        }catch(\Exception $errors){
            Log::error("Error *update UserController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function delete($id, UserRequest $userRequest)
    {
        try{
            return new UserResource($this->interfaceUserRepository->delete($id));
        }catch(\Exception $errors){
            Log::error("Error *delete UserController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

}