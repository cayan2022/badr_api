<?php

namespace App\Models;

use App\Models\Traits\HasActivation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Resources\UserResource;
 use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Http\Filters\Filterable;
use App\Http\Filters\UserFilter;
/**
 * User Class
 */
class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles , InteractsWithMedia, HasActivation , Filterable, SoftDeletes;

    /**
     *
     */
    public const MODERATOR = 'moderator';

    public const PATIENT = 'patient';

    /**
     *
     */
    public const TYPES = [
        self::MODERATOR,
        self::PATIENT
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'type', 'phone' , 'password', 'is_block','country_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected  $filter  = UserFilter::class;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_block'=>'boolean'
    ];
    public const MEDIA_COLLECTION_NAME = 'images';
    public const MEDIA_COLLECTION_URL = 'images/user.png';

    protected $perPage = 16;
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->is_block = false;
        });
    }

    /*Mutators*/
    /**
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /*Helpers*/
    /**
     * @return UserResource
     */
    public function getResource(): UserResource
    {
        return new UserResource($this->fresh());
    }
    /**
     * Get the access token currently associated with the user. Create a new.
     *
     * @param  string|null  $device
     * @return string
     */
    public function createTokenForDevice(string $device = null): string
    {
        $device = $device ?: 'Unknown Device';

        //$this->tokens()->where('name', $device)->delete();

        return $this->createToken($device)->plainTextToken;
    }

    /**
     * @return bool
     */
    public function isModerator(): bool
    {
        return $this->type===self::MODERATOR;
    }
    /**
     * The user profile image url.
     *
     */
    public function getAvatar()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_NAME);
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL));
    }
    /*Relations*/
    /**
     * @return HasMany
     */
    public function orderHistories(): HasMany
    {
        return $this->hasMany(OrderHistory::class);
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_histories','user_id','order_id');
    }
}
