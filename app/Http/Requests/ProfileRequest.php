<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => Auth::user()->id
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
            'change-infos'      => [
                                    'first_name'        => ['bail', 'nullable', 'max:25'],
                                    'last_name'         => ['bail', 'nullable', 'max:25'],
                                    'phone_number'      => ['bail', 'nullable', 'max:15'],
                                    'image'             => ['bail', 'nullable', 'mimes:jpg,jpeg,png']
                                ],
            
            'change-email'      => [
                                    'email'             => ['bail', 'required', 'email:rfc,dns', 'unique:users,email,'.$this->id, 'max:50'],
                                    'password'          => ['bail', 'required', 'string', 'min:6', 'max:50']
                                ],

            'change-username'    => [
                                    'username'          => ['bail', 'required', 'unique:users,username,'.$this->id, 'min:3', 'max:22'],
                                    'password'          => ['bail', 'required', 'string', 'min:6', 'max:50']
                                ],

            'change-password'   => [
                                    'current_password'  => ['bail', 'required', 'string', 'min:6', 'max:50'],
                                    'new_password'      => ['bail', 'required', 'string', 'min:6', 'max:50'],
                                    'confirm_password'  => ['bail', 'required', 'same:new_password']
                                ],
            default => [],
        };
    }

}
