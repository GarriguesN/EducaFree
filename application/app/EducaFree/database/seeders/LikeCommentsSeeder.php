<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\CommentReply;
use App\Models\User;
use Faker\Factory as Faker;

class LikeCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

            // Retrieve all courses and users
            $comments = Comment::all();
            $users = User::all();

            // Iterate over each course
            foreach ($comments as $comment) {
                // For each course, create 10 comments
                for ($i = 0; $i < 10; $i++) {
                    // Randomly select a user from the users collection
                    $randomUser = $users->random();

                    // Create a comment with the selected course and random user
                    CommentLike::factory()->create([
                        'comment_id' => $comment->id,
                        'user_id' => $randomUser->id,
                        'liked_at' => $faker->dateTimeBetween('-1 year', 'now'), // Generate a random description
                    ]);
                }
            }
    }
}
