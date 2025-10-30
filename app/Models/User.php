<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'fullname',
        'mobile',
        'email',
        'password',
        'user_type',
        'user_category',
        'auth_level',
        'access_level',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


public function courses()
{
    return $this->belongsToMany(Course::class, 'course_user')
                ->withPivot('enrolled_at', 'paid_amount', 'payment_status')
                ->withTimestamps();
}

public function coupons()
{
    return $this->belongsToMany(Coupon::class, 'coupon_user')
                ->withPivot('used_at')
                ->withTimestamps();
}


}
