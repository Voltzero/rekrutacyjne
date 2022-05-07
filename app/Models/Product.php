<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'quantity',
        'price',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
