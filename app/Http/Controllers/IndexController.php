<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

use App\Models\Home;
use App\Models\Banner;
use App\Models\OccupationArea;

class IndexController extends Controller
{
    public function show(){
        $data[ 'home' ]             = Home::where( 'locale', '=', App::getlocale() )->get();
        $data[ 'banner' ]           = Banner::where( 'locale', '=', App::getlocale() )->inRandomOrder()->limit(1)->get();
        $data[ 'occupationArea' ]   = OccupationArea::where( 'locale', '=', App::getlocale() )->get();

        return view( 'home', compact( 'data' ) );
    }
}
