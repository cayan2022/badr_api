<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'whatsapp_clicks_count' => $this->whatsapp_clicks,
            'phone_clicks_count' => $this->phone_clicks,
            'mail_clicks_count' => $this->mail_clicks,
            'image' => $this->getAvatar()
        ];
    }
}