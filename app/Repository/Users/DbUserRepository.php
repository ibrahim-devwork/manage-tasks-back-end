<?php

namespace App\Repository\Users;

use App\Models\User;
use App\Helpers\Helper;
use App\Repository\Users\InterfaceUserRepository;
use App\Services\UserServices;
use Illuminate\Support\Facades\Hash;

class DbUserRepository implements InterfaceUserRepository {

    protected $user;
    protected $userServices;

    public function __construct(User $user, UserServices $userServices)
    {
        $this->user = $user;
        $this->userServices = $userServices;
    }

    public function getByFilter($filter)
    {
        return $this->userServices->filterUsers($this->user, $filter);
    }

    public function getById($id)
    {   
        return $this->user->where('id', $id)->whereIn('id_role', [2, 3])->first();
    }

    public function create($data)
    {
        $user                 = new $this->user;
        $user->first_name     = $data['first_name'] ?? null;
        $user->last_name      = $data['last_name'] ?? null;
        $user->username       = $data['username'];
        $user->email          = $data['email'];
        $user->phone_number   = $data['phone_number'] ?? null;
        $user->password       = Hash::make($data['confirm_password']);
        $user->id_role        = $data['id_role'];
        $user->image          = "profile.jpg";
        $user->save();

        if(isset($data['actions']) && count($data['actions']) > 0)
            $user->allowed_actions()->attach($data['actions']);
        
        return $user;
    }

    public function update($id, $data)
    {
        $user                 = $this->user->where('id', $id)->whereIn('id_role', [2, 3])->first();
        $user->first_name     = $data['first_name'] ?? null;
        $user->last_name      = $data['last_name'] ?? null;
        $user->username       = $data['username'];
        $user->email          = $data['email'];
        $user->phone_number   = $data['phone_number'] ?? null;
        $user->id_role        = $data['id_role'];
        
        if(isset($data['confirm_password']) && $data['confirm_password'] != "")
            $user->password       = Hash::make($data['confirm_password']);

        $user->update();

        if(isset($data['actions']))
            $user->allowed_actions()->sync($data['actions']);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->where('id', $id)->whereIn('id_role', [2, 3])->first();
        $user->delete();

        return $user;
    }

}
?>