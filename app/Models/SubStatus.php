<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubStatus extends Model implements TranslatableContract
{
    use HasFactory , Translatable;

    protected $fillable=['name','status_id'];

    public $translatedAttributes = ['name'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
