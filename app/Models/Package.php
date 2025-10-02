<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'package';
    
    protected $fillable = [
        'package_name',
        'package_price',
        'package_description',
        'package_image'
    ];

    public $timestamps = true;
}