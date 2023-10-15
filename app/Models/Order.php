<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'user_id',
        'status',
        'payment_status',
    ];

    protected static function booted()
    {
        static::observe(OrderObserver::class);
    }

    public function store()
    {
        $this->belongsTo(Store::class,'store_id');
    }

    public function user()
    {
        $this->belongsTo(User::class,'user_id')->withDefault([
            'name'=>'Guest customer',
        ]);
    }
    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
       $orderNumber =  Order::whereYear('created_at',$year)->max('number');
       if ($orderNumber){
           return $orderNumber + 1;
       }
       return $year.'0001';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items','order_id','product_id'
            , 'id','id')
            ->using(OrderItem::class)
            ->withPivot([
                'product_name',
                'price',
                'quantity',
                'options',
                ]);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class,'order_id');
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class,'order_id','id')
            ->where('type', '=','billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class,'order_id','id')
            ->where('type', '=','shipping');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'order_id');
    }
}
