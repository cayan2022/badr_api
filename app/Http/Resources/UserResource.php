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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'country' => new CountryResource($this->country),
            'phone' => $this->phone,
            'type' => $this->type,
            'is_block' => $this->is_block,
            'role_id' => ['id' => optional($this->roles->first())->id, 'name' => optional($this->roles->first())->name],
            'image' => $this->getAvatar(),
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'created_at_formatted' => $this->created_at ? $this->created_at->diffForHumans() : null,
        ];
    }
}