<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Goutte\Client;


use App\Models\Models;
use App\Models\Generation;
use App\Models\GenerationImage;
use App\Models\GenerationDetail;
use App\Models\Type;

class GetImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $img;
    protected $img_url;
    public function __construct($img, $img_url)
    {
        //
        $this->img = $img;
        $this->img_url = $img_url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if (!file_exists($this->img)) {
            file_put_contents($this->img, file_get_contents($$this->img_url));
        }
    }
}
