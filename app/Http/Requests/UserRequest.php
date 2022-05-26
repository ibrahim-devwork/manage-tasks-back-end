<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class UserRequest extends BaseRequest
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
           
            return Gate::allows('allowed-action', 'manage-users');
        }

        return false;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);

        // Decode JSON Actions array
        if($this->actions && is_string($this->actions)){
            $actions[] = json_decode($this->actions, true);
            if($actions)
            $this->merge([
                'actions' => $actions,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return match (Route::currentRouteName()) {
            'users-index'   => [],
            'users-filter'  => $this->getByFilter(),
            'users-show', 'users-delete' => ['id' => 'exists:users,id'],
            'users-store'   => 
                            [
                                'username'          => ['bail', 'required', 'unique:users,username', 'max:3', 'max:22'],
                                'email'             => ['bail', 'required', 'email:rfc,dns', 'unique:users,email', 'max:50'],
                                'password'          => ['bail', 'required', 'string', 'min:6', 'max:50'],
                                'confirm_password'  => ['bail', 'required', 'same:password']
                            ] + $this->storeOrUpdate(),

            'users-update'  => 
                            [
                                'id'                => 'exists:users,id',
                                'username'          => ['bail', 'required', 'unique:users,username,'.$this->id, 'max:3', 'max:22'],
                                'email'             => ['bail', 'required', 'email:rfc,dns', 'unique:users,email,'.$this->id, 'max:50'],
                            ] + $this->storeOrUpdate(),
            default => [],
        };
    }

    public function storeOrUpdate()
    {
        return [
            'first_name'    => ['bail', 'nullable', 'max:25'],
            'last_name'     => ['bail', 'nullable', 'max:25'],
            'phone_number'  => ['bail', 'nullable', 'max:15'],
            'image'         => ['bail', 'nullable', 'mimes:jpg,jpeg,png'],
            'id_role'       => ['bail', 'required', 'numeric', 'exists:roles,id', 'min:2'],
            'actions'       => ['bail', 'nullable', 'array'],
            'actions.*'     => ['bail' ,'nullable', 'exists:actions,id'],
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
