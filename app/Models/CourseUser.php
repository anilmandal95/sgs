<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    protected $table = 'course_user';

    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'paid_amount',
        'payment_status',
    ];
}
