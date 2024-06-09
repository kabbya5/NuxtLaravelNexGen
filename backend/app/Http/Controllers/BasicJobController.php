<?php

namespace App\Http\Controllers;

use App\Jobs\BasicJob;
use App\Jobs\ImageProcessor;

use Illuminate\Http\Request;
use image;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BasicJobController extends Controller
{
    public function job1(){
        BasicJob::dispatch()->delay(delay:now()->addSeconds(30));
        return view('welcome');
    }

    public function jobImage(){
        return view('job.image');
    }

    public function processImage(Request $request){

        $email = $request->email;
        $image = $request->file('image');

        $file_name = $image->getClientOriginalName();

        $image->storeAs('photos', $file_name);

        
        ImageProcessor::dispatch($email,$file_name);

        // return redirect()->back();
    }
}
