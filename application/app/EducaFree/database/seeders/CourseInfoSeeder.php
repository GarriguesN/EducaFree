<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Request;
use Faker\Factory as Faker;

class CourseInfoSeeder extends Seeder
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
                foreach($courses as $course){
                    for ($i = 0; $i < 300; $i++) {

                        $randomUser = $users->random();

                        CourseInfo::factory()->create([
                            'course_id' => $course->id,
                            'user_id' => $randomUser->id,
                            'progress' => $faker->numberBetween(0, 100),
                            'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                            'updated_at' => now(),
                        ]);
                    }
                }
    }
}
