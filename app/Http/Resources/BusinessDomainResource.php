<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDomainResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = app()->getLocale();
        $other_locale = $locale == 'ar' ? 'en' : 'ar';
        return [
            'id' => $this->id,
            'title_'.$locale => $this->translate($locale)->title,
            'title_'.$other_locale => $this->translate($other_locale)->title,
        ];
    }
}
