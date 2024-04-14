<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SourceResource extends JsonResource
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
            'short_description'=>$this->short_description,
            'is_block'=>$this->is_block,
            'identifier'=>$this->identifier,
            'url'=>$this->url,
            'image'=>$this->getAvatar(),
            'translations'=> $this->getTranslationsArray()
        ];
    }
}
