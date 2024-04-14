<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'price'=>$this->price,
            'discount_percentage'=>$this->discount_percentage,
            'url'=>$this->url,
            'is_block'=>$this->is_block,
            'image'=>$this->getAvatar(),
            'translations'=> $this->getTranslationsArray()
        ];
    }
}
