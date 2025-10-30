<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'instructor_id',
        'price',
        'discount_price',
        'is_free',
        'is_featured',
        'thumbnail',
        'promo_video_url',
        'duration_minutes',
        'total_lectures',
        'level',
        'language',
        'status',
        'total_enrollments',
        'rating',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'category',
        'tags',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')
                    ->withPivot('enrolled_at', 'paid_amount', 'payment_status')
                    ->withTimestamps();
    }
}
