<?php

namespace App\Repository;

use App\Models\User;
use App\Helpers\Helper;
use App\Services\UserServices;
use Illuminate\Support\Facades\Hash;

class UserRepository implements InterfaceRepository {

    protected $user;
    protected $userServices;

    public function __construct(User $user, UserServices $userServices)
    {
        $this->user = $user;
        $this->userServices = $userServices;
    }

    public function getAll()
    {
        return $this->user->where('id_role', 2)->paginate(Helper::count_per_page);
    }

    public function getByFilter($filter)
    {
        return $this->userServices->filterUsers($this->user, $filter);
    }

    public function getById($id)
    {   
        return $this->user->where('id', $id)->where('id_role', 2)->first();
    }

    public function create($data)
    {
        $user                 = new $this->user;
        $user->first_name     = $data['first_name'];
        $user->last_name      = $data['last_name'];
        $user->username       = $data['username'];
        $user->email          = $data['email'];
        $user->phone_number   = $data['phone_number'];
        $user->password       = Hash::make($data['confirm_password']);
        $user->id_role        = $data['id_role'];
      
        if(isset($data['image'])){
        $user->image          = Helper::saveFile($data['image'], 'users');
        }
        $user->save();

        if(isset($data['actions']) && count($data['actions']) > 0)
            $user->allowed_actions()->sync($data['actions']);
        
        return $user;
    }

    public function update($id, $data)
    {
        $user                 = $this->user->where('id', $id)->where('id_role', 2)->first();
        $user->first_name     = $data['first_name'];
        $user->last_name      = $data['last_name'];
        $user->username       = $data['username'];
        $user->email          = $data['email'];
        $user->phone_number   = $data['phone_number'];
        $user->id_role        = $data['id_role'];
       
        if(isset($data['image'])){
        $user->image          = Helper::saveFile($data['image'], 'users');
        }
        $user->update();

        if(isset($data['actions']) && count($data['actions']) > 0)
            $user->allowed_actions()->attach($data['actions']);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->where('id', $id)->where('id_role', 2)->first();
        $user->delete();

        return $user;
    }

}
?>