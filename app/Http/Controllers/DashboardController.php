<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Auth;
use App\User as User;
use LaravelAnalytics;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$data = array(
    		'updates' => $this->cronUpdates(),
            'facebookaccounts' => $this->countFacebookAccounts(),
            'default_users' => $this->countDefaultAccounts()
    	);

    	return view('dashboard.index')->with($data);
    }

    /* Private SQL functions */

    private function cronUpdates()
    {
    	$cronupdates = DB::table('cron_updates')
                            ->orderBy('timestamp', 'desc')
				    		->get();
		return $cronupdates;
    }

    private function countFacebookAccounts()
    {
        $facebookaccounts = DB::table('oauth_identities')
                                ->select(DB::raw('count(*) as count'))
                                ->get();

        $facebookaccounts = $facebookaccounts[0]->count;

        return $facebookaccounts;
    }

    private function countDefaultAccounts()
    {
        $users = User::count();
        return $users;
    }
}
