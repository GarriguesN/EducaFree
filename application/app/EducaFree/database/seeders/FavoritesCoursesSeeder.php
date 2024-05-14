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
            $users = User::all();
            $courses = Course::all();

                    for ($i = 0; $i < 3412; $i++) {

                        $randomUser = $users->random();
                        $randomCourse = $courses->random();

                        Favorite::factory()->create([
                            'course_id' => $randomCourse->id,
                            'user_id' => $randomUser->id,
                        ]);
                    }
    }
}
