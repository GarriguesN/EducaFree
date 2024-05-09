<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseInfo;
use App\Models\Favorite;
use Faker\Factory as Faker;

class FavoritesCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

            // Retrieve all courses and users
            $users = User::all();
            $courses = Course::all();

            // Iterate over each course
                // For each course, create 10 comments

                    for ($i = 0; $i < 5000; $i++) {

                        $randomUser = $users->random();
                        $randomCourse = $courses->random();

                        Favorite::factory()->create([
                            'course_id' => $randomCourse->id,
                            'user_id' => $randomUser->id,
                        ]);
                    }
    }
}
