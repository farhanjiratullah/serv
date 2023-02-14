<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id', 'order_status_id', 'freelancer_id', 'buyer_id', 'file', 'expired', 'note'
    ];

    // Inverse one to many
    public function Service()
    {
        return $this->belongsTo(Service::class);
    }

    public function OrderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function OrderFreelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function OrderBuyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
