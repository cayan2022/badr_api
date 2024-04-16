<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'message' => $this->message,
            'email' => $this->email,
            'contact_files' => $this->getFirstMediaUrl('contact_files'),
        ];
    }
}
