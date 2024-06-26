<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Obtener todas las lecciones
        $courses = Course::all();
        
        // Iterar sobre cada lección
        foreach ($courses as $course) {
            // Generar un número aleatorio entre 3 y 10
            $numLessons = rand(3, 10);
            
            // Crear lecciones aleatorias
            for ($i = 0; $i < $numLessons; $i++) {
                Lesson::factory()->create([
                    'course_id' => $course->id,
                    'name' => $faker->sentence(5),
                    'description' => $faker->paragraph(), // Generar una explicación aleatoria
                ]);
            }
        }

    }
}
