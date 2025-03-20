<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Produto extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'produtos';

    protected $fillable = [
        'code',
        'product_name',
        'brands',
        'categories',
        'imported_t',
        'status',
    ];
}
