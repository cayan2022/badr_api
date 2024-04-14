<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TidingResource extends JsonResource
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
            'description'=>$this->description,
            'short_description'=>$this->short_description,
            'date'=>$this->date,
            'link'=>$this->link,
            'translations'=> $this->getTranslationsArray(),
            'is_block'=>$this->is_block,
            'image'=>$this->getAvatar(),
        ];
    }
}
