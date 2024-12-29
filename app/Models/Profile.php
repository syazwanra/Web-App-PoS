<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class profile extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'profile';
    protected $fillable = ['gender','fullname','user_id', 'outlet_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
