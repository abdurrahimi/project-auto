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

class GetModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $url = "https://www.auto-data.net/";
    protected $data = [];
    public function __construct($data)
    {
        //
        $this->data = $data;
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
        $crawler = $client->request('GET', $this->url.$this->data->url);

        $crawler->filter('a.modeli')->each(function ($node) {
            $check = Models::where('model',$node->text())->first();
            if(empty($check)){
                $url = $node->extract(array('href'));
                $img = $node->filter('img')->extract(array('src'));
                $img_url = 'https://www.auto-data.net/'.$img[0];
                $img = 'public/assets/photos/model/'.str_replace("/","-",$node->text()).".jpg";
                /* if (!file_exists($img)) {
                    file_put_contents($img, file_get_contents($img_url));
                } */
                //Create Image download job
                $job = (new \App\Jobs\GetImage($img,$img_url))
                    ->delay(now()->addSeconds(2));

                dispatch($job);

                $id = Models::insertGetId([
                    "brand_id" => $this->data->id,
                    "model" => $node->text(),
                    "image" => $img,
                    "url" => $url[0]
                ]);
                //Get Generation Job;
                $job = (new \App\Jobs\GetGeneration($id,$url[0]))
                    ->delay(now()->addSeconds(2));

                dispatch($job);
                /* $this->get_generation($id,$url[0]); */

            }else{
                $job = (new \App\Jobs\GetGeneration($check->id,$check->url))
                    ->delay(now()->addSeconds(2));
                /* $this->get_generation($check->id,$check->url); */
            }
        });
    }
}
