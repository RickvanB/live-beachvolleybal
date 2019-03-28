<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Programma;
use App\User as User;
use App\Roles as Roles;
use Session;
use DB;
use Auth;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

class AccountController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function settings()
    {
    	$data = array(
    		'teams' => $this->getTeams(),
            'users' => $this->getAllUsers(),
            'roles' => $this->getAllRoles(),
            'user'  => Self::getAdminUser(),
            'ischecked' => $this->isCheckboxAssigned(),
    	);

    	return view('account.settings')->with($data);
    }

    public function saveSettings($id, Request $request)
    {  	
    	$this->validate($request, [
    		'naam' => 'required',
    		'email' => 'required'
    	]);

    	$user_settings = User::findOrFail($id);
    	$user_settings->fill($request->all())->save();


    	Session::flash('flash_message', 'Instellingen succesvol opgeslagen!');

    	return redirect()->back();
    }

    public function delete($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->delete();
        DB::delete("delete from oauth_identities where user_id = :id", ['id' => $id]);
        Auth::logout();

        return redirect('/');
    }

    public function assignRoles($id, Request $request)
    {
        $user = Sentinel::findById($id);
        $role = Sentinel::findRoleByName('Administrator');

        $role->users()->attach($user);

        Session::flash('flash_message', 'Rol is succesvol gekoppeld aan het account!');

        return redirect()->back();
    }

    public function backendSettings(Request $request)
    {
        $input = $request->input('automatic_updates');
        if($input == 'on')
        {
            $input = 1;
        }
        else
        {
            $input = 0;
        }

        DB::table('backend')
            ->where('id_backend', 1)
            ->update(['automatic_updates' => $input]);

        Session::flash('flash_message', 'Backend instellingen zijn succesvol bijgewerkt!');

        return redirect()->back();
    }


    /* Private SQL functions */
    private function getTeams()
    {
    	$teams = Programma::distinct()
    		->select('team1')
    		->get();
    	return $teams;
    }

    public static function getAdminUser()
    {
        $user = DB::table('users')
                    ->join('role_users', function($join)
                    {
                        $join->on('users.id', '=', 'role_users.user_id')
                             ->where('users.id', '=', Auth::user()->id);
                    })
                    ->join('roles', 'roles.id', '=', 'role_users.role_id')
                    ->select('users.*', 'roles.name')
                    ->get();

        if(!empty($user))
        {
            $user = $user[0]->name;
        }

        return $user;
    }

    private function getAllUsers()
    {   
        $users = DB::table('users')
                        ->leftJoin('oauth_identities', 'users.id', '=', 'oauth_identities.user_id')
                        ->select('users.*', 'oauth_identities.provider')
                        ->get();

        return $users;
    }

    private function getAllRoles()
    {
        $roles = Roles::all();
        return $roles;
    }

    private function isCheckboxAssigned()
    {
        $checkbox = DB::table('backend')
                    ->select('automatic_updates')
                    ->get();

        if(empty($checkbox))
        {
            $checkbox = '';
        }
        else
        {
            $checkbox = $checkbox[0]->automatic_updates;
        }

        return $checkbox;
    }
}
