<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CouponUser extends Pivot
{
    protected $table = 'coupon_user';

    protected $fillable = [
        'user_id',
        'coupon_id',
        'used_at',
    ];
}
