<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'photo', 'role', 'contact_number', 'biography'
    ];

    // One to many
    public function ExperienceUsers()
    {
        return $this->hasMany(ExperienceUser::class);
    }

    // Inverse one to one
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
