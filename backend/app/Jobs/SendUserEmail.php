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

class SendUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file_output_path;
    private $sizes;
    private $email;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $file_output_path, $sizes)
    {
        $this->file_output_path = $file_output_path;
        $this->sizes = $sizes;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sendUserPhoto = new SendUserPhoto();

        foreach($this->sizes as $size){
            $sendUserPhoto->attach($this->file_output_path . '-' . $size . '-jpeg');
        }

        try{
            Mail::to($this->email)->send($sendUserPhoto);
        }catch(Exception $e){
             $this->fail($e);
        }

    }
}
