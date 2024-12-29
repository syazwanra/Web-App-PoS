<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class outlets extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'outlets';
    protected $fillable = ['name', 'phone_number','Branch_Manager', 'address'];


        // Relasi dengan model Product (hasMany)
        public function products()
        {
            return $this->hasMany(Product::class, 'outlet_id');
        }
}
