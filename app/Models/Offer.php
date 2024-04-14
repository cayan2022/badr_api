<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\OfferFilter;
use App\Http\Resources\OfferResource;
use App\Models\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Offer extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, InteractsWithMedia, Translatable, Filterable, HasActivation;

    protected $fillable = [
        'price',
        'discount_percentage',
        'url',
        'is_block'
    ];
    protected $casts=[
        'is_block' => 'boolean',
        'price'=>'double',
        'discount_percentage'=>'double',
    ];
    public $translatedAttributes = ['name','description'];
    public const MEDIA_COLLECTION_NAME = 'offer_avatar';
    public const MEDIA_COLLECTION_URL = 'images/offer.png';

    protected $filter= OfferFilter::class;

    /*helpers*/
    /**
     * @return OfferResource
     */
    public function getResource(): OfferResource
    {
        return new OfferResource($this->fresh());
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
