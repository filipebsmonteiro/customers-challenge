<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'checked',
        'description',
        'interest',
        'date_of_birth',
        'email',
        'account'
    ];

    public function adresses()
    {
        return $this->hasMany(Address::class, 'customer_id');
    }

    public function creditCards()
    {
        return $this->hasMany(CreditCard::class, 'customer_id');
    }
}
