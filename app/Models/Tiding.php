<?php

namespace App\Models;

use App\Http\Resources\TidingResource;
use App\Models\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\Filterable;
use App\Http\Filters\TidingFilter;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Tiding extends Model implements   HasMedia,TranslatableContract
{
    use HasFactory ,InteractsWithMedia,Translatable , Filterable, HasActivation;

    public const MEDIA_COLLECTION_NAME = 'news_avatar';
    public const MEDIA_COLLECTION_URL = 'images/news.jpg';

    protected $fillable = [
        'link', 'date' , 'is_block'
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = TidingFilter::class;

    protected $casts=[
        'is_block' => 'boolean'
    ];

    public $translatedAttributes = ['name','short_description','description'];

    /**
     * @return TidingResource
     */
    public function getResource(): TidingResource
    {
        return new TidingResource($this->fresh());
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
