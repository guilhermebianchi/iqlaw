<?php

use Illuminate\Support\Facades\Route;

// MIDDLEWARES
use \App\Http\Middleware\Localization;

// CONTROLLERS
use \App\Http\Controllers\Controller;
use \App\Http\Controllers\IndexController;
use \App\Http\Controllers\BlogController;
use \App\Http\Controllers\ContactController;
use \App\Http\Controllers\NewsletterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware( [ Localization::class ] )->group( function () {
    Route::redirect('/', 'home' );
    Route::get('/home', [ IndexController::class, 'show' ])->name( 'home' );
    Route::get('/locale/{locale}', [ Controller::class, 'locale' ])->name( 'locale' );
    Route::post('/contact', [ ContactController::class, 'send' ])->name( 'send-contact' );
});
