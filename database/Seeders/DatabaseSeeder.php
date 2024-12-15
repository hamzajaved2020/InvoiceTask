<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;
use App\Models\Session;
use App\Models\Invoice;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create customers
        Customer::factory(10)->create()->each(function ($customer) {
            // Create users for each customer
            User::factory(rand(5, 15))->create(['customer_id' => $customer->id])->each(function ($user) {
                // Create an activated session for each user
                Session::factory()->activated()->create(['user_id' => $user->id]);

                // Create an appointment session for each user
                Session::factory()->appointment()->create(['user_id' => $user->id]);
            });
        });
    }
}
