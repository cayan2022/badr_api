<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name','classification','short_description','full_description'];

}
