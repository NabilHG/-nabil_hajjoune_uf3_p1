<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActorController extends Controller
{

/**
     * List all actors in the database
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function listActors()
    {

        $title = "List of all actors";
        // $actors = DB::table('actors')->get();
        $actors = '';


        // dd($actors); // Remove this unless for debugging

        return view('actors.list', ["actors" => $actors, "title" => $title]);
    }

    /**
     * List all actors by decade
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function listActorsByDecade($year = null)
    {

        $title = "List actors from ".$year." decade";
        // $actors = DB::table('actors')->get()->where();

        // dd($actors); // Remove this unless for debugging
        $actors = '';


        return view('actors.list', ["actors" => $actors, "title" => $title]);
    }

    /**
     * Count the number of actors.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function countActors()
    {
        $title = "Number of Actors";

        // $actors = (DB::table('actors')->get());
        $actors = '';

        return view('actors.count', ["actors" => $actors, "title" => $title]);
    }

    /**
     * Delete an actor from database by id.
     *
     * @return json
     */
    public function deleteActor($id){

        $status = '';

        return response()->json(['action' => 'delete', 'status' => $status]);
    }

}