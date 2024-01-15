<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['firstname', 'surname', 'email', 'address1', 'address2', 'phone'];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }
}