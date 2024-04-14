<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','sub_status_id','user_id','description','duration'];


    public function employee()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function substatus()
    {
        return $this->belongsTo(SubStatus::class,'sub_status_id');
    }


}
