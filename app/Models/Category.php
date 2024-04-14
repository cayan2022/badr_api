<?php

namespace App\Models;

use App\Http\Resources\CategoryResource;
use App\Models\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Http\Filters\Filterable;
use App\Http\Filters\CategoryFilter;
class Category extends Model implements HasMedia , TranslatableContract
{
    use HasFactory , InteractsWithMedia , Translatable , Filterable, HasActivation, SoftDeletes;

    protected $fillable = [
        'is_block'
    ];

    public $translatedAttributes = ['name','description'];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = CategoryFilter::class;

    protected $casts=[
        'is_block'=>'boolean'
    ];

    public const MEDIA_COLLECTION_NAME = 'category_avatar';
    public const MEDIA_COLLECTION_URL = 'images/category.png';
    /*helpers*/
    /**
     * @return CategoryResource
     */
    public function getResource(): CategoryResource
    {
        return new CategoryResource($this->fresh());
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

    /*Relations*/
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function canDeleted(): bool
    {
        return $this->orders()->doesntExist() &&
            $this->services()->doesntExist() ;
    }

}
