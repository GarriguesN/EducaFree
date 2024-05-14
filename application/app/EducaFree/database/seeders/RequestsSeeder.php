<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Request;
use App\Models\User;
use Faker\Factory as Faker;

class RequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
            $users = User::all();
                for ($i = 0; $i < 240; $i++) {
                    $randomUser = $users->random();
                    Request::factory()->create([
                        'title' => $faker->text(50),
                        'description' => $faker->paragraph(),
                        'completed' => $faker->boolean(),
                        'user_id' => $randomUser->id,
                    ]);
                }
    }
}
