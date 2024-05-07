<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $name = $faker->sentence(5);
            $description = $faker->text(150);
            $imagePath = $this->generateImage($name);

            Course::factory()->create([
                'name' =>  $faker->sentence(5),
                'description' => $faker->text(150),
                'img' => $imagePath,
                'vision' => 1
            ]);
        }
    }

    private function generateImage(string $name): string
    {
         $faker = Faker::create();
        $imgName = str_replace(' ', '_', $name); // Reemplaza los espacios en blanco con guiones bajos en el nombre
        $imageData = $faker->image(public_path('storage/ImagesCourses'), 920, 520, null, false);
        $imageName = pathinfo($imageData, PATHINFO_BASENAME); // Obtiene el nombre del archivo de la imagen generada

        // $imagePath = asset('storage/ImagesCourses/' . $imageName); // Obtiene la URL completa de la imagen

        // $imagePathGood = str_replace('localhost', '127.0.0.1:8000', $imagePath);

        
        return $imageName;
    }
}
