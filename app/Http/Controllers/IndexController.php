<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Programma as Programma;
use App\Http\Controllers\ApiController as VCB_API;
use Forecast\Forecast;
use Carbon\Carbon;
use Storage;
use DB;
use Stichoza\GoogleTranslate\TranslateClient;
use Input;
use Auth;

class IndexController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new VCB_API;
    }

    public function Index()
    {
    	$forecast = new Forecast(env('API_KEY_FORECAST_IO'));

    	$options = array(
    		'lang' => 'nl',
    		'units' => 'uk'
    	);
    	$local = $forecast->get('51.3665385', '5.214843299999984', null, $options);

        $day = date('l');
        if( strtolower($day) == 'saturday' ) {
            $day = 'zaterdag';
        } elseif( strtolower($day) == 'sunday') {
            $day = 'zondag';
        }

    	$data = array(
    		'weather' => $local,
            'upcoming' => $this->getProgram($day),
            'query' => $this->getAllTeams(),
    	);

    	return view('index')->with($data);
    }

    public function getChart()
    {
        $options = array(
            'lang' => 'nl',
            'units' => 'uk'
        );
        $local = $forecast->get('51.3665385', '5.214843299999984', null, $options);
    }

    /* Public static functions, gets loaded on every page */

    public static function getPoulesonSaturday()
    {
        $poule = Programma::distinct()
                    ->select('poule')
                    ->where('dag', '=', 'zaterdag')
                    ->get();
        return $poule;
    }

    public static function getPoulesonSunday()
    {
        $poule = Programma::distinct()
                    ->select('poule')
                    ->where('dag', '=', 'zondag')
                    ->get();
        return $poule;
    }

    /* Private functions */

    private function getProgram($day)
    {
        // Get current time.
        $current_time = explode(" ", Carbon::now('Europe/Amsterdam'));

        // Remove the date from the array.
        unset($current_time[0]);
        // Check if the current time is under 18.00 o'clock and if the current day is zaterdag of zondag.
        if($current_time[1] < "12:00:00" && $day == 'zaterdag' || $day == 'zondag')
        {
            $programma = Programma::where('starttijd', '>=', $current_time[1]) // Get only the upcoming matches
                ->where('dag', '=', $day)
                ->orderBy('starttijd', 'asc')
                ->limit(5)
                ->get();

            // To fill the gap between the last game an 17.00 o'clock.
            if($programma->isEmpty())
            {
                $programma = Programma::where('starttijd', '>=', $current_time[1]) // Get only the upcoming matches
                    ->orderBy('starttijd', 'asc')
                    ->whereDay('dag', '=', $day)
                    ->limit(5)
                    ->get();
            }
        }
        if($current_time[1] > "12:00:00" && $day == 'zaterdag' || $day == 'zondag')
        {
            $programma = Programma::where('starttijd', '>=', $current_time[1]) // Get only the upcoming matches
                ->where('dag', '=', $day)
                ->orderBy('starttijd', 'asc')
                ->limit(5)
                ->get();

            // To fill the gap between the last game an 17.00 o'clock.
            if($programma->isEmpty())
            {
                $programma = Programma::where('starttijd', '>=', $current_time[1]) // Get only the upcoming matches
                    ->orderBy('starttijd', 'asc')
                    ->whereDay('dag', '=', $day)
                    ->limit(5)
                    ->get();
            }
        }
        // If not, load standard results, not filtered on time.
        else
        {
            $programma = Programma::orderBy('starttijd', 'asc')
                ->where('dag', '=', $day)
                ->limit(5)
                ->get();
        }

        return $programma;
    }

    private function getAllTeams()
    {
        $endpoint = '/teams/all';
        $type = 'get';
        $result = $this->api->apiCall($endpoint, $type);

        return $result;
    }

    public function insertLastQuery()
    {
        $team = Input::get('team');

        $endpoint = '/teams/search/insert?team=' . $team;
        $type = 'get';
        $result = $this->api->apiCall($endpoint, $type);
        return $result;
    }
}
