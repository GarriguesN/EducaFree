<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $nacho = User::create([
                'name' => 'nacho',
                'email' => 'nacho090603@gmail.com',
                'password' => Hash::make('nacho'),
        ]);
        $admin = User::create([
            'name' => 'admin',
            'email' => 'support@educafree.es',
            'password' => Hash::make('admin'),
        ]);
        $admin->assignRole('admin');

        $editor = User::create([
            'name' => 'editor',
            'email' => 'editor@educafree.net',
            'password' => Hash::make('editor'),
        ]);
        $editor->assignRole('editor');

        // $faker = FakerFactory::create();

        // // Cuantos usuarios se generan random
        // $numberOfUsers = 6000;

        // for ($i = 0; $i < $numberOfUsers; $i++) {
        //     User::create([
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->safeEmail,
        //         'password' => Hash::make($faker->password),
        //         'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
        //         'updated_at' => now(),
        //     ]);
        // }


    }
}
