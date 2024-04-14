<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Http\Resources\SettingResource;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'whatsapp_clicks',
        'phone_clicks',
        'mail_clicks',
    ];

    public const MEDIA_COLLECTION_NAME = 'setting_avatar';
    public const MEDIA_COLLECTION_URL = 'images/setting.png';

    /*helpers*/
    /**
     * @return SettingResource
     */
    public function getResource(): SettingResource
    {
        return new SettingResource($this->fresh());
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