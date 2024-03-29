<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return [
           'id'             => $this->id,
           'first_name'     => $this->first_name,
           'last_name'      => $this->last_name,
           'username'       => $this->username,
           'email'          => $this->email,
           'phone_number'   => $this->phone_number,
           'image'          => asset('images/users/' . $this->image),
           'role'           => $this->role->role ?? null,
           'id_role'        => $this->id_role,
           'actions'        => ActionResource::collection($this->whenLoaded('allowed_actions')),
       ];
    }
}
