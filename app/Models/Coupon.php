<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'usage_limit',
        'used_count',
        'expires_at',
        'active',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user')
                    ->withPivot('used_at')
                    ->withTimestamps();
    }
}
