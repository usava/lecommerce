<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const STATUS_NEW = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_SEND = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_DONE = 4;

    protected $fillable = [
        'product_id', 'user_id', 'quantity', 'address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
