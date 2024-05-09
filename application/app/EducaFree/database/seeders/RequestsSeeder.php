<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Request;
use App\Models\User;
use Faker\Factory as Faker;

class RequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

            // Retrieve all courses and users
            $users = User::all();

            // Iterate over each course
                // For each course, create 10 comments
                for ($i = 0; $i < 240; $i++) {
                    // Randomly select a user from the users collection
                    $randomUser = $users->random();

                    // Create a comment with the selected course and random user
                    Request::factory()->create([
                        'title' => $faker->text(50),
                        'description' => $faker->paragraph(),
                        'completed' => $faker->boolean(),
                        'user_id' => $randomUser->id,
                    ]);
                }
    }
}
