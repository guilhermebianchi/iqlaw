<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Home;

use App\Rules\ReCAPTCHAv3;

use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function show(){
        $data[ 'home' ] = Home::where( 'Locale', '=', App::getlocale() )->get();

        return view( 'contact', compact( 'data' ) );
    }

    public function send(Request $request){
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'name' => 'required',
                'email' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ]
        );

        if( $validator->passes() ){
            $Contact = new Contact;

            $Contact->name = $input[ 'name' ];
            $Contact->email = $input[ 'email' ];
            $Contact->subject = $input[ 'subject' ];
            $Contact->message = $input[ 'message' ];

            if( $Contact->save() ){
                $Contact = Contact::findOrFail( $Contact->id );

                Mail::to( Config::get('mail.from.address' ) )->send( new ContactMail( $Contact ) );

                echo '<script> alert( "Enviado com sucesso!" ); window.location.href = "'.route('home').'"; </script>';
                exit;
            }else{
                echo '<script> alert( "Erro!" ); window.location.href = "'.route('home').'"; </script>';
                exit;
            }

        }else{
            echo '<script> alert( "Erro!" ); window.location.href = "'.route('home').'"; </script>';
            exit;
        }
    }
}
