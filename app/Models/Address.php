<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'user_address';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'mobile',
        'address_line_1',
        'address_line_2',
        'country'
    ];
    
}
