<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'title' => $this->title,
            'reference_link' => $this->reference_link,
            'date' => $this->date->format('Y-m-d'),
            'is_block' => $this->is_block,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'avatar'=>$this->getAvatar(),
            'translations'=> $this->getTranslationsArray(),
        ];
    }
}
