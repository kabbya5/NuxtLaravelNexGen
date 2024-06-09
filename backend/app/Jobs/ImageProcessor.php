<?php

namespace App\Jobs;

use App\Mail\SendUserPhoto;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    private $email;
    private $file_name;

    public function __construct($email,$file_name)
    {
        $this->email = $email;
        $this->file_name = $file_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sendUserPhoto = new SendUserPhoto();

        $photoPath = storage_path('app/photos/');
        $attachmentsPath = storage_path('app/output/');

        $filePath = $photoPath . $this->file_name;

        $manager = new ImageManager(
            new Driver()
        );

        $image = $manager->read($filePath);

        $image->scale(height:100);
        $encoded = $image->toJpeg();

        $file_output_path = $attachmentsPath. pathinfo($this->file_name,PATHINFO_FILENAME);
        $encoded->save($file_output_path.'-100.jpeg');

        $sendUserPhoto->attach($file_output_path .'-100.jpeg');

        $image->scale(height:300);
        $encoded = $image->toJpeg();
        $encoded->save($file_output_path. '-300.jpeg');
        $sendUserPhoto->attach($file_output_path . '-300.jpeg');

        try{
            Mail::to($this->email)->send($sendUserPhoto);
        }catch(Exception $e){
             $this->fail($e);
        }

    }
}
