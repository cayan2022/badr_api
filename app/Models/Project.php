<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Spatie\MediaLibrary\HasMedia;
use App\Http\Filters\ProjectFilter;
use App\Models\Traits\HasActivation;
use App\Http\Resources\ProjectResource;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, InteractsWithMedia, Translatable, Filterable, HasActivation;

    protected $fillable = [
        'owner_name',
        'developer_name',
        'area',
        'building_area',
        'buildings_number',
        'is_block',
    ];
    protected $casts=[
        'is_block' => 'boolean'
    ];
    public $translatedAttributes = ['name','classification','short_description','full_description'];
    public const MEDIA_COLLECTION_NAME = 'project_avatar';
    public const MEDIA_COLLECTION_NAME_DEVELOPER = 'developer_image';
    public const MEDIA_COLLECTION_NAME_OWNER = 'owner_image';
    public const MEDIA_COLLECTION_NAME_SLIDER = 'project_slider';
    public const MEDIA_COLLECTION_URL = 'images/project.png';
    public const MEDIA_COLLECTION_URL_DEVELOPER = 'developer_images/project.png';
    public const MEDIA_COLLECTION_URL_OWNER = 'owner_images/project.png';
    public const MEDIA_COLLECTION_URL_SLIDER = 'project_sliders/project.png';

    protected $filter= ProjectFilter::class;

    /*helpers*/
    /**
     * @return ProjectResource
     */
    public function getResource(): ProjectResource
    {
        return new ProjectResource($this->fresh());
    }
    public function getAvatar()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_NAME);
    }
    public function getAvatarOwner()
    {

        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_NAME_OWNER);
    }
    public function getAvatarDeveloper()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_NAME_DEVELOPER);
    }
    public function getAvatarSlider()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_NAME_SLIDER);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL));
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME_DEVELOPER)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL_DEVELOPER))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL_DEVELOPER));
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME_OWNER)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL_OWNER))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL_OWNER));
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME_SLIDER)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL_SLIDER))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL_SLIDER));
    }
    public function businessDomains()
    {
        return $this->hasMany(BusinessDomain::class);
    }
    public function sliderImage()
    {
        return $this->hasOne(Media::class, 'model_id')->where('collection_name', 'project_slider');
    }
}
