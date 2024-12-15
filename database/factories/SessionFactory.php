<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class SessionFactory extends Factory
{
    protected $model = Session::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'activated' => null, // Default, can be overridden by states
            'appointment' => null, // Default, can be overridden by states
        ];
    }

    public function activated()
    {
        return $this->state(function () {
            return [
                'activated' => $this->faker->dateTimeBetween('-6 months', '+6 months'),
                'appointment' => null,
            ];
        });
    }

    public function appointment()
    {
        return $this->state(function () {
            return [
                'activated' => null,
                'appointment' => $this->faker->dateTimeBetween('-6 months', '+6 months'),
            ];
        });
    }
}
