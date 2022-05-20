<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends BaseRequest
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
            return Gate::allows('allowed-action', 'manage-projects');
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
            'projects-index'   => [],
            'projects-filter'  => $this->getByFilter(),
            'projects-show', 'projects-delete' => ['id' => 'exists:projects,id'],
            'projects-store'   => $this->storeOrUpdate(),
            'projects-update'  => ['id' => 'exists:projects,id'] + $this->storeOrUpdate(),
            default => [],
        };
    }

    public function storeOrUpdate()
    {
        return [
            'name'          => ['bail', 'nullable', 'max:100'],
            'description'   => ['bail', 'nullable', 'max:60000'],
        ];
    }

    public function getByFilter()
    {
        return [
            'count_per_page'    => ['bail', 'nullable', 'numeric'],
            'search'            => ['bail', 'nullable', 'string'],
        ];
    }

}
