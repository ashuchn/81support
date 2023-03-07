<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use softDeletes;
    use HasFactory;
    protected $table = 'products';
}
