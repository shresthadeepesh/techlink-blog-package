<?php

namespace Techlink\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Techlink\Blog\Models\Comment;
use Techlink\Blog\Tests\User;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var stringA
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = collect(User::all()->modelKeys());

        return [
            'description' => $this->faker->paragraph($nbSentences = 30, $variableNbSentences = true),
            'status' => 1,
            'user_id' => $this->faker->randomElement($user),
        ];
    }
}
