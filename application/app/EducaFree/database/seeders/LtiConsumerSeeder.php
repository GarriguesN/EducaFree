<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\LtiConsumer;
use App\Models\Point;

use Faker\Factory as Faker;

class LtiConsumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 27; $i++) {

                LtiConsumer::factory()->create([
                    'name' => $faker->text(50), 
                    'platform_id' => $faker->url(), 
                    'client_id' => $faker->uuid(), 
                    'deployment_id' => $faker->uuid(), 
                    'signature_method' => 'RS256',
                    'settings' => 'test-FakerGenerator',
                    'protected' => 0, 
                    'enabled' => $faker->boolean(), 
                    'created' => $faker->dateTimeBetween('-1 year', 'now'), 
                    'updated' => now(),
                ]);
        }
    }
}
