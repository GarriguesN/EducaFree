<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Create an instance of the Faker library
            $faker = Faker::create();

            // Retrieve all courses and users
            $courses = Course::all();
            $users = User::all();

            // Iterate over each course
            foreach ($courses as $course) {
                // For each course, create 10 comments
                for ($i = 0; $i < 10; $i++) {
                    // Randomly select a user from the users collection
                    $randomUser = $users->random();

                    // Create a comment with the selected course and random user
                    Comment::factory()->create([
                        'course_id' => $course->id,
                        'user_id' => $randomUser->id,
                        'comment' => $faker->paragraph(), // Generate a random description
                    ]);
                }
            }
    }
}
