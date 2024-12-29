<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class product_category extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'product_category';
    protected $fillable = ['name'];

    // Relasi dengan model Product (hasMany)
    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
}
