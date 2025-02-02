<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_date'];

    public $timestamps = false;

    protected $casts = [
        'order_date' => 'date',
    ];
}
