<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all()->pluck('id')->toArray();
        $comments = Comment::all()->pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'comment_id' => $this->faker->randomElement($comments),
        ];
    }
}
