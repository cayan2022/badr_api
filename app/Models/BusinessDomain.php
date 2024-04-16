<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessDomain extends Model  implements TranslatableContract
{
    use  Translatable, SoftDeletes;
    protected $fillable = [
        'project_id',
    ];


    public $translatedAttributes = ['title'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }



}
