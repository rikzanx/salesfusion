<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    
    protected $fillable = [
        "name_customer",
        "address_customer",
        "phone_customer",
    ];

    public function invoices(){
        return $this->hasMany('App\Models\Invoice','customer_id');
    }
}
