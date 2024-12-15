<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = ['email', 'customer_id'];

    // Define the relationship with the Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Define the relationship with the Session model
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_users');
    }
}
