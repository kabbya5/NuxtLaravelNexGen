<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ResizeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file_name;
    private $size;

    private $file_path;
    private $attachmentsPath;

    /**
     * Create a new job instance.
     */
    public function __construct($file_name, $size)
    {
        $this->file_name = $file_name;
        $this->size = $size;

        $photoPath = storage_path('app/photos/');
        $attachmentsPath = storage_path('app/output/');

        $this->file_path = $photoPath . $file_name;
        $this->attachmentsPath = $attachmentsPath;


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $manager = new ImageManager(
            new Driver()
        );

        $image = $manager->read($this->file_path );

        $image->scale(height:$this->size);
        $encoded = $image->toJpeg();

        $file_output_path = $this->attachmentsPath. pathinfo($this->file_name,PATHINFO_FILENAME);
        $encoded->save($file_output_path.'-'. $this->size . '.jpeg' );
    }
}
