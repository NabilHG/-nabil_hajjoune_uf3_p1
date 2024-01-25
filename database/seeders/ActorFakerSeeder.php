<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ActorFakerSeeder extends Seeder
{
    public function run()
    {
        // Create a Faker object
        $faker = Faker::create();

        // Generain 10 randoms actors
        for ($i = 0; $i < 10; $i++) {
            DB::table('actors')->insert([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'birthdate' => $faker->date,
                'country' => $faker->country,
                'img_url' => $faker->imageUrl(640, 480),
                'agencia' => $faker->company, // filling this field with randoms names of companys
                'created_at' => now(),
            ]);
        };
    }
}

