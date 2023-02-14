<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'description', 'delivery_time', 'revision_limit', 'price', 'note'
    ];

    // One to many
    public function AdvantageUsers()
    {
        return $this->hasMany(AdvantageUser::class);
    }

    public function AdvantageServices()
    {
        return $this->hasMany(AdvantageService::class);
    }

    public function Thumbnails()
    {
        return $this->hasMany(Thumbnail::class);
    }
    public function Taglines()
    {
        return $this->hasMany(Tagline::class);
    }

    public function Orders()
    {
        return $this->hasMany(Order::class);
    }

    // Inverse one to many
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
