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
            'title' => $this->title ?? $this->translate($other_locale)->title,
            'locale' => $this->title ? $locale : $other_locale,
        ];
    }
}
