<?php
use SocialNorm\Exceptions\ApplicationRejectedException;
use SocialNorm\Exceptions\InvalidAuthorizationCodeException;
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Homepage route
Route::get('/', 'IndexController@Index');

//Exporting PDF's
Route::get('/vprogramma/{day}/{daytime}/poule/{id}/export', 'ProgrammaController@exportPDF');
Route::get('/uitslagen/{day}/{daytime}/poule/{id}/export', 'ProgrammaController@exportPDFUitslagen');
Route::get('/ranking/{day}/poule/{id}/export', 'ProgrammaController@exportPDFRanking');

/* Programma Routes */
Route::get('/overview/{day}/poule/{id}', 'ProgrammaController@ShowOverview');
Route::get('/vprogramma/{day}/{daytime}/poule/{id}', 'ProgrammaController@ShowFullProgram');
Route::get('/ranking/{day}/poule/{id}', 'ProgrammaController@ShowFullRanking');
Route::get('/uitslagen/{day}/{daytime}/poule/{id}', 'ProgrammaController@ShowResults');

/* Contact page */
Route::get('/contact', 'ContactController@showContactForm');
Route::post('/contact/send', 'ContactController@sendEmail');

Route::get('/api/insertQuery', 'IndexController@insertLastQuery');

// Redirect to Facebook for authorization
Route::get('login/authorize/facebook', function() 
{
    return SocialAuth::authorize('facebook');
});

// Facebook redirects here after authorization
Route::get('/login/callback', function() 
{
    // Automatically log in existing users
    // or create a new user if necessary.
    try
    {
    	SocialAuth::login('facebook', function($user, $details)
    	{
		    $user->name = $details->full_name;
		    $user->email = $details->email;
		    $user->profile_image = $details->avatar;
		    $user->save();
    	});
    }
    catch(ApplicationRejectedException $e)
    {
    	echo "Er gaat iets niet goed, probeer het later nog eens.";
    }
    catch(InvalidAuthorizationCodeException $e)
    {
    	echo "Er gaat iets niet goed, probeer het later nog eens.";
    }

    // Current user is now available via Auth facade
    $user = Auth::user();

    return redirect('/');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    //Index
    Route::get('/', 'IndexController@Index');

    //Exporting PDF's
	Route::get('/vprogramma/{day}/{daytime}/poule/{id}/export', 'ProgrammaController@exportPDF');
	Route::get('/uitslagen/{day}/{daytime}/poule/{id}/export', 'ProgrammaController@exportPDFUitslagen');
	Route::get('/ranking/{day}/poule/{id}/export', 'ProgrammaController@exportPDFRanking');

	/* Programma Routes */
	Route::get('/overview/{day}/poule/{id}', 'ProgrammaController@ShowOverview');
	Route::get('/vprogramma/{day}/{daytime}/poule/{id}', 'ProgrammaController@ShowFullProgram');
	Route::get('/ranking/{day}/poule/{id}', 'ProgrammaController@ShowFullRanking');
	Route::get('/uitslagen/{day}/{daytime}/poule/{id}', 'ProgrammaController@ShowResults');

    //Contact page
    Route::get('/contact', 'ContactController@showContactForm');
    Route::post('/contact/send', 'ContactController@sendEmail');

    //Account
    Route::get('/account/settings', 'AccountController@settings');
    Route::post('/account/{id}/settings/save', 'AccountController@saveSettings');
    Route::post('/account/{id}/settings/delete', 'AccountController@delete');
    Route::post('/account/{id}/settings/assignrole', 'AccountController@assignRoles');
    Route::post('/account/settings/backendsettings', 'AccountController@backendSettings');

    // Matches
    Route::get('/uitslagen/invoeren', 'ScoreController@Overview');
    Route::post('uitslagen/invoeren/{id}', 'ScoreController@postResults');

    //Dashboard
    Route::get('/dashboard', 'DashboardController@index');

    // Redirect to Facebook for authorization
	Route::get('login/authorize/facebook', function() 
	{
	    return SocialAuth::authorize('facebook');
	});

	// Facebook redirects here after authorization
	Route::get('/login/callback', function() 
	{
	    // Automatically log in existing users
	    // or create a new user if necessary.
	    try
	    {
	    	SocialAuth::login('facebook', function($user, $details)
	    	{
			    $user->name = $details->full_name;
			    $user->email = $details->email;
			    $user->profile_image = $details->avatar;
			    $user->save();
	    	});
	    }
	    catch(ApplicationRejectedException $e)
	    {
	    	echo "Er gaat iets niet goed, probeer het later nog eens.";
	    }
	    catch(InvalidAuthorizationCodeException $e)
	    {
	    	echo "Er gaat iets niet goed, probeer het later nog eens.";
	    }

	    // Current user is now available via Auth facade
	    $user = Auth::user();

	    return redirect('/');
	});
});
