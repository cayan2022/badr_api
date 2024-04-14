<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\StatusFilter;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model implements TranslatableContract
{
    use HasFactory , Translatable,Filterable, SoftDeletes;

    protected $fillable=['name'];

    public $translatedAttributes = ['name'];

    protected $with=['subStatuses'];

    protected $withCount=['orders'];

    public const NEW='New';
    public const FOLLOWING='Following';
    public const PAID='Paid';
    public const FAIL='Fail';

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = StatusFilter::class;
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function subStatuses()
    {
        return $this->hasMany(SubStatus::class);
    }
}
