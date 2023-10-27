<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        "inventory_id",
        "type",
        "quantity",
        "notes"
    ];

    public function inventory(){
        return $this->hasOne('App\Models\Inventory','id','inventory_id');
    }
}
