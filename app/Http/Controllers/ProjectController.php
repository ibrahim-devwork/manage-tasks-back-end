<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repository\ProjectRepository;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\Request as FacadesRequest;

class ProjectController extends Controller
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index(ProjectRequest $projectRequest)
    {
        try{
            return ProjectResource::collection($this->projectRepository->getAll());
        }catch(\Exception $errors){
            Log::error("Error *index ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function getByFilter(ProjectRequest $projectRequest)
    {
        try{
            $filter = $projectRequest->validated();
            return ProjectResource::collection($this->projectRepository->getByFilter($filter));
        }catch(\Exception $errors){
            Log::error("Error *getByFilter ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function show($id, ProjectRequest $projectRequest)
    {
        try{
            return new ProjectResource($this->projectRepository->getById($id));
        }catch(\Exception $errors){
            Log::error("Error *show ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function store(ProjectRequest $projectRequest)
    {
        try{
            $data = $projectRequest->validated();
            return new ProjectResource($this->projectRepository->create($data));
        }catch(\Exception $errors){
            Log::error("Error *store ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function update($id, ProjectRequest $projectRequest)
    {   
        try{
            $data = $projectRequest->validated();
            $result = $this->projectRepository->update($id, $data);
           
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
            $result = $this->projectRepository->delete($id);
            
            if($result === 403)
              return  response()->json(['message' => 'Unauthorized action.'], 403);

            return new ProjectResource($result);

        }catch(\Exception $errors){
            Log::error("Error *delete ProjectController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

}

