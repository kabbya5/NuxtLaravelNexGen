<?php

namespace App\Jobs;

use App\Mail\SendUserPhoto;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;


class HourlyReport implements ShouldQueue
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
        $attachmentsPath = storage_path('app/output/');
        $file_output_path = $attachmentsPath. pathinfo($this->file_name, PATHINFO_FILENAME);

        // ResizeJob::dispatch($this->file_name, 100);
        // ResizeJob::dispatch($this->file_name, 100);
        // ResizeJob::dispatch($this->file_name, 500);
        // ResizeJob::dispatch($this->file_name, 600);
        // ResizeJob::dispatch($this->file_name, 400);

        // Job Chaining 
        
        $sizes = [100,400,500,600];
        $jobs = [];

        foreach($sizes as $size){
            $jobs[] =  new ResizeJob($this->file_name, $size);
        }

        Bus::chain(jobs:[
          ...$jobs,
            new SendUserEmail($this->email, $file_output_path,$sizes),

        ])->catch(function(){ 
            
        })->dispatch();

        

    }
}
 