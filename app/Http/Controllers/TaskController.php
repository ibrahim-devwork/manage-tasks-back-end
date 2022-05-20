<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TaskResurce;
use App\Repository\TaskRepository;
use Illuminate\Support\Facades\Request as FacadesRequest;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index(TaskRequest $taskRequest)
    {
        try{
            return TaskResurce::collection($this->taskRepository->getAll());
        }catch(\Exception $errors){
            Log::error("Error *index TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function getByFilter(TaskRequest $taskRequest)
    {
        try{
            $filter = $taskRequest->validated();
            return TaskResurce::collection($this->taskRepository->getByFilter($filter));
        }catch(\Exception $errors){
            Log::error("Error *getByFilter TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function show($id, TaskRequest $taskRequest)
    { 
        try{
            return new TaskResurce($this->taskRepository->getById($id));
        }catch(\Exception $errors){
            Log::error("Error *show TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function store(TaskRequest $taskRequest)
    {
        try{
            $data = $taskRequest->validated();
            return new TaskResurce($this->taskRepository->create($data));
        }catch(\Exception $errors){
            Log::error("Error *store TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function update($id, TaskRequest $taskRequest)
    {   
        try{
            $data = $taskRequest->validated();
            $result = $this->taskRepository->update($id, $data);
           
            if($result === 403)
              return  response()->json(['message' => 'Unauthorized action.'], 403);
                
            return new TaskResurce($result);

        }catch(\Exception $errors){
            Log::error("Error *update TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function changeStatut($id, TaskRequest $taskRequest)
    {   
        try{
            $data = $taskRequest->validated();
            $result = $this->taskRepository->changeStatut($id, $data);
           
            if($result === 403)
              return  response()->json(['message' => 'Unauthorized action.'], 403);
                
            return new TaskResurce($result);

        }catch(\Exception $errors){
            Log::error("Error *changeStatut TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function delete($id, TaskRequest $taskRequest)
    {
        try{
            $result = $this->taskRepository->delete($id);
            
            if($result === 403)
              return  response()->json(['message' => 'Unauthorized action.'], 403);

            return new TaskResurce($result);

        }catch(\Exception $errors){
            Log::error("Error *delete TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

}

