<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyDuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'alias',
        'sort_order'
    ];
}
