<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name,
            'full_description'=> $this->full_description,
            'is_block'=>$this->is_block,
            'city'=>$this->city,
            'address'=>$this->address,
            'telephone'=>$this->telephone,
            'whatsapp'=>$this->whatsapp,
            'map'=>$this->map,
            'image'=>$this->getAvatar(),
            'translations'=> $this->getTranslationsArray()
        ];
    }
}
