<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all()->pluck('id')->toArray();
        $timestamp = $this->faker->dateTimeBetween('-7 day');
        return [
            'text' => $this->faker->text(random_int(120, 220)),
            'user_id' => $this->faker->randomElement($users),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];
    }
}
