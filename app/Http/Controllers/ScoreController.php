<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Programma;
use App\Ranking;
use App\User as User;
use App\Roles as Roles;
use App\Http\Controllers\ApiController as VCB_API;
use Session;
use DB;
use Auth;
use Carbon\Carbon;

class ScoreController extends Controller
{
	private $api;

    public function __construct()
    {
    	$this->middleware('auth');
    	$this->api = new VCB_API;
    }

    /**
     * Overview - Get related teams and show them in an overview
     */
    public function Overview()
    {
    	$data = array(
    		'yourMatches' => $this->getRelatedMatches()
    	);

    	return view('score.index')->with($data);
    }

    public function postResults(Request $request)
    {
    	$postData = $request->all();

    	$endpoint = '/uitslagen/invoeren';
        $type = 'post';
        $headers = NULL;
        $fields = $postData;
        $result = $this->api->apiCall($endpoint, $type, $headers, $fields);

        if($result->status == 200) {
        	Session::flash('flash_message', 'Uitslagen succesvol toegevoegd');

        	return redirect()->back();
        } else {
        	Session::flash('flash_message', 'Er is iets misgegaan, indien dit blijft voorkomen neem dan contact op via het contactformulier');

        	return redirect()->back();
        }

    }

    private function getRelatedMatches()
    {
    	$user = Auth::user();
    	$matches = DB::table('programma')
    		->select('*')
    		->where('team1', 'LIKE', '%'.$user->team.'%')
    		->orWhere('team2', 'LIKE', '%'.$user->team.'%')
    		->get();

    	// Get current time.
        $current_time = explode(" ", Carbon::now('Europe/Amsterdam'));

        // Remove the date from the array.
        unset($current_time[0]);
        // + 30 minutes
        $timeAhead = date('H:i', strtotime('+30 minutes', strtotime($current_time[1])));
        // - 30 minutes
        $timeBehind = date('H:i', strtotime('-30 minutes', strtotime($current_time[1])));

        $filteredMatches = array();
    	foreach ($matches as $match) {
    		if($timeBehind < $match->starttijd && $timeAhead > $match->starttijd ) {
    			$filteredMatches[] = $match;
    		}
    	}

    	return $filteredMatches;
    }
}
