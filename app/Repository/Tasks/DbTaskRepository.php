<?php

namespace App\Repository\Tasks;

use Carbon\Carbon;
use App\Models\Task;
use App\Helpers\Helper;
use App\Repository\AllFnCrudInterfaces\CrudInterface;
use App\Repository\Tasks\InterfaceTaskRepository;
use App\Services\TaskServices;
use Illuminate\Support\Facades\Auth;

class DbTaskRepository implements InterfaceTaskRepository {

    protected $task;
    protected $taskServices;

    public function __construct(Task $task, TaskServices $taskServices)
    {
        $this->task         = $task;
        $this->taskServices = $taskServices;
    }

    public function getByFilter($filter)
    {
        return $this->taskServices->filterTasks($this->task, $filter);
    }

    public function getById($id)
    {   
        return $this->task->where('id', $id)->with('project', 'user', 'tasks_users')->first();
    }

    public function create($data)
    {
        $user = Auth::user();
        $task               = new $this->task;
        $task->description  = $data['description'];
        $task->deadline     = $data['deadline'];
        $task->statut       = $data['statut'];
        $task->id_project   = $data['id_project'];
        $task->id_user      = $user->id;

        $task->save();

        if(isset($data['users']) && count($data['users']) > 0)
            $task->tasks_users()->attach($data['users']);

        return $task;
    }

    public function update($id, $data)
    {
        $user = Auth::user();
        $task               = $this->task->where('id', $id)->first();
        
        if(Helper::isAdmin()){
            if($task->id_user !== $user->id)
                return 403;
        }
       
        $task->description  = $data['description']; 
        $task->deadline     = $data['deadline'];
        $task->statut       = $data['statut'];
        $task->id_project   = $data['id_project'];

        $task->update();

        if(isset($data['users']) && count($data['users']) > 0)
            $task->tasks_users()->sync($data['users']);

        return $task;
    }

    public function changeStatut($id, $data)
    {
        $user = Auth::user();
        $task               = $this->task->where('id', $id)->first();
        
        if(Helper::isAdmin()){
            if($task->id_user !== $user->id)
                return 403;
        }

        $task->statut       = $data['statut'];
        $task->update();

        return $task;
    }

    public function delete($id)
    {
        $user = Auth::user();
        $task = $this->task->where('id', $id)->first();
        
        if(Helper::isAdmin()){
            if($task->id_user !== $user->id)
                return 403;
        }

        $task->delete();
       
        return $task;   
    }

}
?>