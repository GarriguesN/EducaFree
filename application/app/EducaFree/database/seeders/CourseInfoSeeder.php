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

            $users = User::all();
            $courses = Course::all();

                foreach($courses as $course){
                    $numInfo = rand(1, 5);

                    for ($i = 0; $i < $numInfo; $i++) {

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
