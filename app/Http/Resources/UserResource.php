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
            'id'                    => $this->id,
            'username'              => $this->username,
            'last_login'            => $this->last_login,
            'is_active'             => $this->is_active,
            'role'                  => $this->roles()->first()->name,
            'created_at'            => $this->created_at,
            'created_by'            => $this->created_by,


        ];
    }
}
