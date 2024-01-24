<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class FilmFakerSeeder extends Seeder
{
    public function run()
    {
        // Create Faker object
        $faker = Faker::create();

        // Generating 10 fame films
        for ($i = 0; $i < 10; $i++) {
            DB::table('films')->insert([
                'name' => $faker->text(50),
                'year' => $faker->year,
                'genre' => $faker->word,
                'country' => $faker->country,
                'duration' => $faker->numberBetween(60, 240),
                'img_url' => $faker->imageUrl(640, 480),
                'agencia' => $faker->company, // filling this field with randoms names of companys
                'created_at' => now(),
            ]);
        };
    }
}

