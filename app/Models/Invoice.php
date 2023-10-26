<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
            "id_inv",
            "no_invoice",
            "duedate",
            "id_customer",
            "comment",
            "diskon_rate",
            "tax_rate",
            "profit",
            "created_at",
            "tanggal_pengiriman",
            "dp"
    ];
    public function customer(){
        return $this->hasOne('App\Models\Customer','id','id_customer');
    }
    public function items(){
        return $this->hasMany('App\Models\Item','invoice_id');
    }
    public function getTotalInvoiceAttribute(){
        $total = 10;
        return $total;
    }
}
