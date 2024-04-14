<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
            'image'=>$this->getAvatar(),
            'user_name'=>$this->user_name,
            'job'=>$this->job,
            'comment'=>$this->comment,
            'is_block'=>$this->is_block
        ];
    }
}
