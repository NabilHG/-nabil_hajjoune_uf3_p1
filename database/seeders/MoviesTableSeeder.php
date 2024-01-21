<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MoviesTableSeeder extends Seeder
{
    public function run()
    {
        // Creamos un objeto de tipo Faker
        // $faker = Faker::create();

        // Generamos 20 películas de tipo aleatorio
        // for ($i = 0; $i < 20; $i++) {
        //     DB::table('films')->insert([
        //         'name' => $faker->sentence(2),
        //         'year' => $faker->numberBetween(1900, 2022),
        //         'genre' => $faker->word,
        //         'country' => $faker->country,
        //         'duration' => $faker->numberBetween(60, 180),
        //         'img_url' => $faker->imageUrl(640, 480, 'movie', true),
        //     ]);
        // }
    }
}

