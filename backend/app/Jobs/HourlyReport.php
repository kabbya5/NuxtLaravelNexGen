<?php

namespace App\Jobs;

use App\Mail\SendUserPhoto;
use Exception;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;


class HourlyReport implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        $sizes = [100,400,500,600];
        $jobs = [];

        foreach($sizes as $size){
            $jobs[] =  new ResizeJob($this->file_name, $size);
        }
        $email = $this->email;

        Bus::batch(jobs:[
          ...$jobs,
        ])->then(function(Batch $batch) use($sizes,$file_output_path,$email){
            SendUserEmail::dispatch($email, $file_output_path,$sizes);
        })->catch(function(Batch $batch,\Throwable $e){
                dd($e->getMessage());
        })->dispatch();
    }
}
 