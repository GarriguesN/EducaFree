<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Course;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CourseSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(PointSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);        
    }
}
