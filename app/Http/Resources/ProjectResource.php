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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'classification' => $this->classification,
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'image' => $this->getAvatar(),
            'developer_name' => $this->developer_name,
            'developer_image' => $this->getFirstMediaUrl('developer_images'),
            'owner_name' => $this->owner_name,
            'owner_image' => $this->getFirstMediaUrl('owner_images'),
            'project_sliders' => $this->getProjectSlidersUrls(),
            'area' => $this->area,
            'buildings_number' => $this->buildings_number,
            'building_area' => $this->building_area,
            'is_block' => $this->is_block,
            'business_domains' => BusinessDomainResource::collection($this->businessDomains),
            'translations' => $this->getTranslationsArray()
        ];
    }
    /**
     * Get URLs of all project sliders.
     *
     * @return array
     */
    protected function getProjectSlidersUrls()
    {
        return $this->getMedia('project_sliders')->map(function ($media) {
            return $media->getUrl();
        })->toArray();
    }
}