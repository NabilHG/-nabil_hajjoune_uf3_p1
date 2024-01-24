<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmActorSeeder extends Seeder
{
    public function run()
    {

        // Get the IDs of all films and actors
        $films = DB::table('films')->pluck('id')->toArray();
        $actors = DB::table('actors')->pluck('id')->toArray();

        // Iterate over each film
        foreach ($films as $filmId) {
            // Determine a random number of actors between 1 and 3
            $numberOfActors = rand(1, 3);

            // Randomly select the indexes of actors
            $selectedActors = array_rand($actors, $numberOfActors);

            // Iterate over the selected actors and create relationships in the films_actors table
            foreach ((array)$selectedActors as $actorIndex) {
                DB::table('films_actors')->insert([
                    'film_id' => $filmId,
                    'actor_id' => $actors[$actorIndex],
                    'created_at' => now(),
                ]);
            }
        }
    }
}

