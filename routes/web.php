<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return ['Laravel' => app()->version()];
});*/
Route::get('/', function () {
    return view('home');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
