<?php

namespace App\Repository;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileRepository {

    protected $user;

    public function __construct(User $user)
    {
        $this->user   = $user;
    }

    public function changeInfos($data)
    {
        $user                 = $this->user->wher('id', Auth::user()->id)->first();
        $user->first_name     = $data['first_name'];
        $user->last_name      = $data['last_name'];
        $user->phone_number   = $data['phone_number'];
       
        if(isset($data['image'])){
        $user->image          = Helper::saveFile($data['image'], 'users');
        }
        $user->update();

        return $user;
    }

    public function changeEmail($data)
    {
        $user                 = $this->user->wher('id', Auth::user()->id)->first();
        
        if(!$user || !Hash::check($data['password'], $user->password))
            return false;
        
        $user->email          = $data['email'];
        $user->update();

        return $user;
    }

    public function changeUsername($data)
    {
        $user                 = $this->user->wher('id', Auth::user()->id)->first();
        
        if(!$user || !Hash::check($data['password'], $user->password))
            return false;
        
        $user->username       = $data['username'];
        $user->update();
        
        return $user;
    }

    public function changePassword($data)
    {
        $user                   = $this->user->wher('id', Auth::user()->id)->first();
        
        if(!$user || !Hash::check($data['current_password'], $user->password))
            return false;
        
        $user->confirm_password = Hash::make($data['confirm_password']);
        $user->update();
        
        return $user;
    }

}
?>