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

class GetBrand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.auto-data.net/en/allbrands');
        $data = [];
        $data = $crawler->filter('a.marki_blok')->each(function ($node) {
            $href = $node->extract(array('href'));
            $img = $node->filter('img')->extract(array('src'));
            $check = Brand::where('brand',$node->text())->count();
            if($check==0){
                $url = 'https://www.auto-data.net/'.$img[0];
                $img = 'public/assets/photos/logo/'.$node->text().".jpg";
                $job = (new \App\Jobs\GetImage($img,$img_url))
                    ->delay(now()->addSeconds(2));

                dispatch($job);
                /* if (!file_exists($img)) {
                    file_put_contents($img, file_get_contents($url));
                } */
                $data = [
                    "brand" => $node->text(),
                    "logo"  => $img,
                    "url"   => $href[0]
                ];

                Brand::insert($data);
            }
        });
    }
}
