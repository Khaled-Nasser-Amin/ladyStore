<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function colors(){
        return $this->belongsToMany(Color::class,'orders_colors','order_id','color_id')->withPivot(['quantity','amount','total_amount','color']);
    }

    public function sizes(){
        return $this->belongsToMany(Size::class,'orders_sizes','order_id','size_id')->withPivot(['quantity','size','price','tax']);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'orders_products')->withPivot(['name_ar','name_en','image']);

    }
    public function customer(){
        return $this->belongsTo(Customer::class,'user_id','id');

    }
    public function delivery_service_provider(){
        return $this->belongsTo(DeliveryServiceProvider::class);

    }
    public function refunds(){
        return $this->hasMany(Refund::class);

    }

    public function vendors(){
        return $this->belongsToMany(User::class,'order_vendor','order_id','vendor_id')->withPivot(['subtotal','taxes','total_amount']);
    }

    public function scopeGetOrdersThroughMonth($q,$year,$month){
        return $q->whereYear('created_at',$year)->whereMonth('created_at',$month)
        ->orderBy('created_at')->get()->groupBy(function($data) {
            //week
            return Carbon::parse($data->created_at)->format('W');

        });
    }

    public function transaction(){
        return $this->hasOne(Transaction::class);
    }

}
