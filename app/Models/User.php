<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    const ROLE_SCHOOL = 2;
    const ROLE_ADMIN = 1;
    const ROLE_STUDENT = 3;
    const CONFIRMED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'email',
        'last_action',
        'provider',
        'provider_id',
        'last_auth',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUserRoleId(string $role = 'admin'): int
    {
        if ($role === 'school') {
            return self::ROLE_SCHOOL;
        }

        if ($role === 'student') {
            return self::ROLE_STUDENT;
        }

        if ($role === 'admin') {
            return self::ROLE_ADMIN;
        }

        return 0;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        try {
            $this
                ->addMediaConversion('school-preview')
                ->fit(Manipulations::FIT_CROP, 140, 30)
                ->nonQueued();
        } catch (InvalidManipulation $e) {
            Log::error("Media for schools: {$e->getMessage()}, {$e->getFile()}");
        }
    }

    public function school(): HasOne
    {
        return $this->hasOne(School::class, 'user_id', 'id');
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
