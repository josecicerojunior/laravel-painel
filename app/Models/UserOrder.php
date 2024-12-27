<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOrder extends Model
{
    use HasFactory;

    public function items () {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    // public function user():BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }

}

