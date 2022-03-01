<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class ReCAPTCHAv3 implements Rule
{
    public function passes( $attribute, $value )
    {
        $client = new Client();

        try {
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'form_params' => [
                        'secret' => config('recaptcha.v3.private_key'),
                        'response' => $value,
                        'remoteip' => Request::ip(),
                    ],
                ]
            );
        }catch( \GuzzleHttp\Exception\BadResponseException $e ){
            return false;
        }

        return $this->getScore( $response ) >= config('recaptcha.v3.minimum_score');
    }

    private function getScore($response)
    {
        return \GuzzleHttp\json_decode($response->getBody(), true)['score'];
    }

    public function message()
    {
        return 'Failed on reCAPTCHA verification.';
    }
}
