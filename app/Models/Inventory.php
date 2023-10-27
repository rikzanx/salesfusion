<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
            "sku",
            "name",
            "description",
            "lokasi",
            "qty",
    ];

    public function transactions()
    {
        return $this->hasMany('App\Models\InventoryTransaction','inventory_id');
    }
    public function images()
    {
        return $this->hasMany('App\Models\ImagesInventory','inventory_id');
    }
    public function item_invoices()
    {
        return $this->hasMany('App\Models\Item','inventory_id');
    }
}
