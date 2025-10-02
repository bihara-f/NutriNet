<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'address',
        'country',
        'zip_code',
        'card_number',
        'expiration_date',
        'cvv',
        'package_id'
    ];

    // Add relationships
    protected $with = ['package', 'user'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}