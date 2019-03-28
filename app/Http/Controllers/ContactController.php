<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html;
use Illuminate\Form;
use App\Programma;
use App\Http\Requests;
use App\Http\Requests\ContactRequest;
use Session;
use Mail;

class ContactController extends Controller
{
    public function showContactForm()
    {
    	$data = array();

    	return view('contact.contact')->with($data);
    }

    public function sendEmail(ContactRequest $request)
    {
        $data = $request->only('name', 'email', 'message');
        $data['messageLines'] = explode('\n', $request->get('message'));

        Mail::queue('contact.email', $data, function($message) use ($data)
        {
            $message->subject('Contactformulier ingevuld door: '.$data['name'])
                    ->from($data['email'])
                    ->to('socialmedia@vcbladel.nl');
        });

    	Session::flash('flash_message', 'Je email wordt verzonden, je krijg zo snel mogelijk iets van ons te horen!');

        return redirect()->back();
    }

}
