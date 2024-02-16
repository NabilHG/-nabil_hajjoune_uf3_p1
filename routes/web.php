<?php

use App\Http\Controllers\FilmController;
use App\Http\Middleware\ValidateYear;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('year')->group(function () {
    Route::group(['prefix' => 'filmout'], function () {
        // Routes included with prefix "filmout"
        Route::get('oldFilms/{year?}', [FilmController::class, "listOldFilms"])->name('oldFilms');
        Route::get('newFilms/{year?}', [FilmController::class, "listNewFilms"])->name('newFilms');
        Route::get('films/{year?}/{genre?}', [FilmController::class, "listFilms"])->name('listFilms');
        Route::get('filmsByYear/{year?}', [FilmController::class, "listByYear"])->name('listFilmsByYear');
        Route::get('filmsByGenre/{genre?}', [FilmController::class, "listByGenre"])->name('listFilmsByGenre');
        Route::get('sortFilms', [FilmController::class, "sortByYear"])->name('sortByYear');
        Route::get('countFilms', [FilmController::class, "countFilms"])->name('listCount');
    });
});

Route::middleware('url')->group(function () {
    Route::group(['prefix' => 'filmin'], function () {
        // Routes included with prefix "filmin"
        Route::post('createFilm', [FilmController::class, "createFilm"])->name('createFilm');
    });
});


//Actor's routes
Route::group(['prefix' => 'actorout'], function () {
    // Routes included with prefix "actorout"
    Route::get('actors', [ActorController::class, "listActors"])->name('listActors');
    // Route::get('listActorsByDecade/{year}', [ActorController::class, "listActorsByDecade"])->name('listActorsByDecade');
    // Route::get('countActors', [FilmController::class, "countFilms"])->name('countActors');
    // Route::get('deleteActor/{id}', [ActorController::class, "deleteActor"])->name('deleteActor');
});