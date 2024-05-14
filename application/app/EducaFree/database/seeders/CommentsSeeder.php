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
            $faker = Faker::create();

            $courses = Course::all();
            $users = User::all();

            foreach ($courses as $course) {
                $numComments = rand(1, 10);

                for ($i = 0; $i < $numComments; $i++) {
                    $randomUser = $users->random();

                    Comment::factory()->create([
                        'course_id' => $course->id,
                        'user_id' => $randomUser->id,
                        'comment' => $faker->paragraph(),
                    ]);
                }
            }
    }
}
