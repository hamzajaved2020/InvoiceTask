<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_date' => $this->faker->dateTimeBetween('-2 months', '-1 months'),
            'end_date' => $this->faker->dateTimeBetween('-1 months', 'now'),
            'customer_id' => Customer::factory(),
            'total_prices' => $this->faker->randomFloat(2, 50, 1000),
            'total_events' => $this->faker->numberBetween(1, 10),
        ];
    }

    /**
     * Configure the factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Invoice $invoice) {
            $users = User::factory(3)->create(['customer_id' => $invoice->customer_id]);
            $invoice->users()->attach($users->pluck('id')->toArray());
        });
    }
}
