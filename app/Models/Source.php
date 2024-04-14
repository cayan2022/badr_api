<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use App\Http\Filters\SourceFilter;
use App\Models\Traits\HasActivation;
use App\Http\Resources\SourceResource;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Source extends Model implements HasMedia, TranslatableContract
{
    use HasFactory, InteractsWithMedia, Translatable, Filterable, HasActivation, SoftDeletes;

    protected $fillable = [
        'is_block',
        'identifier',
    ];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    public $translatedAttributes = ['name','short_description'];

    protected $casts = [
        'is_block' => 'boolean',
    ];
    public const MEDIA_COLLECTION_NAME = 'source_avatar';
    public const MEDIA_COLLECTION_URL = 'images/source.png';
    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = SourceFilter::class;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /*Helpers*/
    /**
     * @return SourceResource
     */
    public function getResource(): SourceResource
    {
        return new SourceResource($this->fresh());
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

    public function setIdentifierAttribute($value)
    {
        $this->attributes['identifier'] = $value;
    }

    public function getUrlAttribute(): string
    {
        $identifier=$this->identifier;
        if ($identifier==='website'){
            return config('app.domain_url');
        }
        return config('app.domain_url')."/?_source=$identifier";
    }
}
