<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ProjectResource;
use App\Repository\Projects\InterfaceProjectRepository;
use Illuminate\Support\Facades\Request as FacadesRequest;

class ProjectController extends Controller
{
    protected $interfaceProjectRepository;

    public function __construct(InterfaceProjectRepository $interfaceProjectRepository)
    {
        $this->interfaceProjectRepository = $interfaceProjectRepository;
    }

    public function index(ProjectRequest $projectRequest)
    {
        try{
            $filter = $projectRequest->validated();
            return ProjectResource::collection($this->interfaceProjectRepository->getByFilter($filter));
        }catch(\Exception $errors){
            Log::error("Error *getByFilter ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function show($id, ProjectRequest $projectRequest)
    {
        try{
            return new ProjectResource($this->interfaceProjectRepository->getById($id));
        }catch(\Exception $errors){
            Log::error("Error *show ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function store(ProjectRequest $projectRequest)
    {
        try{
            $data = $projectRequest->validated();
            return new ProjectResource($this->interfaceProjectRepository->create($data));
        }catch(\Exception $errors){
            Log::error("Error *store ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function update($id, ProjectRequest $projectRequest)
    {   
        try{
            $data = $projectRequest->validated();
            $result = $this->interfaceProjectRepository->update($id, $data);
           
            if($result === 403)
              return  response()->json(['message' => 'Unauthorized action.'], 403);
                
            return new ProjectResource($result);

        }catch(\Exception $errors){
            Log::error("Error *update ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function delete($id, ProjectRequest $projectRequest)
    {
        try{
            $result = $this->interfaceProjectRepository->delete($id);
            
            if($result === 403)
              return  response()->json(['message' => 'Unauthorized action.'], 403);

            return new ProjectResource($result);

        }catch(\Exception $errors){
            Log::error("Error *delete ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

}

