<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExperienceUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'detail_user_id', 'experience'
    ];

    // Inverse one to many
    public function DetailUser()
    {
        return $this->belongsTo(DetailUser::class);
    }
}
