<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{

   
    /**
     * Read films from storage
     *
     * @return array
     */
    public static function readFilms(): array
    {
        // Read films from JSON file in storage
        $filmsJson = Storage::json('/public/films.json');

        // Read films from the database
        $filmsDB = DB::table('films')->get();
        $filmsDB = json_decode(json_encode($filmsDB), true);

        // Merge films from JSON and database
        $films = array_merge($filmsJson, $filmsDB);

        return $films;
    }

    /**
     * List films older than input year 
     * If year is not informed, 2000 will be used as the criteria
     *
     * @param int|null $year
     * @return \Illuminate\Contracts\View\View
     */
    public function listOldFilms($year = null)
    {
        $old_films = [];
        if (is_null($year))
            $year = 2000;

        // Set the title for the view
        $title = "List of Old Movies (Before $year)";
        $films = FilmController::readFilms();

        // Filter films older than the specified year
        foreach ($films as $film) {
            if ($film['year'] < $year)
                $old_films[] = $film;
        }
        return view('films.list', ["films" => $old_films, "title" => $title]);
    }

    /**
     * List films younger than input year
     * If year is not informed, 2000 will be used as the criteria
     *
     * @param int|null $year
     * @return \Illuminate\Contracts\View\View
     */
    public function listNewFilms($year = null)
    {
        $new_films = [];
        if (is_null($year))
            $year = 2000;

        // Set the title for the view
        $title = "List of New Movies (After $year)";
        $films = FilmController::readFilms();

        // Filter films younger than the specified year
        foreach ($films as $film) {
            if ($film['year'] >= $year)
                $new_films[] = $film;
        }
        return view('films.list', ["films" => $new_films, "title" => $title]);
    }

    /**
     * List ALL movies or filter by year or genre.
     * If both year and genre are not provided, lists all movies.
     * If year or genre is provided, filters movies accordingly.
     *
     * @param int|null $year
     * @param string|null $genre
     * @return \Illuminate\Contracts\View\View
     */
    public function listFilms($year = null, $genre = null)
    {
        $films_filtered = [];

        $title = "List of All Movies";
        $films = FilmController::readFilms();

        // If no filter is provided, return all movies
        if (is_null($year) && is_null($genre))
            return view('films.list', ["films" => $films, "title" => $title]);

        // Filter movies based on year and/or genre
        foreach ($films as $film) {
            if ((!is_null($year) && is_null($genre)) && $film['year'] == $year) {
                $title = "List of All Movies Filtered by Year";
                $films_filtered[] = $film;
            } else if ((is_null($year) && !is_null($genre)) && strtolower($film['genre']) == strtolower($genre)) {
                $title = "List of All Movies Filtered by Category";
                $films_filtered[] = $film;
            } else if (!is_null($year) && !is_null($genre) && strtolower($film['genre']) == strtolower($genre) && $film['year'] == $year) {
                $title = "List of All Movies Filtered by Category and Year";
                $films_filtered[] = $film;
            }
        }
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    /**
     * List movies filtered by a specific year.
     *
     * @param int $year
     * @return \Illuminate\Contracts\View\View
     */
    public function listByYear($year)
    {
        $films_filtered = [];

        $title = "List of All Movies by Year";
        $films = FilmController::readFilms();

        // If no year is provided, return all movies
        if (is_null($year))
            return view('films.list', ["films" => $films, "title" => $title]);

        // Filter movies by the specified year
        foreach ($films as $film) {
            if (!is_null($year) && $film['year'] == $year) {
                $title = "List of All Movies Filtered by Year";
                $films_filtered[] = $film;
            }
        }

        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    /**
     * List movies filtered by a specific genre.
     *
     * @param string|null $genre
     * @return \Illuminate\Contracts\View\View
     */
    public function listByGenre($genre = null)
    {
        $films_filtered = [];

        $title = "List of All Movies";
        $films = FilmController::readFilms();

        // If no genre is provided, return all movies
        if (is_null($genre))
            return view('films.list', ["films" => $films, "title" => $title]);

        // Filter movies by the specified genre
        foreach ($films as $film) {
            if ((!is_null($genre)) && strtolower($film['genre']) == strtolower($genre)) {
                $title = "List of All Movies Filtered by Category";
                $films_filtered[] = $film;
            }
        }
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    /**
     * Sort movies by year and display the sorted list.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function sortByYear()
    {
        $title = "Movies Sorted by Year";

        $films = FilmController::readFilms();

        // Sort movies by year
        usort($films, function ($a, $b) {
            return $a['year'] - $b['year'];
        });

        return view('films.list', ["films" => $films, "title" => $title]);
    }

    /**
     * Count the number of movies and display the count.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function countFilms()
    {
        $title = "Number of Movies";
        $films = FilmController::readFilms();

        // Count the number of movies
        $films = count($films);

        return view('films.count', ["films" => $films, "title" => $title]);
    }

    /**
     * Check if a movie exists based on user input.
     *
     * @param array $newFilm
     * @return bool
     */
    public function isFilm($newFilm)
    {
        $films = FilmController::readFilms();
        foreach ($films as $film) {
            if ($film["name"] === $newFilm["name"]) {
                return true;
            }
        }
        return false;
    }

    
    public function saveIntoDB($title, $request){
        // Get the name from the request
        $name = $request->input('name');

        // Check if a record with the same name already exists in the database
        $existingRecord = DB::table('films')
            ->where('name', $name)
            ->exists();

        // If no record with the same name exists, proceed with insertion
        if (!$existingRecord) {
            // Get other data from the request
            $year = $request->input('year');
            $genre = $request->input('genre');
            $country = $request->input('country');
            $duration = $request->input('duration');
            $img_url = $request->input('img_url');

            // Insert data into the corresponding table using Query Builder
            $as = DB::table('films')->insert([
                'name' => $name,
                'year' => $year,
                'genre' => $genre,
                'country' => $country,
                'duration' => $duration,
                'img_url' => $img_url,
            ]);

            $films = FilmController::readFilms();
            return ['',  'data' => ["films" => $films, "title" => $title], 'view' => 'films.list'];
        } else {
            return ['', 'data' => ["error" => "Movie already exists"], 'view' => 'welcome'];
        }
    }

    public function saveIntoJson($title, $request){
        $films = FilmController::readFilms();
        $newFilm = [
            'name' => $request->input('name'),
            'year' => $request->input('year'),
            'genre' => $request->input('genre'),
            'country' => $request->input('country'),
            'duration' => $request->input('duration'),
            'img_url' => $request->input('img_url'),
        ];
        
        // Check if the movie already exists
        if ($this->isFilm($newFilm)) {
            return ['', 'data' => ["error" => "Movie already exists"], 'view' => 'welcome'];
        } else {
            // Add the new movie to the films array and update the JSON file
            $films[] = $newFilm;
            Storage::put("/public/films.json",json_encode($films));
            $films = FilmController::readFilms();
            return ['',  'data' => ["films" => $films, "title" => $title], 'view' => 'films.list'];
        }
    }
    
    /**
     * Create a new movie and display the updated list of movies.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function createFilm(Request $request)
    {
        
        $storageLocation = config('storage.storage_location');

        $title = "All Movies";
        
        $status = [];
        // Save the new movie into the database or JSON file based on the storage location configuration
        if($storageLocation ==='json'){
            $status = FilmController::saveIntoJson($title, $request);
        } else {
            $status = FilmController::saveIntoDB($title, $request);
        }

        return view($status['view'], $status['data']);

    }

    
}
