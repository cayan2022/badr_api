<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'short_description'];
}
