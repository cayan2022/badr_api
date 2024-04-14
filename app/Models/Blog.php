<?php

namespace App\Models;

use App\Http\Filters\BlogFilter;
use App\Http\Filters\Filterable;
use App\Http\Resources\BlogResource;
use App\Models\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model implements HasMedia,  TranslatableContract
{
    use HasFactory, InteractsWithMedia, HasActivation, Filterable , Translatable;

    protected $fillable = [
        'reference_link',
        'date',
        'is_block'
    ];

    protected $filter=BlogFilter::class;

    public $translatedAttributes = ['title','short_description','long_description'];

    protected $casts = [
        'is_block' => 'boolean',
        'date'=>'date'
    ];

    public const MEDIA_COLLECTION_NAME = 'blog_avatar';
    public const MEDIA_COLLECTION_URL = 'images/blog.png';

    /*Helpers*/
    /**
     * @return
     */
    public function getResource(): BlogResource
    {
        return new BlogResource($this->fresh());
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
