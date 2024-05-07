<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Point;
use Faker\Factory as Faker;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Obtener todas las lecciones
        $lessons = Lesson::all();
        
        // Iterar sobre cada lección
        foreach ($lessons as $lesson) {
            // Crear dos puntos por cada lección
            for ($i = 0; $i < 6; $i++) {
                Point::factory()->create([
                    'lesson_id' => $lesson->id,
                    'explanation' => $faker->paragraph(), // Generar una explicación aleatoria
                ]);
            }
        }
    }
}
