<?php

namespace App\Models;

use App\Http\Resources\PortfolioResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\Filterable;
use Spatie\MediaLibrary\HasMedia;
use App\Http\Filters\PortfolioFilter;
use App\Models\Traits\HasActivation;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Portfolio extends Model implements HasMedia, TranslatableContract
{
    use HasFactory;
    use InteractsWithMedia;
    use Translatable;
    use Filterable;
    use HasActivation;

    protected $fillable = [
        'is_block',
        'portfolio_category_id',
        'url',
    ];

    protected $casts = [
        'is_block' => 'boolean'
    ];

    public $translatedAttributes = [
        'name',
        'short_description',
        'full_description',
    ];

    public const MEDIA_COLLECTION_LOGO_NAME = 'portfolio_logo';
    public const MEDIA_COLLECTION_COVER_NAME = 'portfolio_cover';
    public const MEDIA_COLLECTION_URL = 'images/project.png';

    protected $filter = PortfolioFilter::class;

    /**
     * @return PortfolioResource
     */
    public function getResource(): PortfolioResource
    {
        return new PortfolioResource($this->fresh());
    }

    public function getLogo()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_LOGO_NAME);
    }

    public function getCover()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_COVER_NAME);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_LOGO_NAME)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL));

        $this->addMediaCollection(self::MEDIA_COLLECTION_COVER_NAME)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL));
    }

    public function portfolioCategory()
    {
        return $this->belongsTo(PortfolioCategory::class, 'portfolio_category_id');
    }
}