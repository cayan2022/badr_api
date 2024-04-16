<?php

namespace App\Models;

use App\Http\Resources\ContactUsResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ContactUs extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'email',
        'name',
        'message',
    ];
    public const MEDIA_COLLECTION_NAME = 'contact_files';
    public const MEDIA_COLLECTION_URL = 'files/default.png'; // Update with your default file URL

    /**
     * @return ContactUsResource
     */
    public function getResource(): ContactUsResource
    {
        return new ContactUsResource($this->fresh());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL));
    }
}
