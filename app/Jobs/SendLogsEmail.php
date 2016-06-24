<?php

namespace BrngyWiFi\Jobs;

use BrngyWiFi\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendLogsEmail extends Job implements SelfHandling/*, ShouldQueue*/
{
    use InteractsWithQueue, SerializesModels;

    public $fileName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::send('emails.error_logs', [], function ($m) {
            $m->from('bgyadmin@gmail.com', 'Barangay Comms');
            $m->to('raymundo.gabriel7@gmail.com')->subject('Error in Device.');
            $m->attach(public_path('error-logs/' . $this->fileName));
        });

        $this->release();
    }
}
