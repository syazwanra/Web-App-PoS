<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class gender extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'gender';
    protected $fillable = ['name'];

        // Relasi dengan model Product (hasMany)
        public function products()
        {
            return $this->hasMany(Product::class, 'gender_id');
        }
}
