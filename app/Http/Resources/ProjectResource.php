<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'classification'=>$this->classification,
            'short_description'=>$this->short_description,
            'full_description'=>$this->full_description,
            'image'=>$this->getAvatar(),
            'is_block'=>$this->is_block,
            'translations'=> $this->getTranslationsArray()
        ];
    }
}
