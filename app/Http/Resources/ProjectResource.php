<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $business_ar = [];
        $business_en = [];
        foreach ($this->businessDomains as $domain){
            var_dump($domain->translate()->locale);
            if ($domain->translate()->locale == 'ar'){
                $business_ar['id'] = $domain->id;
                $business_ar['title'] = $domain->translate('ar')->title;
            }else{
                $business_en['id'] = $domain->id;
                $business_en['title'] = $domain->translate('en')->title;
            }
        }

        dd($business_ar,$business_en);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'classification' => $this->classification,
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'image' => asset($this->getAvatar()),
            'developer_name' => $this->developer_name,
            'developer_image' => asset($this->getAvatarDeveloper()),
            'owner_name' => $this->owner_name,
            'owner_image' => asset($this->getAvatarOwner()),
            'project_sliders' => $this->getProjectSlidersData(),
            'area' => $this->area,
            'buildings_number' => $this->buildings_number,
            'building_area' => $this->building_area,
            'is_block' => $this->is_block,
//            'business_domains' => [
//                'ar' => [
//                    'id' => ,
//                    'title' => ,
//                ],
//                'en' => [
//                    'id' => ,
//                    'title' => ,
//                ]
//            ],
            'translations' => $this->getTranslationsArray()
        ];
    }

    /**
     * Get URLs of all project sliders.
     *
     * @return array
     */
    protected function getProjectSlidersData()
    {
        return $this->getMedia('project_slider')->map(function ($media) {
            return [
                'url' => asset($media->getUrl()),
                'id' => $media->id
            ];
        })->toArray();
    }
    protected function getBusinessDomainsWithTranslations()
    {
        $translations = [];

        // Loop through each language
        foreach (['ar', 'en'] as $language) {
            $translations[$language] = [];

            // Loop through each business domain
            foreach ($this->businessDomains as $businessDomain) {
                $translation = $businessDomain->translations->where('locale', $language)->first();

                // Include the translation if it exists
                if ($translation) {
                    $translations[$language][] = [
                        'title' => $translation->title,
                        'project_id' => $this->id,
                        'id' => $translation->business_domain_id
                    ];
                }
            }
        }

        return $translations;
    }
}
