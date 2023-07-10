<?php

namespace App\Repository\Profile;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DbProfileRepository {

    protected $user;

    public function __construct(User $user)
    {
        $this->user   = $user;
    }

    public function getProfile()
    {
        return  $this->user->where('id', Auth::user()->id)->first();
    }

    public function changeInfos($data)
    {   
        $user                 = $this->user->where('id', Auth::user()->id)->first();
        $user->first_name     = $data['first_name'] ?? null;
        $user->last_name      = $data['last_name'] ?? null;
        $user->phone_number   = $data['phone_number'] ?? null;
       
        if(isset($data['image'])){
        $user->image          = Helper::saveFile($data['image'], 'users');
        }
        $user->update();

        return $user;
    }

    public function changeEmail($data)
    {
        $user                 = $this->user->where('id', Auth::user()->id)->first();
        
        if(!$user || !Hash::check($data['password'], $user->password))
            return false;
        
        $user->email          = $data['email'];
        $user->update();

        return $user;
    }

    public function changeUsername($data)
    {
        $user                 = $this->user->where('id', Auth::user()->id)->first();
        
        if(!$user || !Hash::check($data['password'], $user->password))
            return false;
        
        $user->username       = $data['username'];
        $user->update();
        
        return $user;
    }

    public function changePassword($data)
    {
        $user                   = $this->user->where('id', Auth::user()->id)->first();
        
        if(!$user || !Hash::check($data['current_password'], $user->password))
            return false;
        
        $user->password = Hash::make($data['confirm_password']);
        $user->update();
        
        return $user;
    }

}
?>