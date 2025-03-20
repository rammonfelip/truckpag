<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'produtos';

    protected $fillable = [
        'code', 'product_name', 'url', 'brands', 'categories', 'image_url', 'origins', 'last_modified_t',
        'last_modified_datetime', 'imported_t', 'imported_datetime', 'status',
    ];
}
