<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController as VCB_API;
use App\Programma;
use App\Ranking;
use Carbon\Carbon;
use Barryvdh\DomPDF;
use DB;

class ProgrammaController extends Controller
{
    private $api;

	public function __construct()
	{
		$this->api = new VCB_API;
	}
    
	/*
        Overview page when clicking on a poule.   
     */
    public function ShowOverview($day, $id)
    {
        $limit = 5;
	    // Collect all data to one array.
        if($day == 'zaterdag') { 
        	$data = array(
        		'dag' => $day,
        		'poule' => $id,
                'ochtendprogramma' => NULL,
                'middagprogramma' => $this->getAfternoonProgram($day, $id, $limit),
        		'ochtend_uitslagen' => NULL,
                'middag_uitslagen' => $this->getAfternoonResults($day, $id, $limit),
        		'ranking' => $this->getPouleResults($day, $id, $limit),
                'lastupdate' => $this->getLastUpdate(),
                'sponsors' => $this->getSponsorImages()
        	);
        } else {
            $data = array(
                'dag' => $day,
                'poule' => $id,
                'ochtendprogramma' => $this->getMorningProgram($day, $id, $limit),
                'middagprogramma' => $this->getAfternoonProgram($day, $id, $limit),
                'ochtend_uitslagen' => $this->getMorningResults($day, $id, $limit),
                'middag_uitslagen' => $this->getAfternoonResults($day, $id, $limit),
                'ranking' => $this->getPouleResults($day, $id, $limit),
                'lastupdate' => $this->getLastUpdate(),
                'sponsors' => $this->getSponsorImages()
            );
        }

    	return view('programma.index')->with($data);
    }

    /*
        Show full ranking based on poule
     */
    public function ShowFullRanking($day, $id)
    {
        $limit = 50;
    	$data = array(
    		'dag' => $day,
    		'poule' => $id,
    		'ranking' => $this->getPouleResults($day, $id, $limit),
            'lastupdate' => $this->getLastUpdate(),
            'sponsors' => $this->getSponsorImages()
    	);

    	return view('programma.ranking')->with($data);
    }
    /*
        Show full program based on time and poule
     */
    public function ShowFullProgram($day, $daytime, $id)
    {
        $limit = 50;
    	$data = array(
    		'dag' => $day,
    		'poule' => $id,
            'dagdeel' => $daytime,
    		'programma' => $this->getFullProgram($day, $daytime, $id, $limit),
            'lastupdate' => $this->getLastUpdate(),
            'sponsors' => $this->getSponsorImages()
    	);

    	return view('programma.vprogramma')->with($data);
    }
    /*
        Show results based on poule and day
     */
    public function ShowResults($day, $daytime, $id)
    {
        $limit = 50;
    	$data = array(
    		'poule' => $id,
    		'dag' => $day,
            'dagdeel' => $daytime,
            'uitslagen' => $this->getFullProgram($day, $daytime, $id, $limit),
            'lastupdate' => $this->getLastUpdate(),
            'sponsors' => $this->getSponsorImages()
    	);

    	return view('programma.uitslagen')->with($data);
    }

    /*
        Export PDF
     */
    public function exportPDF($day, $daytime, $id)
    {      
        $limit = 50;
        $data = array(
            "programma" => $this->getFullProgram($day, $daytime, $id, $limit),
            "dag" => $day,
            "poule" => $id,
        );
        
        $pdf = \PDF::loadView('pdf.pdf_export_vprogramma', $data);
        return $pdf->download('export_programma.pdf');
    }

    public function exportPDFUitslagen($day, $daytime, $id)
    {
        $limit = 50;
        $data = array(
            "uitslagen" => $this->getFullProgram($day, $daytime, $id, $limit),
            "dag" => $day,
            "poule" => $id,
        );

        $pdf = \PDF::loadView('pdf.pdf_export_uitslagen', $data);
        return $pdf->download('export_uitslagen.pdf');
    }

    public function exportPDFRanking($day, $id)
    {   
        $ranking_full = Ranking::where('poule', '=', $id)
            ->where('dag', '=', $day)
            ->orderBy('plaats', 'asc')
            ->get();

        $data = array(
            "ranking" => $ranking_full,
            "dag" => $day,
            "poule" => $id,
        );

        $pdf = \PDF::loadView('pdf.pdf_export_ranking', $data);
        return $pdf->download('export_ranking.pdf');
    }

    /* PRIVATE FUNCTIONS */
    
    private function getSponsorImages()
    {
        // Find all images in directory
        $directory = public_path() . '/assets/sponsors/';
        $result = glob($directory . "*.*");
        foreach ($result as $image) {
            // Remove part of string
            $images[] = str_replace('/home/vagrant/Code/beachvolleybalbladel/public', "", $image);
        }

        // Shuffle array to randomize images
        shuffle($images);
        // Get 3 images
        return array_slice($images, 0, 3);
    }


    private function getMorningProgram($day = NULL, $id = NULL, $limit = NULL)
    {
        $endpoint = '/program/' . $day . '/ochtend/' . $id . '/' . $limit . '';
        $type = 'get';
        $result = $this->api->apiCall($endpoint, $type);

        return $result;
    }

    private function getAfternoonProgram($day = NULL, $id = NULL, $limit = NULL)
    {
        $endpoint = '/program/' . $day . '/middag/' . $id . '/' . $limit . '';
        $type = 'get';
        $result = $this->api->apiCall($endpoint, $type);

        return $result;
    }

    private function getFullProgram($day = NULL, $daytime = NULL, $id = NULL, $limit = NULL)
    {
        $endpoint = '/program/' . $day . '/' . $daytime . '/' . $id . '/' . $limit . '';
        $type = 'get';
        $result = $this->api->apiCall($endpoint, $type);

        return $result;
    }

    private function getMorningResults($day = NULL, $id = NULL, $limit = NULL)
    {
        $endpoint = '/results/' . $day . '/ochtend/' . $id . '/' . $limit . '';
        $type = 'get';
        $result = $this->api->apiCall($endpoint, $type);

        return $result;
    }

    private function getAfternoonResults($day = NULL, $id = NULL, $limit = NULL)
    {
        $endpoint = '/results/' . $day . '/middag/' . $id . '/' . $limit . '';
        $type = 'get';
        $result = $this->api->apiCall($endpoint, $type);

        return $result;
    }

    private function getPouleResults($day = NULL, $id = NULL, $limit = NULL)
    {
        $endpoint = '/poule/results/' . $day . '/' . $id . '/' . $limit . '';
        $type = 'get';
        $result = $this->api->apiCall($endpoint, $type);

        return $result;
    }

    private function getLastUpdate()
    {
        $lastupdate = DB::table('cron_updates')
            ->select('timestamp')
            ->where('programma', '=', 'Succesvol')
            ->orderBy('timestamp', 'desc')
            ->limit(1)
            ->first();

        if(!empty($lastupdate))
        {
            $lastupdate = $lastupdate->timestamp;
        }

        return $lastupdate;
    }
}
