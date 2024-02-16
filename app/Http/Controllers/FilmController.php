<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    /**
     * Read films from storage
     *
     * @return array
     */
    public static function readFilms(): array
    {
        $films = Storage::json('/public/films.json');
        // $films = Storage::json(storage_path('app/public/films.json'));

        // dd($films);
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

        $title = "List of Old Movies (Before $year)";
        $films = FilmController::readFilms();

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

        $title = "List of New Movies (After $year)";
        $films = FilmController::readFilms();

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

        if (is_null($year) && is_null($genre))
            return view('films.list', ["films" => $films, "title" => $title]);

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

        if (is_null($year))
            return view('films.list', ["films" => $films, "title" => $title]);

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

        if (is_null($genre))
            return view('films.list', ["films" => $films, "title" => $title]);

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

    /**
     * Create a new movie and display the updated list of movies.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function createFilm(Request $request)
    {
        $title = "All Movies";
        $films = FilmController::readFilms();
        $newFilm = [
            'name' => $request->input('name'),
            'year' => $request->input('year'),
            'genre' => $request->input('genre'),
            'country' => $request->input('country'),
            'duration' => $request->input('duration'),
            'img_url' => $request->input('img_url'),
        ];
        
        if ($this->isFilm($newFilm)) {
            return view('welcome', ["error" => "Movie already exists"]);
        } else {
            $films[] = $newFilm;
            Storage::put("/public/films.json",json_encode($films));
            $films = FilmController::readFilms();
            return view('films.list', ["films" => $films, "title" => $title]);
        }
    }
}
