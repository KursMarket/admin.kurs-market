<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sale extends Model
{
    use HasFactory;
    public $timestamps = false;
    const SALE_TYPE = 1;
    const PROMO_TYPE = 0;
    const PERCENT_DISCOUNT = 'PERCENT';
    const FIX_DISCOUNT = 'FIX';

    protected $fillable = [
        'school_id',
        'course_id',
        'type',
        'date_from',
        'date_to',
        'discount',
        'discount_type',
    ];

    public function school(): HasOne
    {
        return $this->hasOne(School::class, 'user_id', 'school_id');
    }
}
