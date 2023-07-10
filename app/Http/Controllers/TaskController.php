<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TaskResurce;
use App\Repository\Tasks\InterfaceTaskRepository;
use Illuminate\Support\Facades\Request as FacadesRequest;

class TaskController extends Controller
{
    protected $interfaceTaskRepository;

    public function __construct(InterfaceTaskRepository $interfaceTaskRepository)
    {
        $this->interfaceTaskRepository = $interfaceTaskRepository;
    }

    public function index(TaskRequest $taskRequest)
    {
        try{
            $filter = $taskRequest->validated();
            return TaskResurce::collection($this->interfaceTaskRepository->getByFilter($filter));
        }catch(\Exception $errors){
            Log::error("Error *getByFilter TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function show($id, TaskRequest $taskRequest)
    { 
        try{
            return new TaskResurce($this->interfaceTaskRepository->getById($id));
        }catch(\Exception $errors){
            Log::error("Error *show TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function store(TaskRequest $taskRequest)
    {
        try{
            $data = $taskRequest->validated();
            return new TaskResurce($this->interfaceTaskRepository->create($data));
        }catch(\Exception $errors){
            Log::error("Error *store TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

    public function update($id, TaskRequest $taskRequest)
    {   
        try{
            $data = $taskRequest->validated();
            $result = $this->interfaceTaskRepository->update($id, $data);
           
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
            $result = $this->interfaceTaskRepository->changeStatut($id, $data);
           
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
            $result = $this->interfaceTaskRepository->delete($id);
            
            if($result === 403)
              return  response()->json(['message' => 'Unauthorized action.'], 403);

            return new TaskResurce($result);

        }catch(\Exception $errors){
            Log::error("Error *delete TaskController*, IP: " . FacadesRequest::getClientIp(true) . ", {$errors->getMessage()}");
            return response()->json(['errors' => $errors->getMessage()], 500);
        }
    }

}

