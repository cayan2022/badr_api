<?php

namespace App\Models;

use App\Http\Filters\DoctorFilter;
use App\Http\Filters\Filterable;
use App\Http\Resources\DoctorResource;
use App\Models\Traits\HasActivation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Doctor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasActivation,Filterable;

    protected $fillable = [
        'name',
        'specialization',
        'order',
        'is_block'
    ];
    protected $casts = [
        'is_block' => 'boolean',
    ];

    protected $filter=DoctorFilter::class;

    public const MEDIA_COLLECTION_NAME = 'doctor_avatar';
    public const MEDIA_COLLECTION_URL = 'images/doctor.png';
    /*Helpers*/
    /**
     * @return DoctorResource
     */
    public function getResource(): DoctorResource
    {
        return new DoctorResource($this->fresh());
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
