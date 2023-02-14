<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    // protected $dates = [
    //     'created_at', 'updated_at', 'email_verified_at'
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // One to one
    public function DetailUser()
    {
        return $this->hasOne(DetailUser::class);
    }

    // One to many
    public function Services()
    {
        return $this->hasMany(Service::class);
    }

    public function OrderFreelancers()
    {
        return $this->hasMany(Order::class, 'freelancer_id');
    }
    
    public function OrderBuyers()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    // Has many through
    public function ExperienceUsers() {
        return $this->hasManyThrough(ExperienceUser::class, DetailUser::class);
    }
}
