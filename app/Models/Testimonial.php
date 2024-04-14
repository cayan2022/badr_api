<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\TestimonialFilter;
use App\Http\Resources\TestimonialResource;
use App\Models\Traits\HasActivation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasActivation, Filterable;

    protected $fillable = [
        'user_name',
        'comment',
        'job',
        'is_block'
    ];

    protected $filter=TestimonialFilter::class;
    public const MEDIA_COLLECTION_NAME = 'testimonial_avatar';
    public const MEDIA_COLLECTION_URL = 'images/testimonial.png';
    protected $casts = [
        'is_block' => 'boolean',
    ];
    /*Helpers*/
    /**
     * @return TestimonialResource
     */
    public function getResource(): TestimonialResource
    {
        return new TestimonialResource($this->fresh());
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
