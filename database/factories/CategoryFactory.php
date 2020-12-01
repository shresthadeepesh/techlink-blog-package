<?php

namespace Techlink\Blog\Database\Factories;

use Techlink\Blog\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Techlink\Blog\Tests\User;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = collect(User::all()->modelKeys());

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph($nbSentences = 30, $variableNbSentences = true),
            'user_id' => $this->faker->randomElement($user),
        ];
    }
}
