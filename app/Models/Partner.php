<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\PartnerFilter;
use App\Http\Resources\PartnerResource;
use App\Models\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Partner extends Model implements HasMedia,  TranslatableContract
{
    use HasFactory, InteractsWithMedia, HasActivation, Filterable , Translatable;

    protected $fillable = [
        'link',
        'is_block'
    ];

    protected $filter=PartnerFilter::class;

    public $translatedAttributes = ['name'];

    protected $casts = [
        'is_block' => 'boolean'
    ];

    public const MEDIA_COLLECTION_NAME = 'partner_avatar';
    public const MEDIA_COLLECTION_URL = 'images/partner.png';

    /*Helpers*/
    /**
     * @return PartnerResource
     */
    public function getResource(): PartnerResource
    {
        return new PartnerResource($this->fresh());
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
