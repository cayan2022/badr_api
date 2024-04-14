<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioCategoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'p_c_translations';

    public $timestamps = false;

    protected $fillable = ['name', 'description'];
}