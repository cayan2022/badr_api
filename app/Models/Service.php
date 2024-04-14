<?php

namespace App\Models;

use App\Http\Resources\ServiceResource;
use App\Models\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Filters\Filterable;
use App\Http\Filters\ServiceFilter;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements   HasMedia,TranslatableContract
{
    use HasFactory ,InteractsWithMedia, Translatable , Filterable, HasActivation;

    public const MEDIA_COLLECTION_NAME = 'service_avatar';
    public const MEDIA_COLLECTION_URL = 'images/service.png';
    protected $fillable = [
        'category_id',
        'is_block'
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = ServiceFilter::class;

    public $translatedAttributes = ['name','description'];

    protected $casts = [
        'is_block' => 'boolean'
    ];

    /*Relations*/
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    /*helpers*/
    /**
     * @return ServiceResource
     */
    public function getResource(): ServiceResource
    {
        return new ServiceResource($this->fresh());
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
