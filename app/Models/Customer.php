<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = ['name'];

    // Define the relationship with the User model
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
