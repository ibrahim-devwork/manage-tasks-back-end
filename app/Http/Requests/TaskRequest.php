<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Helper::isSuperAdmin()){
            return true;
        }
        elseif(Helper::isAdmin()) {          
            return Gate::allows('allowed-action', 'manage-tasks');
        }
        return false;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return match (Route::currentRouteName()) {
            'tasks-index'           => [],
            'tasks-filter'          => $this->getByFilter(),
            'tasks-show', 'projects-delete' => ['id' => 'exists:tasks,id'],
            'tasks-store'           => $this->storeOrUpdate(),
            'tasks-update'          => ['id' => 'exists:tasks,id'] + $this->storeOrUpdate(),
            
            'tasks-changeStatut'    => ['id'        => 'exists:tasks,id',
                                        'statut'    => ['bail', 'required', 'numeric', 'min:1', 'max:5']],
            default => [],
        };
    }

    public function storeOrUpdate()
    {
        return [
            'description'   => ['bail', 'required', 'max:300'],
            'deadline'      => ['bail', 'required', 'date', 'date_format:Y-m-d'],
            'statut'        => ['bail', 'required', 'numeric', 'min:1', 'max:5'],
            'id_project'    => ['bail', 'required', 'exists:projects,id'],
            'users'         => ['bail', 'required', 'array'],
            'users.*'       => ['bail' ,'required', 'exists:users,id'],
        ];
    }

    public function getByFilter()
    {
        return [
            'count_per_page'    => ['bail', 'nullable', 'numeric'],
            'id_project'        => ['bail', 'nullable', 'numeric'],
            'statut'            => ['bail', 'nullable', 'numeric'],
            'search'            => ['bail', 'nullable', 'string'],
        ];
    }

}
