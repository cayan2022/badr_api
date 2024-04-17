<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDomainResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = app()->getLocale();
        dd($locale);
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
