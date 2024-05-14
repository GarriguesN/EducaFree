<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\CommentReply;
use App\Models\User;
use Faker\Factory as Faker;

class LikeCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $comments = Comment::all();
        $users = User::all();

        foreach ($comments as $comment) {
            $likes = rand(1, 10);

            for ($i = 0; $i < $likes; $i++) {

                $randomUser = $users->random();

                // Verificar si ya existe un like para este comentario y usuario
                $existingLike = CommentLike::where('comment_id', $comment->id)
                                            ->where('user_id', $randomUser->id)
                                            ->exists();

                if (!$existingLike) {
                    CommentLike::factory()->create([
                        'comment_id' => $comment->id,
                        'user_id' => $randomUser->id,
                        'liked_at' => $faker->dateTimeBetween('-1 year', 'now'),
                    ]);
                }
            }
        }
    }
}
