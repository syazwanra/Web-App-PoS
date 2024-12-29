<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'product';

    protected $fillable = [
        'id', 
        'image_url', 
        'name', 
        'description', 
        'price', 
        'outlet_id', 
        'status', 
        'product_category_id', 
        'gender_id'
    ];

    // Relasi dengan model Outlet (belongsTo)
    public function outlets()
    {
        return $this->belongsTo(outlets::class, 'outlet_id');
    }

    // Relasi dengan model ProductCategory (belongsTo)
    public function product_category()
    {
        return $this->belongsTo(product_category::class, 'product_category_id');
    }

    // Relasi dengan model Gender (belongsTo)
    public function gender()
    {
        return $this->belongsTo(gender::class, 'gender_id');
    }
}
