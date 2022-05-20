<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResurce extends JsonResource
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
            'id'            => $this->id,
            'description'   => $this->description,
            'deadline'      => $this->deadline,
            'statut'        => $this->statut,
            'project'       => new ProjectResource($this->whenLoaded('project')),
            'user'          => new UserResource($this->whenLoaded('user')),
            'users'         => UserResource::collection($this->whenLoaded('tasks_users'))
        ];
    }
}
