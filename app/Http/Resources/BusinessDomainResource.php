<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDomainResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title_ar' => $this->translate('ar'),
            'title_en' => $this->translate('en'),
        ];
    }
}
