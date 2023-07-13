<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'course_id',
        'user_id',
        'grade',
        'text',
        'status',
        'source',
        'show_on_home_page',
        'sort_order_on_home_page',
    ];

    public function school(): HasOne
    {
        return $this->hasOne(School::class, 'user_id', 'school_id');
    }

    public function author(): HasOne
    {
        return $this->hasOne(Student::class, 'user_id', 'user_id');
    }

    public function course(): HasOne
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }
}
