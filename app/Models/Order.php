<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalItemsAttribute()
    {
        return $this->items->sum('qty');
    }

    public function getFormattedTotalPriceAttribute()
    {
        return number_format($this->total_price, 0, ',', '.');
    }
}
