<?php

namespace App\Models;

use App\Http\Filters\AboutFilter;
use App\Http\Filters\Filterable;
use App\Http\Resources\AboutResource;
use App\Models\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model implements TranslatableContract
{
    use HasFactory, Translatable, Filterable, HasActivation;

    protected $fillable = ['is_block'];

    protected $casts=[
        'is_block'=>'boolean'
    ];
    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = AboutFilter::class;

    public $translatedAttributes = ['title','description'];

    /*helpers*/
    /**
     * @return AboutResource
     */
    public function getResource(): AboutResource
    {
        return new AboutResource($this->fresh());
    }
}
