<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Zeronine',
            'email' => 'zeronine09@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$tm/3j9x/dXqUcDcbZlbCJ.ZoO8OBKHrkC/ghG0dysqpVihFevNNp.', // hadidfajar09
            // 'remember_token' => Str::random(10),
        ];
    }
}
