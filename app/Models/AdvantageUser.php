<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvantageUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id', 'advantage'
    ];

    // Inverse one to many
    public function Service()
    {
        return $this->belongsTo(Service::class);
    }
}
