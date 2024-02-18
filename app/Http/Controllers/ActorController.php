<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ActorController extends Controller
{

    /**
     * List all actors in the database
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function listActors()
    {
        // Set the title for the view
        $title = "List of all actors";

        // Retrieve all actors from the database
        $actors = DB::table('actors')->get();

        // Convert the retrieved actors to an array
        $actors = json_decode(json_encode($actors), true);

        // Pass the actors and title to the view and return the view
        return view('actors.list', ["actors" => $actors, "title" => $title]);
    }

    /**
     * List all actors by decade
     *
     * @param int $year The year representing the start of the decade
     * @return \Illuminate\Contracts\View\View
     */
    public function listActorsByDecade($year)
    {
        // Set the title for the view
        $title = "List actors from ".$year." decade";
        
        // Calculate the start and end dates of the provided decade
        $startDate = "{$year}-01-01";
        $endDate = date('Y-m-d', strtotime("+9 years", strtotime($startDate)));

        // Query to retrieve actors born within the provided decade
        $actors = DB::table('actors')
            ->whereBetween('birthdate', [$startDate, $endDate])
            ->get();
            
        // Convert the retrieved actors to an array
        $actors = json_decode(json_encode($actors), true);

        // Pass the actors and title to the view and return the view
        return view('actors.list', ["actors" => $actors, "title" => $title]);
    }

    /**
     * Count the number of actors.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function countActors()
    {
        // Set the title for the view
        $title = "Number of Actors";

        // Count the total number of actors in the database
        $actors = count(DB::table('actors')->get());

        // Pass the count of actors and title to the view and return the view
        return view('actors.count', ["actors" => $actors, "title" => $title]);
    }

    /**
     * Delete an actor from database by id.
     *
     * @param int $id The ID of the actor to delete
     * @param Request $request The request object
     * @return json
     */
    public function deleteActor($id, Request $request)
    {
        // Attempt to delete the actor by its ID
        $deleted = DB::table('actors')->where('id', $id)->delete();

        // Check if the actor was deleted successfully
        if ($deleted) {
            $status = 'true';
        } else {
            $status = 'false';
        }

        // Return a JSON response indicating the status of the deletion
        return response()->json(['action' => 'delete', 'status' => $status]);
    }

}
