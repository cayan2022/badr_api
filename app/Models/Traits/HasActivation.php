<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasActivation
{
    public function isActive():bool
    {
        return $this->is_block === false;
    }
    public function isBlock():bool
    {
        return $this->is_block === true;
    }
    public function block(?Model $model=null):void
    {
        if (isset($model)){
            $model->update(['is_block'=>true]);
        }else{
            $this->update(['is_block'=>true]);
        }
    }
    public function active(?Model $model=null):void
    {
        if (isset($model)){
            $model->update(['is_block'=>false]);
        }else{
            $this->update(['is_block'=>false]);
        }
    }
    public function toggleActivation(?Model $model=null):void
    {
        if (isset($model)){
            $model->isActive() ? $model->block() : $model->active();
        }else{
            $this->isActive() ? $this->block() : $this->active();
        }
    }
    /*
     * Scopes
     * */
    public function scopeWhereIsActive($query)
    {
        return $query->where('is_block', false);
    }
    public function scopeWhereIsBlock($query)
    {
        return $query->where('is_block', true);
    }
}
