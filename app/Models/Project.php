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

class Project extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, InteractsWithMedia, Translatable, Filterable, HasActivation;

    protected $fillable = [
        'is_block'
    ];
    protected $casts=[
        'is_block' => 'boolean'
    ];
    public $translatedAttributes = ['name','classification','short_description','full_description'];
    public const MEDIA_COLLECTION_NAME = 'project_avatar';
    public const MEDIA_COLLECTION_URL = 'images/project.png';

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL));
    }
}
