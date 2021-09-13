<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps=false;
    protected $guarded=[];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function order(){
        return $this->belongsToMany(Order::class,'orders_colors','color_id','order_id')->withPivot(['quantity','amount','total_amount','color']);
    }

    public function images(){
        return $this->hasMany(Images::class);
    }

    public function sizes(){
        return $this->hasMany(Size::class);
    }
}
