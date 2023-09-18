<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function() {
    Route::get('/login', function () {
        return view('auth');
    });

    Route::get('/register', function() {
        return view('auth');
    });
});

Route::get('/', function() {
    $mToken = $_COOKIE['X-TOKEN'] ?? null;
    if (!$mToken) {
        return redirect('/login');
    }
    return redirect('/tasks');
});

Route::get('/tasks', function() {
    return view('app');
});

Route::get('/task/{id}', function() {
    return view('app');
});

Route::get('/archives', function() {
    return view('app');
});
