<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = ['start_date', 'end_date', 'customer_id', 'total_prices', 'total_events'];

    // Define the relationship with the Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'invoice_users');
    }
}
