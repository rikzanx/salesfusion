<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory;
    use Sluggable;
    protected $primaryKey = 'id';

    protected $fillable = [
        "category_id",
        "name",
        "slug",
        "brand",
        "description",
        "dilihat",
        "price",
        "stock"
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category(){
        return $this->hasOne('App\Models\Category','id','category_id');
    }

    public function images(){
        return $this->hasMany('App\Models\ImagesProduct','product_id');
    }
}
