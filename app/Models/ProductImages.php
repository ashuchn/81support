<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use illuminate\Database\Eloquent\SoftDeletes;

class ProductImages extends Model
{
    // use SoftDeletes;
    use HasFactory;
    protected $table = 'product_images';
}
