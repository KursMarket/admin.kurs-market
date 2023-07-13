<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class School extends Model
{
    use HasFactory;

    const CONFIRMED = 1;

    public $timestamps = false;
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'name',
        'short_title',
        'phone',
        'partner_suffix',
        'partner_postfix',
        'description',
        'site_link',
        'site_link_text',
        'confirm_status',
        'meta_point',
        'meta_title',
        'meta_description',
        'url',
        'sort_order',
    ];

    public function scopeWithUsersOrderByCreatedAtDesc($query)
    {
        return $query
            ->select(['schools.*', 'users.created_at'])
            ->leftJoin('users', 'users.id', '=', 'schools.user_id')
            ->orderByDesc('users.created_at');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'school_id', 'id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
