<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class roles extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'roles';
    protected $fillable = ['name'];

    public function listUsers()
    {
       return $this->hasMany(User::class, 'role_id');
    }
}
