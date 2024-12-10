<?php
use App\Http\Controllers\CayCanhController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cay_canh', CayCanhController::class);

