<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\UserDetails;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const IS_ACTIVE = 1;
    public const NOT_ACTIVE = 0;

    public const TEACHER_TYPE = 1;
    public const STUDENT_TYPE = 2;

    public const TEACHER_STATUS_PENDING = 1;
    public const TEACHER_STATUS_APPROVED = 2;
    public const TEACHER_STATUS_DISAPPROVED = 3;

    protected $guard = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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

    public function user_details()
    {
        return $this->hasOne(UserDetails::class);
    }

    public static function teacherRequestStatus()
    {
        return [
            ['value'=>static::TEACHER_STATUS_PENDING, 'name' => "Pending"],
            ['value'=>static::TEACHER_STATUS_APPROVED, 'name' =>  "Approved"],
            ['value'=>static::TEACHER_STATUS_DISAPPROVED, 'name' =>  "Disapproved"],
        ];
    }
}
