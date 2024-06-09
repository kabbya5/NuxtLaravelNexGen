<?php

use App\Http\Controllers\BasicJobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(BasicJobController::class)->group(function(){
    Route::get('/job-1','job1');
    Route::get('/job/image/', 'jobImage')->name('job.image');
    Route::post('process/image/', 'processImage')->name('image.process');
});