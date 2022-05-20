<?php

namespace App\Repository;

use App\Helpers\Helper;
use App\Models\Project;
use App\Services\ProjectServices;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements InterfaceRepository {

    protected $project;
    protected $projectServices;

    public function __construct(Project $project, ProjectServices $projectServices)
    {
        $this->project         = $project;
        $this->projectServices = $projectServices;
    }

    public function getAll()
    {
        $user = Auth::user();
        if(Helper::isSuperAdmin()){
            return $this->project->paginate(Helper::count_per_page);
        }elseif(Helper::isAdmin()){
            return $this->project->where('id_user', $user->id)->paginate(Helper::count_per_page);
        }
        
    }

    public function getByFilter($filter)
    {
        return $this->projectServices->filterProjects($this->project, $filter);
    }

    public function getById($id)
    {   
        return $this->project->where('id', $id)->first();
    }

    public function create($data)
    {
        $user = Auth::user();
        $project               = new $this->project;
        $project->name         = $data['name'];
        $project->description  = $data['description'];
        $project->id_user      = $user->id;

        $project->save();

        return $project;
    }

    public function update($id, $data)
    {
        $user = Auth::user();
        $project               = $this->project->where('id', $id)->first();
        
        if(Helper::isAdmin()){
            if($project->id_user !== $user->id)
                return 403;
        }

        $project->name         = $data['name'];
        $project->description  = $data['description'];

        $project->update();

        return $project;
    }

    public function delete($id)
    {
        $user = Auth::user();
        $project = $this->project->where('id', $id)->first();
        
        if(Helper::isAdmin()){
            if($project->id_user !== $user->id)
                return 403;
        }

        $project->delete();
       
        return $project; 
    }

}
?>